<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use Auth;
use Validator;
use DataTables;
use App\Models\Regency;
use App\Models\Galeri;

class GaleriController extends Controller
{
    public function index()
    {
        return view('backend.galeri.index', [
            'kabupatenKotas' => $this->getKabupatenKota()
        ]);
    }

    public function getKabupatenKota()
    {
        $getData = Regency::get()
                    ->map(function($d){
                        return [
                            'id' => Crypt::encryptString($d->id),
                            'nama' => $d->name
                        ];
                    });
        return $getData;
    }

    public function datatable()
    {
        $data = new Galeri;
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
            ->editColumn('tanggal', function($data){
                return Carbon::parse($data->tanggal)->format('d-m-Y');
            })
            ->addColumn('file', function($data){
                if($data->jenis_file == 'gambar')
                {
                    return '<img src="'.asset($data->file_path).'" alt="" style="width: 5rem;">';
                }
                if($data->jenis_file == 'video')
                {
                    return '<video style="width:15rem" controls> <source src="'.asset($data->file_path).'" type="video/mp4">Browser Anda tidak mendukung video.</video>';
                }
            })
            ->rawColumns(['aksi', 'file'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'kabupaten_kota_id' => 'required',
            'tanggal' => 'required',
            'jenis_file' => 'required',
            'file' => 'required | mimes:jpg,jpeg,png,webp,mkv,mp4'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $galeri = new Galeri;
            $galeri->user_id = Auth::user()->id;
            $galeri->kabupaten_kota_id = Crypt::decryptString($request->kabupaten_kota_id);
            $galeri->nama = $request->nama;
            $galeri->tanggal = $request->tanggal;
            $galeri->jenis_file = $request->jenis_file;
            $galeri->save();

            if($request->jenis_file == 'gambar')
            {
                if (!in_array(
                    strtolower($request->file('file')->getClientOriginalExtension()),
                    ['jpg', 'jpeg', 'png', 'webp']
                )) {
                    return response()->json(['errors' => 'Jenis file tidak sama dengan file yang diupload']);
                }

                $destinationPath = public_path('galeri/gambar');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory(
                        $destinationPath,
                        0755,
                        true,
                        true
                    );
                }

                $fileExtension = $request->file('file')->getClientOriginalExtension();
                $fileName = time().'_'.uniqid().'.'.$fileExtension;
                $file = Image::read($request->file);
                $cropSize = $destinationPath.'/'.$fileName;
                $file->save($cropSize, 60);

                $galeri->file_path = 'galeri/gambar/'.$fileName;
            }

            if($request->jenis_file == 'video')
            {
                if (!in_array(
                    strtolower($request->file('file')->getClientOriginalExtension()),
                    ['mkv', 'mp4']
                )) {
                    return response()->json(['errors' => 'Jenis file tidak sama dengan file yang diupload']);
                }

                $destinationPath = public_path('galeri/video');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory(
                        $destinationPath,
                        0755,
                        true,
                        true
                    );
                }

                $file = $request->file('file');
                // Nama file unik
                $filename = time() . '_' . uniqid() . '.' .
                            $file->getClientOriginalExtension();

                $file->move($destinationPath, $filename);

                $galeri->file_path = 'galeri/video/' . $filename;
            }

            $galeri->save();

            return response()->json(['success' => 'Berhasil menambahkan file di galeri']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
