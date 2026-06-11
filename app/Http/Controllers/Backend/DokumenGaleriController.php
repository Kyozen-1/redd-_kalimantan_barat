<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Auth;
use Validator;
use DataTables;
use App\Models\DokumenGaleri;
use App\Models\PivotKategoriDokumen;
use App\Models\MdKategoriDokumen;

class DokumenGaleriController extends Controller
{
    public function index()
    {
        return view('backend.dokumen-galeri.index',[
            'mdKategoriDokumens' => $this->mdKategoriDokumen()
        ]);
    }

    public function mdKategoriDokumen()
    {
        $getData = MdKategoriDokumen::statusAktif()
                ->get()
                ->map(function($d){
                    return [
                        'id' => Crypt::encryptString($d->id),
                        'nama' => $d->nama
                    ];
                });
        return $getData;
    }

    public function datatable()
    {
        $data = new DokumenGaleri;
        $data = $data->statusAktif();
        $data = $data->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = Crypt::encryptString($data->id);
                $button_edit = '<button type="button" name="edit" id="'.$id.'"
                class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></button>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_edit . ' ' . $button_delete;
                return $button;
            })
            ->addColumn('kategori', function($data){
                $pivots = $data->pivot_kategori_dokumen;
                $html = '<ul>';
                foreach ($pivots as $pivot) {
                    $html .= '<li>'.$pivot->md_kategori_dokumen->nama.'</li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('excel', function($data){
                if($data->document_file_excel_path)
                {
                    return '<iframe
                        src="https://view.officeapps.live.com/op/embed.aspx?src='.asset($data->document_file_excel_path).'"
                        width="100%"
                        height="300px">
                    </iframe>';
                } else {
                    return 'tidak ada';
                }
            })
            ->addColumn('pdf', function($data){
                if($data->document_file_pdf_path)
                {
                    return '<iframe src="'.asset($data->document_file_pdf_path).'" width="100%" height="300px" style="border:1px solid #ccc;">
                                Browser Anda tidak mendukung iframe.
                            </iframe>';
                } else {
                    return 'tidak ada';
                }
            })
            ->addColumn('word', function($data){
                if($data->document_file_word_path)
                {
                    return '<iframe
                        src="https://view.officeapps.live.com/op/embed.aspx?src='.asset($data->document_file_word_path).'"
                        width="100%"
                        height="300px">
                    </iframe>';
                } else {
                    return 'tidak ada';
                }
            })
            ->rawColumns(['aksi', 'kategori', 'excel', 'pdf', 'word'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori_id' => 'required',
            'kategori_id.*' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        if($request->excel)
        {
            $errors = Validator::make($request->all(), [
                'excel' => 'required|mimes:xlsx',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        if($request->pdf)
        {
            $errors = Validator::make($request->all(), [
                'pdf' => 'required|mimes:pdf',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        if($request->word)
        {
            $errors = Validator::make($request->all(), [
                'word' => 'required|mimes:docx',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        try {
            $dokumenGaleri = new DokumenGaleri();
            $dokumenGaleri->user_id = Auth::user()->id;
            $dokumenGaleri->nama = $request->nama;
            $dokumenGaleri->save();

            // Simpan kategori
            foreach ($request->kategori_id as $kategori) {
                $pivot = new PivotKategoriDokumen;
                $pivot->user_id = Auth::user()->id;
                $pivot->kategori_id = Crypt::decryptString($kategori);
                $pivot->dokumen_id = $dokumenGaleri->id;
                $pivot->save();
            }

            // Mapping file
            $uploads = [
                'excel' => [
                    'folder' => 'dokumen/excel',
                    'field'  => 'document_file_excel_path'
                ],
                'pdf' => [
                    'folder' => 'dokumen/pdf',
                    'field'  => 'document_file_pdf_path'
                ],
                'word' => [
                    'folder' => 'dokumen/word',
                    'field'  => 'document_file_word_path'
                ]
            ];

            foreach ($uploads as $requestKey => $config) {

                if ($request->hasFile($requestKey)) {

                    $destinationPath = public_path($config['folder']);

                    // Buat folder jika belum ada
                    if (!File::exists($destinationPath)) {
                        File::makeDirectory(
                            $destinationPath,
                            0755,
                            true,
                            true
                        );
                    }

                    $file = $request->file($requestKey);

                    // Nama file unik
                    $filename = time() . '_' . uniqid() . '.' .
                                $file->getClientOriginalExtension();

                    $file->move($destinationPath, $filename);

                    $dokumenGaleri->{$config['field']} =
                        $config['folder'] . '/' . $filename;
                }
            }

            $dokumenGaleri->save();

            return response()->json(['success' => 'Berhasil menambahkan dokumen galeri']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);

        $getData = DokumenGaleri::find($id);
        $kategoris = [];
        foreach ($getData->pivot_kategori_dokumen as $pivot) {
            $kategoris[] = $pivot->md_kategori_dokumen->nama;
        }

        $data = [
            'nama' => $getData->nama,
            'excel' => $getData->document_file_excel_path ? asset($getData->document_file_excel_path):null,
            'pdf' => $getData->document_file_pdf_path ? asset($getData->document_file_pdf_path) : null,
            'word' => $getData->document_file_word_path ? asset($getData->document_file_word_path) : null,
            'kategori' => $kategoris
        ];

        return response()->json(['result' => $data]);
    }

    public function update(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori_id' => 'required',
            'kategori_id.*' => 'required',
            'hidden_id' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        if($request->excel)
        {
            $errors = Validator::make($request->all(), [
                'excel' => 'required|mimes:xlsx',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        if($request->pdf)
        {
            $errors = Validator::make($request->all(), [
                'pdf' => 'required|mimes:pdf',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        if($request->word)
        {
            $errors = Validator::make($request->all(), [
                'word' => 'required|mimes:docx',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        try {
            $hiddenId = Crypt::decryptString($request->hidden_id);

            $dokumenGaleri = DokumenGaleri::find($hiddenId);
            $dokumenGaleri->nama = $request->nama;
            $dokumenGaleri->save();

            // Hapus yang lama Start
                $pivotOlds = PivotKategoriDokumen::where('dokumen_id', $hiddenId)->get();
                foreach ($pivotOlds as $pivotOld) {
                    PivotKategoriDokumen::find($pivotOld->id)->delete();
                }
            // Hapus yang lama end
            // Kategori Baru Start
                foreach ($request->kategori_id as $kategori) {
                    $pivot = new PivotKategoriDokumen;
                    $pivot->user_id = Auth::user()->id;
                    $pivot->kategori_id = Crypt::decryptString($kategori);
                    $pivot->dokumen_id = $dokumenGaleri->id;
                    $pivot->save();
                }
            // Kategori Baru End

            if($request->excel)
            {
                $filePathOld = public_path($dokumenGaleri->document_file_excel_path);
                if (file_exists($filePathOld)) {
                    unlink($filePathOld);
                }

                $file = $request->file('excel');

                // Nama file unik
                $filename = time() . '_' . uniqid() . '.' .
                            $file->getClientOriginalExtension();

                $destinationPath = public_path('dokumen/excel');
                $file->move($destinationPath, $filename);

                $dokumenGaleri->document_file_excel_path =
                    'dokumen/excel' . '/' . $filename;
            }
            if($request->pdf)
            {
                $filePathOld = public_path($dokumenGaleri->document_file_pdf_path);
                if (file_exists($filePathOld)) {
                    unlink($filePathOld);
                }

                $file = $request->file('pdf');

                // Nama file unik
                $filename = time() . '_' . uniqid() . '.' .
                            $file->getClientOriginalExtension();

                $destinationPath = public_path('dokumen/pdf');
                $file->move($destinationPath, $filename);

                $dokumenGaleri->document_file_pdf_path =
                    'dokumen/pdf' . '/' . $filename;
            }

            if($request->word)
            {
                $filePathOld = public_path($dokumenGaleri->document_file_word_path);
                if (file_exists($filePathOld)) {
                    unlink($filePathOld);
                }

                $file = $request->file('word');

                // Nama file unik
                $filename = time() . '_' . uniqid() . '.' .
                            $file->getClientOriginalExtension();

                $destinationPath = public_path('dokumen/word');
                $file->move($destinationPath, $filename);

                $dokumenGaleri->document_file_word_path =
                    'dokumen/word' . '/' . $filename;
            }
            $dokumenGaleri->save();

            return response()->json(['success' => 'Berhasil mengupdate data']);

        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $dokumenGaleri = DokumenGaleri::find($id);
            $dokumenGaleri->status_aktif = '0';
            $dokumenGaleri->save();

            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
