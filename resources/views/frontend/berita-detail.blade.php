@extends('frontend.layouts.site-app')

@section('title', $berita->judul . ' | REDD+ Kalimantan Barat')
@section('meta_description', Str::limit(strip_tags($berita->deskripsi), 150))

@section('body')
    <script>
        function handleImageError(img) {
            img.onerror = null; 
            const placeholder = document.createElement('div');
            placeholder.className = 'news-placeholder';
            const isFeatured = img.closest('.featured-article') !== null || img.closest('.news-detail__hero') !== null;
            const aspectRatio = isFeatured ? '1182 / 495' : '452 / 249';
            const borderRadius = isFeatured ? '0.6rem' : '0.55rem';
            const iconSize = isFeatured ? '4rem' : '2.2rem';
            
            placeholder.style.cssText = `aspect-ratio: ${aspectRatio}; border-radius: ${borderRadius}; background: #f0f3f1; display: grid; place-items: center; color: #a8b0a9; width: 100%;`;
            placeholder.innerHTML = `<i class="mdi mdi-image-outline" style="font-size: ${iconSize};"></i>`;
            
            img.parentNode.replaceChild(placeholder, img);
        }
    </script>

    <main class="site-page news-detail-page">
        @include('frontend.layouts.site-header')

        <section class="site-shell news-detail-container" style="padding-top: 8.6rem; padding-bottom: 12rem;">
            {{-- Back Link --}}
            <div class="news-detail__back">
                <a href="{{ route('frontend.berita-agenda') }}" class="back-link">
                    <i class="mdi mdi-arrow-left" aria-hidden="true"></i> Kembali
                </a>
            </div>

            {{-- Full-width Hero Image --}}
            @php
                $firstGambar = $berita->pivot_gambar_berita->first();
            @endphp
            <div class="news-detail__hero">
                @if($firstGambar && $firstGambar->image_path)
                    <img src="{{ $firstGambar->gambar_url }}" alt="{{ $berita->judul }}" loading="lazy" onerror="handleImageError(this)">
                @else
                    <div class="news-placeholder" style="aspect-ratio: 1182 / 495; border-radius: 0.6rem; background: #f0f3f1; display: grid; place-items: center; color: #a8b0a9; width: 100%;">
                        <i class="mdi mdi-image-outline" style="font-size: 4rem;"></i>
                    </div>
                @endif
            </div>

            {{-- Full-width Title & Meta --}}
            <h1 class="news-detail__title">{{ $berita->judul }}</h1>
            <div class="article-meta">
                <span>Berita</span>
                <small>| {{ $berita->created_at ? $berita->created_at->diffForHumans() : '-' }} | Admin</small>
            </div>

            {{-- Two-column: Article Content + Sidebar --}}
            <div class="news-detail__grid" style="display: grid; grid-template-columns: 1fr 320px; gap: 3rem; align-items: start; margin-bottom: 4rem;">
                <article class="news-detail__content">
                    @foreach (explode("\n\n", $berita->deskripsi) as $paragraph)
                        @if(trim($paragraph))
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </article>

                <aside class="news-detail__sidebar" aria-label="Berita Lainnya">
                    @foreach ($otherStories as $story)
                        @php
                            $storyGambar = $story->pivot_gambar_berita->first();
                        @endphp
                        <a href="{{ route('frontend.berita.detail', $story->id) }}" class="story-sidebar-link">
                            <article class="story-card">
                                @if($storyGambar && $storyGambar->image_path)
                                    <img src="{{ $storyGambar->gambar_url }}" alt="{{ $story->judul }}" loading="lazy" onerror="handleImageError(this)">
                                @else
                                    <div class="news-placeholder" style="aspect-ratio: 452 / 249; border-radius: 0.55rem; background: #f0f3f1; display: grid; place-items: center; color: #a8b0a9; width: 100%;">
                                        <i class="mdi mdi-image-outline" style="font-size: 2.2rem;"></i>
                                    </div>
                                @endif
                                <h3>{{ $story->judul }}</h3>
                                <div class="article-meta">
                                    <span>{{ ['Berita', 'Pengumuman'][array_rand(['Berita', 'Pengumuman'])] }}</span>
                                    <small>| {{ $story->created_at ? $story->created_at->diffForHumans() : '-' }} | Admin</small>
                                </div>
                            </article>
                        </a>
                    @endforeach
                </aside>
            </div>
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection
