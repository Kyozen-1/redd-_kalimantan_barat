<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;
use Validator;
use DataTables;
use App\Models\MdEmisi;
use App\Models\MdSektorEmisi;
use App\Models\PivotSektorEmisi;
use App\Models\DataEmisi;

class DataEmisiController extends Controller
{
    public function index()
    {
        return view('backend.data-emisi.index',[
            'emisis' => $this->mdEmisi(),
            'sektors' => $this->mdSektorEmisi()
        ]);
    }

    public function mdEmisi()
    {
        $getData = MdEmisi::statusAktif()
                ->get()
                ->map(function($d){
                    return [
                        'id' => Crypt::encryptString($d->id),
                        'nama' => $d->nama
                    ];
                });
        return $getData;
    }

    public function mdSektorEmisi()
    {
        $getData = MdSektorEmisi::statusAktif()
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
        $getDatas = MdEmisi::with([
                        'pivot_sektor_emisi' => function ($q) {
                            $q->statusAktif()
                                ->with([
                                    'sektor_emisi' => function ($q) {
                                        $q->statusAktif();
                                    },
                                    'data_emisi' => function ($q) {
                                        $q->statusAktif();
                                    }
                                ]);
                        }
                    ])
                    ->statusAktif()
                    ->get();

        $data = [];

        foreach ($getDatas as $emisi) {
            foreach ($emisi->pivot_sektor_emisi as $pivot) {
                $dataNilai = [];
                foreach ($pivot->data_emisi as $dataEmisi) {
                    $dataNilai[] = [
                        'id' => Crypt::encryptString($dataEmisi->id),
                        'tahun' => $dataEmisi->tahun,
                        'nilai' => $dataEmisi->nilai
                    ];
                }
                $data[] = [
                    'id' => Crypt::encryptString($emisi->id),
                    'emisi' => $emisi->nama,
                    'sektor' => optional($pivot->sektor_emisi)->nama,
                    'data_nilai' => $dataNilai
                ];
            }
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = $data['id'];
                $button_delete = '<button type="button" id="'.$id.'" class="deleteData btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_delete;
                return $button;
            })
            ->addColumn('nilai', function($data){
                $html = '<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach ($data['data_nilai'] as $data_nilai) {
                                $button_edit = '<button type="button" id="'.$data_nilai['id'].'" class="editNilai btn btn-icon waves-effect btn-warning" title="Edit Nilai"><i class="fas fa-edit"></i></button>';
                                $button_delete = '<button type="button" id="'.$data_nilai['id'].'" class="deleteNilai btn btn-icon waves-effect btn-danger" title="Delete Nilai"><i class="fas fa-trash"></i></button>';
                                $button = $button_edit . ' ' . $button_delete;
                                $html .= '<tr>';
                                    $html .= '<td>'.$data_nilai['tahun'].'</td>';
                                    $html .= '<td class="tdNilai" data-value="'.$data_nilai['nilai'].'">'.$data_nilai['nilai'].'</td>';
                                    $html .= '<td class="tdAction">'.$button.'</td>';
                                $html .= '</tr>';
                            }
                    $html .= '</tbody>
                        </table>';

                return $html;
            })
            ->rawColumns(['aksi','nilai'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'emisi_id' => 'required',
            'sektor_emisi_id' => 'required',
            'data_emisi' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $emisiId = Crypt::decryptString($request->emisi_id);
            $sektorEmisiId = Crypt::decryptString($request->sektor_emisi_id);
            $cekPivotSektorEmisi = PivotSektorEmisi::where('emisi_id', $emisiId)->where('sektor_emisi_id', $sektorEmisiId)->first();
            if($cekPivotSektorEmisi)
            {
                if($cekPivotSektorEmisi->status_aktif == '0')
                {
                    $pivotSektorEmisi = PivotSektorEmisi::find($cekPivotSektorEmisi->id);
                    $pivotSektorEmisi->status_aktif = '1';
                    $pivotSektorEmisi->save();

                    $pivotSektorEmisiId = $pivotSektorEmisi->id;
                } else {
                    $pivotSektorEmisiId = $cekPivotSektorEmisi->id;
                }
            } else {
                $pivotSektorEmisi = new PivotSektorEmisi;
                $pivotSektorEmisi->emisi_id = $emisiId;
                $pivotSektorEmisi->sektor_emisi_id = $sektorEmisiId;
                $pivotSektorEmisi->save();

                $pivotSektorEmisiId = $pivotSektorEmisi->id;
            }

            foreach ($request->data_emisi as $data_emisi) {
                $cekDataEmisi = DataEmisi::where('pivot_sektor_emisi_id', $pivotSektorEmisiId)
                                    ->where('tahun', $data_emisi['tahun'])
                                    ->first();
                if($cekDataEmisi)
                {
                    $dataEmisi = DataEmisi::find($cekDataEmisi->id);
                } else {
                    $dataEmisi = new DataEmisi;
                }
                $dataEmisi->pivot_sektor_emisi_id = $pivotSektorEmisiId;
                $dataEmisi->tahun = $data_emisi['tahun'];
                $dataEmisi->nilai = $data_emisi['nilai'];
                $dataEmisi->status_aktif = '1';
                $dataEmisi->save();
            }

            return response()->json(['success' => 'Berhasil menambahkan data emisi']);

        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function destroyData($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $pivotSektorEmisi = PivotSektorEmisi::find($id);
            $pivotSektorEmisi->status_aktif = '0';
            $pivotSektorEmisi->save();
            return response()->json(['success' => 'Berhasil menghapus data']);
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
            $dataEmisi = DataEmisi::find($id);
            $dataEmisi->nilai = $request->nilai;
            $dataEmisi->save();
            return response()->json(['success' => 'Berhasil merubah nilai data emisi']);

        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function destroyNilai($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $dataEmisi = DataEmisi::find($id);
            $dataEmisi->status_aktif = '0';
            $dataEmisi->save();
            return response()->json(['success' => 'Berhasil menghapus nilai']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
