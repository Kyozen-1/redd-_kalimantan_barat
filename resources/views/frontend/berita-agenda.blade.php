@extends('frontend.layouts.site-app')

@section('title', 'Berita & Agenda | REDD+ Kalimantan Barat')
@section('meta_description', 'Berita terbaru dan agenda kegiatan REDD+ Kalimantan Barat')

@section('body')
    <script>
        function handleImageError(img) {
            img.onerror = null; 
            const placeholder = document.createElement('div');
            placeholder.className = 'news-placeholder';
            const isFeatured = img.closest('.featured-article') !== null;
            const aspectRatio = isFeatured ? '1182 / 495' : '452 / 249';
            const borderRadius = isFeatured ? '0.6rem' : '0.55rem';
            const iconSize = isFeatured ? '4rem' : '2.2rem';
            
            placeholder.style.cssText = `aspect-ratio: ${aspectRatio}; border-radius: ${borderRadius}; background: #f0f3f1; display: grid; place-items: center; color: #a8b0a9; width: 100%;`;
            placeholder.innerHTML = `<i class="mdi mdi-image-outline" style="font-size: ${iconSize};"></i>`;
            
            img.parentNode.replaceChild(placeholder, img);
        }
    </script>

    <main class="site-page news-page">
        @include('frontend.layouts.site-header')

        <section class="site-shell news-featured" aria-labelledby="featured-news-heading">
            @if ($featuredNews)
                <div class="news-featured__main">
                    <p class="news-eyebrow">+ Berita Terbaru</p>
                    <a href="{{ route('frontend.berita.detail', $featuredNews->id) }}" style="text-decoration: none; color: inherit;">
                        <h1 id="featured-news-heading">{{ $featuredNews->judul }}</h1>
                    </a>

                    <a href="{{ route('frontend.berita.detail', $featuredNews->id) }}" style="text-decoration: none; color: inherit; display: block;">
                        <article class="featured-article">
                            @php
                                $firstGambar = $featuredNews->pivot_gambar_berita->first();
                            @endphp
                            @if($firstGambar && $firstGambar->image_path)
                                <img src="{{ $firstGambar->gambar_url }}" alt="{{ $featuredNews->judul }}" loading="lazy" onerror="handleImageError(this)">
                            @else
                                <div class="news-placeholder" style="aspect-ratio: 1182 / 495; border-radius: 0.6rem; background: #f0f3f1; display: grid; place-items: center; color: #a8b0a9;">
                                    <i class="mdi mdi-image-outline" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            <div class="article-meta">
                                <span>Berita</span>
                                <small>| {{ $featuredNews->created_at ? $featuredNews->created_at->diffForHumans() : '-' }} | Admin</small>
                            </div>
                        </article>
                    </a>
                </div>
            @else
                <div class="news-featured__main">
                    <p class="news-eyebrow">+ Berita Terbaru</p>
                    <p>Belum ada berita terbaru.</p>
                </div>
            @endif

            <aside class="news-featured__side" aria-label="Berita pilihan">
                @foreach ($sideStories as $story)
                    @php
                        $storyGambar = $story->pivot_gambar_berita->first();
                    @endphp
                    <a href="{{ route('frontend.berita.detail', $story->id) }}" style="text-decoration: none; color: inherit; display: block;">
                        <article class="story-card story-card--side">
                            @if($storyGambar && $storyGambar->image_path)
                                <img src="{{ $storyGambar->gambar_url }}" alt="{{ $story->judul }}" loading="lazy" onerror="handleImageError(this)">
                            @else
                                <div class="news-placeholder" style="aspect-ratio: 452 / 249; border-radius: 0.55rem; background: #f0f3f1; display: grid; place-items: center; color: #a8b0a9;">
                                    <i class="mdi mdi-image-outline" style="font-size: 2.2rem;"></i>
                                </div>
                            @endif
                            <h2>{{ $story->judul }}</h2>
                            <div class="article-meta">
                                <span>Berita</span>
                                <small>| {{ $story->created_at ? $story->created_at->diffForHumans() : '-' }} | Admin</small>
                            </div>
                        </article>
                    </a>
                @endforeach
            </aside>
        </section>

        @if($otherStories->count() > 0)
            <section class="site-shell other-news" aria-labelledby="other-news-heading">
                <h2 id="other-news-heading">+ Berita Lainnya</h2>
                <div class="story-grid">
                    @foreach ($otherStories as $story)
                        @php
                            $otherGambar = $story->pivot_gambar_berita->first();
                        @endphp
                        <a href="{{ route('frontend.berita.detail', $story->id) }}" style="text-decoration: none; color: inherit; display: block;">
                            <article class="story-card">
                                @if($otherGambar && $otherGambar->image_path)
                                    <img src="{{ $otherGambar->gambar_url }}" alt="{{ $story->judul }}" loading="lazy" onerror="handleImageError(this)">
                                @else
                                    <div class="news-placeholder" style="aspect-ratio: 452 / 249; border-radius: 0.55rem; background: #f0f3f1; display: grid; place-items: center; color: #a8b0a9;">
                                        <i class="mdi mdi-image-outline" style="font-size: 2.2rem;"></i>
                                    </div>
                                @endif
                                <h3>{{ $story->judul }}</h3>
                                <div class="article-meta">
                                    <span>Berita</span>
                                    <small>| {{ $story->created_at ? $story->created_at->diffForHumans() : '-' }} | Admin</small>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="site-shell agenda-lsm">
            <section class="agenda-panel" aria-labelledby="agenda-heading">
                <h2 id="agenda-heading">+ Update & Kalender Kegiatan</h2>
                <p class="agenda-year">{{ now()->year }}</p>

                <div class="agenda-list">
                    @forelse ($agendas as $event)
                        @php
                            $carbonDate = $event->tanggal ? \Carbon\Carbon::parse($event->tanggal) : null;
                            $day = $carbonDate ? $carbonDate->format('d') : '-';
                            $month = $carbonDate ? $carbonDate->format('M') : '-';
                            $fullDate = $carbonDate ? $carbonDate->translatedFormat('d F Y') : '-';
                            $datetime = $carbonDate ? $carbonDate->format('Y-m-d') : '';
                        @endphp
                        <article class="agenda-item js-open-agenda-modal"
                            data-id="{{ $event->id }}"
                            data-nama="{{ $event->nama }}"
                            data-deskripsi="{{ $event->deskripsi }}"
                            data-tanggal="{{ $fullDate }}"
                            data-day="{{ $day }}"
                            data-month="{{ $month }}"
                            style="cursor: pointer;">
                            <time datetime="{{ $datetime }}">
                                <strong>{{ $day }}</strong>
                                <span>{{ $month }}</span>
                            </time>
                            <div>
                                <h3>{{ $event->nama }}</h3>
                                <p>Dinas Lingkungan Hidup dan Kehutanan Provinsi Kalimantan Barat</p>
                            </div>
                        </article>
                    @empty
                        <p>Belum ada agenda kegiatan.</p>
                    @endforelse
                </div>
            </section>

            <section class="lsm-banner" aria-labelledby="lsm-heading">
                <img src="{{ asset('frontend/images/news-agenda/lsm-collab.png') }}" alt="Ruang kolaborasi LSM REDD+ Kalimantan Barat" loading="lazy">
                <div class="lsm-banner__content">
                    <h2 id="lsm-heading">+ Ruang Kolaborasi LSM</h2>
                    <p>Platform khusus bagi Lembaga Swadaya Masyarakat untuk berbagi laporan lapangan, memantau transparansi data, dan mengajukan inisiatif pelestarian lokal</p>
                    <a class="site-cta js-open-lsm-modal" href="#lsm-modal"><span>+</span>Akses Ruang LSM</a>
                </div>
            </section>
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection
