document.addEventListener('DOMContentLoaded', function () {

    const input = document.querySelector('.eng-input');
    const overlay = document.querySelector('.eng-text-overlay');
    const fontRadios = document.querySelectorAll('input[name="engraving_font"]');
    const sizeRadios = document.querySelectorAll('input[name="engraving_size"]');
    const form = document.querySelector('form.cart');

    if (!input || !overlay || !form) return;

    /* TEXT PREVIEW */
    input.addEventListener('input', function () {
        overlay.textContent = input.value.substring(0, 20);
    });

    /* FONT PREVIEW */
    fontRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            overlay.className = 'eng-text-overlay font-' + this.value;
        });
    });

    /* SIZE PREVIEW */
    sizeRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            overlay.classList.toggle('big', this.value === 'big');
        });
    });

    /* COPY DATA INTO CART FORM BEFORE SUBMIT */
    form.addEventListener('submit', function () {

        const fields = [
            'engraving_text',
            'engraving_font',
            'engraving_size',
            'engraving_image_id'
        ];

        fields.forEach(name => {
            let source;

            if (name === 'engraving_font' || name === 'engraving_size') {
                source = document.querySelector('[name="' + name + '"]:checked');
            } else {
                source = document.querySelector('[name="' + name + '"]');
            }

            if (!source || !source.value) return;

            let target = form.querySelector('[name="' + name + '"]');
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
