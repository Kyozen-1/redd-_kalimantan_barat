{{-- Modal Detail Agenda --}}
<div id="agendaModal" class="agenda-modal-overlay" aria-hidden="true" role="dialog" aria-labelledby="agendaModalTitle">
    <div class="agenda-modal-card">
        {{-- Header --}}
        <div class="agenda-modal__header">
            <div>
                <h2 id="agendaModalTitle" class="agenda-modal__title">&bull; DETAIL AGENDA KEGIATAN</h2>
                <p class="agenda-modal__subtitle">Informasi pelaksanaan kegiatan REDD+ Kalimantan Barat</p>
            </div>
            <button type="button" class="agenda-modal__close js-close-agenda-modal" aria-label="Tutup Modal">&times;</button>
        </div>

        {{-- Body Content --}}
        <div class="agenda-modal__body">
            <div class="agenda-modal__top">
                <div class="agenda-modal__date-badge">
                    <strong id="agendaModalDay">--</strong>
                    <span id="agendaModalMonth">---</span>
                </div>
                <div class="agenda-modal__meta">
                    <span class="agenda-modal__tag"><i class="mdi mdi-calendar-clock" aria-hidden="true"></i> <span id="agendaModalFullDate">-- --- ----</span></span>
                    <p class="agenda-modal__organizer"><i class="mdi mdi-map-marker-outline" aria-hidden="true"></i> <span id="agendaModalOrganisator">Dinas Lingkungan Hidup dan Kehutanan Prov. Kalbar</span></p>
                </div>
            </div>

            <h3 id="agendaModalNama" class="agenda-modal__event-title">---</h3>

            <div class="agenda-modal__desc-box">
                <h4 class="agenda-modal__desc-heading">&bull; Deskripsi Kegiatan</h4>
                <p id="agendaModalDeskripsi">Memuat deskripsi agenda...</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="agenda-modal__footer">
            <button type="button" class="agenda-modal__btn-close js-close-agenda-modal">Tutup Detail</button>
        </div>
    </div>
</div>

<style>
/* Agenda Modal Styles */
.agenda-modal-overlay {
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

.agenda-modal-overlay.is-active {
    opacity: 1;
    visibility: visible;
}

.agenda-modal-card {
    background: #f8faf8;
    border-radius: 12px;
    width: min(640px, 100%);
    padding: 2.2rem 2.6rem;
    box-shadow: 0 24px 48px rgba(0, 0, 0, 0.22);
    transform: translateY(18px) scale(0.98);
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.agenda-modal-overlay.is-active .agenda-modal-card {
    transform: translateY(0) scale(1);
}

.agenda-modal__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    padding-bottom: 1.2rem;
    border-bottom: 1px solid #e5e9e5;
}

.agenda-modal__title {
    margin: 0;
    color: #1f7b1c;
    font-size: 0.98rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    text-transform: uppercase;
}

.agenda-modal__subtitle {
    margin: 0.3rem 0 0;
    color: #4f5750;
    font-size: 0.86rem;
    font-weight: 500;
}

.agenda-modal__close {
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

.agenda-modal__close:hover {
    color: #1f7b1c;
    transform: scale(1.1);
}

.agenda-modal__body {
    padding: 1.4rem 0;
    overflow-y: auto;
}

.agenda-modal__top {
    display: flex;
    align-items: center;
    gap: 1.2rem;
}

.agenda-modal__date-badge {
    min-width: 4.8rem;
    height: 4.8rem;
    border-radius: 0.4rem;
    background: #e3f3de;
    color: #1f7b1c;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    flex-shrink: 0;
}

.agenda-modal__date-badge strong {
    font-size: 1.4rem;
    font-weight: 800;
    line-height: 1;
}

.agenda-modal__date-badge span {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-top: 0.15rem;
}

.agenda-modal__meta {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}

.agenda-modal__tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: #1f7b1c;
    font-size: 0.85rem;
    font-weight: 700;
}

.agenda-modal__organizer {
    margin: 0;
    color: #555f56;
    font-size: 0.84rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.agenda-modal__event-title {
    margin: 1.3rem 0 1rem;
    color: #151a16;
    font-size: 1.15rem;
    font-weight: 700;
    line-height: 1.35;
}

.agenda-modal__desc-box {
    background: #ffffff;
    border: 1px solid #e2e7e2;
    border-radius: 8px;
    padding: 1.3rem 1.5rem;
}

.agenda-modal__desc-heading {
    margin: 0 0 0.6rem;
    color: #1f7b1c;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.agenda-modal__desc-box p {
    margin: 0;
    color: #444d45;
    font-size: 0.9rem;
    line-height: 1.65;
    white-space: pre-line;
}

.agenda-modal__footer {
    padding-top: 1.2rem;
    border-top: 1px solid #e5e9e5;
    display: flex;
    justify-content: flex-end;
}

.agenda-modal__btn-close {
    background: #1f7b1c;
    color: #ffffff;
    border: none;
    padding: 0.6rem 1.4rem;
    border-radius: 6px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.15s;
}

.agenda-modal__btn-close:hover {
    background: #176314;
}

@media (max-width: 640px) {
    .agenda-modal-card {
        padding: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('agendaModal');
    if (!modal) return;

    const closeBtns = modal.querySelectorAll('.js-close-agenda-modal');
    const dayEl = document.getElementById('agendaModalDay');
    const monthEl = document.getElementById('agendaModalMonth');
    const fullDateEl = document.getElementById('agendaModalFullDate');
    const namaEl = document.getElementById('agendaModalNama');
    const deskripsiEl = document.getElementById('agendaModalDeskripsi');
    const organizerEl = document.getElementById('agendaModalOrganisator');

    function openModal(data) {
        if (data.day) dayEl.textContent = data.day;
        if (data.month) monthEl.textContent = data.month;
        if (data.tanggal) fullDateEl.textContent = data.tanggal;
        if (data.nama) namaEl.textContent = data.nama;
        if (data.deskripsi) {
            deskripsiEl.textContent = data.deskripsi;
        } else {
            deskripsiEl.textContent = 'Belum ada deskripsi tambahan untuk agenda ini.';
        }
        if (data.penyelenggara) organizerEl.textContent = data.penyelenggara;

        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        // Fetch fresh API data if ID available
        if (data.id) {
            fetch(`{{ url('/api/agenda') }}/${data.id}`)
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success' && res.data) {
                        const d = res.data;
                        if (d.nama) namaEl.textContent = d.nama;
                        if (d.deskripsi) deskripsiEl.textContent = d.deskripsi;
                        if (d.formatted_date) fullDateEl.textContent = d.formatted_date;
                        if (d.day) dayEl.textContent = d.day;
                        if (d.month) monthEl.textContent = d.month;
                    }
                })
                .catch(err => console.error('Failed to fetch agenda details:', err));
        }
    }

    function closeModal() {
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.body.addEventListener('click', function (e) {
        const trigger = e.target.closest('.js-open-agenda-modal, [data-open-agenda-modal]');
        if (trigger) {
            e.preventDefault();
            const data = {
                id: trigger.getAttribute('data-id'),
                nama: trigger.getAttribute('data-nama'),
                deskripsi: trigger.getAttribute('data-deskripsi'),
                tanggal: trigger.getAttribute('data-tanggal'),
                day: trigger.getAttribute('data-day'),
                month: trigger.getAttribute('data-month'),
                penyelenggara: trigger.getAttribute('data-penyelenggara') || 'Dinas Lingkungan Hidup dan Kehutanan Prov. Kalbar'
            };
            openModal(data);
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
});
</script>
