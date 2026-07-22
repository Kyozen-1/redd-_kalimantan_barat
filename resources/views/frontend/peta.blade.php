@extends('frontend.layouts.site-app')

@section('title', 'Peta Kalimantan Barat | REDD+ Kalimantan Barat')
@section('meta_description', 'Sistem Informasi Spasial Data Kehutanan Kalimantan Barat - Peta interaktif tutupan lahan, hutan lindung, dan ekosistem gambut.')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin="" />
@endpush

@section('body')
    <main class="peta-page" id="peta-page">

        {{-- ══════════════════════════════════════════════════
             LEAFLET MAP (full-screen)
        ══════════════════════════════════════════════════ --}}
        <div class="peta-map" id="peta-map"></div>

        {{-- ══════════════════════════════════════════════════
             LEFT SIDEBAR
        ══════════════════════════════════════════════════ --}}
        <aside class="peta-sidebar" id="peta-sidebar">
            <div class="peta-sidebar__header">
                <p class="peta-sidebar__suptitle">PETA KALIMANTAN BARAT</p>
                <h1 class="peta-sidebar__title">Sistem Informasi Spasial<br>Data Kehutanan</h1>
                <a href="{{ url('/') }}" class="peta-sidebar__back">
                    <i class="mdi mdi-arrow-left" aria-hidden="true"></i>
                    Kembali ke Halaman Utama
                </a>
            </div>

            {{-- Search --}}
            <div class="peta-search">
                <input type="text" placeholder="Cari Lokasi / Kawasan" aria-label="Cari Lokasi" id="peta-search-input">
                <i class="mdi mdi-magnify" aria-hidden="true"></i>
            </div>

            {{-- Layer Peta --}}
            <div class="peta-layers">
                <h2 class="peta-section-title">• LAYER PETA</h2>
                <label class="peta-layer-item">
                    <input type="checkbox" name="layer" value="batas-wilayah" id="layer-batas-wilayah">
                    <span class="peta-layer-item__check"></span>
                    Batas Wilayah
                </label>
                <label class="peta-layer-item">
                    <input type="checkbox" name="layer" value="tutupan-lahan" id="layer-tutupan-lahan">
                    <span class="peta-layer-item__check"></span>
                    Tutupan Lahan
                </label>
                <label class="peta-layer-item">
                    <input type="checkbox" name="layer" value="hutan-lindung" id="layer-hutan-lindung">
                    <span class="peta-layer-item__check"></span>
                    Hutan Lindung
                </label>
                <label class="peta-layer-item">
                    <input type="checkbox" name="layer" value="ekosistem-gambut" id="layer-ekosistem-gambut">
                    <span class="peta-layer-item__check"></span>
                    Ekosistem Gambut
                </label>
                <label class="peta-layer-item">
                    <input type="checkbox" name="layer" value="titik-panas" id="layer-titik-panas">
                    <span class="peta-layer-item__check"></span>
                    Titik Panas
                </label>
                <label class="peta-layer-item">
                    <input type="checkbox" name="layer" value="proyek-percontohan" id="layer-proyek-percontohan">
                    <span class="peta-layer-item__check"></span>
                    Proyek Percontohan
                </label>
                <label class="peta-layer-item">
                    <input type="checkbox" name="layer" value="perhutanan-sosial" id="layer-perhutanan-sosial">
                    <span class="peta-layer-item__check"></span>
                    Perhutanan Sosial
                </label>
            </div>

            {{-- Keterangan / Legend --}}
            <div class="peta-legend">
                <h2 class="peta-section-title">• KETERANGAN</h2>
                <div class="peta-legend-item">
                    <span class="peta-legend-swatch peta-legend-swatch--hutan-primer"></span>
                    Hutan Primer
                </div>
                <div class="peta-legend-item">
                    <span class="peta-legend-swatch peta-legend-swatch--perkebunan"></span>
                    Perkebunan
                </div>
                <div class="peta-legend-item">
                    <span class="peta-legend-swatch peta-legend-swatch--kawasan-lindung"></span>
                    Kawasan Lindung
                </div>
                <div class="peta-legend-item">
                    <span class="peta-legend-swatch peta-legend-swatch--gambut"></span>
                    Gambut
                </div>
                <div class="peta-legend-item">
                    <span class="peta-legend-swatch peta-legend-swatch--titik-panas"></span>
                    Titik Panas
                </div>
                <div class="peta-legend-item">
                    <span class="peta-legend-swatch peta-legend-swatch--proyek"></span>
                    Proyek Percontohan
                </div>
            </div>
        </aside>

        {{-- ══════════════════════════════════════════════════
             TOP STAT CARDS
        ══════════════════════════════════════════════════ --}}
        <div class="peta-stats" id="peta-stats">
            <article class="peta-stat-card">
                <div class="peta-stat-card__icon peta-stat-card__icon--forest">
                    <i class="mdi mdi-pine-tree" aria-hidden="true"></i>
                </div>
                <div class="peta-stat-card__body">
                    <span class="peta-stat-card__label">Hutan Lindung</span>
                    <strong class="peta-stat-card__value">271.000</strong>
                    <small class="peta-stat-card__unit">Ha</small>
                </div>
            </article>

            <article class="peta-stat-card">
                <div class="peta-stat-card__icon peta-stat-card__icon--peat">
                    <i class="mdi mdi-sprout" aria-hidden="true"></i>
                </div>
                <div class="peta-stat-card__body">
                    <span class="peta-stat-card__label">Ekosistem Gambut</span>
                    <strong class="peta-stat-card__value">1.2 jt</strong>
                    <small class="peta-stat-card__unit">Ha</small>
                </div>
            </article>

            <article class="peta-stat-card">
                <div class="peta-stat-card__icon peta-stat-card__icon--hotspot">
                    <i class="mdi mdi-fire" aria-hidden="true"></i>
                </div>
                <div class="peta-stat-card__body">
                    <span class="peta-stat-card__label">TITIK PANAS</span>
                    <strong class="peta-stat-card__value">47</strong>
                    <small class="peta-stat-card__unit">Titik (Bulan ini)</small>
                </div>
            </article>

            <article class="peta-stat-card">
                <div class="peta-stat-card__icon peta-stat-card__icon--project">
                    <i class="mdi mdi-map-marker-radius" aria-hidden="true"></i>
                </div>
                <div class="peta-stat-card__body">
                    <span class="peta-stat-card__label">PROYEK AKTIF</span>
                    <strong class="peta-stat-card__value">12</strong>
                    <small class="peta-stat-card__unit">Lokasi</small>
                </div>
            </article>
        </div>

    </main>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="{{ asset('frontend/js/peta.js') }}"></script>
@endpush
