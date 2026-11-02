<?php
/** Not found template. @package Palmy */
get_header();
?>
	<section class="palmy-no-results">
		<p class="palmy-kicker"><?php esc_html_e( '404 · Not found', 'palmy' ); ?></p>
		<h1><?php esc_html_e( 'This page is off the map', 'palmy' ); ?></h1>
		<p><?php esc_html_e( 'The address may have changed. Search the site or return to the workspace.', 'palmy' ); ?></p>
		<?php get_search_form(); ?>
		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go to Home →', 'palmy' ); ?></a></p>
	</section>
<?php get_footer();
