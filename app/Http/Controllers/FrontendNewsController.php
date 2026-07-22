<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Agenda;
use Illuminate\Http\Request;

class FrontendNewsController extends Controller
{
    /**
     * Display the Berita & Agenda page.
     */
    public function index()
    {
        // Get all active news ordered by newest
        $newsList = Berita::statusAktif()->with(['pivot_gambar_berita' => function($query) {
            $query->statusAktif();
        }])->orderBy('created_at', 'desc')->get();

        // Get all active agendas ordered by date
        $agendas = Agenda::statusAktif()->orderBy('tanggal', 'asc')->get();

        // Separate news list:
        // 1. Featured news (first one)
        $featuredNews = $newsList->first();

        // 2. Side stories (next 2 news items)
        $sideStories = $newsList->slice(1, 2);

        // 3. Other stories (all news items after the first 3)
        $otherStories = $newsList->slice(3);

        return view('frontend.berita-agenda', compact('featuredNews', 'sideStories', 'otherStories', 'agendas'));
    }

    /**
     * Display a specific Berita (News) detail.
     */
    public function show($id)
    {
        $berita = Berita::statusAktif()->with(['pivot_gambar_berita' => function($query) {
            $query->statusAktif();
        }])->findOrFail($id);

        // Retrieve other active news items to populate the sidebar
        $otherStories = Berita::statusAktif()->with(['pivot_gambar_berita' => function($query) {
            $query->statusAktif();
        }])->where('id', '!=', $id)->latest()->take(3)->get();

        return view('frontend.berita-detail', compact('berita', 'otherStories'));
    }
}
