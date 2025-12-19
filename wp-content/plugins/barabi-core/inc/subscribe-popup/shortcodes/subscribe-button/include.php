<?php

include_once BARABI_CORE_INC_PATH . '/subscribe-popup/shortcodes/subscribe-button/class-barabicore-subscribe-button-shortcode.php';

foreach ( glob( BARABI_CORE_INC_PATH . '/subscribe-popup/shortcodes/subscribe-button/variations/*/include.php' ) as $variation ) {
    include_once $variation;
}
