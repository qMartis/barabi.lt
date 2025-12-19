<?php $image_id = teenglow_core_get_post_value_through_levels( 'qodef_fullscreen_menu_image' ); ?>

<?php if ( ! empty( $image_id ) ) : ?>
    <div class="qodef-image-holder">
        <?php echo wp_get_attachment_image( $image_id, 'full' ); ?>
    </div>
<?php endif; ?>
