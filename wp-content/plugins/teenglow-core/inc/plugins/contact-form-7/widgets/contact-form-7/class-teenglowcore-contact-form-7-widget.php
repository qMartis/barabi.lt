<?php

if ( ! function_exists( 'teenglow_core_add_contact_form_7_widget' ) ) {
	/**
	 * Function that add widget into widgets list for registration
	 *
	 * @param array $widgets
	 *
	 * @return array
	 */
	function teenglow_core_add_contact_form_7_widget( $widgets ) {
		$widgets[] = 'TeenglowCore_Contact_Form_7_Widget';

		return $widgets;
	}

	add_filter( 'teenglow_core_filter_register_widgets', 'teenglow_core_add_contact_form_7_widget' );
}

if ( class_exists( 'QodeFrameworkWidget' ) ) {
	class TeenglowCore_Contact_Form_7_Widget extends QodeFrameworkWidget {

		public function map_widget() {
			$this->set_base( 'teenglow_core_contact_form_7' );
			$this->set_name( esc_html__( 'Teenglow Contact Form 7', 'teenglow-core' ) );
			$this->set_description( esc_html__( 'Add contact form 7 to widget areas', 'teenglow-core' ) );
			$this->set_widget_option(
				array(
					'field_type' => 'text',
					'name'       => 'widget_title',
					'title'      => esc_html__( 'Widget Title', 'teenglow-core' ),
				)
			);
			$this->set_widget_option(
				array(
					'field_type' => 'select',
					'name'       => 'contact_form_id',
					'title'      => esc_html__( 'Select Contact Form 7', 'teenglow-core' ),
					'options'    => qode_framework_get_cpt_items( 'wpcf7_contact_form', array( 'numberposts' => '-1' ) ),
				)
			);
		}

		public function render( $atts ) { ?>
			<div class="qodef-contact-form-7">
				<?php
				if ( ! empty( $atts['contact_form_id'] ) ) {
					echo do_shortcode( '[contact-form-7 id="' . esc_attr( $atts['contact_form_id'] ) . '"]' ); // XSS OK
				}
				?>
			</div>
			<?php
		}
	}
}
