<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Validator;
use App\Models\MdPenyebabDeforestasi;
use App\Models\Regency;
use App\Models\DataDeforestasi;

class DataDeforestasiController extends Controller
{
    public function index()
    {
        return view('backend.data-deforestasi.index',[
            'penyebabDeforestasis' => $this->mdPenyebabDeforestasi(),
            'kabupatenKotas' => $this->getKabupatenKota()
        ]);
    }

    public function mdPenyebabDeforestasi()
    {
        $getData = MdPenyebabDeforestasi::statusAktif()
                ->get()
                ->map(function($d){
                    return [
                        'id' => Crypt::encryptString($d->id),
                        'real_id' => $d->id,
                        'nama' => $d->nama
                    ];
                });
        return $getData;
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

    public function data($penyebab_deforestasi_id)
    {
        try {
            $penyebabDeforestasiId = Crypt::decryptString($penyebab_deforestasi_id);
        } catch (\Throwable $th) {
            $penyebabDeforestasiId = $penyebab_deforestasi_id;
        }
        $data = DataDeforestasi::with('kabupaten_kota')
                    ->where('penyebab_deforestasi_id',$penyebabDeforestasiId)
                    ->statusAktif()
                    ->orderBy('kabupaten_kota_id')
                    ->orderBy('tahun')
                    ->get();

        $group = $data->groupBy(function($item){

            return $item->kabupaten_kota->name;

        });

        return view('backend.data-deforestasi.partials.data',compact('group'));
    }

    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'penyebab_deforestasi_id' => 'required',
            'kabupaten_kota_id' => 'required',
            'data_deforestasi' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $penyebabDeforestasiId = Crypt::decryptString($request->penyebab_deforestasi_id);
            $kabupatenKotaId = Crypt::decryptString($request->kabupaten_kota_id);

            foreach ($request->data_deforestasi as $data_deforestasi) {
                $cekDataDeforestasi = DataDeforestasi::where('penyebab_deforestasi_id', $penyebabDeforestasiId)
                                    ->where('kabupaten_kota_id', $kabupatenKotaId)
                                    ->where('tahun', $data_deforestasi['tahun'])
                                    ->first();
                if($cekDataDeforestasi)
                {
                    $dataDeforestasi = DataDeforestasi::find($cekDataDeforestasi->id);
                } else {
                    $dataDeforestasi = new DataDeforestasi;
                }
                $dataDeforestasi->penyebab_deforestasi_id = $penyebabDeforestasiId;
                $dataDeforestasi->kabupaten_kota_id = $kabupatenKotaId;
                $dataDeforestasi->tahun = $data_deforestasi['tahun'];
                $dataDeforestasi->nilai = $data_deforestasi['nilai'];
                $dataDeforestasi->status_aktif = '1';
                $dataDeforestasi->save();
            }

            return response()->json(['success' => 'Berhasil menambahkan data deforestasi']);

        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function updateNilai(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'id' => 'required',
            'nilai' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $id = Crypt::decryptString($request->id);
            $dataDeforestasi = DataDeforestasi::find($id);
            $dataDeforestasi->nilai = $request->nilai;
            $dataDeforestasi->save();
            return response()->json(['success' => 'Berhasil merubah nilai data deforestasi']);

        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function destroyNilai($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $dataDeforestasi = DataDeforestasi::find($id);
            $dataDeforestasi->status_aktif = '0';
            $dataDeforestasi->save();
            return response()->json([
                'success' => 'Berhasil menghapus nilai'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
