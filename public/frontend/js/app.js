document.querySelectorAll('.password-field').forEach((field) => {
    const input = field.querySelector('input');
    const toggle = field.querySelector('.password-field__toggle');

    if (!input || !toggle) {
        return;
    }

    toggle.addEventListener('click', () => {
        const isHidden = input.type === 'password';

        input.type = isHidden ? 'text' : 'password';
        toggle.setAttribute('aria-pressed', String(isHidden));
        toggle.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
    });
});
