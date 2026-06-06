<nav class="site-nav" aria-label="Navigasi utama">
    <a class="site-brand" href="{{ url('/') }}">
        <img class="site-brand__crest" src="{{ asset('frontend/images/logo-pemprov-kalbar.webp') }}" alt="Provinsi Kalimantan Barat">
        <img class="site-brand__indonesia" src="{{ asset('frontend/images/indonesia-logo.png') }}" alt="Bhinneka Tunggal Ika">
        <img class="site-brand__redd" src="{{ asset('frontend/images/redd-plus-kalbar.png') }}" alt="REDD+ Kalbar">
    </a>

    <div class="site-menu">
        <a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
        <a class="{{ request()->routeIs('frontend.data-pemetaan') ? 'active' : '' }}" href="{{ route('frontend.data-pemetaan') }}">Data & Pemetaan</a>
        <a href="#">Program & Strategi REDD+</a>
        <a href="#">Berita & Agenda</a>
        <a href="#">Perpustakaan & Publikasi</a>
        <a href="#">SIS-REDD+</a>
        <a class="site-map-btn" href="{{ route('frontend.data-pemetaan') }}"><span>+</span>Lihat Peta</a>
    </div>
</nav>
