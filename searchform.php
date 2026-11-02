<?php
/**
 * Accessible native WordPress search form.
 *
 * @package Palmy
 */
?>
<form role="search" method="get" class="palmy-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="palmy-search-input"><?php esc_html_e( 'Search for:', 'palmy' ); ?></label>
	<input type="search" id="palmy-search-input" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Find', 'palmy' ); ?>">
	<button type="submit"><span class="palmy-search-button-label"><?php esc_html_e( 'Find', 'palmy' ); ?></span></button>
</form>
