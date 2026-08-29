@extends('frontend.layouts.site-app')

@section('title', 'Data dan Pemetaan | REDD+ Kalimantan Barat')
@section('meta_description', 'Dashboard data dan pemetaan REDD+ Kalimantan Barat')

@section('body')
    <main class="site-page data-map-page">
        <section class="map-hero">
            @include('frontend.layouts.site-header')
            <div class="site-shell">
                <div class="map-hero__content">
                    <p>Data dan Pemetaan</p>
                    <h1>Akses Penuh Peta Interaktif</h1>
                    <a class="site-cta" href="{{ route('frontend.peta') }}"><span>+</span>Lihat Peta</a>
                </div>
            </div>
        </section>

        <section id="dashboard" class="site-shell data-dashboard">
            <div class="data-panel data-panel--main">
                <div class="metric-grid metric-grid--top">
                    <article class="metric-card metric-card--wide">
                        <span>Luas Hutan</span>
                        <strong>{{ $luasHutan }}</strong>
                    </article>
                    <article class="metric-card metric-card--wide">
                        <span>Stok Karbon</span>
                        <strong>{{ $stokKarbon }}</strong>
                        <small class="down">{{ $stokKarbonDiff }}</small>
                    </article>
                    <article class="metric-card">
                        <span>Emisi 2025</span>
                        <strong>{{ $emisi2025 }}</strong>
                        <small class="up">▲ 12.5 %</small>
                    </article>
                    <article class="metric-card">
                        <span>Deforestasi 2025</span>
                        <strong>{{ $deforestasi2025 }}</strong>
                        <small class="up">▲ 28 %</small>
                    </article>
                    <article class="metric-card">
                        <span>Serapan Hutan 2025</span>
                        <strong>{{ $serapan2025 }}</strong>
                        <small class="down">▼ 11 %</small>
                    </article>
                    <article class="metric-card">
                        <span>Luas Hutan Tersisa 2025</span>
                        <strong>{{ $luasHutanTersisa }}</strong>
                        <small class="up">▲ 18 %</small>
                    </article>
                </div>

                <div class="chart-toolbar">
                    <div class="chart-legend">
                        <span><i class="legend-green"></i>Emisi CO₂ (Mt CO₂e)</span>
                        <span><i class="legend-brown"></i>Serapan Karbon Hutan (Mt)</span>
                        <span><i class="legend-blue"></i>Deforestasi (rb ha)</span>
                    </div>
                    <div class="chart-filters">
                        <select aria-label="Tahun mulai">
                            <option>2016</option>
                        </select>
                        <span>Sampai</span>
                        <select aria-label="Tahun akhir">
                            <option>2025</option>
                        </select>
                        <small>Maks. 10 Tahun</small>
                    </div>
                </div>

                <div id="forestChart" class="chart-box chart-box--large"></div>
            </div>

            <div class="data-divider"></div>

            <div class="peat-grid">
                <div class="metric-stack">
                    <article class="metric-card">
                        <span>Total Lahan Gambut</span>
                        <strong>{{ $totalGambut }}</strong>
                        <em>Berdasarkan total wilayah Kalbar</em>
                    </article>
                    <article class="metric-card">
                        <span>Gambut Terdegradasi</span>
                        <strong>41 %</strong>
                        <small class="up">▲ 6 %</small>
                    </article>
                    <article class="metric-card">
                        <span>Kawasan Konservasi</span>
                        <strong>3.12 jt ha</strong>
                        <small class="down">▲ 21 %</small>
                    </article>
                    <article class="metric-card">
                        <span>Gambut Dalam Restorasi</span>
                        <strong>218 rb ha</strong>
                        <em>Target 450 rb ha (2030)</em>
                    </article>
                </div>

                <div class="data-panel">
                    <div class="panel-title">
                        <h2>• Kondisi Lahan Gambut Kalimantan Barat</h2>
                        <select id="peatYearSelect" aria-label="Tahun kondisi gambut">
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div id="peatDonutChart" class="chart-box chart-box--donut"></div>
                </div>
            </div>

            <div class="data-panel">
                <div class="panel-title panel-title--spaced">
                    <h2>• Tren Degradasi Gambut</h2>
                    <div class="chart-filters">
                        <select aria-label="Tahun mulai tren gambut">
                            <option>2016</option>
                        </select>
                        <span>Sampai</span>
                        <select aria-label="Tahun akhir tren gambut">
                            <option>2025</option>
                        </select>
                        <small>Maks. 10 Tahun</small>
                    </div>
                </div>
                <div class="chart-legend chart-legend--panel">
                    <span><i class="legend-green"></i>Dalam Restorasi</span>
                    <span><i class="legend-blue"></i>Terdegradasi</span>
                </div>
                <div id="peatTrendChart" class="chart-box"></div>
            </div>

            <div class="data-panel">
                <div class="panel-title panel-title--spaced">
                    <h2>• Luas Kawasan Konservasi Per-Kategori (rb ha)</h2>
                    <div class="chart-filters chart-filters--compact">
                        <select aria-label="Tahun kawasan">
                            <option>2025</option>
                        </select>
                        <select aria-label="Kategori kawasan">
                            <option>Kategori Kawasan</option>
                        </select>
                    </div>
                </div>
                <div id="conservationChart" class="chart-box chart-box--bar"></div>
            </div>

            <div class="data-panel">
                <div class="panel-title panel-title--spaced">
                    <h2>• Luas Deforestasi akibat Karhutla Kalimantan Barat (rb ha)</h2>
                    <div class="chart-filters">
                        <select id="deforestasiRegencySelect" aria-label="Pilih Kabupaten/Kota">
                            @foreach($regencies as $reg)
                                <option value="{{ $reg->id }}" {{ str_contains(strtolower($reg->name), 'bengkayang') ? 'selected' : '' }}>{{ $reg->name }}</option>
                            @endforeach
                        </select>
                        <select id="deforestasiStartYear" aria-label="Tahun mulai">
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ $yr == '2019' ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                        <span>Sampai</span>
                        <select id="deforestasiEndYear" aria-label="Tahun selesai">
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ $yr == '2026' ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                        <small>Maks. 10 Tahun</small>
                    </div>
                </div>
                <div id="karhutlaDeforestasiChart" class="chart-box"></div>
            </div>
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection

@push('scripts')
    <script>
        window.dbChartData = {
            emisiCo2: @json($emisiCo2List),
            serapanKarbon: @json($serapanList),
            deforestasi: @json($deforestasiList),
            peatDonut: @json($peatDonutList),
            peatDonutYears: @json($peatDonutYearly),
            restorasiTrend: @json($restorasiTrend),
            degradasiTrend: @json($degradasiTrend),
            conservation: @json($conservationList),
            karhutlaYears: @json($defaultKarhutlaYears),
            karhutlaList: @json($defaultKarhutlaList),
            ajaxRoute: "{{ route('api.deforestasi-karhutla') }}"
        };
    </script>
    <script src="{{ asset('frontend/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('frontend/js/data-pemetaan.js') }}"></script>
@endpush
