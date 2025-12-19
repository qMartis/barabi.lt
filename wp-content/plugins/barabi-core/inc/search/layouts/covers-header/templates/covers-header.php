<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="qodef-search-cover-form" method="get">
	<div class="qodef-m-inner">
        <span class="qodef-search-label"><?php echo esc_html__( 'What are you looking for?', 'barabi-core' ) ?></span>
        <div class="qodef-m-input-holder">
            <input type="text" placeholder="<?php esc_attr_e( 'Search', 'barabi-core' ); ?>" name="s" class="qodef-m-form-field" autocomplete="off" required/>
            <?php
            barabi_core_get_opener_icon_html(
                array(
                    'html_tag'     => 'button',
                    'option_name'  => 'search',
                    'custom_icon'  => 'search',
                    'custom_class' => 'qodef-m-form-submit',
                )
            );
            ?>
            <div class="qodef-m-form-line"></div>
        </div>
		<?php
		barabi_core_get_opener_icon_html(
			array(
				'option_name'  => 'search',
				'custom_icon'  => 'search',
				'custom_class' => 'qodef-m-close',
			),
			false,
			true
		);
		?>
	</div>
</form>
