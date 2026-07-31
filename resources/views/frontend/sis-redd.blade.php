@extends('frontend.layouts.site-app')

@section('title', 'SIS-REDD+ | REDD+ Kalimantan Barat')
@section('meta_description', 'Sistem Informasi Safeguards REDD+ Kalimantan Barat')

@section('body')
    <main class="site-page sis-page">
        <section class="sis-hero">
            @include('frontend.layouts.site-header')
            <div class="site-shell">

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

            <form method="GET" action="{{ route('frontend.sis-redd') }}" class="sis-table-toolbar">
                <label class="sis-search">
                    <span class="sr-only">Cari Data</span>
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari Data" onchange="this.form.submit()">
                    <i class="mdi mdi-magnify" aria-hidden="true"></i>
                </label>

                <div class="sis-selects">
                    <select name="kabupaten" onchange="this.form.submit()" style="height: 2.08rem; padding: 0 0.8rem; border: 1px solid #cfd4cf; border-radius: 0.22rem; background: #fff; color: #555; font-size: 0.75rem; outline: none; cursor: pointer;">
                        <option value="">-- Kab / Kota --</option>
                        @foreach ($regencies as $reg)
                            <option value="{{ $reg->id }}" {{ (string)$selectedKabupaten === (string)$reg->id ? 'selected' : '' }}>{{ str_replace(['Kabupaten ', 'Kota '], '', $reg->name) }}</option>
                        @endforeach
                    </select>

                    <select name="skema" onchange="this.form.submit()" style="height: 2.08rem; padding: 0 0.8rem; border: 1px solid #cfd4cf; border-radius: 0.22rem; background: #fff; color: #555; font-size: 0.75rem; outline: none; cursor: pointer;">
                        <option value="">-- Skema Kelola --</option>
                        @foreach ($skemaOptions as $skema)
                            <option value="{{ $skema }}" {{ $selectedSkema === $skema ? 'selected' : '' }}>{{ $skema }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <div class="sis-table-wrap">
                <table class="sis-table">
                    <thead>
                        <tr>
                            <th>Nama Desa / LSM</th>
                            <th>Kab / Kota</th>
                            <th>Skema Kelola</th>
                            <th>Nama Lembaga Pengelola</th>
                            <th>Nomor SK / Legalitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($forestData) > 0)
                            @foreach ($forestData as $item)
                                <tr>
                                    <td>{{ $item->nama_desa }}</td>
                                    <td>{{ $item->kabupaten_kota ? str_replace(['Kabupaten ', 'Kota '], '', $item->kabupaten_kota->name) : '-' }}</td>
                                    <td>{{ $item->skema }}</td>
                                    <td>{{ $item->nama_lembaga }}</td>
                                    <td>{{ $item->nomor_sk }}</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($defaultForestRows as $row)
                                <tr>
                                    <td>{{ $row['desa'] }}</td>
                                    <td>{{ $row['kab'] }}</td>
                                    <td>{{ $row['skema'] }}</td>
                                    <td>{{ $row['lembaga'] }}</td>
                                    <td>{{ $row['sk'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($forestData instanceof \Illuminate\Pagination\LengthAwarePaginator && $forestData->hasPages())
                <div class="sis-pagination" style="margin-top: 2.5rem;">
                    {{ $forestData->links() }}
                </div>
            @endif
        </section>

        <section class="site-shell sis-funding-section" aria-labelledby="sis-funding-heading">
            <div class="section-center">
                <h2 id="sis-funding-heading">+ Transparansi Distribusi Dana</h2>
                <p>Mekanisme Alokasi Insentif Finansial yang Adil, Akuntabel, dan Tepat Sasaran</p>
            </div>

            <div class="sis-funding-grid">
                <article class="sis-funding-card">
                    <h3>Pemerintah Daerah</h3>
                    <p>Dukungan penganggaran program hijau dan tata kelola kawasan hutan.</p>
                </article>
                <article class="sis-funding-card">
                    <h3>Masyarakat Lokal & Adat</h3>
                    <p>Insentif langsung bagi komunitas penjaga kelestarian hutan.</p>
                </article>
                <article class="sis-funding-card">
                    <h3>Lembaga Pendukung</h3>
                    <p>Pendanaan kegiatan operasional dan pendampingan lapangan LSM.</p>
                </article>
            </div>
        </section>

        <section class="site-shell sis-accountability-section">
            <div class="section-center">
                <h2>+ Akuntabilitas</h2>
                <p>Pelaporan Berkala dan Audit Terbuka Memastikan Tata Kelola Bebas dari Penyimpangan</p>
            </div>
        </section>

        <section class="site-shell sis-rights-section">
            <div class="section-center">
                <h2>+ Perlindungan Hak Masyarakat Lokal</h2>
                <p>Jaminan Hak Adat, Konsultasi Bebas Tanpa Paksaan (FPIC), dan Akses Informasi Publik</p>
            </div>
        </section>

        <section class="site-shell sis-accountability" aria-label="Akuntabilitas dan perlindungan hak masyarakat">
            <form class="sis-report-card" action="{{ route('frontend.sis-redd.report') }}" method="POST">
                @csrf
                <h2>+ Akuntabilitas</h2>
                <p>Saluran transparan bagi masyarakat untuk melaporkan ketidaksesuaian serta memastikan resolusi konflik yang adil dan inklusif</p>

                @if(session('success'))
                    <div style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4); color: #fff; padding: 0.8rem 1rem; border-radius: 6px; font-size: 0.85rem; margin-bottom: 1rem;">
                        <i class="mdi mdi-check-circle" aria-hidden="true"></i> {{ session('success') }}
                    </div>
                @endif

                <label>
                    <span class="sr-only">Laporan masyarakat</span>
                    <textarea name="laporan" placeholder="Sampaikan laporan Anda..." required style="width: 100%; min-height: 90px; padding: 0.8rem; border-radius: 6px; border: none; font-size: 0.85rem; outline: none; margin-bottom: 1rem;"></textarea>
                </label>
                <button type="submit" style="background: #ffffff; color: #126d0c; border: none; padding: 0.6rem 1.4rem; border-radius: 6px; font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: background 0.2s;">Kirim Laporan</button>
            </form>

            <article class="sis-rights">
                <h2>+ Perlindungan Hak Masyarakat Lokal</h2>
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
