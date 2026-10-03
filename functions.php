<?php
/**
 * Estatein theme functions.
 *
 * @package Estatein
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ESTATEIN_VERSION', '1.3.0' );

require get_template_directory() . '/inc/property-meta.php';
require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/inquiry.php';
require get_template_directory() . '/inc/content.php';

/**
 * Theme supports and menus.
 */
function estatein_setup() {
	load_theme_textdomain( 'estatein', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array( 'height' => 48, 'width' => 160, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	add_image_size( 'estatein-card', 864, 636, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'estatein' ),
		)
	);
}
add_action( 'after_setup_theme', 'estatein_setup' );

/**
 * Styles and scripts.
 */
function estatein_assets() {
	wp_enqueue_style(
		'estatein-fonts',
		'https://fonts.googleapis.com/css2?family=Urbanist:wght@500;600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'estatein-style', get_stylesheet_uri(), array( 'estatein-fonts' ), ESTATEIN_VERSION );
	wp_enqueue_script( 'estatein-main', get_template_directory_uri() . '/assets/js/main.js', array(), ESTATEIN_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'estatein_assets' );

/**
 * URL of a file in the theme's assets folder.
 *
 * @param string $path Path relative to /assets.
 */
function estatein_asset( $path ) {
	return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Print an icon <img>. Width and height match the SVG's own root size.
 *
 * @param string $name   File name in assets/icons, without extension.
 * @param float  $width  Icon width.
 * @param float  $height Icon height.
 */
function estatein_icon( $name, $width = 24, $height = 0 ) {
	printf(
		'<img class="icon icon--%1$s" src="%2$s" width="%3$s" height="%4$s" alt="" aria-hidden="true">',
		esc_attr( $name ),
		esc_url( estatein_asset( 'icons/' . $name . '.svg' ) ),
		esc_attr( $width ),
		esc_attr( $height ? $height : $width )
	);
}

/**
 * URL of a page by slug, falling back to the given path when it doesn't exist yet.
 *
 * @param string $slug Page slug.
 */
function estatein_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/**
 * Menu shown until a Primary Menu is assigned in Appearance → Menus.
 */
function estatein_fallback_menu() {
	$items = array(
		array( __( 'Home', 'estatein' ), home_url( '/' ), is_front_page() ),
		array( __( 'About Us', 'estatein' ), estatein_page_url( 'about-us' ), is_page( 'about-us' ) ),
		array( __( 'Properties', 'estatein' ), get_post_type_archive_link( 'property' ), is_post_type_archive( 'property' ) || is_singular( 'property' ) ),
		array( __( 'Services', 'estatein' ), estatein_page_url( 'services' ), is_page( 'services' ) ),
	);

	echo '<ul class="site-nav__list">';
	foreach ( $items as $item ) {
		printf(
			'<li class="menu-item%1$s"><a href="%2$s">%3$s</a></li>',
			$item[2] ? ' current-menu-item' : '',
			esc_url( $item[1] ),
			esc_html( $item[0] )
		);
	}
	echo '</ul>';
}
