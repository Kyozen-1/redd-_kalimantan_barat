/**
 * peta.js  –  Leaflet map for the Peta Kalimantan Barat page
 * Initializes an interactive map centered on Kalimantan Barat with
 * static overlay layers (polygons, markers) toggled by sidebar checkboxes.
 */

(function () {
    'use strict';

    /* ═══════════════════════════════════════════════════
       1. MAP INITIALIZATION
       ═══════════════════════════════════════════════════ */

    var map = L.map('peta-map', {
        center: [0.05, 109.34],          // Center of Kalimantan Barat
        zoom: 8,
        zoomControl: false,              // We place our own zoom control via CSS
        attributionControl: true
    });

    // Place Leaflet zoom control to the top-left, next to sidebar
    L.control.zoom({ position: 'topleft' }).addTo(map);

    /* ── Tile layers ── */
    var tileLayers = {
        'Peta': L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }),
        'Satelit': L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 18,
            attribution: '&copy; Esri, Maxar, Earthstar Geographics'
        }),
        'Terrain': L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
            maxZoom: 17,
            attribution: '&copy; OpenTopoMap (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
        })
    };

    // Start with the default "Peta" layer
    tileLayers['Peta'].addTo(map);
    var activeLayerName = 'Peta';

    /* ── Google Maps-style map type toggle (bottom-left) ── */
    var MapTypeToggle = L.Control.extend({
        options: { position: 'bottomleft' },

        onAdd: function () {
            var container = L.DomUtil.create('div', 'peta-maptype-toggle');
            L.DomEvent.disableClickPropagation(container);
            L.DomEvent.disableScrollPropagation(container);

            // Build the 3 buttons
            var types = ['Peta', 'Satelit', 'Terrain'];
            types.forEach(function (name) {
                var btn = L.DomUtil.create('button', 'peta-maptype-btn', container);
                btn.textContent = name;
                btn.setAttribute('data-type', name);
                if (name === activeLayerName) {
                    L.DomUtil.addClass(btn, 'peta-maptype-btn--active');
                }

                btn.addEventListener('click', function () {
                    if (name === activeLayerName) return;

                    // Swap tile layer
                    map.removeLayer(tileLayers[activeLayerName]);
                    tileLayers[name].addTo(map);
                    activeLayerName = name;

                    // Update active button
                    container.querySelectorAll('.peta-maptype-btn').forEach(function (b) {
                        L.DomUtil.removeClass(b, 'peta-maptype-btn--active');
                    });
                    L.DomUtil.addClass(btn, 'peta-maptype-btn--active');
                });
            });

            return container;
        }
    });

    new MapTypeToggle().addTo(map);


    /* ═══════════════════════════════════════════════════
       2. LAYER DATA  (static / hardcoded for now)
       ═══════════════════════════════════════════════════ */

    // ── Batas Wilayah (Province boundary - simplified polygon) ──
    var batasWilayahCoords = [
        [2.08, 108.85], [2.08, 109.60], [1.75, 110.15],
        [1.45, 110.55], [1.05, 110.95], [0.55, 111.35],
        [0.02, 111.65], [-0.45, 111.50], [-0.90, 111.15],
        [-1.30, 110.55], [-1.55, 110.05], [-1.70, 109.60],
        [-1.60, 109.10], [-1.25, 108.80], [-0.85, 108.55],
        [-0.35, 108.50], [0.15, 108.60], [0.65, 108.50],
        [1.15, 108.55], [1.60, 108.70], [2.08, 108.85]
    ];

    var batasWilayahLayer = L.polygon(batasWilayahCoords, {
        color: '#2e7d32',
        weight: 2.5,
        dashArray: '8, 5',
        fillOpacity: 0,
        interactive: false
    });

    // ── Tutupan Lahan (Land cover zones) ──
    var tutupanLahanGroup = L.layerGroup([
        // Hutan Primer area near Karangan
        L.polygon([
            [0.75, 109.10], [0.75, 109.45],
            [0.45, 109.45], [0.45, 109.10]
        ], {
            color: '#196819', weight: 1, fillColor: '#196819',
            fillOpacity: 0.45
        }).bindPopup('<b>Hutan Primer</b><br>Area Karangan<br>Luas: ~38.500 Ha'),

        // Hutan Primer area near Pontianak
        L.polygon([
            [-0.10, 109.15], [-0.10, 109.45],
            [-0.35, 109.45], [-0.35, 109.15]
        ], {
            color: '#196819', weight: 1, fillColor: '#196819',
            fillOpacity: 0.45
        }).bindPopup('<b>Hutan Primer</b><br>Area Pontianak<br>Luas: ~21.000 Ha'),

        // Perkebunan (Plantation) near Darit
        L.polygon([
            [0.55, 109.55], [0.55, 109.80],
            [0.30, 109.80], [0.30, 109.55]
        ], {
            color: '#c8b432', weight: 1, fillColor: '#d6c830',
            fillOpacity: 0.50
        }).bindPopup('<b>Perkebunan</b><br>Area Darit<br>Luas: ~15.200 Ha')
    ]);

    // ── Hutan Lindung (Protected forest zones) ──
    var hutanLindungGroup = L.layerGroup([
        L.polygon([
            [1.20, 109.00], [1.20, 109.55],
            [0.85, 109.55], [0.85, 109.00]
        ], {
            color: '#2e7d32', weight: 2, fillColor: '#43a047',
            fillOpacity: 0.30
        }).bindPopup('<b>Hutan Lindung</b><br>Kawasan Sungaiduri - Karangan<br>Luas: ~52.000 Ha'),

        L.polygon([
            [0.10, 110.10], [0.10, 110.55],
            [-0.20, 110.55], [-0.20, 110.10]
        ], {
            color: '#2e7d32', weight: 2, fillColor: '#43a047',
            fillOpacity: 0.30
        }).bindPopup('<b>Hutan Lindung</b><br>Kawasan Meliau<br>Luas: ~67.000 Ha'),

        L.polygon([
            [-0.45, 109.60], [-0.45, 110.00],
            [-0.75, 110.00], [-0.75, 109.60]
        ], {
            color: '#2e7d32', weight: 2, fillColor: '#43a047',
            fillOpacity: 0.30
        }).bindPopup('<b>Hutan Lindung</b><br>Kawasan Kubu<br>Luas: ~42.800 Ha')
    ]);

    // ── Ekosistem Gambut (Peatland ecosystem) ──
    var ekosistemGambutGroup = L.layerGroup([
        L.polygon([
            [-0.30, 108.80], [-0.30, 109.30],
            [-0.70, 109.30], [-0.70, 108.80]
        ], {
            color: '#5d4037', weight: 1.5, fillColor: '#6d5e2f',
            fillOpacity: 0.40
        }).bindPopup('<b>Ekosistem Gambut</b><br>Gambut Pesisir Pontianak<br>Luas: ~85.000 Ha<br>Kedalaman: 3-6 m'),

        L.polygon([
            [-0.80, 109.40], [-0.80, 109.90],
            [-1.20, 109.90], [-1.20, 109.40]
        ], {
            color: '#5d4037', weight: 1.5, fillColor: '#6d5e2f',
            fillOpacity: 0.40
        }).bindPopup('<b>Ekosistem Gambut</b><br>Gambut Sungai Kapuas Hilir<br>Luas: ~120.000 Ha<br>Kedalaman: 4-8 m'),

        L.polygon([
            [1.50, 108.90], [1.50, 109.25],
            [1.15, 109.25], [1.15, 108.90]
        ], {
            color: '#5d4037', weight: 1.5, fillColor: '#6d5e2f',
            fillOpacity: 0.40
        }).bindPopup('<b>Ekosistem Gambut</b><br>Gambut Sambas<br>Luas: ~58.000 Ha<br>Kedalaman: 2-4 m')
    ]);

    // ── Titik Panas (Hotspots / fire points) ──
    var hotspotIcon = L.divIcon({
        className: 'peta-leaflet-hotspot',
        iconSize: [14, 14],
        iconAnchor: [7, 7],
        popupAnchor: [0, -10]
    });

    var titikPanasGroup = L.layerGroup([
        L.marker([0.35, 110.05], { icon: hotspotIcon })
            .bindPopup('<b>Titik Panas</b><br>Terdeteksi: 18 Jun 2026<br>Confidence: 85%<br>Satelit: VIIRS'),
        L.marker([-0.15, 109.55], { icon: hotspotIcon })
            .bindPopup('<b>Titik Panas</b><br>Terdeteksi: 17 Jun 2026<br>Confidence: 72%<br>Satelit: MODIS'),
        L.marker([0.80, 109.30], { icon: hotspotIcon })
            .bindPopup('<b>Titik Panas</b><br>Terdeteksi: 19 Jun 2026<br>Confidence: 91%<br>Satelit: VIIRS'),
        L.marker([-0.55, 109.70], { icon: hotspotIcon })
            .bindPopup('<b>Titik Panas</b><br>Terdeteksi: 16 Jun 2026<br>Confidence: 68%<br>Satelit: MODIS'),
        L.marker([1.30, 109.15], { icon: hotspotIcon })
            .bindPopup('<b>Titik Panas</b><br>Terdeteksi: 19 Jun 2026<br>Confidence: 78%<br>Satelit: VIIRS'),
        L.marker([-0.90, 110.10], { icon: hotspotIcon })
            .bindPopup('<b>Titik Panas</b><br>Terdeteksi: 15 Jun 2026<br>Confidence: 88%<br>Satelit: VIIRS')
    ]);

    // ── Proyek Percontohan (Pilot projects) ──
    var projectIcon = L.divIcon({
        className: 'peta-leaflet-project',
        iconSize: [16, 16],
        iconAnchor: [8, 8],
        popupAnchor: [0, -10]
    });

    var proyekPercontohanGroup = L.layerGroup([
        L.marker([0.65, 109.20], { icon: projectIcon })
            .bindPopup('<b>Proyek Percontohan REDD+</b><br>Karangan<br>Status: Aktif<br>Periode: 2024-2028'),
        L.marker([-0.02, 109.34], { icon: projectIcon })
            .bindPopup('<b>Proyek Rehabilitasi Lahan</b><br>Pontianak<br>Status: Aktif<br>Periode: 2025-2029'),
        L.marker([0.05, 110.30], { icon: projectIcon })
            .bindPopup('<b>Proyek Konservasi Meliau</b><br>Meliau<br>Status: Aktif<br>Periode: 2023-2027'),
        L.marker([-0.50, 109.80], { icon: projectIcon })
            .bindPopup('<b>Proyek Restorasi Gambut</b><br>Kubu<br>Status: Aktif<br>Periode: 2024-2028'),
        L.marker([1.45, 109.00], { icon: projectIcon })
            .bindPopup('<b>Proyek Hutan Kemasyarakatan</b><br>Sambas<br>Status: Aktif<br>Periode: 2025-2030')
    ]);

    // ── Perhutanan Sosial (Social forestry zones) ──
    var perhutananSosialGroup = L.layerGroup([
        L.polygon([
            [0.90, 109.60], [0.90, 110.00],
            [0.60, 110.00], [0.60, 109.60]
        ], {
            color: '#1565c0', weight: 1.5, fillColor: '#42a5f5',
            fillOpacity: 0.25, dashArray: '5, 5'
        }).bindPopup('<b>Perhutanan Sosial</b><br>Hutan Desa Kembayan<br>Luas: ~12.500 Ha<br>Status: SK Tetap'),

        L.polygon([
            [-0.50, 110.10], [-0.50, 110.50],
            [-0.80, 110.50], [-0.80, 110.10]
        ], {
            color: '#1565c0', weight: 1.5, fillColor: '#42a5f5',
            fillOpacity: 0.25, dashArray: '5, 5'
        }).bindPopup('<b>Perhutanan Sosial</b><br>Hutan Kemasyarakatan Sintang<br>Luas: ~18.300 Ha<br>Status: SK Tetap'),

        L.polygon([
            [1.60, 109.30], [1.60, 109.60],
            [1.35, 109.60], [1.35, 109.30]
        ], {
            color: '#1565c0', weight: 1.5, fillColor: '#42a5f5',
            fillOpacity: 0.25, dashArray: '5, 5'
        }).bindPopup('<b>Perhutanan Sosial</b><br>Hutan Tanaman Rakyat Sambas<br>Luas: ~8.700 Ha<br>Status: SK Sementara')
    ]);


    /* ═══════════════════════════════════════════════════
       3. CITY LABELS
       ═══════════════════════════════════════════════════ */

    var cities = [
        { name: 'Pontianak',     lat: -0.02,  lng: 109.34, size: 'lg' },
        { name: 'Singkawang',    lat: 0.91,   lng: 108.98, size: 'md' },
        { name: 'Sambas',        lat: 1.36,   lng: 109.31, size: 'md' },
        { name: 'Sintang',       lat: 0.08,   lng: 111.50, size: 'md' },
        { name: 'Meliau',        lat: 0.02,   lng: 110.35, size: 'sm' },
        { name: 'Kubu',          lat: -0.45,  lng: 109.55, size: 'sm' },
        { name: 'Ketapang',      lat: -1.83,  lng: 109.98, size: 'md' },
        { name: 'Mempawah',      lat: 0.34,   lng: 108.96, size: 'sm' },
        { name: 'Sungai Raya',   lat: 0.02,   lng: 109.41, size: 'sm' },
        { name: 'Ngabang',       lat: 0.35,   lng: 109.98, size: 'sm' },
        { name: 'Sanggau',       lat: 0.13,   lng: 110.59, size: 'sm' },
        { name: 'Sekadau',       lat: 0.02,   lng: 110.99, size: 'sm' },
        { name: 'Putussibau',    lat: 0.83,   lng: 112.93, size: 'md' },
        { name: 'Nanga Pinoh',   lat: -0.35,  lng: 111.75, size: 'sm' },
        { name: 'Sukadana',      lat: -1.25,  lng: 109.98, size: 'sm' }
    ];

    var cityLabelGroup = L.layerGroup();
    cities.forEach(function (c) {
        var fontSize = c.size === 'lg' ? 13 : c.size === 'md' ? 11 : 10;
        var fontWeight = c.size === 'lg' ? 800 : 600;

        L.marker([c.lat, c.lng], {
            icon: L.divIcon({
                className: 'peta-city-label',
                html: '<span style="font-size:' + fontSize + 'px;font-weight:' + fontWeight + '">' + c.name + '</span>',
                iconSize: [0, 0],
                iconAnchor: [0, 0]
            }),
            interactive: false
        }).addTo(cityLabelGroup);
    });
    cityLabelGroup.addTo(map);


    /* ═══════════════════════════════════════════════════
       4. SIDEBAR CHECKBOX ↔ LAYER TOGGLE
       ═══════════════════════════════════════════════════ */

    var layerMap = {
        'batas-wilayah':      batasWilayahLayer,
        'tutupan-lahan':      tutupanLahanGroup,
        'hutan-lindung':      hutanLindungGroup,
        'ekosistem-gambut':   ekosistemGambutGroup,
        'titik-panas':        titikPanasGroup,
        'proyek-percontohan': proyekPercontohanGroup,
        'perhutanan-sosial':  perhutananSosialGroup
    };

    var checkboxes = document.querySelectorAll('.peta-layers input[type="checkbox"]');

    checkboxes.forEach(function (cb) {
        cb.addEventListener('change', function () {
            var layer = layerMap[this.value];
            if (!layer) return;

            if (this.checked) {
                layer.addTo(map);
            } else {
                map.removeLayer(layer);
            }
        });
    });


    /* ═══════════════════════════════════════════════════
       5. KEEP MAP SIZE IN SYNC
       ═══════════════════════════════════════════════════ */

    window.addEventListener('resize', function () {
        map.invalidateSize();
    });

    // Trigger invalidateSize after a short delay to account for CSS transitions
    setTimeout(function () {
        map.invalidateSize();
    }, 300);

})();
