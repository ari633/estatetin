<?php
/**
 * Property details page.
 *
 * @package Estatein
 */

get_header();
the_post();

$property_id = get_the_ID();
$field       = function ( $key ) use ( $property_id ) {
	return get_post_meta( $property_id, 'estatein_' . $key, true );
};

$price    = $field( 'price' );
$location = $field( 'location' );
$features = array_filter( array_map( 'trim', explode( "\n", (string) $field( 'features' ) ) ) );

// Gallery: featured image first, then other images uploaded to this property.
$image_ids = array_keys( get_attached_media( 'image', $property_id ) );
if ( has_post_thumbnail() ) {
	$image_ids = array_merge( array( get_post_thumbnail_id() ), array_diff( $image_ids, array( get_post_thumbnail_id() ) ) );
}

$facts = array_filter(
	array(
		array( 'bed', 22, 17, __( 'Bedrooms', 'estatein' ), $field( 'bedrooms' ) ? zeroise( (int) $field( 'bedrooms' ), 2 ) : '' ),
		array( 'bath', 21.0171, 21, __( 'Bathrooms', 'estatein' ), $field( 'bathrooms' ) ? zeroise( (int) $field( 'bathrooms' ), 2 ) : '' ),
		/* translators: %s: area in square feet. */
		array( 'area', 21.0145, 21, __( 'Area', 'estatein' ), $field( 'area' ) ? sprintf( __( '%s Square Feet', 'estatein' ), $field( 'area' ) ) : '' ),
	),
	function ( $fact ) {
		return '' !== $fact[4];
	}
);

/*
 * Pricing breakdown. Each item is array( label, value, note ); items without a
 * value are dropped, and a group with no items is not shown.
 */
$price_number = estatein_number( $price );
$insurance    = estatein_number( $field( 'insurance' ) );
$one_off_fees = array_sum(
	array_map(
		function ( $key ) use ( $field ) {
			return (float) estatein_number( $field( $key ) );
		},
		array( 'transfer_tax', 'legal_fees', 'home_inspection', 'insurance' )
	)
);
$amount       = function ( $key ) use ( $field ) {
	return '' === $field( $key ) ? '' : estatein_money( $field( $key ) );
};

$pricing = array(
	array(
		'title' => __( 'Additional Fees', 'estatein' ),
		'stack' => false,
		'items' => array(
			array( __( 'Property Transfer Tax', 'estatein' ), $amount( 'transfer_tax' ), __( 'Based on the sale price and local regulations', 'estatein' ) ),
			array( __( 'Legal Fees', 'estatein' ), $amount( 'legal_fees' ), __( 'Approximate cost for legal services, including title transfer', 'estatein' ) ),
			array( __( 'Home Inspection', 'estatein' ), $amount( 'home_inspection' ), __( 'Recommended for due diligence', 'estatein' ) ),
			array( __( 'Property Insurance', 'estatein' ), $amount( 'insurance' ), __( 'Annual cost for comprehensive property insurance', 'estatein' ) ),
			array( __( 'Mortgage Fees', 'estatein' ), $amount( 'mortgage_fees' ), __( 'If applicable, consult with your lender for specific details', 'estatein' ) ),
		),
	),
	array(
		'title' => __( 'Monthly Costs', 'estatein' ),
		'stack' => true,
		'items' => array(
			array( __( 'Property Taxes', 'estatein' ), $amount( 'property_tax' ), __( 'Approximate monthly property tax based on the sale price and local rates', 'estatein' ) ),
			array( __( "Homeowners' Association Fee", 'estatein' ), $amount( 'hoa_fee' ), __( 'Monthly fee for common area maintenance and security', 'estatein' ) ),
		),
	),
	array(
		'title' => __( 'Total Initial Costs', 'estatein' ),
		'stack' => false,
		'items' => $price_number ? array(
			array( __( 'Listing Price', 'estatein' ), estatein_money( $price_number ), '' ),
			array( __( 'Additional Fees', 'estatein' ), $one_off_fees ? estatein_money( $one_off_fees ) : '', __( 'Property transfer tax, legal fees, inspection, insurance', 'estatein' ) ),
			array( __( 'Down Payment', 'estatein' ), estatein_money( $price_number * 0.2 ), '20%' ),
			array( __( 'Mortgage Amount', 'estatein' ), estatein_money( $price_number * 0.8 ), __( 'If applicable', 'estatein' ) ),
		) : array(),
	),
	array(
		'title' => __( 'Monthly Expenses', 'estatein' ),
		'stack' => false,
		'items' => array(
			array( __( 'Property Taxes', 'estatein' ), $amount( 'property_tax' ), '' ),
			array( __( "Homeowners' Association Fee", 'estatein' ), $amount( 'hoa_fee' ), '' ),
			array( __( 'Mortgage Payment', 'estatein' ), $price_number ? __( 'Varies based on terms and interest rate', 'estatein' ) : '', __( 'If applicable', 'estatein' ) ),
			array( __( 'Property Insurance', 'estatein' ), $insurance ? estatein_money( $insurance / 12 ) : '', __( 'Approximate monthly cost', 'estatein' ) ),
		),
	),
);

