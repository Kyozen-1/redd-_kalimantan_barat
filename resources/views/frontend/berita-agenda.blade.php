@extends('frontend.layouts.site-app')

@section('title', 'Berita & Agenda | REDD+ Kalimantan Barat')
@section('meta_description', 'Berita terbaru dan agenda kegiatan REDD+ Kalimantan Barat')

@section('body')
    @php
        $sideStories = [
            [
                'title' => 'Dana Insentif REDD+ Mengalir, Pemprov Kalbar Prioritaskan Kelestarian Hutan Desa',
                'image' => 'frontend/images/news-agenda/planting-news.png',
                'category' => 'Pengumuman',
                'time' => '2 hari yang lalu',
            ],
            [
                'title' => 'Geliat Ekonomi Hijau: Masyarakat Lokal Kalbar Manfaatkan Hasil Hutan Bukan Kayu Skema REDD+',
                'image' => 'frontend/images/news-agenda/mangrove-news.png',
                'category' => 'Berita',
                'time' => '5 hari yang lalu',
            ],
        ];

        $otherStories = [
            $sideStories[0],
            $sideStories[1],
            $sideStories[0],
            $sideStories[1],
        ];

        $events = [
            ['date' => '21', 'month' => 'Mei', 'title' => 'Loka Karya Data Emisi Karbon Tingkat Provinsi Kalimantan Barat'],
            ['date' => '25', 'month' => 'Mei', 'title' => 'Peluncuran Inisiatif Restorasi Gambut Berbasis Masyarakat di Kubu Raya'],
            ['date' => '25', 'month' => 'Mei', 'title' => 'Pertemuan Tahunan Mitra Pembangunan REDD+: Capaian & Target 2027'],
        ];
    @endphp

    <main class="site-page news-page">
        <div class="site-shell">
            @include('frontend.layouts.site-header')
        </div>

        <section class="site-shell news-featured" aria-labelledby="featured-news-heading">
            <div class="news-featured__main">
                <p class="news-eyebrow">&bull; Berita Terbaru</p>
                <h1 id="featured-news-heading">Komitmen Hijau Kalbar: Jutaan Hektar Hutan Berhasil Dilindungi Lewat Skema REDD+</h1>

                <article class="featured-article">
                    <img src="{{ asset('frontend/images/news-agenda/featured-news.png') }}" alt="Penyerahan dokumen kerja sama mitigasi perubahan iklim Kalimantan Barat">
                    <div class="article-meta">
                        <span>Berita</span>
                        <small>| 1 Hari yang lalu | Admin</small>
                    </div>
                </article>
            </div>

            <aside class="news-featured__side" aria-label="Berita pilihan">
                @foreach ($sideStories as $story)
                    <article class="story-card story-card--side">
                        <img src="{{ asset($story['image']) }}" alt="{{ $story['title'] }}">
                        <h2>{{ $story['title'] }}</h2>
                        <div class="article-meta">
                            <span>{{ $story['category'] }}</span>
                            <small>| {{ $story['time'] }} | Admin</small>
                        </div>
                    </article>
                @endforeach
            </aside>
        </section>

        <section class="site-shell other-news" aria-labelledby="other-news-heading">
            <h2 id="other-news-heading">&bull; Berita Lainnya</h2>
            <div class="story-grid">
                @foreach ($otherStories as $story)
                    <article class="story-card">
                        <img src="{{ asset($story['image']) }}" alt="{{ $story['title'] }}">
                        <h3>{{ $story['title'] }}</h3>
                        <div class="article-meta">
                            <span>{{ $story['category'] }}</span>
                            <small>| {{ $story['time'] }} | Admin</small>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="site-shell agenda-lsm">
            <section class="agenda-panel" aria-labelledby="agenda-heading">
                <h2 id="agenda-heading">&bull; Update & Kalender Kegiatan</h2>
                <p class="agenda-year">2026</p>

                <div class="agenda-list">
                    @foreach ($events as $event)
                        <article class="agenda-item">
                            <time datetime="2026-05-{{ $event['date'] }}">
                                <strong>{{ $event['date'] }}</strong>
                                <span>{{ $event['month'] }}</span>
                            </time>
                            <div>
                                <h3>{{ $event['title'] }}</h3>
                                <p>Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="lsm-banner" aria-labelledby="lsm-heading">
                <img src="{{ asset('frontend/images/news-agenda/lsm-collab.png') }}" alt="Ruang kolaborasi LSM REDD+ Kalimantan Barat">
                <div class="lsm-banner__content">
                    <h2 id="lsm-heading">&bull; Ruang Kolaborasi LSM</h2>
                    <p>Platform khusus bagi Lembaga Swadaya Masyarakat untuk berbagi laporan lapangan, memantau transparansi data, dan mengajukan inisiatif pelestarian lokal</p>
                    <a class="site-cta" href="#"><span>+</span>Akses Ruang LSM</a>
                </div>
            </section>
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection
