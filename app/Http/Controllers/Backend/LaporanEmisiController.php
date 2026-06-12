<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Validator;
use DataTables;
use App\Models\LaporanEmisi;

class LaporanEmisiController extends Controller
{
    public function index()
    {
        return view('backend.laporan-emisi.index');
    }

    public function datatable()
    {
        $data = new LaporanEmisi;
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
            ->rawColumns(['aksi', 'excel', 'pdf', 'word'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
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
            $laporanEmisi = new LaporanEmisi;
            $laporanEmisi->nama = $request->nama;
            $laporanEmisi->save();

            // Mapping file
            $uploads = [
                'excel' => [
                    'folder' => 'laporan-emisi/excel',
                    'field'  => 'document_file_excel_path'
                ],
                'pdf' => [
                    'folder' => 'laporan-emisi/pdf',
                    'field'  => 'document_file_pdf_path'
                ],
                'word' => [
                    'folder' => 'laporan-emisi/word',
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

                    $laporanEmisi->{$config['field']} =
                        $config['folder'] . '/' . $filename;
                }
            }

            $laporanEmisi->save();

            return response()->json(['success' => 'Berhasil menambahkan Laporan Emisi']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);

        $getData = LaporanEmisi::find($id);

        $data = [
            'nama' => $getData->nama,
            'excel' => $getData->document_file_excel_path ? asset($getData->document_file_excel_path):null,
            'pdf' => $getData->document_file_pdf_path ? asset($getData->document_file_pdf_path) : null,
            'word' => $getData->document_file_word_path ? asset($getData->document_file_word_path) : null
        ];

        return response()->json(['result' => $data]);
    }

    public function update(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
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

            $laporanEmisi = LaporanEmisi::find($hiddenId);
            $laporanEmisi->nama = $request->nama;
            $laporanEmisi->save();

            if($request->excel)
            {
                $filePathOld = public_path($laporanEmisi->document_file_excel_path);
                if (file_exists($filePathOld)) {
                    unlink($filePathOld);
                }

                $file = $request->file('excel');

                // Nama file unik
                $filename = time() . '_' . uniqid() . '.' .
                            $file->getClientOriginalExtension();

                $destinationPath = public_path('laporan-emisi/excel');
                $file->move($destinationPath, $filename);

                $laporanEmisi->document_file_excel_path =
                    'laporan-emisi/excel' . '/' . $filename;
            }
            if($request->pdf)
            {
                $filePathOld = public_path($laporanEmisi->document_file_pdf_path);
                if (file_exists($filePathOld)) {
                    unlink($filePathOld);
                }

                $file = $request->file('pdf');

                // Nama file unik
                $filename = time() . '_' . uniqid() . '.' .
                            $file->getClientOriginalExtension();

                $destinationPath = public_path('laporan-emisi/pdf');
                $file->move($destinationPath, $filename);

                $laporanEmisi->document_file_pdf_path =
                    'laporan-emisi/pdf' . '/' . $filename;
            }

            if($request->word)
            {
                $filePathOld = public_path($laporanEmisi->document_file_word_path);
                if (file_exists($filePathOld)) {
                    unlink($filePathOld);
                }

                $file = $request->file('word');

                // Nama file unik
                $filename = time() . '_' . uniqid() . '.' .
                            $file->getClientOriginalExtension();

                $destinationPath = public_path('laporan-emisi/word');
                $file->move($destinationPath, $filename);

                $laporanEmisi->document_file_word_path =
                    'laporan-emisi/word' . '/' . $filename;
            }
            $laporanEmisi->save();

            return response()->json(['success' => 'Berhasil mengupdate data']);

        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $laporanEmisi = LaporanEmisi::find($id);
            $laporanEmisi->status_aktif = '0';
            $laporanEmisi->save();

            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
