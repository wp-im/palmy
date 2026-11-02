( function () {
	'use strict';

	var app = document.getElementById( 'palmy-app' );
	if ( ! app ) {
		return;
	}

	var mobileToggle = app.querySelector( '[data-palmy-mobile-toggle]' );
	var mobileBackdrop = app.querySelector( '[data-palmy-close-mobile]' );
	var subnavBackdrop = app.querySelector( '[data-palmy-close-subnav]' );
	var activeTrigger = null;

	function closeSubnav( restoreFocus ) {
		var openPanel = app.querySelector( '.palmy-subpanel.is-open' );
		if ( openPanel ) {
			openPanel.classList.remove( 'is-open' );
			openPanel.hidden = true;
		}
		app.querySelectorAll( '[data-palmy-subnav-toggle][aria-expanded="true"]' ).forEach( function ( trigger ) {
			trigger.setAttribute( 'aria-expanded', 'false' );
		} );
		app.classList.remove( 'is-menu-open' );
		if ( subnavBackdrop ) {
			subnavBackdrop.hidden = true;
		}
		if ( restoreFocus && activeTrigger ) {
			activeTrigger.focus();
		}
		activeTrigger = null;
	}

	function closeMobileNav( restoreFocus ) {
		app.classList.remove( 'is-mobile-nav-open' );
		if ( mobileToggle ) {
			mobileToggle.setAttribute( 'aria-expanded', 'false' );
		}
		if ( mobileBackdrop ) {
			mobileBackdrop.hidden = true;
		}
		if ( restoreFocus && mobileToggle ) {
			mobileToggle.focus();
		}
	}

	app.querySelectorAll( '[data-palmy-subnav-toggle]' ).forEach( function ( trigger ) {
		trigger.addEventListener( 'click', function () {
			var panelId = trigger.getAttribute( 'aria-controls' );
			var panel = panelId ? document.getElementById( panelId ) : null;
			var wasOpen = trigger.getAttribute( 'aria-expanded' ) === 'true';
			closeSubnav( false );
			if ( wasOpen || ! panel ) {
				return;
			}
			panel.hidden = false;
			panel.classList.add( 'is-open' );
			trigger.setAttribute( 'aria-expanded', 'true' );
			activeTrigger = trigger;
			app.classList.add( 'is-menu-open' );
			if ( subnavBackdrop ) {
				subnavBackdrop.hidden = false;
			}
			closeMobileNav( false );
		} );
	} );

	app.querySelectorAll( '[data-palmy-close-subnav]' ).forEach( function ( button ) {
		button.addEventListener( 'click', function () {
			closeSubnav( true );
		} );
	} );

	if ( mobileToggle ) {
		mobileToggle.addEventListener( 'click', function () {
			var open = ! app.classList.contains( 'is-mobile-nav-open' );
			closeSubnav( false );
			app.classList.toggle( 'is-mobile-nav-open', open );
			mobileToggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			if ( mobileBackdrop ) {
				mobileBackdrop.hidden = ! open;
			}
		} );
	}

	if ( mobileBackdrop ) {
		mobileBackdrop.addEventListener( 'click', function () {
			closeMobileNav( true );
		} );
	}

	app.querySelectorAll( '[data-palmy-scroll]' ).forEach( function ( button ) {
		button.addEventListener( 'click', function () {
			var destination = button.getAttribute( 'data-palmy-scroll' );
			var top = destination === 'bottom' ? document.documentElement.scrollHeight : 0;
			var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
			window.scrollTo( { top: top, behavior: reduceMotion ? 'auto' : 'smooth' } );
		} );
	} );

	var backButton = app.querySelector( '[data-palmy-back]' );
	if ( backButton ) {
		backButton.addEventListener( 'click', function () {
			if ( window.history.length > 1 ) {
				window.history.back();
			} else {
				window.location.href = app.getAttribute( 'data-home-url' ) || '/';
			}
		} );
	}

	document.addEventListener( 'keydown', function ( event ) {
		if ( event.key !== 'Escape' ) {
			return;
		}
		if ( app.classList.contains( 'is-menu-open' ) ) {
			closeSubnav( true );
		} else if ( app.classList.contains( 'is-mobile-nav-open' ) ) {
			closeMobileNav( true );
		}
	} );
}() );
