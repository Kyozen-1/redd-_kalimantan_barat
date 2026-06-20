@extends('frontend.layouts.site-app')

@section('title', 'Perpustakaan & Publikasi | REDD+ Kalimantan Barat')
@section('meta_description', 'Repositori dokumen digital, gambar, dan video REDD+ Kalimantan Barat')

@section('body')
    @php
        $activeTab = request('tab') === 'dokumen' ? 'dokumen' : 'media';

        $filters = ['Kabupaten / Kota', 'Bulan', '2025'];

        $categories = [
            'Semua',
            'Tingkat Provinsi',
            'Tingkat Kesatuan Hidrologis Gambut',
            'Tingkat Kawasan Konservasi',
            'Tingkat Desa',
            'Laporan Tahunan & Kajian Ilmiah',
        ];

        $documents = [
            'Pergub Kalbar No. 51 Tahun 2024 tentang Rencana Aksi Daerah Penurunan Emisi Gas Rumah Kaca (RAD-GRK) Provinsi Kalimantan Barat',
            'Pergub Kalbar No. 39 Tahun 2019 tentang Pencegahan dan Penanggulangan Kebakaran Hutan dan Lahan',
            'Pergub Kalbar tentang Rencana Aksi Daerah Tujuan Pembangunan Berkelanjutan (RAD-TPB) / SDGs Kalimantan Barat',
            'Pergub Kalbar No. 110 Tahun 2020 tentang Tata Cara Pembukaan Lahan Pertanian Berbasis Kearifan Lokal',
        ];

        $galleryImages = [
            ['src' => 'frontend/images/news-agenda/mangrove-news.png', 'alt' => 'Kegiatan pemantauan mangrove di jalur sungai Kalimantan Barat'],
            ['src' => 'frontend/images/news-agenda/planting-news.png', 'alt' => 'Kegiatan penanaman pohon bersama kelompok masyarakat'],
            ['src' => 'frontend/images/news-agenda/mangrove-news.png', 'alt' => 'Kegiatan pemantauan mangrove di jalur sungai Kalimantan Barat'],
            ['src' => 'frontend/images/news-agenda/mangrove-news.png', 'alt' => 'Kegiatan pemantauan mangrove di jalur sungai Kalimantan Barat'],
            ['src' => 'frontend/images/news-agenda/planting-news.png', 'alt' => 'Kegiatan penanaman pohon bersama kelompok masyarakat'],
            ['src' => 'frontend/images/news-agenda/mangrove-news.png', 'alt' => 'Kegiatan pemantauan mangrove di jalur sungai Kalimantan Barat'],
        ];
    @endphp

    <main class="site-page library-page">
        <div class="site-shell">
            @include('frontend.layouts.site-header')
        </div>

        <section class="site-shell library-hero">
            <p>Perpustakaan & Publikasi</p>
            <h1>Akses Repositori Dokumen Digital</h1>

            <nav class="library-tabs" aria-label="Kategori perpustakaan">
                <a class="{{ $activeTab === 'media' ? 'active' : '' }}" href="{{ route('frontend.perpustakaan-publikasi', ['tab' => 'media']) }}">Gambar &amp; Video</a>
                <span aria-hidden="true"></span>
                <a class="{{ $activeTab === 'dokumen' ? 'active' : '' }}" href="{{ route('frontend.perpustakaan-publikasi', ['tab' => 'dokumen']) }}">Dokumen</a>
            </nav>
        </section>

        <section class="site-shell library-content">
            <div class="library-toolbar {{ $activeTab === 'media' ? 'library-toolbar--media' : '' }}">
                @if ($activeTab === 'dokumen')
                    <label class="library-search">
                        <span class="sr-only">Cari Dokumen</span>
                        <input type="search" placeholder="Cari Dokumen">
                        <i class="mdi mdi-magnify" aria-hidden="true"></i>
                    </label>
                @endif

                <div class="library-selects" aria-label="Filter perpustakaan">
                    @foreach ($filters as $filter)
                        <button type="button">{{ $filter }} <i class="mdi mdi-chevron-down" aria-hidden="true"></i></button>
                    @endforeach
                </div>
            </div>

            @if ($activeTab === 'dokumen')
                <div class="library-chips" aria-label="Kategori dokumen">
                    @foreach ($categories as $index => $category)
                        <button class="{{ $index === 0 ? 'active' : '' }}" type="button">{{ $category }}</button>
                    @endforeach
                </div>

                <div class="document-list">
                    @foreach ($documents as $document)
                        <article class="document-item">
                            <h2>{{ $document }}</h2>
                            <p>Tanggal upload: 21 Desember 2025</p>
                            <div class="document-actions">
                                <div>
                                    <a href="#"><i class="mdi mdi-file-document-outline" aria-hidden="true"></i>Buka File</a>
                                </div>
                                <div>
                                    <a href="#">Download File Utama</a>
                                    <span>PDF - 14MB</span>
                                </div>
                                <div>
                                    <a href="#">Download Data Tabel</a>
                                    <span>XLSX</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="library-gallery">
                    @foreach ($galleryImages as $image)
                        <a class="gallery-tile" href="#">
                            <img src="{{ asset($image['src']) }}" alt="{{ $image['alt'] }}">
                        </a>
                    @endforeach
                </div>
            @endif

            <nav class="pagination-mini library-pagination" aria-label="Halaman perpustakaan">
                <a href="#" aria-label="Halaman sebelumnya"><i class="mdi mdi-chevron-left" aria-hidden="true"></i></a>
                <a href="#">1</a>
                <a href="#">2</a>
                <a class="active" href="#" aria-current="page">3</a>
                <a href="#">4</a>
                <a href="#" aria-label="Halaman berikutnya"><i class="mdi mdi-chevron-right" aria-hidden="true"></i></a>
            </nav>
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection
