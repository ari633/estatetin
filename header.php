<?php
/**
 * Site header: announcement banner and navigation bar.
 *
 * @package Estatein
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
	<div class="banner" data-banner>
		<img class="banner__pattern" src="<?php echo esc_url( estatein_asset( 'img/banner-pattern.svg' ) ); ?>" width="1918.9" height="1280.4" alt="" aria-hidden="true">
		<p class="banner__text">
			<?php esc_html_e( '✨Discover Your Dream Property with Estatein', 'estatein' ); ?>
			<a href="<?php echo esc_url( estatein_page_url( 'about-us' ) ); ?>"><?php esc_html_e( 'Learn More', 'estatein' ); ?></a>
		</p>
		<button class="banner__close" type="button" data-banner-close aria-label="<?php esc_attr_e( 'Dismiss announcement', 'estatein' ); ?>">
			<?php estatein_icon( 'close', 24 ); ?>
		</button>
	</div>

	<div class="navbar">
		<div class="navbar__inner container">
			<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php get_template_part( 'template-parts/logo' ); ?>
			</a>

			<button class="navbar__toggle" type="button" data-nav-toggle aria-controls="site-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Menu', 'estatein' ); ?>">
				<span></span><span></span><span></span>
			</button>

			<nav class="site-nav" id="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'estatein' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'site-nav__list',
						'depth'          => 1,
						'fallback_cb'    => 'estatein_fallback_menu',
					)
				);
				?>
				<a class="btn <?php echo is_page( 'contact' ) ? 'btn--primary' : 'btn--dark'; ?> navbar__contact" href="<?php echo esc_url( estatein_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'estatein' ); ?></a>
			</nav>
		</div>
	</div>
</header>

<main class="site-main">
