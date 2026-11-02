<?php
/**
 * Palmy status strip and hardware-inspired controls.
 *
 * @package Palmy
 */
?>
			</main>
		</div>
	</div>
	<footer class="palmy-footer">
		<div class="palmy-footer-status"><strong><?php esc_html_e( 'PALMY / READY', 'palmy' ); ?></strong><span><?php echo esc_html( get_bloginfo( 'name' ) ); ?> · <?php esc_html_e( 'Native WordPress', 'palmy' ); ?></span></div>
		<div class="palmy-footer-right">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav class="palmy-footer-menu" aria-label="<?php esc_attr_e( 'Footer links', 'palmy' ); ?>">
					<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'menu', 'fallback_cb' => false, 'depth' => 1 ) ); ?>
				</nav>
			<?php endif; ?>
			<?php do_action( 'palmy_footer_actions' ); ?>
			<nav class="palmy-hardware" aria-label="<?php esc_attr_e( 'Hardware controls', 'palmy' ); ?>">
				<button class="palmy-hardware-key" type="button" data-palmy-back><?php esc_html_e( 'Back', 'palmy' ); ?></button>
				<span class="palmy-hardware-key palmy-scroll-key-group" role="group" aria-label="<?php esc_attr_e( 'Scroll controls', 'palmy' ); ?>"><span class="palmy-scroll-keys"><button type="button" data-palmy-scroll="top" aria-label="<?php esc_attr_e( 'Scroll to top', 'palmy' ); ?>">↑</button><button type="button" data-palmy-scroll="bottom" aria-label="<?php esc_attr_e( 'Scroll to bottom', 'palmy' ); ?>">↓</button></span></span>
				<a class="palmy-hardware-key" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'palmy' ); ?></a>
				<a class="palmy-hardware-key" href="<?php echo esc_url( palmy_notes_url() ); ?>"><?php esc_html_e( 'Notes', 'palmy' ); ?></a>
			</nav>
		</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
