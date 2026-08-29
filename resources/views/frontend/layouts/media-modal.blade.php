{{-- Modal Detail Media / Gambar --}}
<div id="mediaModal" class="media-modal-overlay" aria-hidden="true" role="dialog" aria-labelledby="mediaModalTitle">
    <div class="media-modal-card">
        {{-- Header --}}
        <div class="media-modal__header">
            <div>
                <h2 id="mediaModalTitle" class="media-modal__title">+ DETAIL FOTO &amp; MEDIA</h2>
                <p class="media-modal__subtitle">Dokumentasi &amp; Galeri Publikasi REDD+ Kalimantan Barat</p>
            </div>
            <button type="button" class="media-modal__close js-close-media-modal" aria-label="Tutup Modal">&times;</button>
        </div>

        {{-- Image Display Area --}}
        <div class="media-modal__body">
            <div class="media-modal__img-wrapper">
                <button type="button" id="mediaModalPrev" class="media-modal__nav-btn media-modal__nav-btn--prev" aria-label="Gambar Sebelumnya">
                    <i class="mdi mdi-chevron-left" aria-hidden="true"></i>
                </button>
                
                <img id="mediaModalImage" src="" alt="" loading="eager">

                <button type="button" id="mediaModalNext" class="media-modal__nav-btn media-modal__nav-btn--next" aria-label="Gambar Berikutnya">
                    <i class="mdi mdi-chevron-right" aria-hidden="true"></i>
                </button>
            </div>

            <div class="media-modal__caption-box">
                <div class="media-modal__meta" style="display: flex; flex-wrap: wrap; gap: 0.5rem 1rem; align-items: center;">
                    <span><i class="mdi mdi-account" aria-hidden="true"></i> <span id="mediaModalNama">Nama</span></span>
                    <span>&bull;</span>
                    <span><i class="mdi mdi-calendar" aria-hidden="true"></i> <span id="mediaModalDate">Date</span></span>
                    <span>&bull;</span>
                    <span id="mediaModalCounter">Gambar 1 dari 6</span>
                </div>
                <h3 id="mediaModalCaption" class="media-modal__caption">---</h3>
            </div>
        </div>

        {{-- Footer --}}
        <div class="media-modal__footer">
            <a id="mediaModalDownload" href="#" download class="media-modal__download-btn">
                <i class="mdi mdi-download" aria-hidden="true"></i> Download Foto
            </a>
            <button type="button" class="media-modal__close-btn js-close-media-modal">Tutup</button>
        </div>
    </div>
</div>

<style>
/* Media Modal Styles */
.media-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(12, 18, 12, 0.75);
    backdrop-filter: blur(4px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.25s ease, visibility 0.25s ease;
}

.media-modal-overlay.is-active {
    opacity: 1;
    visibility: visible;
}

.media-modal-card {
    background: #ffffff;
    border-radius: 12px;
    width: min(860px, 100%);
    padding: 2rem 2.4rem;
    box-shadow: 0 24px 48px rgba(0, 0, 0, 0.28);
    transform: translateY(18px) scale(0.98);
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    max-height: 92vh;
    display: flex;
    flex-direction: column;
}

.media-modal-overlay.is-active .media-modal-card {
    transform: translateY(0) scale(1);
}

.media-modal__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e6ebe6;
}

.media-modal__title {
    margin: 0;
    color: #1f7b1c;
    font-size: 0.98rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.media-modal__subtitle {
    margin: 0.25rem 0 0;
    color: #555e56;
    font-size: 0.86rem;
    font-weight: 500;
}

.media-modal__close {
    background: transparent;
    border: none;
    font-size: 1.8rem;
    line-height: 1;
    color: #1d211e;
    cursor: pointer;
    padding: 0;
    margin: -0.4rem -0.4rem 0 0;
    transition: color 0.2s, transform 0.2s;
}

.media-modal__close:hover {
    color: #1f7b1c;
    transform: scale(1.1);
}

.media-modal__body {
    padding: 1.2rem 0;
    overflow-y: auto;
}

.media-modal__img-wrapper {
    position: relative;
    width: 100%;
    background: #0f1410;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 280px;
    max-height: 480px;
}

.media-modal__img-wrapper img {
    max-width: 100%;
    max-height: 480px;
    object-fit: contain;
    display: block;
}

.media-modal__nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.85);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: #1a201b;
    font-size: 1.4rem;
    display: grid;
    place-items: center;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s, color 0.2s;
    z-index: 5;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.media-modal__nav-btn:hover {
    background: #1f7b1c;
    color: #ffffff;
}

