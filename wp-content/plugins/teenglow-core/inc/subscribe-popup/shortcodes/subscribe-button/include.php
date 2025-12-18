<?php

include_once TEENGLOW_CORE_INC_PATH . '/subscribe-popup/shortcodes/subscribe-button/class-teenglowcore-subscribe-button-shortcode.php';

foreach ( glob( TEENGLOW_CORE_INC_PATH . '/subscribe-popup/shortcodes/subscribe-button/variations/*/include.php' ) as $variation ) {
    include_once $variation;
}
