<a itemprop="url" href="#" class="qodef-m-link">
	<?php echo teenglow_core_get_svg_icon( 'heart', 'qodef-m-link-icon' ); ?>
<!--	<span class="qodef-m-link-count">--><?php //echo esc_html( $number_of_items ); ?><!--</span>-->
</a>
<div class="qodef-m-items">
	<?php
	if ( ! empty( $number_of_items ) ) {
		$items = teenglow_core_get_wishlist_items();

		foreach ( $items as $id => $title ) {
			$item_params          = array();
			$item_params['id']    = $id;
			$item_params['title'] = $title;

			teenglow_core_template_part( 'wishlist', 'widgets/wishlist-dropdown/templates/item', '', $item_params );
		}
	}
	?>
</div>
