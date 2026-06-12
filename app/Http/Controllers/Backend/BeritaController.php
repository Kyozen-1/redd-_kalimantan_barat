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
                $button_edit = '<button type="button" name="edit" id="'.$id.'"
                class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></button>';
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
}
