<nav class="site-nav" aria-label="Navigasi utama">
    <a class="site-brand" href="{{ url('/') }}">
        <img class="site-brand__crest" src="{{ asset('frontend/images/logo-pemprov-kalbar.webp') }}" alt="Provinsi Kalimantan Barat">
        <img class="site-brand__indonesia" src="{{ asset('frontend/images/indonesia-logo.png') }}" alt="Bhinneka Tunggal Ika">
        <img class="site-brand__redd" src="{{ asset('frontend/images/redd-plus-kalbar.png') }}" alt="REDD+ Kalbar">
    </a>

    <div class="site-menu">
        <a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
        <a class="{{ request()->routeIs('frontend.data-pemetaan') ? 'active' : '' }}" href="{{ route('frontend.data-pemetaan') }}">Data & Pemetaan</a>
        <a class="{{ request()->routeIs('frontend.program-strategi') ? 'active' : '' }}" href="{{ route('frontend.program-strategi') }}">Program & Strategi REDD+</a>
        <a class="{{ request()->routeIs('frontend.berita-agenda') ? 'active' : '' }}" href="{{ route('frontend.berita-agenda') }}">Berita & Agenda</a>
        <a class="{{ request()->routeIs('frontend.perpustakaan-publikasi') ? 'active' : '' }}" href="{{ route('frontend.perpustakaan-publikasi') }}">Perpustakaan & Publikasi</a>
        <a class="{{ request()->routeIs('frontend.sis-redd') ? 'active' : '' }}" href="{{ route('frontend.sis-redd') }}">SIS-REDD+</a>
        <a class="site-map-btn {{ request()->routeIs('frontend.peta') ? 'active' : '' }}" href="{{ route('frontend.peta') }}"><span><i class="mdi mdi-arrow-top-right" aria-hidden="true"></i></span>Lihat Peta</a>
    </div>
</nav>
