<?php

namespace App\Http\Controllers\Backend\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;
use Validator;
use DataTables;
use App\Models\MdLsm;
use App\Models\Regency;
use App\Models\MdWilayahCakupan;

class LsmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.master-data.lsm.index',
        [
            'kabupatenKotas' => $this->getKabupatenKota(),
            'wilayahCakupans' => $this->getWilayahCakupan()
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

    public function getWilayahCakupan()
    {
        $getData = MdWilayahCakupan::statusAktif()
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
        $data = new MdLsm;
        $data = $data->statusAktif();
        $data = $data->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = Crypt::encryptString($data->id);
                $button_show = '<button type="button" name="detail" id="'.$id.'" class="detail btn btn-icon waves-effect btn-success" title="Detail Data"><i class="fas fa-eye"></i></button>';
                $button_edit = '<button type="button" name="edit" id="'.$id.'"
                class="edit btn btn-icon waves-effect btn-warning" title="Edit Data" data-kabupaten-kota="'.$data->kabupaten_kota->name.'" data-wilayah-cakupan="'.$data->md_wilayah_cakupan->nama.'"><i class="fas fa-edit"></i></button>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_show . ' ' . $button_edit . ' ' . $button_delete;
                return $button;
            })
            ->editColumn('kabupaten_kota_id', function($data){
                return $data->kabupaten_kota?->name;
            })
            ->editColumn('md_wilayah_cakupan_id', function($data){
                return $data->md_wilayah_cakupan?->nama;
            })
            ->editColumn('link', function($data){
                return '<a href="'.$data->link.'" class="btn btn-icon waves-effect btn-info" target="blank"><i class="fas fa-external-link-alt"></i></a>';
            })
            ->rawColumns(['aksi', 'link'])
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
            'link' => 'required',
            'kabupaten_kota_id' => 'required',
            'md_wilayah_cakupan_id' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);
            $wilayahCakupanId = Crypt::decryptString($request->md_wilayah_cakupan_id);

            $mdLsm = new MdLsm;
            $mdLsm->user_id = Auth::user()->id;
            $mdLsm->kabupaten_kota_id = $kabupatenKotaId;
            $mdLsm->nama = $request->nama;
            $mdLsm->link = $request->link;
            $mdLsm->md_wilayah_cakupan_id = $wilayahCakupanId;
            $mdLsm->save();

            return response()->json(['success' => 'Berhasil menambahkan data lsm']);
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
        $getData = MdLsm::find($id);

        $data = [
            'nama' => $getData->nama,
            'kabupaten_kota' => $getData->kabupaten_kota->name,
            'wilayah_cakupan' => $getData->md_wilayah_cakupan->nama
        ];

        return response()->json(['result' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);
        $getData = MdLsm::find($id);

        $data = [
            'nama' => $getData->nama,
            'kabupaten_kota' => $getData->kabupaten_kota->name,
            'wilayah_cakupan' => $getData->md_wilayah_cakupan->nama,
            'link' => $getData->link
        ];

        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'link' => 'required',
            'kabupaten_kota_id' => 'required',
            'md_wilayah_cakupan_id' => 'required',
            'hidden_id' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        try {
            $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);
            $mdWilayahCakupanId = Crypt::decryptString($request->md_wilayah_cakupan_id);
            $hiddenId = Crypt::decryptString($request->hidden_id);

            $mdLsm = MdLsm::find($hiddenId);
            $mdLsm->kabupaten_kota_id = $kabupatenKotaId;
            $mdLsm->link = $request->link;
            $mdLsm->md_wilayah_cakupan_id = $mdWilayahCakupanId;
            $mdLsm->nama = $request->nama;
            $mdLsm->save();

            return response()->json(['success' => 'Berhasil merubah data']);
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
            $mdLsm = MdLsm::find($id);
            $mdLsm->status_aktif = '0';
            $mdLsm->save();

            return response()->json(['success' => 'Berhasil menghapus LSM']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
