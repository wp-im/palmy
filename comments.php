<?php
/** Comments template. @package Palmy */
if ( post_password_required() ) {
	return;
}
?>
<section class="palmy-comments" id="comments">
	<?php if ( have_comments() ) : ?>
		<h2 class="palmy-comments-title"><?php comments_number( esc_html__( 'No replies', 'palmy' ), esc_html__( '1 reply', 'palmy' ), esc_html__( '% replies', 'palmy' ) ); ?></h2>
		<ol><?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 40 ) ); ?></ol>
		<?php the_comments_pagination( array( 'prev_text' => esc_html__( '← Older replies', 'palmy' ), 'next_text' => esc_html__( 'Newer replies →', 'palmy' ) ) ); ?>
	<?php endif; ?>
	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p><?php esc_html_e( 'Replies are closed.', 'palmy' ); ?></p>
	<?php endif; ?>
	<?php comment_form( array( 'class_form' => 'palmy-comment-form' ) ); ?>
</section>
