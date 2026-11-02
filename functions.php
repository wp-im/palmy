<?php
/**
 * Palmy theme setup.
 *
 * @package Palmy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PALMY_VERSION', '0.1.0' );

require_once get_template_directory() . '/inc/navigation.php';

/**
 * Register theme supports and menu locations.
 *
 * @return void
 */
function palmy_setup() {
	load_theme_textdomain( 'palmy', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-logo', array( 'height' => 64, 'width' => 64, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'search-form',
			'script',
			'style',
		)
	);

	register_nav_menus(
		array(
			'primary' => __( 'Palmy sidebar menu', 'palmy' ),
			'footer'  => __( 'Palmy footer links', 'palmy' ),
		)
	);

	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 920;
	}
}
add_action( 'after_setup_theme', 'palmy_setup' );

/**
 * Enqueue Palmy styles and accessible menu controls.
 *
 * @return void
 */
function palmy_enqueue_assets() {
	wp_enqueue_style( 'palmy-style', get_stylesheet_uri(), array(), PALMY_VERSION );
	wp_enqueue_script( 'palmy-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), PALMY_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'palmy_enqueue_assets' );

/**
 * Return the short context label shown in the application header.
 *
 * @return string
 */
function palmy_current_context() {
	if ( is_search() ) {
		return __( 'Search', 'palmy' );
	}
	if ( is_home() || is_front_page() ) {
		return __( 'Workspace', 'palmy' );
	}
	if ( is_archive() ) {
		return wp_strip_all_tags( get_the_archive_title() );
	}
	if ( is_singular() ) {
		return wp_strip_all_tags( get_the_title() );
	}

	return __( 'Palmy', 'palmy' );
}

/**
 * Return a safe target for the physical Notes key.
 *
 * @return string
 */
function palmy_notes_url() {
	$pages = get_pages(
		array(
			'sort_column' => 'menu_order,post_title',
			'sort_order'  => 'ASC',
			'number'      => 1,
		)
	);

	if ( ! empty( $pages ) ) {
		return get_permalink( $pages[0] );
	}

	return is_user_logged_in() ? admin_url( 'edit.php?post_type=page' ) : home_url( '/' );
}

/**
 * Keep embedded media and blocks inside the reading surface.
 *
 * @return void
 */
function palmy_content_width() {
	$GLOBALS['content_width'] = 920;
}
add_action( 'after_setup_theme', 'palmy_content_width', 0 );
