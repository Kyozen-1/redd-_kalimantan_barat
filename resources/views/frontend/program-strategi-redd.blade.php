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
    @endphp

    <main class="site-page program-page">
        @include('frontend.layouts.site-header')

        <section class="site-shell program-hero">
            <p class="program-eyebrow">+ Program & Strategi REDD+</p>
            <h1>Implementasi 5 Pilar Strategi Nasional</h1>
        </section>

        <section class="site-shell pillar-section" aria-labelledby="pillar-heading">
            <div class="pillar-copy">
                <h2 id="pillar-heading">+ 5 Pilar</h2>
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
                <h2 id="social-forest-heading">+ Perhutanan Sosial</h2>
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
                <h2 id="rad-heading">+ RAD REDD+ Kalimantan Barat</h2>
                <p>Dokumen kebijakan komprehensif yang menjadi fondasi operasional penurunan emisi di tingkat provinsi</p>

                <label class="search-field">
                    <span class="sr-only">Cari Dokumen</span>
                    <input type="search" name="search_rad" placeholder="Cari Dokumen">
                    <i class="mdi mdi-magnify" aria-hidden="true"></i>
                </label>

                <div class="rad-list">
                    @forelse ($radDocuments as $document)
                        <article class="rad-card">
                            <div class="rad-card__preview">
                                <i class="mdi mdi-file-document-outline" aria-hidden="true"></i>
                            </div>
                            <div class="rad-card__body">
                                <h3>{{ $document->nama }}</h3>
                                @if($document->document_path)
                                    <a href="{{ Storage::disk('minio')->url($document->document_path) }}" target="_blank">Download File</a>
                                @else
                                    <a href="#">Download File</a>
                                @endif
                            </div>
                        </article>
                    @empty
                        <p>Tidak ada dokumen RAD yang tersedia.</p>
                    @endforelse
                </div>
            </aside>

            <section class="mrv-panel" aria-labelledby="mrv-heading">
                <h2 id="mrv-heading">+ Laporan Emisi (MRV)</h2>

                <label class="search-field search-field--wide">
                    <span class="sr-only">Cari Laporan</span>
                    <input type="search" name="search_report" placeholder="Cari Laporan">
                    <i class="mdi mdi-magnify" aria-hidden="true"></i>
                </label>

                <div class="report-list">
                    @forelse ($reports as $report)
                        <article class="report-item">
                            <h3>{{ $report->nama }}</h3>
                            <p>Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat</p>
                            <small>Tanggal upload: {{ $report->created_at ? $report->created_at->format('d F Y') : '-' }}</small>
                            <div class="report-links">
                                @if($report->document_file_pdf_path)
                                    <a href="{{ Storage::disk('minio')->url($report->document_file_pdf_path) }}" target="_blank">Download File Utama</a>
                                @else
                                    <a href="#">Download File Utama</a>
                                @endif

                                @if($report->document_file_excel_path)
                                    <a href="{{ Storage::disk('minio')->url($report->document_file_excel_path) }}" target="_blank">Download Data Tabel</a>
                                @else
                                    <a href="#">Download Data Tabel</a>
                                @endif
                            </div>
                            <div class="report-meta">
                                <span>{{ $report->document_file_pdf_path ? 'PDF' : '' }}</span>
                                <span>{{ $report->document_file_excel_path ? 'XLSX' : '' }}</span>
                            </div>
                        </article>
                    @empty
                        <p>Tidak ada laporan emisi yang tersedia.</p>
                    @endforelse
                </div>

                <nav id="reportPagination" class="pagination-mini" aria-label="Halaman laporan emisi">
                </nav>
            </section>
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. RAD Documents Search (Simple list filter)
            const radInput = document.querySelector('input[name="search_rad"]');
            const radCards = document.querySelectorAll('.rad-card');

            if (radInput) {
                radInput.addEventListener('input', function () {
                    const query = this.value.toLowerCase().trim();
                    radCards.forEach(card => {
                        const titleEl = card.querySelector('h3');
                        if (titleEl) {
                            const titleText = titleEl.textContent.toLowerCase();
                            if (titleText.includes(query)) {
                                card.style.display = '';
                            } else {
                                card.style.display = 'none';
                            }
                        }
                    });
                });
            }

            // 2. MRV Reports Search & Dynamic Client-Side Pagination
            const reportInput = document.querySelector('input[name="search_report"]');
            const reportItems = document.querySelectorAll('.report-item');
            const paginationContainer = document.getElementById('reportPagination');

            let currentPage = 1;
            const pageSize = 5;

            function renderReports() {
                if (!reportItems.length) return;

                const query = reportInput ? reportInput.value.toLowerCase().trim() : '';

                // Filter items matching search query
                const filteredItems = Array.from(reportItems).filter(item => {
                    const titleEl = item.querySelector('h3');
                    if (titleEl) {
                        return titleEl.textContent.toLowerCase().includes(query);
                    }
                    return false;
                });

                // Hide all items initially
                reportItems.forEach(item => {
                    item.style.display = 'none';
                });

                // Calculate pagination bounds
                const totalPages = Math.ceil(filteredItems.length / pageSize);
                if (currentPage > totalPages) {
                    currentPage = Math.max(1, totalPages);
                }

                // Show only items for current page
                const startIndex = (currentPage - 1) * pageSize;
                const endIndex = startIndex + pageSize;
                filteredItems.slice(startIndex, endIndex).forEach(item => {
                    item.style.display = '';
                });

                // Render dynamic pagination links
                paginationContainer.innerHTML = '';
                if (totalPages <= 1) {
                    return; // No pagination links needed if 0 or 1 page
                }

                // Prev Button
                const prev = document.createElement(currentPage === 1 ? 'span' : 'a');
                prev.className = currentPage === 1 ? 'disabled' : '';
                if (currentPage === 1) {
                    prev.style.cssText = 'opacity: 0.5; cursor: not-allowed; padding: 0.3rem 0.5rem;';
                }
                prev.innerHTML = '<i class="mdi mdi-chevron-left" aria-hidden="true"></i>';
                if (currentPage > 1) {
                    prev.href = '#';
                    prev.addEventListener('click', function (e) {
                        e.preventDefault();
                        currentPage--;
                        renderReports();
                    });
                }
                paginationContainer.appendChild(prev);

                // Numbered buttons
                for (let page = 1; page <= totalPages; page++) {
                    const pageLink = document.createElement('a');
                    if (page === currentPage) {
                        pageLink.className = 'active';
                        pageLink.href = '#';
                        pageLink.addEventListener('click', e => e.preventDefault());
                    } else {
                        pageLink.href = '#';
                        pageLink.addEventListener('click', function (e) {
                            e.preventDefault();
                            currentPage = page;
                            renderReports();
                        });
                    }
                    pageLink.textContent = page;
                    paginationContainer.appendChild(pageLink);
                }

                // Next Button
                const next = document.createElement(currentPage === totalPages ? 'span' : 'a');
                next.className = currentPage === totalPages ? 'disabled' : '';
                if (currentPage === totalPages) {
                    next.style.cssText = 'opacity: 0.5; cursor: not-allowed; padding: 0.3rem 0.5rem;';
                }
                next.innerHTML = '<i class="mdi mdi-chevron-right" aria-hidden="true"></i>';
                if (currentPage < totalPages) {
                    next.href = '#';
                    next.addEventListener('click', function (e) {
                        e.preventDefault();
                        currentPage++;
                        renderReports();
                    });
                }
                paginationContainer.appendChild(next);
            }

            // Initial render
            renderReports();

            // Search input listener
            if (reportInput) {
                reportInput.addEventListener('input', function () {
                    currentPage = 1; // Reset to page 1 on new search
                    renderReports();
                });
            }
        });
    </script>
@endpush
