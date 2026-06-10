<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Auth;
use Validator;
use DataTables;
use App\Models\DokumenGaleri;
use App\Models\PivotKategoriDokumen;
use App\Models\MdKategoriDokumen;

class DokumenGaleriController extends Controller
{
    public function index()
    {
        return view('backend.dokumen-galeri.index',[
            'mdKategoriDokumens' => $this->mdKategoriDokumen()
        ]);
    }

    public function mdKategoriDokumen()
    {
        $getData = MdKategoriDokumen::statusAktif()
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
        $data = new DokumenGaleri;
        $data = $data->statusAktif();
        $data = $data->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function($data){
                $id = Crypt::encryptString($data->id);
                $button_show = '<button type="button" name="detail" id="'.$id.'" class="detail btn btn-icon waves-effect btn-success" title="Detail Data"><i class="fas fa-eye"></i></button>';
                $button_edit = '<button type="button" name="edit" id="'.$id.'"
                class="edit btn btn-icon waves-effect btn-warning" title="Edit Data"><i class="fas fa-edit"></i></button>';
                $button_delete = '<button type="button" name="delete" id="'.$id.'" class="delete btn btn-icon waves-effect btn-danger" title="Delete Data"><i class="fas fa-trash"></i></button>';
                $button = $button_show . ' ' . $button_edit . ' ' . $button_delete;
                return $button;
            })
            ->addColumn('kategori', function($data){
                $pivots = $data->pivot_kategori_dokumen;
                $html = '<ul>';
                foreach ($pivots as $pivot) {
                    $html .= '<li>'.$pivot->md_kategori_dokumen->nama.'</li>';
                }
                $html .= '</ul>';
                return $html;
            })
            ->addColumn('excel', function($data){

            })
            ->addColumn('pdf', function($data){

            })
            ->addColumn('word', function($data){

            })
            ->rawColumns(['aksi', 'kategori'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $errors = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori_id' => 'required',
            'kategori_id.*' => 'required',
        ]);

        if($errors -> fails())
        {
            return response()->json(['errors' => $errors->errors()->all()]);
        }

        if($request->excel)
        {
            $errors = Validator::make($request->all(), [
                'excel' => 'required|mimes:xlsx',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        if($request->pdf)
        {
            $errors = Validator::make($request->all(), [
                'pdf' => 'required|mimes:pdf',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        if($request->word)
        {
            $errors = Validator::make($request->all(), [
                'word' => 'required|mimes:docx',
            ]);

            if($errors -> fails())
            {
                return response()->json(['errors' => $errors->errors()->all()]);
            }
        }

        try {
            $dokumenGaleri = new DokumenGaleri;
            $dokumenGaleri->user_id = Auth::user()->id;
            $dokumenGaleri->nama = $request->nama;
            $dokumenGaleri->save();

            $kategoriId = $request->kategori_id;
            for ($i=0; $i < count($kategoriId); $i++) {
                $pivot = new PivotKategoriDokumen;
                $pivot->user_id = Auth::user()->id;
                $pivot->kategori_id = Crypt::decryptString($kategoriId[$i]);
                $pivot->dokumen_id = $dokumenGaleri->id;
                $pivot->save();
            }

            if($request->excel)
            {
                $file = $request->file('excel');
                $filename = $file->getClientOriginalName();
                $destinationPath = public_path('dokumen/excel');
                $file->move($destinationPath, $filename);
                $filePath = 'dokumen/excel/' . $filename;

                $fileExcelUpload = DokumenGaleri::find($dokumenGaleri->id);
                $fileExcelUpload->document_file_excel_path = $filePath;
                $fileExcelUpload->save();
            }

            if($request->pdf)
            {
                $file = $request->file('pdf');
                $filename = $file->getClientOriginalName();
                $destinationPath = public_path('dokumen/pdf');
                $file->move($destinationPath, $filename);
                $filePath = 'dokumen/pdf/' . $filename;

                $filePdfUpload = DokumenGaleri::find($dokumenGaleri->id);
                $filePdfUpload->document_file_pdf_path = $filePath;
                $filePdfUpload->save();
            }

            if($request->word)
            {
                $file = $request->file('word');
                $filename = $file->getClientOriginalName();
                $destinationPath = public_path('dokumen/word');
                $file->move($destinationPath, $filename);
                $filePath = 'dokumen/word/' . $filename;

                $fileWordUpload = DokumenGaleri::find($dokumenGaleri->id);
                $fileWordUpload->document_file_word_path = $filePath;
                $fileWordUpload->save();
            }

            return response()->json(['success' => 'Berhasil menambahkan dokumen galeri']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage()]);
        }
    }
}
