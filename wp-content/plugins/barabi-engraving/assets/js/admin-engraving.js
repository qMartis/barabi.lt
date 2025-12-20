document.addEventListener('DOMContentLoaded', function () {
    const enableCheckbox = document.getElementById('barabi_engraving_enabled');
    const controls = document.getElementById('barabi-engraving-controls');
    const button = document.querySelector('.barabi-select-image');
    let frame;

    if (enableCheckbox) {
        enableCheckbox.addEventListener('change', function () {
            controls.style.display = this.checked ? 'block' : 'none';
        });
    }

    if (!button) return;

    button.addEventListener('click', function (e) {
        e.preventDefault();

        if (frame) {
            frame.open();
            return;
        }

        frame = wp.media({
            title: 'Select engraving image',
            button: { text: 'Use this image' },
            multiple: false
        });

        frame.on('select', function () {
            const attachment = frame.state().get('selection').first().toJSON();
            document.getElementById('barabi_engraving_image_id').value = attachment.id;
            document.querySelector('.barabi-engraving-preview').innerHTML =
                '<img src="' + attachment.sizes.thumbnail.url + '" style="max-width:100%;margin-top:10px;">';
        });

        frame.open();
    });
});
