document.addEventListener('DOMContentLoaded', () => {

    const input = document.querySelector('.eng-input');
    const overlay = document.querySelector('.eng-text-overlay');
    const fontRadios = document.querySelectorAll('input[name="engraving_font"]');
    const sizeRadios = document.querySelectorAll('input[name="engraving_size"]');
    const form = document.querySelector('form.cart');

    if (!input || !overlay || !form) return;

    /* ---------- STATE ---------- */
    const state = {
        text: '',
        font: null,
        size: null
    };

    /* ---------- HELPERS ---------- */
    const getCheckedValue = name => {
        const el = document.querySelector(`input[name="${name}"]:checked`);
        return el ? el.value : null;
    };

    const updatePreview = () => {

        /* text */
        overlay.textContent = state.text.substring(0, 20);

        /* font */
        overlay.classList.forEach(cls => {
            if (cls.startsWith('font-')) overlay.classList.remove(cls);
        });
        if (state.font) {
            overlay.classList.add(`font-${state.font}`);
        }

        /* size */
        overlay.classList.toggle('big', state.size === 'big');
    };

    /* ---------- EVENTS ---------- */

    // TEXT
    input.addEventListener('input', () => {
        state.text = input.value;
        updatePreview();
    });

    // FONT
    fontRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            state.font = radio.value;
            updatePreview();
        });
    });

    // SIZE
    sizeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            state.size = radio.value;
            updatePreview();
        });
    });

    /* ---------- INIT (in case something is preselected) ---------- */
    state.text = input.value || '';
    state.font = getCheckedValue('engraving_font');
    state.size = getCheckedValue('engraving_size');
    updatePreview();

    /* ---------- COPY DATA TO CART ---------- */
    form.addEventListener('submit', () => {

        const fields = [
            'engraving_text',
            'engraving_font',
            'engraving_size',
            'engraving_image_id'
        ];

        fields.forEach(name => {

            let source;
            if (name === 'engraving_font' || name === 'engraving_size') {
                source = document.querySelector(`input[name="${name}"]:checked`);
            } else {
                source = document.querySelector(`[name="${name}"]`);
            }

            if (!source || !source.value) return;

            let target = form.querySelector(`[name="${name}"]`);
            if (!target) {
                target = document.createElement('input');
                target.type = 'hidden';
                target.name = name;
                form.appendChild(target);
            }

            target.value = source.value;
        });

    });

});
