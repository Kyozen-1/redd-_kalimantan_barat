@extends('frontend.layouts.site-app')

@section('title', 'REDD+ Kalimantan Barat')
@section('meta_description', 'Portal resmi REDD+ Kalimantan Barat')

@push('styles')
    <style>
        :root {
            --green: #126b18;
            --green-dark: #06470b;
            --green-soft: #e9f5e7;
            --text: #1b251e;
            --muted: #788279;
            --line: #e7ece6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--text);
            background: #f8faf8;
            font-family: "Montserrat", ui-sans-serif, system-ui, sans-serif;
            letter-spacing: 0;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .page {
            overflow: hidden;
            background: #fbfcfb;
        }

        .hero {
            min-height: 530px;
            position: relative;
            color: #fff;
            background-image: linear-gradient(90deg, rgba(0, 8, 2, .88) 0%, rgba(0, 8, 2, .58) 38%, rgba(0, 8, 2, .7) 100%), url("{{ asset('images/redd-home/hero-river.png') }}");
            background-size: cover;
            background-position: center;
        }

        .container {
            width: min(1120px, calc(100% - 64px));
            margin: 0 auto;
        }

        .hero .site-nav {
            padding-top: 24px;
        }

        .nav {
            position: relative;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 34px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 170px;
        }

        .brand-logo {
            display: block;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, .26));
        }

        .brand-logo--crest {
            width: 30px;
            height: 38px;
        }

        .brand-logo--indonesia {
            width: 42px;
            height: 42px;
        }

        .brand-logo--redd {
            width: 74px;
            height: 42px;
        }

        .menu-pill {
            display: flex;
            align-items: center;
            gap: 0;
            padding: 6px 7px 6px 14px;
            border-radius: 999px;
            background: #fff;
            border: 3px solid rgba(49, 138, 31, .95);
            box-shadow: 0 16px 36px rgba(0, 0, 0, .25);
        }

        .menu-pill a {
            color: #465248;
            font-weight: 700;
            font-size: 12px;
            padding: 8px 12px;
            white-space: nowrap;
        }

        .menu-pill a.active {
            color: var(--green);
            border-bottom: 2px solid var(--green);
        }

        .menu-pill a.map-btn {
            color: #fff;
        }

        .map-btn,
        .primary-btn,
        .small-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 999px;
            background: var(--green);
            color: #fff;
            font-weight: 800;
            box-shadow: 0 10px 24px rgba(18, 107, 24, .22);
        }

        .map-btn {
            min-width: 104px;
            padding: 9px 14px;
            font-size: 12px;
        }

        .primary-btn {
            margin-top: 22px;
            padding: 12px 17px;
            font-size: 13px;
        }

        .small-btn {
            padding: 11px 18px;
            font-size: 13px;
        }

        .dot-icon {
            width: 18px;
            height: 18px;
            display: inline-grid;
            place-items: center;
            flex: 0 0 auto;
            border-radius: 999px;
            background: #fff;
            color: var(--green);
            font-size: 11px;
            line-height: 1;
        }

        .hero-grid {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: flex-end;
            min-height: 420px;
            padding: 82px 0 70px;
        }

        .hero-content {
            width: 100%;
        }

        .eyebrow {
            margin: 0 0 12px;
            color: rgba(255, 255, 255, .76);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .hero h1 {
            margin: 0;
            max-width: 520px;
            color: #fff;
            font-size: 46px;
            line-height: 1.04;
            font-weight: 800;
        }

        .hero-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 48px;
            width: 100%;
            margin-top: 96px;
        }

        .language {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 36px;
            padding: 8px 13px;
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 999px;
            background: transparent;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .language select {
            min-width: 86px;
            border: 0;
            outline: 0;
            appearance: none;
            background: transparent;
            color: inherit;
            font: inherit;
            cursor: pointer;
        }

        .language select option {
            color: #151515;
            font-weight: 700;
        }

        .stats {
            display: inline-flex;
            align-items: center;
            gap: 54px;
        }

        .stat label {
            display: block;
            margin-bottom: 4px;
            color: rgba(255, 255, 255, .76);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .stat strong {
            color: #fff;
            font-size: 26px;
            line-height: 1;
            font-weight: 800;
        }

        .stat small {
            display: block;
            margin-top: 6px;
            color: rgba(255, 255, 255, .72);
            font-size: 12px;
        }

        .section {
            padding: 96px 0;
            background: #fbfcfb;
        }

        .official {
            text-align: center;
            min-height: 470px;
        }

        .official-logo {
            width: 56px;
            height: 70px;
            margin: 0 auto 28px;
            object-fit: contain;
            filter: drop-shadow(0 8px 18px rgba(18, 107, 24, .18));
        }

        .green-title {
            margin: 0;
            color: var(--green);
            font-size: 12px;
            line-height: 1.5;
            font-weight: 800;
            text-transform: uppercase;
        }

        .official blockquote {
            max-width: 680px;
            margin: 28px auto 0;
            color: #70766f;
            font-size: 22px;
            line-height: 1.23;
            font-weight: 600;
        }

        .mechanism {
            display: grid;
            grid-template-columns: 360px 1fr;
            align-items: center;
            gap: 80px;
            margin-top: 120px;
            text-align: left;
        }

        .section-kicker {
            margin: 0 0 16px;
            color: var(--green);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .mechanism p {
            margin: 0 0 14px;
            color: #5f665f;
            font-size: 13px;
            line-height: 1.45;
            font-weight: 600;
        }

        .carousel-mask {
            overflow: hidden;
            position: relative;
            padding: 30px 0;
        }

        .carousel-mask::before,
        .carousel-mask::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            z-index: 2;
            width: 90px;
            pointer-events: none;
        }

        .carousel-mask::before {
            left: 0;
            background: linear-gradient(90deg, #fbfcfb, rgba(251, 252, 251, 0));
        }

        .carousel-mask::after {
            right: 0;
            background: linear-gradient(270deg, #fbfcfb, rgba(251, 252, 251, 0));
        }

        .carousel-track {
            display: flex;
            width: max-content;
            gap: 18px;
            animation: scroll-left 24s linear infinite;
        }

        .carousel-track img {
            width: 640px;
            height: 150px;
            border-radius: 16px;
            object-fit: cover;
            box-shadow: 0 18px 42px rgba(9, 45, 12, .13);
        }

        @keyframes scroll-left {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-50%);
            }
        }

        .forest-band {
            position: relative;
            min-height: 395px;
            display: grid;
            align-items: center;
            color: #fff;
            background-image: linear-gradient(rgba(3, 26, 5, .5), rgba(3, 26, 5, .45)), url("{{ asset('images/redd-home/forest-banner.png') }}");
            background-size: cover;
            background-position: center;
        }

        .forest-band p {
            width: min(930px, calc(100% - 64px));
            margin: 0 auto;
            text-align: center;
            color: rgba(255, 255, 255, .92);
            font-size: 21px;
            line-height: 1.35;
            font-weight: 500;
        }

        .floating-card {
            width: min(590px, calc(100% - 48px));
            margin: -62px auto 0;
            position: relative;
            z-index: 4;
            padding: 32px 48px;
            text-align: center;
            background: #fff;
            border-radius: 4px;
            border: 1px solid var(--line);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .16);
        }

        .circle-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 18px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            border: 1px solid #8cc98f;
            background: #eaf7e9;
            color: var(--green);
            font-size: 28px;
            font-weight: 800;
        }

        .circle-icon i {
            line-height: 1;
        }

        .icon-stack {
            position: relative;
            width: 24px;
            height: 22px;
            display: inline-block;
        }

        .floating-card p {
            margin: 0;
            color: #7b837b;
            font-size: 12px;
            line-height: 1.45;
            font-weight: 600;
        }

        .initiatives {
            padding-top: 120px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-top: 28px;
        }

        .initiative-card {
            min-height: 132px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            text-align: center;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 4px;
            box-shadow: 0 8px 22px rgba(20, 40, 20, .08);
            padding: 18px;
        }

        .initiative-card .circle-icon {
            width: 45px;
            height: 45px;
            margin: 0;
            font-size: 19px;
        }

        .initiative-card .circle-icon i {
            font-size: 18px;
        }

        .initiative-card b {
            max-width: 165px;
            color: #485147;
            font-size: 11px;
            line-height: 1.25;
            font-weight: 800;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 1.08fr .92fr;
            gap: 90px;
            align-items: center;
            padding: 115px 0 70px;
        }

        .image-stat {
            position: relative;
            width: min(430px, 100%);
            margin-left: 36px;
        }

        .image-stat img {
            width: 100%;
            height: 275px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 18px 42px rgba(20, 40, 20, .1);
        }

        .badge {
            position: absolute;
            min-width: 134px;
            padding: 15px 17px;
            background: #fff;
            border-radius: 7px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, .16);
            color: #677067;
            font-size: 12px;
            font-weight: 800;
        }

        .badge strong {
            display: block;
            margin-top: 5px;
            color: var(--green);
            font-size: 30px;
            line-height: 1;
        }

        .badge.bottom {
            left: 22px;
            bottom: -38px;
        }

        .badge.top {
            right: -50px;
            top: 56px;
        }

        .dashboard-copy {
            text-align: right;
        }

        .dashboard-copy p {
            max-width: 430px;
            margin: 18px 0 26px auto;
            color: #7a8379;
            font-size: 14px;
            line-height: 1.45;
            font-weight: 600;
        }

        .news {
            display: grid;
            grid-template-columns: 1fr 310px;
            gap: 58px;
            padding: 78px 0 90px;
        }

        .news h2 {
            max-width: 710px;
            margin: 0 0 24px;
            color: #1b241f;
            font-size: 26px;
            line-height: 1.16;
            font-weight: 800;
        }

        .featured-image {
            width: 100%;
            height: 360px;
            object-fit: cover;
            border-radius: 6px;
        }

        .meta {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 10px;
            color: var(--green);
            font-size: 11px;
            font-weight: 800;
        }

        .tag {
            display: inline-flex;
            align-items: center;
            min-height: 18px;
            padding: 3px 8px;
            border-radius: 2px;
            color: #fff;
            background: var(--green);
            font-size: 10px;
            line-height: 1;
        }

        .side-news {
            padding-top: 24px;
        }

        .side-item {
            margin-bottom: 18px;
        }

        .side-item img {
            width: 100%;
            height: 145px;
            object-fit: cover;
            border-radius: 7px;
        }

        .side-item h3 {
            margin: 9px 0 7px;
            color: #263026;
            font-size: 13px;
            line-height: 1.25;
            font-weight: 800;
        }

        .visit {
            text-align: center;
            padding: 64px 0 120px;
        }

        .visit p {
            margin: 16px 0 34px;
            color: #747d74;
            font-size: 13px;
            font-weight: 600;
        }

        .visit-card {
            width: 325px;
            max-width: 100%;
            min-height: 86px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 28px;
            border-radius: 4px;
            background: var(--green);
            color: #fff;
            text-align: left;
        }

        .visit-card span {
            display: block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            opacity: .82;
        }

        .visit-card small {
            display: block;
            margin-top: 2px;
            font-size: 10px;
            opacity: .82;
        }

        .visit-card strong {
            font-size: 25px;
            font-weight: 800;
        }

        .footer {
            padding: 76px 0 58px;
            background: #fff;
            border-top: 1px solid #e2e7e1;
            box-shadow: 0 -10px 28px rgba(0, 0, 0, .05);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.1fr .8fr;
            gap: 130px;
            align-items: end;
        }

        .footer .brand {
            margin-bottom: 26px;
        }

        .footer .brand-logo {
            filter: none;
        }

        .footer h2 {
            max-width: 540px;
            margin: 0 0 18px;
            color: var(--green);
            font-size: 24px;
            line-height: 1.16;
            font-weight: 800;
        }

        .footer p {
            max-width: 620px;
            margin: 0;
            color: #97a096;
            font-size: 14px;
            line-height: 1.5;
            font-weight: 600;
        }

        .contact h3 {
            margin: 0 0 17px;
            color: #2b342b;
            font-size: 14px;
            font-weight: 800;
        }

        .contact p {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
            color: #4d574d;
            font-size: 12px;
            font-weight: 700;
        }

        .contact .pin {
            color: var(--green);
            font-weight: 900;
        }

        @media (max-width: 980px) {
            .container {
                width: min(100% - 32px, 760px);
            }

            .nav {
                align-items: flex-start;
                gap: 20px;
            }

            .menu-pill {
                overflow-x: auto;
                justify-content: flex-start;
                max-width: calc(100vw - 210px);
            }

            .hero-grid,
            .mechanism,
            .dashboard,
            .news,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 44px;
            }

            .hero-meta {
                align-items: flex-start;
                flex-direction: column;
                margin-top: 64px;
            }

            .stats {
                flex-wrap: wrap;
                gap: 24px;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-copy {
                text-align: left;
            }

            .dashboard-copy p {
                margin-left: 0;
            }

            .image-stat {
                margin-left: 0;
            }
        }

        @media (max-width: 640px) {
            .hero {
                min-height: 720px;
            }

            .nav {
                display: block;
            }

            .menu-pill {
                max-width: 100%;
                margin-top: 22px;
            }

            .hero-grid {
                padding-top: 70px;
                min-height: 520px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .stats {
                display: grid;
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .official blockquote,
            .forest-band p {
                font-size: 18px;
            }

            .mechanism {
                gap: 24px;
                margin-top: 70px;
            }

            .carousel-track img {
                width: 520px;
                height: 122px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .badge.top {
                right: 12px;
            }

            .featured-image {
                height: 260px;
            }
        }
    </style>
@endpush

@section('body')
    <main class="page">
        <section class="hero">
            <div class="container">
                @include('frontend.layouts.site-header')

                <div class="hero-grid">
                    <div class="hero-content">
                        <p class="eyebrow" data-i18n="hero.eyebrow">Portal Resmi REDD+ Kalimantan Barat</p>
                        <h1 data-i18n="hero.title">Masa Depan Hijau Kalimantan Barat</h1>
                        <a class="primary-btn" href="#">
                            <span class="dot-icon">+</span>
                            <span data-i18n="hero.cta">Jelajahi Peta Interaktif</span>
                        </a>

                        <div class="hero-meta">
                            <label class="language" for="hero-language">
                                <i class="fas fa-globe" aria-hidden="true"></i>
                                <span class="sr-only">Language</span>
                                <select id="hero-language" data-language-select aria-label="Language">
                                    <option value="id">Indonesia</option>
                                    <option value="en">English</option>
                                </select>
                                <i class="fas fa-chevron-down" aria-hidden="true"></i>
                            </label>

                            <div class="stats">
                                <div class="stat">
                                    <label data-i18n="stats.forest.label">Luas Hutan</label>
                                    <strong data-i18n="stats.forest.value">8.2jt Ha</strong>
                                    <small data-i18n="stats.forest.update">* Update 24 Mei 2024</small>
                                </div>
                                <div class="stat">
                                    <label data-i18n="stats.emission.label">Penurunan Emisi</label>
                                    <strong>12.5 %</strong>
                                </div>
                                <div class="stat">
                                    <label data-i18n="stats.carbon.label">Stok Karbon</label>
                                    <strong>450 Mt</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section official">
            <div class="container">
                <img class="official-logo" src="{{ asset('frontend/images/logo-pemprov-kalbar.webp') }}" alt="Provinsi Kalimantan Barat">
                <p class="green-title">Sambutan Resmi<br>Pemerintah Provinsi Kalimantan Barat</p>
                <blockquote>"Melalui portal ini, kami mengundang seluruh elemen masyarakat untuk mengawal transparansi data emisi dan pelestarian hutan Kalimantan Barat demi masa depan generasi mendatang"</blockquote>

                <div class="mechanism">
                    <div>
                        <p class="section-kicker">+ Mekanisme REDD+</p>
                        <p>Mekanisme insentif global untuk menurunkan emisi melalui Pengurangan Emisi dari Deforestasi dan Degradasi Hutan (REDD+).</p>
                        <p>Di Kalimantan Barat, program ini mengintegrasikan konservasi biodiversitas dengan peningkatan kesejahteraan masyarakat lokal.</p>
                    </div>

                    <div class="carousel-mask" aria-label="Galeri mekanisme REDD+">
                        <div class="carousel-track">
                            <img src="{{ asset('images/redd-home/mechanism-strip.png') }}" alt="Komoditas dan hutan Kalimantan Barat">
                            <img src="{{ asset('images/redd-home/mechanism-strip.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="forest-band">
            <p>Sebagai salah satu "Paru-paru Dunia", Kalimantan Barat memiliki ekosistem hutan tropis dan Lahan Gambut Strategis seluas jutaan hektar yang berfungsi sebagai penyerap karbon raksasa bagi stabilitas iklim global</p>
        </section>

        <div class="floating-card">
            <div class="circle-icon" aria-hidden="true"><i class="fas fa-user-shield"></i></div>
            <p>Dikelola melalui kolaborasi multipihak di bawah koordinasi Pemerintah Provinsi Kalimantan Barat, melibatkan instansi kehutanan, lembaga adat, serta mitra pembangunan internasional untuk memastikan transparansi dan akuntabilitas data emisi.</p>
        </div>

        <section class="section initiatives">
            <div class="container">
                <p class="section-kicker">+ Inisiatif Unggulan</p>
                <div class="cards">
                    <div class="initiative-card"><span class="circle-icon" aria-hidden="true"><i class="fas fa-tree"></i></span><b>Forest Carbon Partnership Facility (FCPF) Carbon Fund</b></div>
                    <div class="initiative-card"><span class="circle-icon" aria-hidden="true"><span class="icon-stack"><i class="fas fa-folder"></i></span></span><b>Pengelolaan Hutan Desa (Social Forestry / Perhutanan Sosial)</b></div>
                    <div class="initiative-card"><span class="circle-icon" aria-hidden="true"><i class="fas fa-tint"></i></span><b>Restorasi dan Perlindungan Lanskap Gambut</b></div>
                    <div class="initiative-card"><span class="circle-icon" aria-hidden="true"><i class="fas fa-desktop"></i></span><b>Sistem Pemantauan Berbasis Masyarakat dan Geotagging</b></div>
                    <div class="initiative-card"><span class="circle-icon" aria-hidden="true"><i class="fas fa-seedling"></i></span><b>Pengembangan Komoditas Hijau (Green Commodities)</b></div>
                </div>

                <div class="dashboard">
                    <div class="image-stat">
                        <img src="{{ asset('images/redd-home/mangrove-stat.png') }}" alt="Kanal mangrove Kalimantan Barat">
                        <div class="badge bottom">Luas Hutan Tersisa 2025<strong>6.4 jt ha</strong></div>
                        <div class="badge top">Emisi 2025<strong>187 Mt</strong></div>
                    </div>
                    <div class="dashboard-copy">
                        <p class="section-kicker">+ Dashboard Statistik</p>
                        <p>Visualisasi data realisasi dan kontribusi nyata dalam merehabilitasi lahan kritis, memulihkan ekosistem gambut, serta menjaga kelestarian hutan lindung secara berkelanjutan.</p>
                        <a class="small-btn" href="#"><span class="dot-icon">+</span>Lihat Data Lainnya</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="container news">
            <article>
                <p class="section-kicker">+ Berita Terbaru</p>
                <h2>Komitmen Hijau Kalbar: Jutaan Hektar Hutan Berhasil Dilindungi Lewat Skema REDD+</h2>
                <img class="featured-image" src="{{ asset('images/redd-home/community-news.png') }}" alt="Kegiatan konservasi masyarakat">
                <div class="meta"><span class="tag">Berita</span><span>1 hari yang lalu</span><span>|</span><span>Admin</span></div>
            </article>

            <aside class="side-news">
                <div class="side-item">
                    <img src="{{ asset('images/redd-home/community-news.png') }}" alt="Penanaman bibit bersama">
                    <h3>Dinas Intensif REDD+ Mengajak Pemprov Kalbar Prioritaskan Kelestarian Hutan Desa</h3>
                    <div class="meta"><span class="tag">Pengumuman</span><span>2 hari yang lalu</span></div>
                </div>
                <div class="side-item">
                    <img src="{{ asset('images/redd-home/mangrove-stat.png') }}" alt="Kanal hutan mangrove">
                    <h3>Geliat Ekonomi Hijau Masyarakat Lokal Kalbar Manfaatkan Hasil Hutan Bukan Kayu Skema REDD+</h3>
                    <div class="meta"><span class="tag">Berita</span><span>5 hari yang lalu</span><span>|</span><span>Admin</span></div>
                </div>
                <a class="small-btn" href="#"><span class="dot-icon">+</span>Lihat Berita Lainnya</a>
            </aside>
        </section>

        <section class="visit">
            <div class="container">
                <p class="section-kicker">+ Kunjungan Website</p>
                <p>Total akumulasi aktivitas kunjungan per-bulan dari seluruh pengguna</p>
                <div class="visit-card">
                    <div>
                        <span>Total Kunjungan Website</span>
                        <small>Februari 2026</small>
                    </div>
                    <strong>413.939</strong>
                </div>
            </div>
        </section>

        @include('frontend.layouts.site-footer')
    </main>
@endsection

@push('scripts')
    <script>
        (() => {
            const translations = {
                id: {
                    'hero.eyebrow': 'Portal Resmi REDD+ Kalimantan Barat',
                    'hero.title': 'Masa Depan Hijau Kalimantan Barat',
                    'hero.cta': 'Jelajahi Peta Interaktif',
                    'stats.forest.label': 'Luas Hutan',
                    'stats.forest.value': '8.2jt Ha',
                    'stats.forest.update': '* Update 24 Mei 2024',
                    'stats.emission.label': 'Penurunan Emisi',
                    'stats.carbon.label': 'Stok Karbon',
                },
                en: {
                    'hero.eyebrow': 'Official REDD+ West Kalimantan Portal',
                    'hero.title': 'A Greener Future for West Kalimantan',
                    'hero.cta': 'Explore Interactive Map',
                    'stats.forest.label': 'Forest Area',
                    'stats.forest.value': '8.2m ha',
                    'stats.forest.update': '* Updated May 24, 2024',
                    'stats.emission.label': 'Emission Reduction',
                    'stats.carbon.label': 'Carbon Stock',
                },
            };

            const languageSelect = document.querySelector('[data-language-select]');
            const translatable = document.querySelectorAll('[data-i18n]');
            let activeLanguage = 'id';

            const setLanguage = (language) => {
                activeLanguage = language;
                document.documentElement.lang = language;

                translatable.forEach((element) => {
                    const key = element.dataset.i18n;
                    const text = translations[language][key];

                    if (text) {
                        element.textContent = text;
                    }
                });

                if (languageSelect) {
                    languageSelect.value = language;
                }
            };

            languageSelect?.addEventListener('change', (event) => {
                setLanguage(event.target.value);
            });

            setLanguage(activeLanguage);
        })();
    </script>
@endpush
