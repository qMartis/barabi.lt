<?php
$title = get_the_title( $project_id );
$title_tag = ! empty( $title_tag ) ? $title_tag : 'h2';

if ( ! empty( $title ) ) {
	?>
	<<?php echo esc_attr( $title_tag ) ?> class="qodef-e-title">
		<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $project_id ) ); ?>"><?php echo esc_html( $title ); ?></a>
	</<?php echo esc_attr( $title_tag ) ?>>
	<?php
}
