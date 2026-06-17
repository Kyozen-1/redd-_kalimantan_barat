<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Contracts\FileStorageInterface;
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
                        src="https://view.officeapps.live.com/op/embed.aspx?src='.$data->excel_url.'"
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
                    return '<iframe src="'.$data->pdf_url.'" width="100%" height="300px" style="border:1px solid #ccc;">
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
                        src="https://view.officeapps.live.com/op/embed.aspx?src='.$data->word_url.'"
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

    public function store(Request $request, FileStorageInterface $storage)
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

                    $destinationPath = $config['folder'];
                    $file = $request->file($requestKey);
                    $path = $storage->upload(
                                $file,
                                $destinationPath
                            );

                    $dokumenGaleri->{$config['field']} = $path;
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
            'excel' => $getData->document_file_excel_path ? $getData->excel_url:null,
            'pdf' => $getData->document_file_pdf_path ? $getData->pdf_url : null,
            'word' => $getData->document_file_word_path ? $getData->word_url : null,
            'kategori' => $kategoris
        ];

        return response()->json(['result' => $data]);
    }

    public function update(Request $request, FileStorageInterface $storage)
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
                $storage->delete(
                    $dokumenGaleri->document_file_excel_path
                );

                $file = $request->file('excel');
                $destinationPath = 'dokumen/excel';

                $path = $storage->upload(
                            $file,
                            $destinationPath
                        );

                $dokumenGaleri->document_file_excel_path = $path;
            }
            if($request->pdf)
            {
                $storage->delete(
                    $dokumenGaleri->document_file_pdf_path
                );

                $file = $request->file('pdf');
                $destinationPath = 'dokumen/pdf';

                $path = $storage->upload(
                            $file,
                            $destinationPath
                        );

                $dokumenGaleri->document_file_pdf_path = $path;
            }

            if($request->word)
            {
                $storage->delete(
                    $dokumenGaleri->document_file_word_path
                );

                $file = $request->file('word');
                $destinationPath = 'dokumen/word';

                $path = $storage->upload(
                            $file,
                            $destinationPath
                        );

                $dokumenGaleri->document_file_word_path = $path;
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
