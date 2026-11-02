<?php
/**
 * Content card and singular post layout.
 *
 * @package Palmy
 */

$is_singular = is_singular();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'palmy-entry' ); ?>>
	<header class="palmy-entry-header">
		<?php if ( ! is_page() ) : ?>
			<div class="palmy-entry-meta">
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<span><?php the_author_posts_link(); ?></span>
				<?php if ( ! is_search() ) : ?><span><?php the_category( ', ' ); ?></span><?php endif; ?>
			</div>
		<?php endif; ?>
		<h2 class="palmy-entry-title">
			<?php if ( $is_singular ) : ?><?php the_title(); ?><?php else : ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php endif; ?>
		</h2>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<?php if ( ! $is_singular ) : ?><a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"><?php endif; ?>
		<?php the_post_thumbnail( 'large', array( 'class' => 'palmy-entry-thumbnail' ) ); ?>
		<?php if ( ! $is_singular ) : ?></a><?php endif; ?>
	<?php endif; ?>
	<div class="palmy-entry-content <?php echo $is_singular ? 'entry-content' : 'palmy-entry-excerpt'; ?>">
		<?php if ( $is_singular ) : ?>
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<nav class="page-links">' . esc_html__( 'Pages:', 'palmy' ), 'after' => '</nav>' ) ); ?>
		<?php else : ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
	</div>
	<?php if ( ! $is_singular ) : ?>
		<footer class="palmy-entry-footer"><a href="<?php the_permalink(); ?>"><?php esc_html_e( 'Open entry →', 'palmy' ); ?></a><span><?php comments_number( esc_html__( 'No replies', 'palmy' ), esc_html__( '1 reply', 'palmy' ), esc_html__( '% replies', 'palmy' ) ); ?></span></footer>
	<?php endif; ?>
</article>
