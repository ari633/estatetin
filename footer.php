<?php
/**
 * Site footer: call to action, link columns and bottom bar.
 *
 * @package Estatein
 */

$properties_url = get_post_type_archive_link( 'property' );
$home_url       = home_url( '/' );
$about_url      = estatein_page_url( 'about-us' );
$services_url   = estatein_page_url( 'services' );
$contact_url    = estatein_page_url( 'contact' );

$columns = array(
	array(
		'title' => __( 'Home', 'estatein' ),
		'url'   => $home_url,
		'links' => array(
			__( 'Hero Section', 'estatein' ) => $home_url . '#hero',
			__( 'Features', 'estatein' )     => $home_url . '#features',
			__( 'Properties', 'estatein' )   => $home_url . '#properties',
			__( 'Testimonials', 'estatein' ) => $home_url . '#testimonials',
			__( 'FAQ’s', 'estatein' )        => $home_url . '#faqs',
		),
	),
	array(
		'title' => __( 'About Us', 'estatein' ),
		'url'   => $about_url,
		'links' => array(
			__( 'Our Story', 'estatein' )    => $about_url . '#story',
			__( 'Our Works', 'estatein' )    => $about_url . '#works',
			__( 'How It Works', 'estatein' ) => $about_url . '#how-it-works',
			__( 'Our Team', 'estatein' )     => $about_url . '#team',
			__( 'Our Clients', 'estatein' )  => $about_url . '#clients',
		),
	),
	array(
		'title' => __( 'Properties', 'estatein' ),
		'url'   => $properties_url,
		'links' => array(
			__( 'Portfolio', 'estatein' )  => $properties_url . '#portfolio',
			__( 'Categories', 'estatein' ) => $properties_url . '#categories',
		),
	),
	array(
		'title' => __( 'Services', 'estatein' ),
		'url'   => $services_url,
		'links' => array(
			__( 'Valuation Mastery', 'estatein' )    => $services_url . '#valuation',
			__( 'Strategic Marketing', 'estatein' )  => $services_url . '#marketing',
			__( 'Negotiation Wizardry', 'estatein' ) => $services_url . '#negotiation',
			__( 'Closing Success', 'estatein' )      => $services_url . '#closing',
			__( 'Property Management', 'estatein' )  => $services_url . '#management',
		),
	),
	array(
		'title' => __( 'Contact Us', 'estatein' ),
		'url'   => $contact_url,
		'links' => array(
			__( 'Contact Form', 'estatein' ) => $contact_url . '#form',
			__( 'Our Offices', 'estatein' )  => $contact_url . '#offices',
		),
	),
);

$socials = array(
	'facebook' => 'Facebook',
	'linkedin' => 'LinkedIn',
	'twitter'  => 'Twitter',
	'youtube'  => 'YouTube',
);
?>
</main>

<section class="cta">
	<img class="cta__pattern cta__pattern--right" src="<?php echo esc_url( estatein_asset( 'img/cta-pattern-right.svg' ) ); ?>" width="725" height="394" alt="" aria-hidden="true">
	<img class="cta__pattern cta__pattern--left" src="<?php echo esc_url( estatein_asset( 'img/cta-pattern-left.svg' ) ); ?>" width="566" height="308" alt="" aria-hidden="true">
	<div class="cta__inner container">
		<div class="cta__text">
			<h2 class="heading"><?php esc_html_e( 'Start Your Real Estate Journey Today', 'estatein' ); ?></h2>
			<p class="lead"><?php esc_html_e( "Your dream property is just a click away. Whether you're looking for a new home, a strategic investment, or expert real estate advice, Estatein is here to assist you every step of the way. Take the first step towards your real estate goals and explore our available properties or get in touch with our team for personalized assistance.", 'estatein' ); ?></p>
		</div>
		<a class="btn btn--primary" href="<?php echo esc_url( $properties_url ); ?>"><?php esc_html_e( 'Explore Properties', 'estatein' ); ?></a>
	</div>
</section>

<footer class="site-footer">
	<div class="site-footer__main container">
		<div class="site-footer__brand">
			<a class="logo" href="<?php echo esc_url( $home_url ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
				<?php get_template_part( 'template-parts/logo' ); ?>
			</a>
			<form class="newsletter" action="#" method="post" data-newsletter>
				<?php estatein_icon( 'mail', 24 ); ?>
				<label class="screen-reader-text" for="newsletter-email"><?php esc_html_e( 'Email address', 'estatein' ); ?></label>
				<input id="newsletter-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Enter Your Email', 'estatein' ); ?>" required>
				<button type="submit" aria-label="<?php esc_attr_e( 'Subscribe', 'estatein' ); ?>">
					<?php estatein_icon( 'send', 24.9898, 24.8354 ); ?>
				</button>
			</form>
		</div>

		<nav class="footer-links" aria-label="<?php esc_attr_e( 'Footer', 'estatein' ); ?>">
			<?php foreach ( $columns as $column ) : ?>
				<div class="footer-links__column">
					<a class="footer-links__title" href="<?php echo esc_url( $column['url'] ); ?>"><?php echo esc_html( $column['title'] ); ?></a>
					<ul>
						<?php foreach ( $column['links'] as $label => $url ) : ?>
							<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</nav>
	</div>

	<div class="site-footer__bar">
		<div class="site-footer__bar-inner container">
			<div class="site-footer__legal">
				<p>
					<?php
					/* translators: 1: year, 2: site name. */
					printf( esc_html__( '@%1$s %2$s. All Rights Reserved.', 'estatein' ), esc_html( gmdate( 'Y' ) ), esc_html( get_bloginfo( 'name' ) ) );
					?>
				</p>
				<a href="<?php echo esc_url( estatein_page_url( 'terms-and-conditions' ) ); ?>"><?php esc_html_e( 'Terms & Conditions', 'estatein' ); ?></a>
			</div>
			<ul class="socials">
				<?php foreach ( $socials as $slug => $label ) : ?>
					<li>
						<a href="#" aria-label="<?php echo esc_attr( $label ); ?>"><?php estatein_icon( $slug, 24 ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
