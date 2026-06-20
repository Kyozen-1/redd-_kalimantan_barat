<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;
use Validator;
use DataTables;
use App\Models\Agenda;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.agenda.index');
    }

    public function datatable()
    {
        $data = new Agenda;
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
            ->editColumn('tanggal', function($data){
                return Carbon::parse($data->tanggal)->format('d-m-Y');
            })
            ->editColumn('deskripsi', function($data){
                return '<div class="text-truncate" style="max-width:250px;">'
                            .$data->deskripsi.
                        '</div>';
            })
            ->rawColumns(['aksi','deskripsi'])
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
            'tanggal' => 'required',
            'deskripsi' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        try {
            $agenda = new Agenda;
            $agenda->user_id = Auth::user()->id;
            $agenda->nama = $request->nama;
            $agenda->tanggal = $request->tanggal;
            $agenda->deskripsi = $request->deskripsi;
            $agenda->save();

            return response()->json(['success' => 'Berhasil menambahkan agenda']);
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
        $getData = Agenda::find($id);
        $data = [
            'nama' => $getData->nama,
            'tanggal' => Carbon::parse($getData->tanggal)->format('d-m-Y'),
            'deskripsi' => $getData->deskripsi
        ];

        return response()->json(['result' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = Crypt::decryptString($id);
        $getData = Agenda::find($id);
        $data = [
            'nama' => $getData->nama,
            'tanggal' => $getData->tanggal,
            'deskripsi' => $getData->deskripsi
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
            'tanggal' => 'required',
            'deskripsi' => 'required',
            'hidden_id' => 'required'
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }
        try {
            $hiddenId = Crypt::decryptString($request->hidden_id);
            $agenda = Agenda::find($hiddenId);
            $agenda->nama = $request->nama;
            $agenda->tanggal = $request->tanggal;
            $agenda->deskripsi = $request->deskripsi;
            $agenda->save();

            return response()->json(['success' => 'Berhasil merubah agenda']);
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
            $agenda = Agenda::find($id);
            $agenda->status_aktif = '0';
            $agenda->save();

            return response()->json(['success' => 'Berhasil menghapus agenda']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
