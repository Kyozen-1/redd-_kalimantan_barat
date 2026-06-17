<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Contracts\FileStorageInterface;
use Carbon\Carbon;
use Auth;
use DataTables;
use App\Models\LandingPageSection;
use App\Models\MdSectionLandingPage;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('backend.landing-page.index');
    }

    public function mdSectionLandingPage()
    {
        $getData = MdSectionLandingPage::statusAktif()
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
        $data = new LandingPageSection;
        $data = $data->statusAktif();
        $data = $data->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = Crypt::encryptString($data->id);
                $button_edit = '<a href="'.route('cms.landing-page.edit', ['id' => $id]).'"
                class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></a>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_edit . ' ' . $button_delete;
                return $button;
            })
            ->editColumn('section_id', function($data){
                return $data->section?->nama;
            })
            ->editColumn('content', function($data){
                $html = '<ul>';
                    foreach ($data->content as $key => $value) {
                        if($key == 'image')
                        {
                            $url = Storage::disk('s3')->url($value);
                            $html .= '<li><img src="'.$url.'" alt="" style="width: 5rem;"></li>';
                        } else {
                            $html .= '<li>'.$key.' =  '.$value.'</li>';
                        }
                    }
                $html .='</ul>';
                return $html;
            })
            ->rawColumns(['aksi', 'content'])
        ->make(true);
    }

    public function create()
    {
        $availableFields = config('landing_fields');
        return view('backend.landing-page.create', [
            'sections' => $this->mdSectionLandingPage(),
            'availableFields' => $availableFields
        ]);
    }

    public function store(Request $request, FileStorageInterface $storage)
    {
        $request->validate([
            'sort_order' => 'required',
            'section_id' => 'required'
        ]);

        try {
            $content = [];
            if ($request->has('fields')) {
                foreach ($request->fields as $key => $value) {
                    if ($value !== null && $value !== '') {
                        if($key == 'image')
                        {
                            $destinationPath = 'landing-page/images';

                            $path = $storage->upload(
                                $value,
                                $destinationPath
                            );
                            $content[$key] = $path;
                        } else {
                            $content[$key] = $value;
                        }
                    }
                }
            }
            $sectionId = Crypt::decryptString($request->section_id);
            $count = LandingPageSection::where('section_id', $sectionId)->count();
            $sectionKey = ($count + 1);

            $landingPageSection = new LandingPageSection;
            $landingPageSection->user_id = Auth::user()->id;
            $landingPageSection->section_key = $sectionKey;
            $landingPageSection->section_id = $sectionId;
            $landingPageSection->sort_order = $request->sort_order;
            $landingPageSection->content =  $content;
            $landingPageSection->save();

            Alert::success('Berhasil', 'Landing Page berhasil disimpan');
            return redirect()->route('cms.landing-page.index');
        } catch (\Throwable $th) {
            return back()->with('failed', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $availableFields = config('landing_fields');
        $landingPageSection = LandingPageSection::find($id);
        return view('backend.landing-page.edit', [
            'id' => Crypt::encryptString($id),
            'sections' => $this->mdSectionLandingPage(),
            'availableFields' => $availableFields,
            'landingPageSection' => $landingPageSection
        ]);
    }

    public function update(Request $request, $id, FileStorageInterface $storage)
    {
        $request->validate([
            'sort_order' => 'required',
            'section_id' => 'required'
        ]);

        try {

            $id = Crypt::decryptString($id);

            $section = LandingPageSection::findOrFail($id);

            $oldContent = $section->content ?? [];

            if (is_string($oldContent)) {
                $oldContent = json_decode($oldContent, true) ?? [];
            }

            $content = [];

            if ($request->has('fields')) {

                foreach ($request->fields as $key => $value) {
                    /*
                    |--------------------------------------------------------------------------
                    | IMAGE FIELD
                    |--------------------------------------------------------------------------
                    */
                    if ($key === 'image') {
                        $oldImage = $oldContent['image'] ?? null;
                        /*
                        |--------------------------------------------------------------------------
                        | Upload image baru
                        |--------------------------------------------------------------------------
                        */
                        if ($request->hasFile('fields.image')) {
                            $imageFile = $request->file('fields.image');
                            $destinationPath = 'landing-page/images';

                            $newImagePath = $storage->upload(
                                $imageFile,
                                $destinationPath
                            );
                            $content['image'] = $newImagePath;
                            /*
                            |--------------------------------------------------------------------------
                            | Hapus image lama
                            |--------------------------------------------------------------------------
                            */
                            if ($oldImage && Storage::disk('s3')->exists($oldImage))
                            {
                                $storage->delete(
                                    $oldImage
                                );
                            }
                            continue;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Tidak upload baru
                        |--------------------------------------------------------------------------
                        */
                        if ($oldImage) {
                            $content['image'] = $oldImage;
                        }
                        continue;
                    }
                    /*
                    |--------------------------------------------------------------------------
                    | TEXT FIELD
                    |--------------------------------------------------------------------------
                    */
                    $content[$key] = $value;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Detect field yang dihapus dari UI
            |--------------------------------------------------------------------------
            */
            $removedFields = array_diff(
                array_keys($oldContent),
                array_keys($content)
            );

            /*
            |--------------------------------------------------------------------------
            | Jika image dihapus dari UI
            |--------------------------------------------------------------------------
            */
            if (in_array('image', $removedFields)) {
                $oldImage = $oldContent['image'] ?? null;
                if (
                    $oldImage &&
                    Storage::disk('s3')->exists($oldImage)
                ) {
                    $storage->delete(
                        $oldImage
                    );
                }
            }

            $section->sort_order = $request->sort_order;
            $section->section_id = Crypt::decryptString(
                $request->section_id
            );
            $section->content = $content;
            $section->save();

            Alert::success(
                'Berhasil',
                'Landing Page berhasil mengubah data'
            );

            return redirect()->route(
                'cms.landing-page.index'
            );

        } catch (\Throwable $th) {

            return back()
                ->withInput()
                ->with(
                    'failed',
                    $th->getMessage()
                );
        }
    }

    public function destroy(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
            $landingPageSection = LandingPageSection::find($id);
            $landingPageSection->status_aktif = '0';
            $landingPageSection->save();

            return response()->json(['success' => 'Berhasil menghapus']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
