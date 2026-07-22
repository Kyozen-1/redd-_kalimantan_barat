<?php

namespace App\Http\Controllers;

use App\Models\DokumenRad;
use App\Models\LaporanEmisi;
use Illuminate\Http\Request;

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
}
