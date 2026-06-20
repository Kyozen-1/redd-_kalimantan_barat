@extends('frontend.layouts.site-app')

@section('title', 'SIS-REDD+ | REDD+ Kalimantan Barat')
@section('meta_description', 'Sistem Informasi Safeguards REDD+ Kalimantan Barat')

@section('body')
    @php
        $safeguards = [
            'Keselarasan Kebijakan & Regulasi',
            'Transparansi & Akuntabilitas Tata Kelola',
            'Penghormatan terhadap Hak Masyarakat Adat',
            'Partisipasi Penuh Pemangku Kepentingan',
            'Perlindungan Hutan Alam & Keanekaragaman Hayati',
            'Pengelolaan Risiko Pembalikan Emisi',
            'Pengelolaan Risiko Pengalihan Emisi',
        ];

        $metrics = [
            ['label' => 'Total Luas Hutan yang Telah Memiliki Izin Legal', 'value' => '385.420 Hektar'],
            ['label' => 'Jumlah SK (Surat Keputusan) Perhutanan Sosial yang Terbit', 'value' => '248 SK'],
            ['label' => 'Jumlah Kepala Keluarga (KK) yang Menerima Manfaat', 'value' => '42.150'],
            ['label' => 'Kelompok Tani Hutan (KTH) yang Menerima Manfaat', 'value' => '185'],
        ];

        $forestRows = [
            ['desa' => 'Desa A', 'kab' => 'Ketapang', 'skema' => 'Hutan Desa (HD)', 'lembaga' => 'Lembaga A', 'sk' => 'SK.5420/MENLHK/2021'],
            ['desa' => 'Desa B', 'kab' => 'Kubu Raya', 'skema' => 'Hutan Desa (HD)', 'lembaga' => 'Lembaga B', 'sk' => 'SK.2214/MENLHK/2022'],
            ['desa' => 'Desa C', 'kab' => 'Sintang', 'skema' => 'Hutan Adat (HA)', 'lembaga' => 'Lembaga C', 'sk' => 'SK.8845/MENLHK/2023'],
            ['desa' => 'Desa D', 'kab' => 'Kapuas Hulu', 'skema' => 'Hutan Desa (HD)', 'lembaga' => 'Lembaga D', 'sk' => 'SK.1105/MENLHK/2020'],
            ['desa' => 'Desa E', 'kab' => 'Kubu Raya', 'skema' => 'Hutan Kemasyarakatan (HKm)', 'lembaga' => 'Lembaga E', 'sk' => 'SK.3341/MENLHK/2024'],
            ['desa' => 'Desa F', 'kab' => 'Ketapang', 'skema' => 'Hutan Tanaman Rakyat (HTR)', 'lembaga' => 'Lembaga F', 'sk' => 'SK.6572/MENLHK/2022'],
            ['desa' => 'Desa G', 'kab' => 'Kapuas Hulu', 'skema' => 'Hutan Adat (HA)', 'lembaga' => 'Lembaga G', 'sk' => 'SK.9012/MENLHK/2023'],
        ];
    @endphp

    <main class="site-page sis-page">
        <section class="sis-hero">
            <div class="site-shell">
                @include('frontend.layouts.site-header')

                <div class="sis-hero__content">
                    <p>SIS-REDD+</p>
                    <h1>Sistem Informasi Safeguards</h1>
                    <span>Monitoring Sistem | Keadilan Sosial | Akuntabilitas</span>
                </div>
            </div>
        </section>

        <section class="site-shell sis-intro" aria-labelledby="sis-intro-heading">
            <div class="sis-intro__icon" aria-hidden="true">
                <i class="mdi mdi-account-heart"></i>
            </div>
            <h2 id="sis-intro-heading" class="sr-only">Prinsip Safeguards REDD+</h2>
            <p>Menyediakan, mengelola, dan menyajikan informasi mengenai bagaimana prinsip-prinsip perlindungan (safeguards) lingkungan dan sosial diterapkan dalam pelaksanaan program REDD+. Dengan mematuhi 7 poin safeguards cancun, antara lain:</p>

            <div class="sis-chip-list" aria-label="Daftar prinsip safeguards">
                @foreach ($safeguards as $safeguard)
                    <span><i class="mdi mdi-check-circle" aria-hidden="true"></i>{{ $safeguard }}</span>
                @endforeach
            </div>
        </section>

        <section class="site-shell sis-data" aria-label="Data legalitas dan manfaat perhutanan sosial">
            <div class="sis-metric-grid">
                @foreach ($metrics as $metric)
                    <article class="sis-metric-card">
                        <span>{{ $metric['label'] }}</span>
                        <strong>{{ $metric['value'] }}</strong>
                    </article>
                @endforeach
            </div>

            <div class="sis-table-toolbar">
                <label class="sis-search">
                    <span class="sr-only">Cari Data</span>
                    <input type="search" placeholder="Cari Data">
                    <i class="mdi mdi-magnify" aria-hidden="true"></i>
                </label>

                <div class="sis-selects">
                    <button type="button">Kab / Kota <i class="mdi mdi-chevron-down" aria-hidden="true"></i></button>
                    <button type="button">Skema Kelola <i class="mdi mdi-chevron-down" aria-hidden="true"></i></button>
                </div>
            </div>

            <div class="sis-table-wrap">
                <table class="sis-table">
                    <thead>
                        <tr>
                            <th>Nama Desa</th>
                            <th>Kab / Kota</th>
                            <th>Skema Kelola</th>
                            <th>Nama Lembaga Pengelola</th>
                            <th>Nomor SK / Legalitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forestRows as $row)
                            <tr>
                                <td>{{ $row['desa'] }}</td>
                                <td>{{ $row['kab'] }}</td>
                                <td>{{ $row['skema'] }}</td>
                                <td>{{ $row['lembaga'] }}</td>
                                <td>{{ $row['sk'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <nav class="sis-pagination" aria-label="Halaman data safeguards">
                <a class="sis-pagination__control" href="#" aria-label="Halaman sebelumnya"><i class="mdi mdi-chevron-left" aria-hidden="true"></i></a>
                <a href="#" aria-current="page">1</a>
                <a href="#">2</a>
                <span>...</span>
                <a href="#">24</a>
                <a href="#">25</a>
                <a href="#">26</a>
                <a href="#">27</a>
                <a class="sis-pagination__control" href="#" aria-label="Halaman berikutnya"><i class="mdi mdi-chevron-right" aria-hidden="true"></i></a>
            </nav>
        </section>

        <section class="site-shell sis-funding" aria-labelledby="sis-funding-heading">
            <div class="sis-section-title">
                <h2 id="sis-funding-heading">&bull; Transparansi Distribusi Dana</h2>
                <p>Upaya pelaksanaan REDD+ dengan transparansi dan akuntabilitas tata kelola</p>
            </div>

            <div class="sis-chart-panel">
                <div class="sis-chart-filters">
                    <button type="button">2025 <i class="mdi mdi-chevron-down" aria-hidden="true"></i></button>
                    <button type="button">Kategori Kawasan <i class="mdi mdi-chevron-down" aria-hidden="true"></i></button>
                </div>
                <div id="sisFundingChart" class="sis-chart"></div>
            </div>
        </section>

        <section class="site-shell sis-accountability" aria-label="Akuntabilitas dan perlindungan hak masyarakat">
            <form class="sis-report-card" action="#" method="post">
                <h2>&bull; Akuntabilitas</h2>
                <p>Saluran transparan bagi masyarakat untuk melaporkan ketidaksesuaian serta memastikan resolusi konflik yang adil dan inklusif</p>
                <label>
                    <span class="sr-only">Laporan masyarakat</span>
                    <textarea placeholder="Sampaikan laporan Anda..."></textarea>
                </label>
                <button type="button">Kirim Laporan</button>
            </form>

            <article class="sis-rights">
                <h2>&bull; Perlindungan Hak Masyarakat Lokal</h2>
                <p>Komitmen penuh terhadap pengakuan wilayah kelola rakyat dan hak-hak tradisional adat Kalimantan Barat dalam setiap tahapan proyek karbon</p>
            </article>
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('frontend/js/sis-redd.js') }}"></script>
@endpush
