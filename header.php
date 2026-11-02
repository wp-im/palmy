<?php
/**
 * Palmy application frame and shared navigation.
 *
 * @package Palmy
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="palmy-app" id="palmy-app" data-home-url="<?php echo esc_url( home_url( '/' ) ); ?>">
	<a class="screen-reader-text" href="#palmy-main"><?php esc_html_e( 'Skip to content', 'palmy' ); ?></a>
	<header class="palmy-topbar">
		<a class="palmy-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( sprintf( __( '%s home', 'palmy' ), get_bloginfo( 'name' ) ) ); ?>">
			<span class="palmy-brand-mark" aria-hidden="true">p</span>
			<span class="palmy-brand-copy"><strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong><small><?php esc_html_e( 'Palm workspace', 'palmy' ); ?></small></span>
		</a>
		<div class="palmy-context"><span class="palmy-ready"><?php esc_html_e( 'Ready', 'palmy' ); ?></span><span class="palmy-context-title"><?php echo esc_html( palmy_current_context() ); ?></span></div>
		<button class="palmy-mobile-menu-toggle" type="button" data-palmy-mobile-toggle aria-controls="palmy-sidebar" aria-expanded="false"><span aria-hidden="true">☰</span><?php esc_html_e( 'Menu', 'palmy' ); ?></button>
		<div class="palmy-header-actions">
			<?php get_search_form(); ?>
			<?php if ( is_user_logged_in() ) : ?>
				<a class="palmy-action-button palmy-action-button--primary" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php esc_html_e( 'New post', 'palmy' ); ?></a>
			<?php else : ?>
				<a class="palmy-action-button palmy-action-button--primary" href="<?php echo esc_url( wp_login_url( admin_url( 'post-new.php' ) ) ); ?>"><?php esc_html_e( 'Sign in', 'palmy' ); ?></a>
			<?php endif; ?>
			<details class="palmy-account">
				<summary class="palmy-action-button"><?php echo is_user_logged_in() ? esc_html( wp_get_current_user()->display_name ) : esc_html__( 'Account', 'palmy' ); ?></summary>
				<div class="palmy-account-menu">
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( admin_url( 'profile.php' ) ); ?>"><?php esc_html_e( 'Profile', 'palmy' ); ?></a>
						<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Log out', 'palmy' ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_login_url( home_url( '/' ) ) ); ?>"><?php esc_html_e( 'Log in', 'palmy' ); ?></a>
					<?php endif; ?>
				</div>
			</details>
			<?php do_action( 'palmy_header_actions' ); ?>
		</div>
	</header>
	<div class="palmy-layout">
		<aside class="palmy-sidebar" id="palmy-sidebar" aria-label="<?php esc_attr_e( 'Primary navigation', 'palmy' ); ?>">
			<p class="palmy-sidebar-label"><?php esc_html_e( 'Workspace', 'palmy' ); ?></p>
			<nav aria-label="<?php esc_attr_e( 'Primary navigation', 'palmy' ); ?>">
				<?php palmy_render_primary_navigation(); ?>
			</nav>
			<div class="palmy-sidebar-spacer"></div>
			<div class="palmy-sidebar-footnote"><strong><?php esc_html_e( 'PALMY OS', 'palmy' ); ?></strong><span><?php esc_html_e( 'WordPress content · native', 'palmy' ); ?></span></div>
		</aside>
		<button class="palmy-mobile-backdrop" type="button" data-palmy-close-mobile aria-label="<?php esc_attr_e( 'Close navigation', 'palmy' ); ?>" hidden></button>
		<button class="palmy-subnav-backdrop" type="button" data-palmy-close-subnav aria-label="<?php esc_attr_e( 'Close submenu', 'palmy' ); ?>" hidden></button>
		<?php palmy_render_subnavigation_panels(); ?>
		<div class="palmy-workspace">
			<main class="palmy-main" id="palmy-main">
