<?php
defined('ABSPATH') || exit;

/* =========================
 * ENQUEUE CSS + JS
 * ========================= */
add_action('wp_enqueue_scripts', 'barabi_engraving_enqueue');
function barabi_engraving_enqueue() {
    if (!is_product()) return;

    wp_enqueue_style(
            'barabi-engraving-main',
            plugin_dir_url(dirname(__FILE__)) . 'assets/css/main.css',
            [],
            '1.0'
    );

    wp_enqueue_script(
            'barabi-engraving-js',
            plugin_dir_url(dirname(__FILE__)) . 'assets/js/engraving.js',
            [],
            '1.0',
            true
    );
}

/* =========================
 * FRONTEND HTML
 * ========================= */
add_action('woocommerce_after_single_product_summary', 'barabi_render_engraving', 5);
function barabi_render_engraving() {
    global $product;

    if ($product->get_meta('_engraving_enabled') !== '1') return;

    $image_id = $product->get_meta('_engraving_image_id');
    if (!$image_id) return;

    $image = wp_get_attachment_image_url($image_id, 'large');
    ?>
    <div class="eng-section">
        <div class="eng-main-layout">

            <div class="eng-left-side">
                <div class="eng-title">Add Engraving:</div>
                <div class="eng-description">
                    Personalize your product. Type in names, initials, or numbers.
                </div>

                <div id="engravings">
                    <div class="text-engraving">
                        <input
                                type="text"
                                class="eng-input"
                                name="engraving_text"
                                maxlength="20"
                        >

                        <input
                                type="hidden"
                                name="engraving_image_id"
                                value="<?php echo esc_attr($image_id); ?>"
                        >

                        <div class="eng-limit">20 symbols maximum.</div>

                        <div class="eng-row">
                            <div class="eng-label">Font:</div>
                            <div class="eng-btns">
                                <label>
                                    <input type="radio" name="engraving_font" value="poster" checked>
                                    <span>Poster</span>
                                </label>
                                <label>
                                    <input type="radio" name="engraving_font" value="default">
                                    <span>Default</span>
                                </label>
                                <label>
                                    <input type="radio" name="engraving_font" value="handwriting">
                                    <span class="font-hw">Handwriting</span>
                                </label>
                            </div>
                        </div>

                        <div class="eng-row">
                            <div class="eng-label">Size:</div>
                            <div class="eng-btns">
                                <label>
                                    <input type="radio" name="engraving_size" value="regular" checked>
                                    <span>Regular</span>
                                </label>
                                <label>
                                    <input type="radio" name="engraving_size" value="big">
                                    <span>Big</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="emoji-engraving">
                        <div class="eng-title">Emoji engraving:</div>
                        <div class="emoji-selection">
                            
                        </div>
                    </div>
                </div>  
            </div>

            <div class="eng-right-side">
                <div class="eng-img-box">
                    <img src="<?php echo esc_url($image); ?>" alt="engraving image">
                    <div class="eng-text-overlay"></div>
                </div>
            </div>

        </div>
    </div>
    <?php
}

/* =========================
 * SAVE TO CART
 * ========================= */
add_filter('woocommerce_add_cart_item_data', function ($cart_item_data) {
    if (!empty($_POST['engraving_text'])) {
        $cart_item_data['engraving'] = [
                'text'     => sanitize_text_field($_POST['engraving_text']),
                'font'     => sanitize_text_field($_POST['engraving_font'] ?? ''),
                'size'     => sanitize_text_field($_POST['engraving_size'] ?? ''),
//                 'image_id' => absint($_POST['engraving_image_id'] ?? 0),
        ];
    }
    return $cart_item_data;
}, 10, 1);

/* =========================
 * SHOW IN CART & CHECKOUT
 * ========================= */
add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {

    if (empty($cart_item['engraving'])) return $item_data;

    $e = $cart_item['engraving'];

    $item_data[] = [
            'name'  => 'Engraving text',
            'value' => esc_html($e['text']),
    ];

    if ($e['font']) {
        $item_data[] = [
                'name'  => 'Font',
                'value' => esc_html($e['font']),
        ];
    }

    if ($e['size']) {
        $item_data[] = [
                'name'  => 'Size',
                'value' => esc_html($e['size']),
        ];
    }

//     if (!empty($e['image_id'])) {
//         $img = wp_get_attachment_image_url($e['image_id'], 'thumbnail');
//         if ($img) {
//             $item_data[] = [
//                     'name'  => 'Engraving image',
//                     'value' => '<img src="' . esc_url($img) . '" style="max-width:100px;">',
//             ];
//         }
//     }

    return $item_data;
}, 10, 2);

/* =========================
 * SAVE TO ORDER
 * ========================= */
add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values) {

    if (empty($values['engraving'])) return;

    $e = $values['engraving'];

    $item->add_meta_data('Engraving text', $e['text']);

    if ($e['font']) {
        $item->add_meta_data('Font', $e['font']);
    }

    if ($e['size']) {
        $item->add_meta_data('Size', $e['size']);
    }

    if (!empty($e['image_id'])) {
        $url = wp_get_attachment_url($e['image_id']);
        if ($url) {
            $item->add_meta_data('Engraving image', $url);
        }
    }

}, 10, 3);
