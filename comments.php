<?php
/**
 * Comments template.
 *
 * @package AYED_Ghana
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-area__title">
			<?php
			$ayed_count = get_comments_number();
			printf(
				/* translators: %s: comment count */
				esc_html( _n( '%s Comment', '%s Comments', $ayed_count, 'ayed-ghana' ) ),
				esc_html( number_format_i18n( $ayed_count ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>

		<?php
		the_comments_pagination( array(
			'prev_text' => esc_html__( 'Previous', 'ayed-ghana' ),
			'next_text' => esc_html__( 'Next', 'ayed-ghana' ),
		) );
		?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'ayed-ghana' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'class_submit' => 'btn btn--primary',
		'title_reply'  => esc_html__( 'Leave a Comment', 'ayed-ghana' ),
	) );
	?>
</section>