.media-modal__nav-btn--prev { left: 0.8rem; }
.media-modal__nav-btn--next { right: 0.8rem; }

.media-modal__caption-box {
    margin-top: 1rem;
    background: #f7f9f7;
    border: 1px solid #e3e8e3;
    border-radius: 8px;
    padding: 1rem 1.2rem;
}

.media-modal__meta {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    color: #1f7b1c;
    font-size: 0.8rem;
    font-weight: 600;
}

.media-modal__caption {
    margin: 0.4rem 0 0;
    color: #222a23;
    font-size: 0.95rem;
    line-height: 1.45;
    font-weight: 600;
}

.media-modal__footer {
    padding-top: 1rem;
    border-top: 1px solid #e6ebe6;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.media-modal__download-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: #1f7b1c;
    color: #ffffff;
    text-decoration: none;
    padding: 0.55rem 1.2rem;
    border-radius: 6px;
    font-size: 0.86rem;
    font-weight: 600;
    transition: background 0.2s;
}

.media-modal__download-btn:hover {
    background: #165c14;
    color: #ffffff;
}

.media-modal__close-btn {
    background: transparent;
    color: #555;
    border: 1px solid #ccc;
    padding: 0.55rem 1.2rem;
    border-radius: 6px;
    font-size: 0.86rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.media-modal__close-btn:hover {
    background: #eee;
}

@media (max-width: 640px) {
    .media-modal-card {
        padding: 1.2rem;
    }
    .media-modal__nav-btn {
        width: 32px;
        height: 32px;
        font-size: 1.1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('mediaModal');
    if (!modal) return;

    const modalImg = document.getElementById('mediaModalImage');
    const modalCaption = document.getElementById('mediaModalCaption');
    const modalCounter = document.getElementById('mediaModalCounter');
    const modalDownload = document.getElementById('mediaModalDownload');
    const modalNama = document.getElementById('mediaModalNama');
    const modalDate = document.getElementById('mediaModalDate');
    const closeBtns = modal.querySelectorAll('.js-close-media-modal');
    const prevBtn = document.getElementById('mediaModalPrev');
    const nextBtn = document.getElementById('mediaModalNext');

    let galleryItems = [];
    let currentIndex = 0;

    function updateModalItem(index) {
        if (galleryItems.length === 0) return;

        currentIndex = (index + galleryItems.length) % galleryItems.length;
        const item = galleryItems[currentIndex];

        modalImg.src = item.src;
        modalImg.alt = item.alt;
        modalCaption.textContent = item.alt || 'Dokumentasi kegiatan REDD+ Kalimantan Barat';
        modalCounter.textContent = `Gambar ${currentIndex + 1} dari ${galleryItems.length}`;
        if (modalNama) modalNama.textContent = item.nama || '-';
        if (modalDate) modalDate.textContent = item.tanggal || '-';
        modalDownload.href = item.src;
        modalDownload.setAttribute('download', (item.alt || 'media-redd-kalbar').toLowerCase().replace(/[^a-z0-9]/g, '-') + '.png');
    }

    function openMediaModal(items, startIndex) {
        galleryItems = items;
        updateModalItem(startIndex);

        if (galleryItems.length <= 1) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        } else {
            prevBtn.style.display = 'grid';
            nextBtn.style.display = 'grid';
        }

        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Attach click listeners to gallery tiles
    document.body.addEventListener('click', function (e) {
        const tile = e.target.closest('.gallery-tile, [data-open-media-modal]');
        if (tile) {
            e.preventDefault();
            
            // Gather all gallery tiles on the page for prev/next navigation
            const allTiles = Array.from(document.querySelectorAll('.gallery-tile, [data-open-media-modal]'));
            const items = allTiles.map(t => {
                const img = t.querySelector('img') || t;
                return {
                    src: img.getAttribute('src') || t.getAttribute('href') || '',
                    alt: img.getAttribute('alt') || t.getAttribute('data-caption') || 'Dokumentasi Kegiatan',
                    nama: t.getAttribute('data-nama') || '',
                    tanggal: t.getAttribute('data-tanggal') || ''
                };
            });

            const index = allTiles.indexOf(tile);
            openMediaModal(items, index >= 0 ? index : 0);
        }
    });

    prevBtn.addEventListener('click', () => updateModalItem(currentIndex - 1));
    nextBtn.addEventListener('click', () => updateModalItem(currentIndex + 1));
    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (!modal.classList.contains('is-active')) return;

        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowLeft') updateModalItem(currentIndex - 1);
        if (e.key === 'ArrowRight') updateModalItem(currentIndex + 1);
    });
});
</script>
