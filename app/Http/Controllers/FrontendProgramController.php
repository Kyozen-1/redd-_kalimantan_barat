<?php

namespace App\Http\Controllers;

use App\Models\DokumenRad;
use App\Models\LaporanEmisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrontendProgramController extends Controller
{
    /**
     * Display the Program & Strategi REDD+ page.
     */
    public function index()
    {
        $radDocuments = DokumenRad::statusAktif()->get();
        $reports = LaporanEmisi::statusAktif()->get();

        return view('frontend.program-strategi-redd', compact('radDocuments', 'reports'));
    }

    /**
     * Download RAD document locally by streaming it.
     */
    public function downloadRad($id)
    {
        $document = DokumenRad::findOrFail($id);

        if (!$document->document_path) {
            abort(404);
        }

        $disk = Storage::disk('minio');

        if (!$disk->exists($document->document_path)) {
            abort(404);
        }

        $mimeType = $disk->mimeType($document->document_path);

        return response()->streamDownload(
            function () use ($disk, $document) {
                $stream = $disk->readStream($document->document_path);
                if ($stream === false) {
                    abort(404);
                }
                while (!feof($stream)) {
                    echo fread($stream, 8192);
                }
                fclose($stream);
            },
            basename($document->document_path),
            [
                'Content-Type' => $mimeType,
            ]
        );
    }

    /**
     * Download MRV report locally by streaming it.
     */
    public function downloadMrv($id, $type)
    {
        $report = LaporanEmisi::findOrFail($id);

        $path = match ($type) {
            'pdf'   => $report->document_file_pdf_path,
            'excel' => $report->document_file_excel_path,
            default => abort(404),
        };

        if (!$path) {
            abort(404);
        }

        $disk = Storage::disk('minio');

        if (!$disk->exists($path)) {
            abort(404);
        }

        $mimeType = $disk->mimeType($path);

        return response()->streamDownload(
            function () use ($disk, $path) {
                $stream = $disk->readStream($path);
                if ($stream === false) {
                    abort(404);
                }
                while (!feof($stream)) {
                    echo fread($stream, 8192);
                }
                fclose($stream);
            },
            basename($path),
            [
                'Content-Type' => $mimeType,
            ]
        );
    }
}