foreach ( $pricing as $index => $group ) {
	$pricing[ $index ]['items'] = array_filter(
		$group['items'],
		function ( $item ) {
			return '' !== $item[1];
		}
	);
}
$pricing = array_filter(
	$pricing,
	function ( $group ) {
		return (bool) $group['items'];
	}
);
?>

<article class="property container">
	<header class="property__header">
		<div class="property__heading">
			<h1 class="property__title"><?php the_title(); ?></h1>
			<?php if ( $location ) : ?>
				<p class="property__location"><?php estatein_icon( 'pin', 24 ); ?><?php echo esc_html( $location ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( $price ) : ?>
			<p class="price">
				<span class="price__label"><?php esc_html_e( 'Price', 'estatein' ); ?></span>
				<span class="price__value"><?php echo esc_html( $price ); ?></span>
			</p>
		<?php endif; ?>
	</header>

	<?php if ( $image_ids ) : ?>
		<div class="gallery<?php echo 1 === count( $image_ids ) ? ' gallery--single' : ''; ?>" data-gallery>
			<?php if ( count( $image_ids ) > 1 ) : ?>
				<div class="gallery__thumbs">
					<?php foreach ( $image_ids as $index => $image_id ) : ?>
						<?php /* translators: %d: photo number. */ ?>
						<button class="gallery__thumb" type="button" data-gallery-thumb="<?php echo esc_attr( $index ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show photo %d', 'estatein' ), $index + 1 ) ); ?>">
							<?php echo wp_get_attachment_image( $image_id, 'medium' ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<div class="gallery__track" data-gallery-track>
				<?php foreach ( $image_ids as $image_id ) : ?>
					<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'gallery__image' ) ); ?>
				<?php endforeach; ?>
			</div>

			<div class="gallery__controls" data-gallery-controls>
				<button class="carousel__button" type="button" data-gallery-prev aria-label="<?php esc_attr_e( 'Previous photos', 'estatein' ); ?>">
					<?php estatein_icon( 'arrow-left', 30 ); ?>
				</button>
				<div class="gallery__indicators" data-gallery-indicators></div>
				<button class="carousel__button" type="button" data-gallery-next aria-label="<?php esc_attr_e( 'Next photos', 'estatein' ); ?>">
					<?php estatein_icon( 'arrow-right', 30 ); ?>
				</button>
			</div>
		</div>
	<?php endif; ?>

	<div class="property__info">
		<section class="panel">
			<div class="panel__text">
				<h2 class="card__title"><?php esc_html_e( 'Description', 'estatein' ); ?></h2>
				<div class="lead property__description"><?php the_content(); ?></div>
			</div>
			<?php if ( $facts ) : ?>
				<ul class="facts">
					<?php foreach ( $facts as $fact ) : ?>
						<li class="facts__item">
							<span class="facts__label"><span class="tag__icon"><?php estatein_icon( $fact[0], $fact[1], $fact[2] ); ?></span><?php echo esc_html( $fact[3] ); ?></span>
							<span class="card__title"><?php echo esc_html( $fact[4] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>

		<?php if ( $features ) : ?>
			<section class="panel">
				<h2 class="card__title"><?php esc_html_e( 'Key Features and Amenities', 'estatein' ); ?></h2>
				<ul class="amenities">
					<?php foreach ( $features as $feature ) : ?>
						<li class="amenities__item">
							<img class="amenities__bg" src="<?php echo esc_url( estatein_asset( 'img/feature-bg.png' ) ); ?>" alt="" aria-hidden="true">
							<?php estatein_icon( 'bolt', 24 ); ?>
							<span><?php echo esc_html( $feature ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>
		<?php endif; ?>
	</div>
</article>

<section class="section container inquire">
	<div class="inquire__text">
		<?php
		get_template_part(
			'template-parts/section-head',
			null,
			array(
				/* translators: %s: property name. */
				'title' => sprintf( __( 'Inquire About %s', 'estatein' ), get_the_title() ),
				'text'  => __( 'Interested in this property? Fill out the form below, and our real estate experts will get back to you with more details, including scheduling a viewing and answering any questions you may have.', 'estatein' ),
			)
		);
		?>
	</div>
	<?php get_template_part( 'template-parts/inquiry-form', null, array( 'property' => implode( ', ', array_filter( array( get_the_title(), $location ) ) ) ) ); ?>
</section>

<?php if ( $pricing ) : ?>
	<section class="section container" id="pricing">
		<?php
		get_template_part(
			'template-parts/section-head',
			null,
			array(
				'title' => __( 'Comprehensive Pricing Details', 'estatein' ),
				/* translators: %s: property name. */
				'text'  => sprintf( __( 'At Estatein, transparency is key. We want you to have a clear understanding of all costs associated with your property investment. Below, we break down the pricing for %s to help you make an informed decision', 'estatein' ), get_the_title() ),
			)
		);
		?>

		<div class="note">
			<p class="card__title"><?php esc_html_e( 'Note', 'estatein' ); ?></p>
			<p class="lead"><?php esc_html_e( 'The figures provided above are estimates and may vary depending on the property, location, and individual circumstances.', 'estatein' ); ?></p>
		</div>

		<div class="pricing">
			<p class="pricing__price">
				<span class="pricing__label"><?php esc_html_e( 'Listing Price', 'estatein' ); ?></span>
				<span class="pricing__value"><?php echo esc_html( $price ); ?></span>
			</p>

			<div class="pricing__groups">
				<?php foreach ( $pricing as $group ) : ?>
					<section class="panel panel--pricing">
						<header class="panel__header">
							<h3 class="card__title"><?php echo esc_html( $group['title'] ); ?></h3>
							<a class="btn btn--muted" href="#inquire"><?php esc_html_e( 'Learn More', 'estatein' ); ?></a>
						</header>
						<dl class="fees<?php echo $group['stack'] ? ' fees--stack' : ''; ?>">
							<?php foreach ( $group['items'] as $item ) : ?>
								<div class="fees__item">
									<dt class="lead"><?php echo esc_html( $item[0] ); ?></dt>
									<dd>
										<span class="card__title"><?php echo esc_html( $item[1] ); ?></span>
										<?php if ( $item[2] ) : ?>
											<span class="tag fees__note"><?php echo esc_html( $item[2] ); ?></span>
										<?php endif; ?>
									</dd>
								</div>
							<?php endforeach; ?>
						</dl>
					</section>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/section-faq' );
get_footer();
