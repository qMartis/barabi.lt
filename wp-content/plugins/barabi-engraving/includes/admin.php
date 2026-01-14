<?php
defined('ABSPATH') || exit;

add_action('add_meta_boxes', function () {
    add_meta_box(
            'barabi_engraving',
            'Engraving',
            'barabi_engraving_metabox',
            'product',
            'side',
            'high'
    );
});

function barabi_engraving_metabox($post) {
    $enabled  = get_post_meta($post->ID, '_engraving_enabled', true);
    $image_id = get_post_meta($post->ID, '_engraving_image_id', true);
    $image    = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : '';
    ?>
    <p>
        <label>
            <input type="checkbox"
                   id="barabi_engraving_enabled"
                   name="_engraving_enabled"
                   value="1"
                    <?php checked($enabled, '1'); ?>>
            Enable engraving
        </label>
    </p>

    <div id="barabi-engraving-controls"
         style="<?php echo ($enabled === '1') ? '' : 'display:none;'; ?>">

        <input type="hidden"
               name="_engraving_image_id"
               id="barabi_engraving_image_id"
               value="<?php echo esc_attr($image_id); ?>">

        <button type="button" class="button barabi-select-image">
            Select engraving image
        </button>

        <div class="barabi-engraving-preview" style="margin-top:10px;">
            <?php if ($image): ?>
                <img src="<?php echo esc_url($image); ?>" style="max-width:100%;">
            <?php endif; ?>
        </div>
    </div>
    <?php
}

add_action('save_post_product', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    update_post_meta(
            $post_id,
            '_engraving_enabled',
            isset($_POST['_engraving_enabled']) ? '1' : '0'
    );

    if (isset($_POST['_engraving_image_id'])) {
        update_post_meta(
                $post_id,
                '_engraving_image_id',
                absint($_POST['_engraving_image_id'])
        );
    }
});

add_action('admin_enqueue_scripts', function ($hook) {
    if (!in_array($hook, ['post.php', 'post-new.php'])) return;

    wp_enqueue_media();

    wp_enqueue_script(
            'barabi-engraving-admin',
            plugin_dir_url(__FILE__) . '../assets/js/admin-engraving.js',
            [],
            '1.0',
            true
    );
});
