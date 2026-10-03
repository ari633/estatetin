( function () {
	'use strict';

	// Announcement banner: dismiss and remember for this browser session.
	var banner = document.querySelector( '[data-banner]' );
	if ( banner ) {
		var hidden = false;
		try {
			hidden = sessionStorage.getItem( 'estateinBannerHidden' ) === '1';
		} catch ( e ) {}
		if ( hidden ) {
			banner.hidden = true;
		}
		banner.querySelector( '[data-banner-close]' ).addEventListener( 'click', function () {
			banner.hidden = true;
			try {
				sessionStorage.setItem( 'estateinBannerHidden', '1' );
			} catch ( e ) {}
		} );
	}

	// Mobile navigation.
	var toggle = document.querySelector( '[data-nav-toggle]' );
	var nav = document.getElementById( 'site-nav' );
	if ( toggle && nav ) {
		toggle.addEventListener( 'click', function () {
			var open = nav.classList.toggle( 'is-open' );
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
	}

	// Carousels: scroll one "page" of cards at a time and keep the counter in sync.
	function pad( n ) {
		return n < 10 ? '0' + n : String( n );
	}

	document.querySelectorAll( '[data-carousel]' ).forEach( function ( carousel ) {
		var track = carousel.querySelector( '[data-carousel-track]' );
		var prev = carousel.querySelector( '[data-carousel-prev]' );
		var next = carousel.querySelector( '[data-carousel-next]' );
		var current = carousel.querySelector( '[data-carousel-current]' );
		var total = carousel.querySelector( '[data-carousel-total]' );

		function step() {
			return track.clientWidth + ( parseFloat( getComputedStyle( track ).columnGap ) || 0 );
		}

		function pages() {
			return Math.max( 1, Math.ceil( ( track.scrollWidth - track.clientWidth - 1 ) / step() ) + 1 );
		}

		function page() {
			var atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
			return atEnd ? pages() : Math.round( track.scrollLeft / step() ) + 1;
		}

		function update() {
			var count = pages();
			var index = Math.min( page(), count );
			current.textContent = pad( index );
			total.textContent = pad( count );
			prev.disabled = index <= 1;
			next.disabled = index >= count;
		}

		function go( direction ) {
			track.scrollBy( { left: direction * step(), behavior: 'smooth' } );
		}

		prev.addEventListener( 'click', function () {
			go( -1 );
		} );
		next.addEventListener( 'click', function () {
			go( 1 );
		} );
		track.addEventListener( 'scroll', function () {
			window.requestAnimationFrame( update );
		} );
		window.addEventListener( 'resize', update );
		update();
	} );

	// Property photo gallery: thumbnails, paging and page indicators.
	document.querySelectorAll( '[data-gallery]' ).forEach( function ( gallery ) {
		var track = gallery.querySelector( '[data-gallery-track]' );
		var controls = gallery.querySelector( '[data-gallery-controls]' );
		var indicators = gallery.querySelector( '[data-gallery-indicators]' );
		var prev = gallery.querySelector( '[data-gallery-prev]' );
		var next = gallery.querySelector( '[data-gallery-next]' );
		var thumbs = gallery.querySelectorAll( '[data-gallery-thumb]' );
		var images = track.children;

		function gap() {
			return parseFloat( getComputedStyle( track ).columnGap ) || 0;
		}

		function perPage() {
			return Math.max( 1, Math.round( ( track.clientWidth + gap() ) / ( images[ 0 ].offsetWidth + gap() ) ) );
		}

		function first() {
			return Math.round( track.scrollLeft / ( images[ 0 ].offsetWidth + gap() ) );
		}

		function update() {
			var size = perPage();
			var start = first();
			var pages = Math.ceil( images.length / size );
			var page = start + size >= images.length ? pages - 1 : Math.floor( start / size );

			controls.hidden = pages < 2;
			if ( indicators.children.length !== pages ) {
				indicators.innerHTML = new Array( pages + 1 ).join( '<span></span>' );
			}
			Array.prototype.forEach.call( indicators.children, function ( dot, index ) {
				dot.classList.toggle( 'is-active', index === page );
			} );
			thumbs.forEach( function ( thumb, index ) {
				thumb.classList.toggle( 'is-active', index >= start && index < start + size );
			} );
			prev.disabled = start <= 0;
			next.disabled = start + size >= images.length;
		}

		function show( index ) {
			track.scrollTo( { left: index * ( images[ 0 ].offsetWidth + gap() ), behavior: 'smooth' } );
		}

		prev.addEventListener( 'click', function () {
			show( Math.max( 0, first() - perPage() ) );
		} );
		next.addEventListener( 'click', function () {
			show( first() + perPage() );
		} );
		thumbs.forEach( function ( thumb, index ) {
			thumb.addEventListener( 'click', function () {
				show( index );
			} );
		} );
		track.addEventListener( 'scroll', function () {
			window.requestAnimationFrame( update );
		} );
		window.addEventListener( 'resize', update );
		update();
	} );

	// Search filters apply as soon as one is chosen.
	document.querySelectorAll( '[data-autosubmit]' ).forEach( function ( select ) {
		select.addEventListener( 'change', function () {
			select.form.submit();
		} );
	} );

	// Tabs that filter a set of cards (office locations).
	document.querySelectorAll( '[data-tabs]' ).forEach( function ( section ) {
		var tabs = section.querySelectorAll( '[data-tab]' );
		var items = section.querySelectorAll( '[data-tab-item]' );
		var empty = section.querySelector( '[data-tab-empty]' );

		tabs.forEach( function ( tab ) {
			tab.addEventListener( 'click', function () {
				var group = tab.getAttribute( 'data-tab' );
				var shown = 0;

				tabs.forEach( function ( other ) {
					other.setAttribute( 'aria-pressed', other === tab ? 'true' : 'false' );
				} );
				items.forEach( function ( item ) {
					item.hidden = 'all' !== group && item.getAttribute( 'data-tab-item' ) !== group;
					shown += item.hidden ? 0 : 1;
				} );
				empty.hidden = shown > 0;
			} );
		} );
	} );

	// The newsletter form isn't connected to a mailing service yet, so don't submit it.
	var newsletter = document.querySelector( '[data-newsletter]' );
	if ( newsletter ) {
		newsletter.addEventListener( 'submit', function ( event ) {
			event.preventDefault();
		} );
	}
} )();
