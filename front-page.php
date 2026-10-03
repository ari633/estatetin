<?php
/**
 * Home page.
 *
 * @package Estatein
 */

get_header();

$properties_url = get_post_type_archive_link( 'property' );

$stats = array(
	'200+' => __( 'Happy Customers', 'estatein' ),
	'10k+' => __( 'Properties For Clients', 'estatein' ),
	'16+'  => __( 'Years of Experience', 'estatein' ),
);

$properties   = estatein_get_properties();
$testimonials = estatein_get_testimonials();
?>

<section class="hero" id="hero">
	<div class="hero__main">
		<div class="hero__content">
			<div class="hero__text">
				<h1 class="hero__title"><?php esc_html_e( 'Discover Your Dream Property with Estatein', 'estatein' ); ?></h1>
				<p class="lead"><?php esc_html_e( 'Your journey to finding the perfect property begins here. Explore our listings to find the home that matches your dreams.', 'estatein' ); ?></p>

				<a class="hero__badge" href="<?php echo esc_url( $properties_url ); ?>" aria-label="<?php esc_attr_e( 'Discover your dream property', 'estatein' ); ?>">
					<svg class="hero__badge-text" viewBox="0 0 175 175" width="175" height="175" aria-hidden="true">
						<defs>
							<path id="hero-badge-circle" d="M87.5 145.5a58 58 0 1 1 0-116a58 58 0 1 1 0 116"/>
						</defs>
						<text><textPath href="#hero-badge-circle" textLength="358" lengthAdjust="spacing"><?php esc_html_e( '✨Discover Your Dream Property', 'estatein' ); ?></textPath></text>
					</svg>
					<span class="hero__badge-icon"><?php estatein_icon( 'arrow-up-right', 34 ); ?></span>
				</a>
			</div>

			<div class="hero__buttons">
				<a class="btn btn--outline" href="<?php echo esc_url( estatein_page_url( 'about-us' ) ); ?>"><?php esc_html_e( 'Learn More', 'estatein' ); ?></a>
				<a class="btn btn--primary" href="<?php echo esc_url( $properties_url ); ?>"><?php esc_html_e( 'Browse Properties', 'estatein' ); ?></a>
			</div>

			<ul class="stats">
				<?php foreach ( $stats as $value => $label ) : ?>
					<li class="stats__item">
						<strong class="stats__value"><?php echo esc_html( $value ); ?></strong>
						<span class="stats__label"><?php echo esc_html( $label ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="hero__media">
			<img class="hero__pattern" src="<?php echo esc_url( estatein_asset( 'img/hero-pattern.svg' ) ); ?>" width="1922.9" height="1284.4" alt="" aria-hidden="true">
			<img class="hero__image" src="<?php echo esc_url( estatein_asset( 'img/hero-building.png' ) ); ?>" width="920" height="814" alt="<?php esc_attr_e( 'Modern glass office towers', 'estatein' ); ?>">
		</div>
	</div>

	<?php get_template_part( 'template-parts/features', null, array( 'items' => estatein_service_tiles() ) ); ?>
</section>

<section class="section container" id="properties">
	<?php
	$head = array(
		'title'  => __( 'Featured Properties', 'estatein' ),
		'text'   => __( 'Explore our handpicked selection of featured properties. Each listing offers a glimpse into exceptional homes and investments available through Estatein. Click "View Details" for more information.', 'estatein' ),
		'button' => __( 'View All Properties', 'estatein' ),
		'url'    => $properties_url,
	);
	get_template_part( 'template-parts/section-head', null, $head );
	?>
	<div class="carousel" data-carousel>
		<div class="carousel__track" data-carousel-track>
			<?php foreach ( $properties as $property ) : ?>
				<?php get_template_part( 'template-parts/property-card', null, array( 'property' => $property ) ); ?>
			<?php endforeach; ?>
		</div>
		<?php get_template_part( 'template-parts/carousel-footer', null, $head ); ?>
	</div>
</section>

<section class="section container" id="testimonials">
	<?php
	$head = array(
		'title'  => __( 'What Our Clients Say', 'estatein' ),
		'text'   => __( 'Read the success stories and heartfelt testimonials from our valued clients. Discover why they chose Estatein for their real estate needs.', 'estatein' ),
		'button' => __( 'View All Testimonials', 'estatein' ),
		'url'    => estatein_page_url( 'about-us' ) . '#clients',
	);
	get_template_part( 'template-parts/section-head', null, $head );
	?>
	<div class="carousel" data-carousel>
		<div class="carousel__track" data-carousel-track>
			<?php foreach ( $testimonials as $testimonial ) : ?>
				<article class="card testimonial-card">
					<?php /* translators: %d: star rating out of 5. */ ?>
					<div class="rating" role="img" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'estatein' ), $testimonial['rating'] ) ); ?>">
						<?php
						for ( $i = 0; $i < $testimonial['rating']; $i++ ) {
							estatein_icon( 'star', 44 );
						}
						?>
					</div>
					<div class="testimonial-card__text">
						<h3 class="card__title"><?php echo esc_html( $testimonial['title'] ); ?></h3>
						<p><?php echo esc_html( $testimonial['quote'] ); ?></p>
					</div>
					<div class="author">
						<?php if ( $testimonial['photo'] ) : ?>
							<img class="author__photo" src="<?php echo esc_url( $testimonial['photo'] ); ?>" width="60" height="60" alt="" loading="lazy">
						<?php endif; ?>
						<p class="author__text">
							<span class="author__name"><?php echo esc_html( $testimonial['name'] ); ?></span>
							<span class="author__location"><?php echo esc_html( $testimonial['location'] ); ?></span>
						</p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
		<?php get_template_part( 'template-parts/carousel-footer', null, $head ); ?>
	</div>
</section>

<?php get_template_part( 'template-parts/section-faq' ); ?>

<?php
get_footer();
