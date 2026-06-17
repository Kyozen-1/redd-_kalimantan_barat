<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Contracts\FileStorageInterface;
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
            ->rawColumns(['aksi', 'excel', 'pdf', 'word'])
        ->make(true);
    }

    public function store(Request $request, FileStorageInterface $storage)
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

                    $destinationPath = $config['folder'];

                    $file = $request->file($requestKey);
                    $path = $storage->upload(
                                $file,
                                $destinationPath
                            );

                    $laporanEmisi->{$config['field']} = $path;
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
            'excel' => $getData->document_file_excel_path ? $getData->excel_url:null,
            'pdf' => $getData->document_file_pdf_path ? $getData->pdf_url : null,
            'word' => $getData->document_file_word_path ? $getData->word_url : null
        ];

        return response()->json(['result' => $data]);
    }

    public function update(Request $request, FileStorageInterface $storage)
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
                $storage->delete(
                    $laporanEmisi->document_file_excel_path
                );

                $file = $request->file('excel');
                $destinationPath = 'laporan-emisi/excel';

                $path = $storage->upload(
                            $file,
                            $destinationPath
                        );

                $laporanEmisi->document_file_excel_path = $path;
            }
            if($request->pdf)
            {
                $storage->delete(
                    $laporanEmisi->document_file_pdf_path
                );

                $file = $request->file('pdf');
                $destinationPath = 'laporan-emisi/pdf';

                $path = $storage->upload(
                            $file,
                            $destinationPath
                        );

                $laporanEmisi->document_file_pdf_path = $path;
            }

            if($request->word)
            {
                $storage->delete(
                    $laporanEmisi->document_file_word_path
                );

                $file = $request->file('word');
                $destinationPath = 'laporan-emisi/word';

                $path = $storage->upload(
                            $file,
                            $destinationPath
                        );

                $laporanEmisi->document_file_word_path = $path;
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
