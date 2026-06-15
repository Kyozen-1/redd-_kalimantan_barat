@extends('frontend.layouts.site-app')

@section('title', 'Program & Strategi REDD+ | REDD+ Kalimantan Barat')
@section('meta_description', 'Implementasi 5 pilar strategi nasional REDD+ dan laporan program Kalimantan Barat')

@section('body')
    @php
        $pillars = [
            ['title' => 'Kelembagaan & Tata Kelola', 'icon' => 'mdi-account-group'],
            ['title' => 'Kerangka Hukum & Kebijakan', 'icon' => 'mdi-scale-balance'],
            ['title' => 'Keterlibatan Pemangku Kepentingan', 'icon' => 'mdi-account-switch'],
            ['title' => 'Paradigma Perubahan Budaya', 'icon' => 'mdi-handshake'],
            ['title' => 'Program Strategis', 'icon' => 'mdi-calendar-check'],
        ];

        $forestStats = [
            ['label' => 'Hutan Adat', 'value' => '20'],
            ['label' => 'Kemitraan Kehutanan', 'value' => '4'],
            ['label' => 'Hutan Desa', 'value' => '183'],
            ['label' => 'Hutan Kemasyarakatan', 'value' => '25'],
            ['label' => 'Hutan Tanaman Rakyat', 'value' => '39'],
        ];

        $radDocuments = [
            'Strategi dan Rencana Aksi Provinsi (SRAP) REDD+ Kalbar',
            'Dokumen panduan pengembangan kebijakan REDD+ untuk daerah',
            'Strategi dan Rencana Aksi Provinsi (SRAP) REDD+ Kalbar',
        ];

        $reports = array_fill(0, 4, [
            'title' => 'LAPORAN CAPAIAN PENURUNAN EMISI GRK TAHUN 2025',
            'agency' => 'Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat',
            'date' => 'Tanggal upload: 21 Desember 2025',
            'mainSize' => 'PDF - 14MB',
            'tableSize' => 'XLSX',
        ]);
    @endphp

    <main class="site-page program-page">
        <div class="site-shell">
            @include('frontend.layouts.site-header')
        </div>

        <section class="site-shell program-hero">
            <p class="program-eyebrow">Program & Strategi REDD+</p>
            <h1>Implementasi 5 Pilar Strategi Nasional</h1>
        </section>

        <section class="site-shell pillar-section" aria-labelledby="pillar-heading">
            <div class="pillar-copy">
                <h2 id="pillar-heading">&bull; 5 Pilar</h2>
                <p>Strategi Nasional REDD+ dijalankan melalui 5 pilar utama yang saling terintegrasi. Pilar-pilar ini dirancang untuk memperkuat tata kelola kelembagaan, hukum, dan program kerja, sekaligus mendorong perubahan budaya serta kolaborasi aktif di seluruh lapisan masyarakat.</p>
            </div>

            <div class="pillar-grid" aria-label="Daftar 5 pilar strategi nasional REDD+">
                @foreach ($pillars as $pillar)
                    <article class="pillar-card">
                        <h3>{{ $pillar['title'] }}</h3>
                        <i class="mdi {{ $pillar['icon'] }}" aria-hidden="true"></i>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="site-shell social-forest" aria-labelledby="social-forest-heading">
            <div class="section-center">
                <h2 id="social-forest-heading">&bull; Perhutanan Sosial</h2>
                <p>Perhutanan Sosial adalah program strategis nasional yang bertujuan untuk memberikan akses kelola kawasan hutan kepada masyarakat setempat atau masyarakat hukum adat untuk meningkatkan kesejahteraan mereka dan menjaga keseimbangan lingkungan.</p>
            </div>

            <div class="social-stat-grid" aria-label="Statistik perhutanan sosial">
                @foreach ($forestStats as $stat)
                    <article class="social-stat-card">
                        <span>{{ $stat['label'] }}</span>
                        <strong>{{ $stat['value'] }}</strong>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="site-shell program-documents">
            <aside class="rad-panel" aria-labelledby="rad-heading">
                <h2 id="rad-heading">&bull; RAD REDD+ Kalimantan Barat</h2>
                <p>Dokumen kebijakan komprehensif yang menjadi fondasi operasional penurunan emisi di tingkat provinsi</p>

                <label class="search-field">
                    <span class="sr-only">Cari Dokumen</span>
                    <input type="search" placeholder="Cari Dokumen">
                    <i class="mdi mdi-magnify" aria-hidden="true"></i>
                </label>

                <div class="rad-list">
                    @foreach ($radDocuments as $document)
                        <article class="rad-card">
                            <div class="rad-card__preview">
                                <i class="mdi mdi-file-document-outline" aria-hidden="true"></i>
                            </div>
                            <div class="rad-card__body">
                                <h3>{{ $document }}</h3>
                                <a href="#">Download File</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </aside>

            <section class="mrv-panel" aria-labelledby="mrv-heading">
                <h2 id="mrv-heading">&bull; Laporan Emisi (MRV)</h2>

                <label class="search-field search-field--wide">
                    <span class="sr-only">Cari Laporan</span>
                    <input type="search" placeholder="Cari Laporan">
                    <i class="mdi mdi-magnify" aria-hidden="true"></i>
                </label>

                <div class="report-list">
                    @foreach ($reports as $report)
                        <article class="report-item">
                            <h3>{{ $report['title'] }}</h3>
                            <p>{{ $report['agency'] }}</p>
                            <small>{{ $report['date'] }}</small>
                            <div class="report-links">
                                <a href="#">Download File Utama</a>
                                <a href="#">Download Data Tabel</a>
                            </div>
                            <div class="report-meta">
                                <span>{{ $report['mainSize'] }}</span>
                                <span>{{ $report['tableSize'] }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>

                <nav class="pagination-mini" aria-label="Halaman laporan emisi">
                    <a href="#" aria-label="Halaman sebelumnya"><i class="mdi mdi-chevron-left" aria-hidden="true"></i></a>
                    <a href="#">1</a>
                    <a href="#">2</a>
                    <a class="active" href="#" aria-current="page">3</a>
                    <a href="#">4</a>
                    <a href="#" aria-label="Halaman berikutnya"><i class="mdi mdi-chevron-right" aria-hidden="true"></i></a>
                </nav>
            </section>
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection
