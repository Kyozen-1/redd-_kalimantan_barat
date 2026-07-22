{{-- Modal Ruang Kolaborasi LSM --}}
<div id="lsmModal" class="lsm-modal-overlay" aria-hidden="true" role="dialog" aria-labelledby="lsmModalTitle">
    <div class="lsm-modal-card">
        {{-- Header --}}
        <div class="lsm-modal__header">
            <div>
                <h2 id="lsmModalTitle" class="lsm-modal__title">&bull; RUANG KOLABRASI LSM</h2>
                <p class="lsm-modal__subtitle">Temukan LSM dan lakukan kolaborasi</p>
            </div>
            <button type="button" class="lsm-modal__close js-close-lsm-modal" aria-label="Tutup Modal">&times;</button>
        </div>

        {{-- Search Input --}}
        <div class="lsm-modal__search-wrapper">
            <input type="text" id="lsmSearchInput" class="lsm-modal__search-input" placeholder="Cari Data" autocomplete="off">
            <i class="mdi mdi-magnify lsm-modal__search-icon" aria-hidden="true"></i>
        </div>

        {{-- Table Container --}}
        <div class="lsm-modal__table-container">
            <table class="lsm-modal__table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Nama LSM</th>
                        <th style="width: 25%;">Sektor</th>
                        <th style="width: 28%;">Wilayah Cakupan</th>
                        <th style="width: 22%; text-align: center;">Halaman Website</th>
                    </tr>
                </thead>
                <tbody id="lsmTableBody">
                    {{-- Dynamically populated via JS --}}
                </tbody>
            </table>

            {{-- State overlays --}}
            <div id="lsmLoadingState" class="lsm-modal__state-box" style="display: none;">
                <i class="mdi mdi-loading mdi-spin" style="font-size: 2rem; color: #1f7b1c;"></i>
                <p>Memuat data LSM...</p>
            </div>
            <div id="lsmEmptyState" class="lsm-modal__state-box" style="display: none;">
                <i class="mdi mdi-alert-circle-outline" style="font-size: 2rem; color: #8a948b;"></i>
                <p>Data LSM tidak ditemukan</p>
            </div>
        </div>
    </div>
</div>

<style>
/* LSM Modal Styles */
.lsm-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 20, 15, 0.65);
    backdrop-filter: blur(3px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.25s ease, visibility 0.25s ease;
}

.lsm-modal-overlay.is-active {
    opacity: 1;
    visibility: visible;
}

.lsm-modal-card {
    background: #f8faf8;
    border-radius: 12px;
    width: min(840px, 100%);
    padding: 2.2rem 2.8rem;
    box-shadow: 0 24px 48px rgba(0, 0, 0, 0.22);
    transform: translateY(18px) scale(0.98);
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.lsm-modal-overlay.is-active .lsm-modal-card {
    transform: translateY(0) scale(1);
}

.lsm-modal__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

.lsm-modal__title {
    margin: 0;
    color: #1f7b1c;
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.lsm-modal__subtitle {
    margin: 0.3rem 0 0;
    color: #4f5750;
    font-size: 0.88rem;
    font-weight: 500;
}

.lsm-modal__close {
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

.lsm-modal__close:hover {
    color: #1f7b1c;
    transform: scale(1.1);
}

.lsm-modal__search-wrapper {
    position: relative;
    margin: 1.4rem 0 1.2rem;
    width: 100%;
}

.lsm-modal__search-input {
    width: 100%;
    height: 44px;
    padding: 0 2.8rem 0 1.2rem;
    border-radius: 6px;
    border: 1px solid #dcdfdc;
    background: #ffffff;
    font-size: 0.88rem;
    color: #222222;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    font-family: inherit;
}

.lsm-modal__search-input:focus {
    border-color: #1f7b1c;
    box-shadow: 0 0 0 3px rgba(31, 123, 28, 0.12);
}

.lsm-modal__search-input::placeholder {
    color: #9ea69f;
}

.lsm-modal__search-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2rem;
    color: #889289;
    pointer-events: none;
}

.lsm-modal__table-container {
    max-height: 380px;
    overflow-y: auto;
    border-radius: 4px;
    position: relative;
}

.lsm-modal__table-container::-webkit-scrollbar {
    width: 6px;
}
.lsm-modal__table-container::-webkit-scrollbar-track {
    background: #eef2ee;
    border-radius: 3px;
}
.lsm-modal__table-container::-webkit-scrollbar-thumb {
    background: #b8c0b8;
    border-radius: 3px;
}

.lsm-modal__table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.lsm-modal__table thead {
    position: sticky;
    top: 0;
    z-index: 2;
    background: #b5b9b5;
}

.lsm-modal__table th {
    padding: 0.8rem 1.2rem;
    color: #ffffff;
    font-weight: 700;
    font-size: 0.88rem;
    letter-spacing: 0.2px;
}

.lsm-modal__table td {
    padding: 1.1rem 1.2rem;
    font-size: 0.88rem;
    color: #2c332d;
    border-bottom: 1px solid #e5e9e5;
    background: #ffffff;
}

.lsm-modal__table tbody tr {
    transition: background-color 0.15s ease;
}

.lsm-modal__table tbody tr:hover td {
    background: #f4f7f4;
}

.lsm-table-link {
    color: #1f7b1c;
    font-weight: 600;
    text-decoration: underline;
    transition: opacity 0.2s;
}

.lsm-table-link:hover {
    opacity: 0.8;
}

.lsm-modal__state-box {
    padding: 3rem 1.5rem;
    text-align: center;
    background: #ffffff;
    color: #667067;
}
.lsm-modal__state-box p {
    margin: 0.6rem 0 0;
    font-size: 0.9rem;
    font-weight: 500;
}

@media (max-width: 640px) {
    .lsm-modal-card {
        padding: 1.5rem;
    }
    .lsm-modal__table th,
    .lsm-modal__table td {
        padding: 0.8rem 0.6rem;
        font-size: 0.82rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('lsmModal');
    if (!modal) return;

    const closeBtns = modal.querySelectorAll('.js-close-lsm-modal');
    const searchInput = document.getElementById('lsmSearchInput');
    const tableBody = document.getElementById('lsmTableBody');
    const loadingState = document.getElementById('lsmLoadingState');
    const emptyState = document.getElementById('lsmEmptyState');

    let allLsmData = [];
    let isFetched = false;
    let searchDebounceTimer = null;

    function openModal() {
        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        if (!isFetched) {
            fetchLsmData();
        } else {
            if (searchInput) searchInput.focus();
        }
    }

    function closeModal() {
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Attach click listeners to any LSM trigger button/link across the page
    document.body.addEventListener('click', function (e) {
        const trigger = e.target.closest('.js-open-lsm-modal, [data-open-lsm-modal], a[href="#lsm-modal"]');
        if (trigger) {
            e.preventDefault();
            openModal();
        }
    });

    closeBtns.forEach(btn => btn.addEventListener('click', closeModal));

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('is-active')) {
            closeModal();
        }
    });

    function fetchLsmData(query = '') {
        loadingState.style.display = 'block';
        emptyState.style.display = 'none';

        const url = query ? `{{ route('api.lsm') }}?q=${encodeURIComponent(query)}` : `{{ route('api.lsm') }}`;

        fetch(url)
            .then(res => res.json())
            .then(res => {
                loadingState.style.display = 'none';
                if (res.status === 'success' && Array.isArray(res.data)) {
                    if (!query) {
                        allLsmData = res.data;
                        isFetched = true;
                    }
                    renderTable(res.data);
                } else {
                    renderTable([]);
                }
            })
            .catch(err => {
                console.error('Failed to load LSM data:', err);
                loadingState.style.display = 'none';
                renderTable([]);
            });
    }

    function renderTable(items) {
        tableBody.innerHTML = '';
        if (!items || items.length === 0) {
            emptyState.style.display = 'block';
            return;
        }
        emptyState.style.display = 'none';

        items.forEach((item, index) => {
            const tr = document.createElement('tr');
            
            const linkHref = item.link ? (item.link.startsWith('http') ? item.link : 'https://' + item.link) : '#';
            const linkTarget = item.link ? '_blank' : '_self';
            const linkText = item.link_label || (`Link ` + (index + 1));

            tr.innerHTML = `
                <td style="font-weight: 600; color: #1d211e;">${escapeHtml(item.nama)}</td>
                <td>${escapeHtml(item.sektor)}</td>
                <td>${escapeHtml(item.wilayah_cakupan)}</td>
                <td style="text-align: center;">
                    ${item.link ? `<a href="${escapeHtml(linkHref)}" target="${linkTarget}" rel="noopener noreferrer" class="lsm-table-link">${escapeHtml(linkText)}</a>` : '-'}
                </td>
            `;
            tableBody.appendChild(tr);
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const val = this.value.trim().toLowerCase();
            clearTimeout(searchDebounceTimer);
            
            // Fast client-side filter first if data exists
            if (allLsmData.length > 0) {
                const filtered = allLsmData.filter(item => {
                    return (item.nama && item.nama.toLowerCase().includes(val)) ||
                           (item.sektor && item.sektor.toLowerCase().includes(val)) ||
                           (item.wilayah_cakupan && item.wilayah_cakupan.toLowerCase().includes(val));
                });
                renderTable(filtered);
            }

            // Also query API for deep search if query is longer
            searchDebounceTimer = setTimeout(() => {
                if (val.length > 1) {
                    fetchLsmData(val);
                } else if (val.length === 0) {
                    renderTable(allLsmData);
                }
            }, 300);
        });
    }
});
</script>
