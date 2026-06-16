<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use App\Contracts\FileStorageInterface;
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
            ->editColumn('kabupaten_kota_id', function($data){
                return $data->kabupaten_kota->name;
            })
            ->editColumn('tanggal', function($data){
                return Carbon::parse($data->tanggal)->format('d-m-Y');
            })
            ->addColumn('file', function($data){
                if($data->jenis_file == 'gambar')
                {
                    return '<img src="'.$data->file_url.'" alt="" style="width: 5rem;">';
                }
                if($data->jenis_file == 'video')
                {
                    return '<video style="width:15rem" controls> <source src="'.$data->file_url.'" type="video/mp4">Browser Anda tidak mendukung video.</video>';
                }
            })
            ->rawColumns(['aksi', 'file'])
        ->make(true);
    }

    public function store(Request $request, FileStorageInterface $storage)
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

                $destinationPath = 'galeri/gambar';

                $path = $storage->upload(
                    $request->file('file'),
                    $destinationPath
                );

                $galeri->file_path = $path;
            }

            if($request->jenis_file == 'video')
            {
                if (!in_array(
                    strtolower($request->file('file')->getClientOriginalExtension()),
                    ['mkv', 'mp4']
                )) {
                    return response()->json(['errors' => 'Jenis file tidak sama dengan file yang diupload']);
                }

                $destinationPath = 'galeri/video';

                $path = $storage->upload(
                    $request->file('file'),
                    $destinationPath
                );

                $galeri->file_path = $path;
            }

            $galeri->save();

            return response()->json(['success' => 'Berhasil menambahkan file di galeri']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $getData = Galeri::find($id);
        $data = [
            'nama' => $getData->nama,
            'kabupaten_kota' => $getData->kabupaten_kota->name,
            'tanggal' => $getData->tanggal,
            'jenis_file' => $getData->jenis_file,
            'file_path' => $getData->file_url
        ];

        return response()->json(['result' => $data]);
    }

    public function update(Request $request, FileStorageInterface $storage)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'kabupaten_kota_id' => 'required',
            'tanggal' => 'required',
            'jenis_file' => 'required',
            'hidden_id' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        if($request->file)
        {
            $errors = Validator::make($request->all(), [
                'file' => 'mimes:jpg,jpeg,png,webp,mkv,mp4'
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        try {
            $hiddenId = Crypt::decryptString($request->hidden_id);

            $galeri = Galeri::find($hiddenId);
            $galeri->kabupaten_kota_id = Crypt::decryptString($request->kabupaten_kota_id);
            $galeri->nama = $request->nama;
            $galeri->tanggal = $request->tanggal;
            $galeri->save();

            if($request->file)
            {
                $galeri->jenis_file = $request->jenis_file;
                if($request->jenis_file == 'gambar')
                {
                    if (!in_array(
                        strtolower($request->file('file')->getClientOriginalExtension()),
                        ['jpg', 'jpeg', 'png', 'webp']
                    )) {
                        return response()->json(['errors' => 'Jenis file tidak sama dengan file yang diupload']);
                    }

                    $storage->delete(
                        $galeri->file_path
                    );

                    $destinationPath = 'galeri/gambar';

                    $galeri->file_path = $storage->upload(
                                            $request->file('file'),
                                            $destinationPath
                                        );
                }

                if($request->jenis_file == 'video')
                {
                    if (!in_array(
                        strtolower($request->file('file')->getClientOriginalExtension()),
                        ['mkv', 'mp4']
                    )) {
                        return response()->json(['errors' => 'Jenis file tidak sama dengan file yang diupload']);
                    }

                    $storage->delete(
                        $galeri->file_path
                    );

                    $destinationPath = 'galeri/video';

                    $galeri->file_path = $storage->upload(
                                            $request->file('file'),
                                            $destinationPath
                                        );
                }

                $galeri->save();
            }

            return response()->json(['success' => 'Berhasil merubah data']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $galeri = Galeri::find($id);
            $galeri->status_aktif = '0';
            $galeri->save();
            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['result' => $th->getMessage()]);
        }
    }
}
