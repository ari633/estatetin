<?php
/**
 * Properties page: search, listing and inquiry form.
 *
 * @package Estatein
 */

get_header();

$archive_url = get_post_type_archive_link( 'property' );
$ranges      = estatein_filter_ranges();
$filtering   = false;

foreach ( array( 'q', 'location', 'ptype', 'price', 'size', 'year' ) as $param ) {
	$filtering = $filtering || '' !== estatein_filter_value( $param );
}

$filters = array(
	'location' => array( 'filter-location', __( 'Location', 'estatein' ), estatein_property_options( 'estatein_location' ) ),
	'ptype'    => array( 'filter-type', __( 'Property Type', 'estatein' ), estatein_property_options( 'estatein_type' ) ),
	'price'    => array( 'filter-price', __( 'Pricing Range', 'estatein' ), $ranges['price'] ),
	'size'     => array( 'filter-size', __( 'Property Size', 'estatein' ), $ranges['size'] ),
	'year'     => array( 'filter-year', __( 'Build Year', 'estatein' ), estatein_property_options( 'estatein_build_year' ) ),
);

// Published properties matching the search; the design's samples on an empty site.
$properties = array_map( 'estatein_property_data', $wp_query->posts );
if ( ! $properties && ! $filtering ) {
	$properties = estatein_get_properties();
}

// With plain permalinks the archive URL carries ?post_type=property, which a GET form would drop.
$hidden = array();
wp_parse_str( (string) wp_parse_url( $archive_url, PHP_URL_QUERY ), $hidden );
?>

<section class="page-hero">
	<div class="page-hero__text">
		<h1 class="heading"><?php esc_html_e( 'Find Your Dream Property', 'estatein' ); ?></h1>
		<p class="lead"><?php esc_html_e( 'Welcome to Estatein, where your dream property awaits in every corner of our beautiful world. Explore our curated selection of properties, each offering a unique story and a chance to redefine your life. With categories to suit every dreamer, your journey', 'estatein' ); ?></p>
	</div>
</section>

<form class="search container" action="<?php echo esc_url( strtok( $archive_url, '?' ) ); ?>" method="get" role="search">
	<?php foreach ( $hidden as $name => $value ) : ?>
		<input type="hidden" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
	<?php endforeach; ?>

	<div class="search__bar">
		<label class="screen-reader-text" for="property-search"><?php esc_html_e( 'Search for a property', 'estatein' ); ?></label>
		<input class="search__input" id="property-search" type="search" name="q" value="<?php echo esc_attr( estatein_filter_value( 'q' ) ); ?>" placeholder="<?php esc_attr_e( 'Search For A Property', 'estatein' ); ?>">
		<button class="btn btn--primary search__submit" type="submit">
			<?php estatein_icon( 'search', 24 ); ?>
			<span><?php esc_html_e( 'Find Property', 'estatein' ); ?></span>
		</button>
	</div>

	<div class="search__filters">
		<?php foreach ( $filters as $name => $filter ) : ?>
			<div class="filter">
				<?php estatein_icon( $filter[0], 24 ); ?>
				<label class="screen-reader-text" for="filter-<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $filter[1] ); ?></label>
				<select class="filter__select" id="filter-<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" data-autosubmit>
					<option value=""><?php echo esc_html( $filter[1] ); ?></option>
					<?php foreach ( $filter[2] as $value => $label ) : ?>
						<?php $value = is_int( $value ) ? $label : $value; ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php selected( estatein_filter_value( $name ), $value ); ?>><?php echo esc_html( $label ); ?></option>
					<?php endforeach; ?>
				</select>
				<span class="filter__chevron"><?php estatein_icon( 'chevron-down', 24 ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</form>

<section class="section container" id="portfolio">
	<?php
	get_template_part(
		'template-parts/section-head',
		null,
		array(
			'title' => __( 'Discover a World of Possibilities', 'estatein' ),
			'text'  => __( 'Our portfolio of properties is as diverse as your dreams. Explore the following categories to find the perfect property that resonates with your vision of home', 'estatein' ),
		)
	);
	?>

	<?php if ( $properties ) : ?>
		<div class="carousel" data-carousel>
			<div class="carousel__track" data-carousel-track>
				<?php
				foreach ( $properties as $property ) {
					get_template_part(
						'template-parts/property-card',
						null,
						array(
							'property' => $property,
							'style'    => 'tagline',
						)
					);
				}
				?>
			</div>
			<?php get_template_part( 'template-parts/carousel-footer' ); ?>
		</div>
	<?php else : ?>
		<div class="empty">
			<p class="card__title"><?php esc_html_e( 'No properties match your search.', 'estatein' ); ?></p>
			<a class="btn btn--muted" href="<?php echo esc_url( $archive_url ); ?>"><?php esc_html_e( 'Clear Search', 'estatein' ); ?></a>
		</div>
	<?php endif; ?>
</section>

<section class="section container" id="form">
	<?php
	get_template_part(
		'template-parts/section-head',
		null,
		array(
			'title' => __( "Let's Make it Happen", 'estatein' ),
			'text'  => __( "Ready to take the first step toward your dream property? Fill out the form below, and our real estate wizards will work their magic to find your perfect match. Don't wait; let's embark on this exciting journey together.", 'estatein' ),
		)
	);
	get_template_part( 'template-parts/inquiry-form' );
	?>
</section>

<?php
get_footer();
