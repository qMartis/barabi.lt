<?php

if ( ! function_exists( 'teenglow_include_comments_in_templates' ) ) {
	/**
	 * Function which includes comments templates on pages/posts
	 */
	function teenglow_include_comments_in_templates() {

		// Include comments template
		comments_template();
	}

	add_action( 'teenglow_action_after_page_content', 'teenglow_include_comments_in_templates', 100 ); // permission 100 is set to comment template be at the last place
	add_action( 'teenglow_action_after_blog_post_item', 'teenglow_include_comments_in_templates', 100 );
}

if ( ! function_exists( 'teenglow_is_page_comments_enabled' ) ) {
	/**
	 * Function that check is module enabled
	 */
	function teenglow_is_page_comments_enabled() {
		return apply_filters( 'teenglow_filter_enable_page_comments', true );
	}
}

if ( ! function_exists( 'teenglow_load_page_comments' ) ) {
	/**
	 * Function which loads page template module
	 */
	function teenglow_load_page_comments() {

		if ( teenglow_is_page_comments_enabled() ) {
			teenglow_template_part( 'comments', 'templates/comments' );
		}
	}

	add_action( 'teenglow_action_page_comments_template', 'teenglow_load_page_comments' );
}

if ( ! function_exists( 'teenglow_get_comments_list_template' ) ) {
	/**
	 * Function which modify default WordPress comments list template
	 *
	 * @param object $comment
	 * @param array $args
	 * @param int $depth
	 */
	function teenglow_get_comments_list_template( $comment, $args, $depth ) {
		global $post;

		$classes = array();

		$is_author_comment = $post->post_author === $comment->user_id;
		if ( $is_author_comment ) {
			$classes[] = 'qodef-comment--author';
		}

		$is_specific_comment = 'pingback' === $comment->comment_type || 'trackback' === $comment->comment_type;
		if ( $is_specific_comment ) {
			$classes[] = 'qodef-comment--no-avatar';
			$classes[] = 'qodef-comment--' . esc_attr( $comment->comment_type );
		}
		?>
		<li class="qodef-comment-item qodef-e <?php echo esc_attr( implode( ' ', apply_filters( 'teenglow_filter_comment_item_classes', $classes, $comment ) ) ); ?>">
			<div id="comment-<?php comment_ID(); ?>" class="qodef-e-inner">
				<?php if ( ! $is_specific_comment ) { ?>
					<div class="qodef-e-image"><?php echo get_avatar( $comment, apply_filters( 'teenglow_filter_comment_gravatar_size', '94' ) ); ?></div>
				<?php } ?>
				<div class="qodef-e-content">
					<div class="qodef-e-date commentmetadata">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>"><?php comment_time( get_option( 'date_format' ) ); ?></a>
					</div>
					<h6 class="qodef-e-title vcard"><?php echo sprintf( '<span class="fn">%s%s</span>', esc_attr( $is_specific_comment ) ? sprintf( '%s: ', esc_attr( ucwords( $comment->comment_type ) ) ) : '', get_comment_author_link() ); ?></h6>
					<?php if ( ! $is_specific_comment ) { ?>
						<div class="qodef-e-text"><?php comment_text( $comment ); ?></div>
					<?php } ?>
					<div class="qodef-e-links">
						<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'reply_text' => '<span class="qodef-e-link-text">' . esc_html__( 'Reply', 'teenglow' ) . '</span>' . teenglow_get_svg_icon( 'pagination-arrow-right' ),
									'depth'      => $depth,
									'max_depth'  => $args['max_depth'],
								)
							)
						);

						edit_comment_link( '<span class="qodef-e-link-text">' . esc_html__( 'Edit', 'teenglow' ) . '</span>' . teenglow_get_svg_icon( 'pagination-arrow-right' ) );
						?>
					</div>
				</div>
			</div>
		<?php //li tag will be closed by WordPress after looping through child elements ?>
		<?php
	}
}

if ( ! function_exists( 'teenglow_get_comment_form_args' ) ) {
	/**
	 * Function that define new comment form args in order to override default WordPress comment form
	 *
	 * @param array $attr - additional array which override default values
	 *
	 * @return array
	 */
	function teenglow_get_comment_form_args( $attr = array() ) {
		$qodef_commenter      = wp_get_current_commenter();
		$qodef_required_attr  = get_option( 'require_name_email' ) ? ' required="required"' : '';
		$qodef_required_label = get_option( 'require_name_email' ) ? '*' : '';

		$comment_placeholder = isset( $attr['comment_placeholder'] ) && ! empty( $attr['comment_placeholder'] ) ? esc_attr( $attr['comment_placeholder'] ) : esc_attr__( 'Message', 'teenglow' );

		$args = array(
			'title_reply'        => esc_html__( 'Leave a Comment:', 'teenglow' ),
			'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h4>',
			'comment_field'      => '<p class="comment-form-comment">
                                    <textarea id="comment" name="comment" placeholder="' . $comment_placeholder . '" cols="45" rows="8" maxlength="65525" required="required"></textarea>
                                    </p>',
			'fields'             => array(
				'author' => '<p class="comment-form-author">
                            <input id="author" name="author" placeholder="' . sprintf( '%1s%2s', esc_attr__( 'Name', 'teenglow' ), esc_attr( $qodef_required_label ) ) . '" type="text" value="' . esc_attr( $qodef_commenter['comment_author'] ) . '" size="30" maxlength="245" ' . $qodef_required_attr . ' />
                            </p>',
				'email'  => '<p class="comment-form-email">
                            <input id="email" name="email" placeholder="' . sprintf( '%1s%2s', esc_attr__( 'Email', 'teenglow' ), esc_attr( $qodef_required_label ) ) . '" type="text" value="' . esc_attr( $qodef_commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes" ' . $qodef_required_attr . ' />
                            </p>',
				'url'    => '<p class="comment-form-url">
                            <input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'teenglow' ) . '" type="text" value="' . esc_attr( $qodef_commenter['comment_author_url'] ) . '" size="30" maxlength="200" />
                            </p>',
			),
			'submit_button'      => '<button name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s"><span class="qodef-m-text">%4$s</span></button>',
			'label_submit'       => esc_html__( 'Send Message', 'teenglow'),
			'class_submit'       => 'qodef-button qodef-layout--filled',
			'class_form'         => 'qodef-comment-form',
		);

		return apply_filters( 'teenglow_filter_comment_form_args', $args );
	}
}

if ( ! function_exists( 'teenglow_set_gravatar_size' ) ) {
	/**
	 * Function that set comment/review form gravatar image size
	 *
	 * @return int
	 */
	function teenglow_set_gravatar_size() {
		return 94;
	}

	add_filter( 'teenglow_filter_comment_gravatar_size', 'teenglow_set_gravatar_size' );
	add_filter( 'woocommerce_review_gravatar_size', 'teenglow_set_gravatar_size' );
}
