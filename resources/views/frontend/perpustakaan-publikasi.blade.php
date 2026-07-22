@extends('frontend.layouts.site-app')

@section('title', 'Perpustakaan & Publikasi | REDD+ Kalimantan Barat')
@section('meta_description', 'Repositori dokumen digital, gambar, dan video REDD+ Kalimantan Barat')

@section('body')
    <main class="site-page library-page">
        @include('frontend.layouts.site-header')

        <section class="site-shell library-hero">
            <p>Perpustakaan &amp; Publikasi</p>
            <h1>Akses Repositori Dokumen Digital</h1>

            <nav class="library-tabs" aria-label="Kategori perpustakaan">
                <a class="{{ $activeTab === 'media' ? 'active' : '' }}" href="{{ route('frontend.perpustakaan-publikasi', ['tab' => 'media']) }}">Gambar &amp; Video</a>
                <span aria-hidden="true"></span>
                <a class="{{ $activeTab === 'dokumen' ? 'active' : '' }}" href="{{ route('frontend.perpustakaan-publikasi', ['tab' => 'dokumen']) }}">Dokumen</a>
            </nav>
        </section>

        <section class="site-shell library-content">
            <form method="GET" action="{{ route('frontend.perpustakaan-publikasi') }}" class="library-toolbar {{ $activeTab === 'media' ? 'library-toolbar--media' : '' }}">
                <input type="hidden" name="tab" value="{{ $activeTab }}">

                @if ($activeTab === 'dokumen')
                    <label class="library-search">
                        <span class="sr-only">Cari Dokumen</span>
                        <input type="search" name="search" value="{{ $search }}" placeholder="Cari Dokumen" onchange="this.form.submit()">
                        <i class="mdi mdi-magnify" aria-hidden="true"></i>
                    </label>
                @endif

                <div class="library-selects" aria-label="Filter perpustakaan">
                    <select name="kabupaten" onchange="this.form.submit()" style="height: 2.45rem; padding: 0 1rem; border: 1px solid #c9cfca; border-radius: 0.24rem; background: #fff; font-size: 0.88rem; color: #555; outline: none; cursor: pointer;">
                        <option value="">-- Kabupaten / Kota --</option>
                        @foreach ($regencies as $reg)
                            <option value="{{ $reg->id }}" {{ (string)$selectedKabupaten === (string)$reg->id ? 'selected' : '' }}>{{ str_replace(['Kabupaten ', 'Kota '], '', $reg->name) }}</option>
                        @endforeach
                    </select>

                    <select name="tahun" onchange="this.form.submit()" style="height: 2.45rem; padding: 0 1rem; border: 1px solid #c9cfca; border-radius: 0.24rem; background: #fff; font-size: 0.88rem; color: #555; outline: none; cursor: pointer;">
                        <option value="">-- Tahun --</option>
                        @for ($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ (string)$selectedTahun === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </form>

            @if ($activeTab === 'dokumen')
                @if (count($categories) > 0)
                    <div class="library-chips" aria-label="Kategori dokumen">
                        <a href="{{ route('frontend.perpustakaan-publikasi', ['tab' => 'dokumen', 'search' => $search, 'kabupaten' => $selectedKabupaten, 'tahun' => $selectedTahun]) }}" class="library-chip {{ !$selectedKategori ? 'active' : '' }}" style="text-decoration: none;">Semua</a>
                        @foreach ($categories as $cat)
                            <a href="{{ route('frontend.perpustakaan-publikasi', ['tab' => 'dokumen', 'kategori' => $cat->id, 'search' => $search, 'kabupaten' => $selectedKabupaten, 'tahun' => $selectedTahun]) }}" class="library-chip {{ (string)$selectedKategori === (string)$cat->id ? 'active' : '' }}" style="text-decoration: none;">{{ $cat->nama }}</a>
                        @endforeach
                    </div>
                @endif

                <div class="document-list">
                    @forelse ($documents as $doc)
                        @php
                            $uploadDate = $doc->tanggal ? \Carbon\Carbon::parse($doc->tanggal)->translatedFormat('d F Y') : ($doc->created_at ? $doc->created_at->translatedFormat('d F Y') : '-');
                        @endphp
                        <article class="document-item">
                            <h2>{{ $doc->nama }}</h2>
                            <p>Tanggal upload: {{ $uploadDate }}</p>
                            <div class="document-actions">
                                @if($doc->document_file_pdf_path)
                                    <div>
                                        <a href="{{ $doc->pdf_url }}" target="_blank" rel="noopener noreferrer"><i class="mdi mdi-file-document-outline" aria-hidden="true"></i>Buka File PDF</a>
                                    </div>
                                    <div>
                                        <a href="{{ $doc->pdf_url }}" download>Download File Utama</a>
                                        <span>PDF</span>
                                    </div>
                                @endif
                                @if($doc->document_file_excel_path)
                                    <div>
                                        <a href="{{ $doc->excel_url }}" download>Download Data Tabel</a>
                                        <span>XLSX</span>
                                    </div>
                                @endif
                                @if($doc->document_file_word_path)
                                    <div>
                                        <a href="{{ $doc->word_url }}" download>Download File Word</a>
                                        <span>DOCX</span>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div style="padding: 4rem 1.5rem; text-align: center; color: #667067;">
                            <i class="mdi mdi-file-document-outline" style="font-size: 3rem; color: #a0aaa1;"></i>
                            <p style="margin-top: 0.8rem; font-size: 0.95rem;">Belum ada dokumen digital.</p>
                        </div>
                    @endforelse
                </div>

                @if ($documents instanceof \Illuminate\Pagination\LengthAwarePaginator && $documents->hasPages())
                    <div class="library-pagination" style="margin-top: 3.5rem;">
                        {{ $documents->links() }}
                    </div>
                @endif
            @else
                <div class="library-gallery">
                    @forelse ($galleryMedia as $item)
                        @php
                            $imgSrc = $item->file_path ? Storage::disk('s3')->url($item->file_path) : asset('frontend/images/news-agenda/mangrove-news.png');
                            $caption = $item->deskripsi ?: ($item->kabupaten_kota ? 'Dokumentasi ' . $item->kabupaten_kota->name : 'Dokumentasi REDD+ Kalimantan Barat');
                        @endphp
                        <a class="gallery-tile js-open-media-modal" href="#media-modal" style="cursor: pointer;">
                            <img src="{{ $imgSrc }}" alt="{{ $caption }}">
                        </a>
                    @empty
                        <div style="grid-column: 1 / -1; padding: 4rem 1.5rem; text-align: center; color: #667067;">
                            <i class="mdi mdi-image-multiple-outline" style="font-size: 3rem; color: #a0aaa1;"></i>
                            <p style="margin-top: 0.8rem; font-size: 0.95rem;">Belum ada media galeri.</p>
                        </div>
                    @endforelse
                </div>

                @if ($galleryMedia instanceof \Illuminate\Pagination\LengthAwarePaginator && $galleryMedia->hasPages())
                    <div class="library-pagination" style="margin-top: 3.5rem;">
                        {{ $galleryMedia->links() }}
                    </div>
                @endif
            @endif
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection
