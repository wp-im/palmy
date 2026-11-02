<?php
/**
 * Hierarchical WordPress menus for Palmy's leftbar and sliding subpanels.
 *
 * @package Palmy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build a nested menu tree from a registered WordPress menu location.
 *
 * @param array<int,object> $items Menu item objects.
 * @param int               $parent_id Parent menu item ID.
 * @param int               $depth Current depth.
 * @return array<int,array<string,mixed>>
 */
function palmy_build_menu_tree( $items, $parent_id = 0, $depth = 0 ) {
	if ( $depth > 6 ) {
		return array();
	}

	$nodes = array();
	foreach ( $items as $item ) {
		if ( (int) $item->menu_item_parent !== (int) $parent_id ) {
			continue;
		}

		$nodes[] = array(
			'id'       => 'palmy-menu-' . absint( $item->ID ),
			'title'    => (string) $item->title,
			'url'      => (string) $item->url,
			'current'  => ! empty( $item->current ) || ! empty( $item->current_item_parent ) || ! empty( $item->current_item_ancestor ),
			'depth'    => $depth,
			'children' => palmy_build_menu_tree( $items, (int) $item->ID, $depth + 1 ),
		);
	}

	return $nodes;
}

/**
 * Provide working defaults until a custom sidebar menu is assigned.
 *
 * @return array<int,array<string,mixed>>
 */
function palmy_default_navigation() {
	$pages = get_pages(
		array(
			'sort_column' => 'menu_order,post_title',
			'sort_order'  => 'ASC',
			'number'      => 12,
		)
	);
	$categories = get_categories(
		array(
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'number'     => 12,
		)
	);

	$page_links = array();
	foreach ( $pages as $page ) {
		$page_links[] = array(
			'id'       => 'palmy-page-' . absint( $page->ID ),
			'title'    => get_the_title( $page ),
			'url'      => get_permalink( $page ),
			'current'  => is_page( $page->ID ),
			'depth'    => 1,
			'children' => array(),
		);
	}

	$category_links = array();
	foreach ( $categories as $category ) {
		$category_links[] = array(
			'id'       => 'palmy-category-' . absint( $category->term_id ),
			'title'    => $category->name,
			'url'      => get_category_link( $category ),
			'current'  => is_category( $category->term_id ),
			'depth'    => 1,
			'children' => array(),
		);
	}

	return array(
		array(
			'id'       => 'palmy-feed',
			'title'    => __( 'Feed', 'palmy' ),
			'url'      => home_url( '/' ),
			'current'  => is_home() || is_front_page() || is_single() || is_archive(),
			'depth'    => 0,
			'children' => array(),
		),
		array(
			'id'       => 'palmy-pages',
			'title'    => __( 'Pages', 'palmy' ),
			'url'      => home_url( '/' ),
			'current'  => is_page(),
			'depth'    => 0,
			'children' => $page_links,
		),
		array(
			'id'       => 'palmy-topics',
			'title'    => __( 'Topics', 'palmy' ),
			'url'      => home_url( '/' ),
			'current'  => is_category() || is_tag(),
			'depth'    => 0,
			'children' => $category_links,
		),
		array(
			'id'       => 'palmy-search',
			'title'    => __( 'Find', 'palmy' ),
			'url'      => get_search_link(),
			'current'  => is_search(),
			'depth'    => 0,
			'children' => array(),
		),
	);
}

/**
 * Get the primary menu tree or the built-in native-content navigation.
 *
 * @return array<int,array<string,mixed>>
 */
function palmy_primary_navigation() {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations['primary'] ) ) {
		$items = wp_get_nav_menu_items( $locations['primary'] );
		if ( is_array( $items ) && $items ) {
			return palmy_build_menu_tree( $items );
		}
	}

	return palmy_default_navigation();
}

/**
 * Render descendants inside a slide-out menu panel.
 *
 * @param array<int,array<string,mixed>> $nodes Child navigation nodes.
 * @return void
 */
function palmy_render_subnav_items( $nodes ) {
	foreach ( $nodes as $node ) {
		printf( '<li data-depth="%1$d"><a href="%2$s"%3$s>%4$s</a>', absint( $node['depth'] ), esc_url( $node['url'] ), ! empty( $node['current'] ) ? ' aria-current="page"' : '', esc_html( $node['title'] ) );
		if ( ! empty( $node['children'] ) ) {
			echo '<ul class="palmy-subpanel-children">';
			palmy_render_subnav_items( $node['children'] );
			echo '</ul>';
		}
		echo '</li>';
	}
}

/**
 * Render the sidebar's primary navigation controls.
 *
 * @return void
 */
function palmy_render_primary_navigation() {
	$nodes = palmy_primary_navigation();
	echo '<ul class="palmy-primary-list">';
	foreach ( $nodes as $node ) {
		$has_children = ! empty( $node['children'] );
		$active       = ! empty( $node['current'] );
		foreach ( $node['children'] as $child ) {
			$active = $active || ! empty( $child['current'] );
		}
		$marker = '◆';
		if ( preg_match( '/^\X/u', $node['title'], $match ) ) {
			$marker = $match[0];
		}

		echo '<li class="palmy-primary-item' . ( $active ? ' is-current' : '' ) . '">';
		if ( $has_children ) {
			printf(
				'<button class="palmy-primary-link" type="button" data-palmy-subnav-toggle="%1$s" aria-controls="%1$s" aria-expanded="false"><span class="palmy-primary-marker" aria-hidden="true">%2$s</span><span class="palmy-primary-label">%3$s</span><span class="palmy-primary-chevron" aria-hidden="true">›</span></button>',
				esc_attr( $node['id'] ),
				esc_html( $marker ),
				esc_html( $node['title'] )
			);
		} else {
			printf(
				'<a class="palmy-primary-link" href="%1$s"%2$s><span class="palmy-primary-marker" aria-hidden="true">%3$s</span><span class="palmy-primary-label">%4$s</span><span class="palmy-primary-chevron" aria-hidden="true">↗</span></a>',
				esc_url( $node['url'] ),
				$active ? ' aria-current="page"' : '',
				esc_html( $marker ),
				esc_html( $node['title'] )
			);
		}
		echo '</li>';
	}
	echo '</ul>';
}

/**
 * Render all secondary navigation panels.
 *
 * @return void
 */
function palmy_render_subnavigation_panels() {
	foreach ( palmy_primary_navigation() as $node ) {
		if ( empty( $node['children'] ) ) {
			continue;
		}

		printf(
			'<section class="palmy-subpanel" id="%1$s" data-palmy-subpanel="%1$s" aria-label="%2$s" hidden>',
			esc_attr( $node['id'] ),
			esc_attr( $node['title'] )
		);
		echo '<header class="palmy-subpanel-head"><span class="palmy-subpanel-title">' . esc_html( $node['title'] ) . '</span><button class="palmy-subpanel-close" type="button" data-palmy-close-subnav aria-label="' . esc_attr__( 'Close submenu', 'palmy' ) . '">×</button></header>';
		echo '<nav aria-label="' . esc_attr( sprintf( __( '%s section', 'palmy' ), $node['title'] ) ) . '"><ul class="palmy-subpanel-list">';
		if ( ! empty( $node['url'] ) && '#' !== $node['url'] ) {
			printf( '<li class="palmy-view-parent"><a href="%1$s">%2$s</a></li>', esc_url( $node['url'] ), esc_html( sprintf( __( 'Open %s', 'palmy' ), $node['title'] ) ) );
		}
		palmy_render_subnav_items( $node['children'] );
		echo '</ul></nav></section>';
	}
}
