<footer class="site-footer">
    <div class="site-shell site-footer__grid">
        <div>
            <div class="site-footer__brand">
                <img src="{{ asset('frontend/images/logo-pemprov-kalbar.webp') }}" alt="Provinsi Kalimantan Barat">
                <img src="{{ asset('frontend/images/indonesia-logo.png') }}" alt="Bhinneka Tunggal Ika">
                <img src="{{ asset('frontend/images/redd-plus-kalbar.png') }}" alt="REDD+ Kalbar">
            </div>
            <h2>{{ $footerData['title'] ?? 'Berkomitmen Menjaga Kelestarian Hutan Kalimantan Barat untuk Generasi Mendatang' }}</h2>
            <p>{{ $footerData['description'] ?? 'Implementasi strategi REDD+ bukan sekadar angka pengurangan emisi, melainkan janji kita untuk menjaga keanekaragaman hayati dan kesejahteraan masyarakat lokal di jantung Kalimantan.' }}</p>
        </div>

        <div class="site-footer__contact">
            <h3>Kontak Resmi</h3>
            <p><span><i class="mdi mdi-map-marker" aria-hidden="true"></i></span>Kantor Dinas Lingkungan Hidup dan Kehutanan Prov. Kalbar<br>Jl. Letjen Suprapto No. 3, Pontianak</p>
            <p><span><i class="mdi mdi-email" aria-hidden="true"></i></span>kontak@reddplus.kalbarprov.go.id</p>
            <p><span><i class="mdi mdi-phone" aria-hidden="true"></i></span>+62 (561) 736-xxxx</p>
        </div>
    </div>
</footer>
