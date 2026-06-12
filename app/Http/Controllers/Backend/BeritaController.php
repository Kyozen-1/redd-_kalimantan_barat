<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Mews\Purifier\Facades\Purifier;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use Auth;
use DataTables;
use App\Models\Berita;
use App\Models\PivotGambarBerita;

class BeritaController extends Controller
{
    public function index()
    {
        return view('backend.berita.index');
    }

    public function create()
    {
        return view('backend.berita.create');
    }

    public function datatable()
    {
        $data = new Berita;
        $data = $data->statusAktif();
        $data = $data->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = Crypt::encryptString($data->id);
                $button_edit = '<a href="'.route('cms.berita.edit', ['id' => $id]).'" class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></a>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_edit . ' ' . $button_delete;
                return $button;
            })
            ->addColumn('tanggal', function($data){
                return Carbon::parse($data->created_at)->format('d-m-Y');
            })
            ->rawColumns(['aksi'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        try {
            $berita = new Berita;
            $berita->user_id = Auth::user()->id;
            $berita->judul = $request->judul;
            $berita->deskripsi = Purifier::clean($request->deskripsi,'news');
            $berita->save();

            if ($request->hasFile('gambar')) {

                $destinationPath = public_path('berita');

                if (!File::exists($destinationPath)) {
                    File::makeDirectory(
                        $destinationPath,
                        0755,
                        true,
                        true
                    );
                }

                foreach ($request->file('gambar') as $file) {

                    $fileExtension = $file->getClientOriginalExtension();
                    $fileName = time().'_'.uniqid().'.'.$fileExtension;
                    $file = Image::read($file);
                    $cropSize = $destinationPath.'/'.$fileName;
                    $file->save($cropSize, 60);

                    $pivot = new PivotGambarBerita;
                    $pivot->berita_id = $berita->id;
                    $pivot->nama = $fileName;
                    $pivot->image_path = 'berita/'.$fileName;
                    $pivot->save();
                }
            }

            Alert::success('Berhasil', 'Berita berhasil disimpan');
            return redirect()->route('cms.berita.index');
        } catch (\Throwable $th) {
            return back()->with('failed', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);

        $getData = Berita::find($id);
        $gambar = $getData->pivot_gambar_berita
                    ->map(function ($item) {
                        return [
                            'source' => asset($item->image_path),
                            'path'   => $item->image_path
                        ];
                    });
        $data = [
            'judul' => $getData->judul,
            'deskripsi' => $getData->deskripsi,
            'gambar' => $gambar
        ];
        return view('backend.berita.edit',[
            'id' => Crypt::encryptString($id),
            'berita' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        try {
            $id = Crypt::decryptString($id);
            $berita = Berita::find($id);
            $berita->judul = $request->judul;
            $berita->deskripsi = Purifier::clean($request->deskripsi,'news');
            $berita->save();

            $existingImages = $request->existing_images ?? [];

            $newImages = [];

            if ($request->hasFile('gambar')) {

                foreach ($request->file('gambar') as $file) {

                    $filename =
                        time().'_'.
                        uniqid().
                        '.'.$file->extension();

                    $file->move(
                        public_path('berita'),
                        $filename
                    );

                    $newImages[] =
                        'berita/'.$filename;
                }
            }

            $finalImages = array_merge(
                $existingImages,
                $newImages
            );

            $oldImages = $berita
                        ->pivot_gambar_berita
                        ->pluck('image_path')
                        ->toArray();

            $deletedImages = array_diff(
                                $oldImages,
                                $finalImages
                            );

            PivotGambarBerita::where(
                'berita_id',
                $berita->id
            )->delete();

            foreach ($finalImages as $image) {
                $pivot = new PivotGambarBerita;
                $pivot->berita_id = $berita->id;
                $pivot->nama = basename($image);
                $pivot->image_path = $image;
                $pivot->save();
            }

            foreach ($deletedImages as $image) {
                $path = public_path($image);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            Alert::success('Berhasil', 'Berita berhasil diubah');
            return redirect()->route('cms.berita.index');
        } catch (\Throwable $th) {
            return back()->with('failed', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $berita = Berita::find($id);
            $berita->status_aktif = '0';
            $berita->save();

            return response()->json(['success' => 'Berhasil menghapus data']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
