<?php
/**
 * Main fallback template.
 *
 * @package Palmy
 */

get_header();
?>
	<?php if ( is_search() ) : ?>
		<header class="palmy-page-heading">
			<p class="palmy-kicker"><?php esc_html_e( 'Find', 'palmy' ); ?></p>
			<h1><?php printf( esc_html__( 'Search results for: %s', 'palmy' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
		</header>
	<?php elseif ( is_archive() ) : ?>
		<header class="palmy-page-heading">
			<p class="palmy-kicker"><?php esc_html_e( 'Archive', 'palmy' ); ?></p>
			<h1><?php the_archive_title(); ?></h1>
			<?php the_archive_description( '<div class="palmy-page-description">', '</div>' ); ?>
		</header>
	<?php elseif ( is_home() && ! is_front_page() ) : ?>
		<header class="palmy-page-heading"><p class="palmy-kicker"><?php esc_html_e( 'Workspace', 'palmy' ); ?></p><h1><?php single_post_title(); ?></h1></header>
	<?php endif; ?>
	<?php if ( is_search() && '' === get_search_query() ) : ?>
		<div class="palmy-search-prompt"><?php esc_html_e( 'Enter a word or phrase to search this site.', 'palmy' ); ?><?php get_search_form(); ?></div>
	<?php endif; ?>
	<?php if ( have_posts() ) : ?>
		<div class="palmy-feed">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;
			?>
		</div>
		<?php if ( is_singular() ) : ?><?php comments_template(); ?><?php endif; ?>
		<?php if ( ! is_singular() ) : ?><?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => esc_html__( '← Newer', 'palmy' ), 'next_text' => esc_html__( 'Older →', 'palmy' ) ) ); ?><?php endif; ?>
	<?php else : ?>
		<section class="palmy-no-results">
			<h2><?php esc_html_e( 'Nothing here yet', 'palmy' ); ?></h2>
			<p><?php esc_html_e( 'Try another search, or browse the available pages and topics from the sidebar.', 'palmy' ); ?></p>
			<?php get_search_form(); ?>
		</section>
	<?php endif; ?>
<?php
get_footer();
