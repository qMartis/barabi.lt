<?php if ( is_array( $features ) && count( $features ) > 0 ) { ?>
	<div class="qodef-e-features">
		<?php foreach ( $features as $feature ) { ?>
			<span class="qodef-pill">
				<span class="qodef-m-text"><?php echo $feature['item_title'] ?></span>
			</span>
		<?php } ?>
	</div>
	<?php
}
