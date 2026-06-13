<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Validator;
use DataTables;
use App\Models\DokumenRad;

class DokumenRadController extends Controller
{
    public function index()
    {
        return view('backend.dokumen-rad.index');
    }

    public function datatable()
    {
        $data = new DokumenRad;
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
            ->addColumn('dokumen', function($data){
                return '<iframe src="'.asset($data->document_path).'" width="100%" height="300px" style="border:1px solid #ccc;">
                                Browser Anda tidak mendukung iframe.
                            </iframe>';
            })
            ->rawColumns(['aksi', 'dokumen'])
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

        if($request->document)
        {
            $errors = Validator::make($request->all(), [
                'document' => 'required|mimes:pdf',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        try {
            $dokumenRad = new DokumenRad;
            $dokumenRad->nama = $request->nama;
            $dokumenRad->save();

            $destinationPath = public_path('dokumen-rad');

            // Buat folder jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory(
                    $destinationPath,
                    0755,
                    true,
                    true
                );
            }

            $file = $request->file('document');
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $filePath = 'dokumen-rad/' . $filename;

            $dokumenRad->document_path = $filePath;
            $dokumenRad->save();

            return response()->json(['success' => 'Berhasil menambahkan dokumen rad']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);

        $getData = DokumenRad::find($id);

        $data = [
            'nama' => $getData->nama,
            'document' => $getData->document_path ? asset($getData->document_path) : null,
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

        if($request->document)
        {
            $errors = Validator::make($request->all(), [
                'document' => 'required|mimes:pdf',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        try {
            $hiddenId = Crypt::decryptString($request->hidden_id);

            $dokumenRad = DokumenRad::find($hiddenId);
            $dokumenRad->nama = $request->nama;
            $dokumenRad->save();

            if($request->document)
            {
                $filePathOld = public_path($dokumenRad->document_path);
                if (file_exists($filePathOld)) {
                    unlink($filePathOld);
                }

                $file = $request->file('document');

                // Nama file unik
                $filename = time() . '_' . uniqid() . '.' .
                            $file->getClientOriginalExtension();

                $destinationPath = public_path('dokumen-rad');
                $file->move($destinationPath, $filename);

                $dokumenRad->document_path =
                    'dokumen-rad' . '/' . $filename;
            }

            $dokumenRad->save();

            return response()->json(['success' => 'Berhasil mengupdate data']);

        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $dokumenRad = DokumenRad::find($id);
            $dokumenRad->status_aktif = '0';
            $dokumenRad->save();

            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
