<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Validator;
use DataTables;
use Auth;
use App\Models\MdKawasanHutan;
use App\Models\DataKawasan;

class DataKawasanController extends Controller
{
    public function index()
    {
        return view('backend.data-kawasan.index', [
            'kawasanHutans' => $this->mdKawasanHutan()
        ]);
    }

    public function mdKawasanHutan()
    {
        $getData = MdKawasanHutan::statusAktif()
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
        $getDatas = MdKawasanHutan::with([
                        'data_kawasan' => function ($q) {
                            $q->statusAktif();
                        }
                    ])
                    ->statusAktif()
                    ->get();

        $data = [];

        foreach ($getDatas as $kawasan) {
            $dataNilai = [];
            foreach ($kawasan->data_kawasan as $dataKawasan) {
                $dataNilai[] = [
                    'id' => Crypt::encryptString($dataKawasan->id),
                    'tahun' => $dataKawasan->tahun,
                    'nilai' => $dataKawasan->nilai
                ];
            }
            $data[] = [
                'kawasan' => $kawasan->nama,
                'data_nilai' => $dataNilai
            ];
        }

        return DataTables::of($data)
            ->addIndexColumn()
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
            ->rawColumns(['nilai'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'kawasan_hutan_id' => 'required',
            'data_kawasan' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        try {
            $kawasanHutanId = Crypt::decryptString($request->kawasan_hutan_id);

            foreach ($request->data_kawasan as $data_kawasan) {
                $cekDataKawasan = DataKawasan::where('kawasan_hutan_id', $kawasanHutanId)
                                    ->where('tahun', $data_kawasan['tahun'])
                                    ->first();
                if($cekDataKawasan)
                {
                    $dataKawasan = DataKawasan::find($cekDataKawasan->id);
                } else {
                    $dataKawasan = new DataKawasan;
                }
                $dataKawasan->user_id = Auth::user()->id;
                $dataKawasan->kawasan_hutan_id = $kawasanHutanId;
                $dataKawasan->tahun = $data_kawasan['tahun'];
                $dataKawasan->nilai = $data_kawasan['nilai'];
                $dataKawasan->status_aktif = '1';
                $dataKawasan->save();
            }

            return response()->json(['success' => 'Berhasil menambahkan data kawasan']);

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
            $dataKawasan = DataKawasan::find($id);
            $dataKawasan->nilai = $request->nilai;
            $dataKawasan->save();
            return response()->json(['success' => 'Berhasil merubah nilai data Kawasan']);

        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }

    public function destroyNilai($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $dataKawasan = DataKawasan::find($id);
            $dataKawasan->status_aktif = '0';
            $dataKawasan->save();
            return response()->json(['success' => 'Berhasil menghapus nilai']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
