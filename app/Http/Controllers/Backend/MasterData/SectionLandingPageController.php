<?php

namespace App\Http\Controllers\Backend\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;
use Validator;
use DataTables;
use App\Models\MdSectionLandingPage;

class SectionLandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.master-data.section-landing-page.index');
    }

    public function datatable()
    {
        $data = new MdSectionLandingPage;
        $data = $data->statusAktif();
        $data = $data->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = Crypt::encryptString($data->id);
                $button_show = '<button type="button" name="detail" id="'.$id.'" class="detail btn btn-icon waves-effect btn-success" title="Detail Data"><i class="fas fa-eye"></i></button>';
                $button_edit = '<button type="button" name="edit" id="'.$id.'" class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></button>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_show . ' ' . $button_edit . ' ' . $button_delete;
                return $button;
            })
            ->rawColumns(['aksi'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        try {
            $sectionLandingPage = new MdSectionLandingPage;
            $sectionLandingPage->user_id = Auth::user()->id;
            $sectionLandingPage->nama = $request->nama;
            $sectionLandingPage->save();

            return response()->json(['success' => 'Berhasil menambahkan section landing page']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = Crypt::decryptString($id);
        $getData = MdSectionLandingPage::find($id);
        $dataSend = [
            'nama' => $getData->nama
        ];

        return response()->json(['result' => $dataSend]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);
        $getData = MdSectionLandingPage::find($id);
        $dataSend = [
            'nama' => $getData->nama
        ];

        return response()->json(['result' => $dataSend]);
    }

    /**
     * Update the specified resource in storage.
     */
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

        try {
            $id = Crypt::decryptString($request->hidden_id);

            $sectionLandingPage = MdSectionLandingPage::find($id);
            $sectionLandingPage->nama = $request->nama;
            $sectionLandingPage->save();

            return response()->json(['success' => 'Berhasil merubah section landing page']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
            $sectionLandingPage = MdSectionLandingPage::find($id);
            $sectionLandingPage->status_aktif = '0';
            $sectionLandingPage->save();

            return response()->json(['success' => 'Berhasil menghapus section landing page']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
