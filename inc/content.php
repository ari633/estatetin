<?php
/**
 * Data for the home page sections.
 *
 * Each helper returns published posts when there are any, and otherwise the
 * sample content from the design so a fresh install looks complete.
 *
 * @package Estatein
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Card data for one property.
 *
 * @param WP_Post $post Property.
 */
function estatein_property_data( $post ) {
	$bedrooms  = get_post_meta( $post->ID, 'estatein_bedrooms', true );
	$bathrooms = get_post_meta( $post->ID, 'estatein_bathrooms', true );

	return array(
		'title'     => get_the_title( $post ),
		'excerpt'   => wp_trim_words( get_the_excerpt( $post ), 12, '...' ),
		'image'     => get_the_post_thumbnail_url( $post, 'estatein-card' ),
		/* translators: %s: number of bedrooms. */
		'bedrooms'  => $bedrooms ? sprintf( __( '%s-Bedroom', 'estatein' ), $bedrooms ) : '',
		/* translators: %s: number of bathrooms. */
		'bathrooms' => $bathrooms ? sprintf( __( '%s-Bathroom', 'estatein' ), $bathrooms ) : '',
		'type'      => get_post_meta( $post->ID, 'estatein_type', true ),
		'tagline'   => get_post_meta( $post->ID, 'estatein_tagline', true ),
		'price'     => get_post_meta( $post->ID, 'estatein_price', true ),
		'url'       => get_permalink( $post ),
	);
}

/**
 * Properties for the "Featured Properties" carousel.
 *
 * @param int $limit Maximum number of properties.
 */
function estatein_get_properties( $limit = 12 ) {
	$posts = get_posts(
		array(
			'post_type'   => 'property',
			'numberposts' => $limit,
		)
	);

	if ( $posts ) {
		return array_map( 'estatein_property_data', $posts );
	}

	$url = get_post_type_archive_link( 'property' );

	return array(
		array(
			'title'     => 'Seaside Serenity Villa',
			'excerpt'   => 'A stunning 4-bedroom, 3-bathroom villa in a peaceful suburban neighborhood...',
			'image'     => estatein_asset( 'img/property-1.png' ),
			'bedrooms'  => '4-Bedroom',
			'bathrooms' => '3-Bathroom',
			'type'      => 'Villa',
			'tagline'   => 'Coastal Escapes - Where Waves Beckon',
			'price'     => '$550,000',
			'url'       => $url,
		),
		array(
			'title'     => 'Metropolitan Haven',
			'excerpt'   => 'A chic and fully-furnished 2-bedroom apartment with panoramic city views...',
			'image'     => estatein_asset( 'img/property-2.png' ),
			'bedrooms'  => '2-Bedroom',
			'bathrooms' => '2-Bathroom',
			'type'      => 'Villa',
			'tagline'   => 'Urban Oasis - Life in the Heart of the City',
			'price'     => '$550,000',
			'url'       => $url,
		),
		array(
			'title'     => 'Rustic Retreat Cottage',
			'excerpt'   => 'An elegant 3-bedroom, 2.5-bathroom townhouse in a gated community...',
			'image'     => estatein_asset( 'img/property-3.png' ),
			'bedrooms'  => '3-Bedroom',
			'bathrooms' => '3-Bathroom',
			'type'      => 'Villa',
			'tagline'   => "Countryside Charm - Escape to Nature's Embrace",
			'price'     => '$550,000',
			'url'       => $url,
		),
	);
}

/**
 * Testimonials for the "What Our Clients Say" carousel.
 *
 * @param int $limit Maximum number of testimonials.
 */
function estatein_get_testimonials( $limit = 12 ) {
	$posts = get_posts(
		array(
			'post_type'   => 'testimonial',
			'numberposts' => $limit,
		)
	);

	if ( $posts ) {
		$items = array();
		foreach ( $posts as $post ) {
			$rating  = (int) get_post_meta( $post->ID, 'estatein_rating', true );
			$items[] = array(
				'title'    => get_the_title( $post ),
				'quote'    => wp_strip_all_tags( $post->post_content ),
				'name'     => get_post_meta( $post->ID, 'estatein_author', true ),
				'location' => get_post_meta( $post->ID, 'estatein_location', true ),
				'photo'    => get_the_post_thumbnail_url( $post, 'thumbnail' ),
				'rating'   => $rating ? min( 5, max( 1, $rating ) ) : 5,
			);
		}
		return $items;
	}

	return array(
		array(
			'title'    => 'Exceptional Service!',
			'quote'    => "Our experience with Estatein was outstanding. Their team's dedication and professionalism made finding our dream home a breeze. Highly recommended!",
			'name'     => 'Wade Warren',
			'location' => 'USA, California',
			'photo'    => estatein_asset( 'img/profile-1.png' ),
			'rating'   => 5,
		),
		array(
			'title'    => 'Efficient and Reliable',
			'quote'    => "Estatein provided us with top-notch service. They helped us sell our property quickly and at a great price. We couldn't be happier with the results.",
			'name'     => 'Emelie Thomson',
			'location' => 'USA, Florida',
			'photo'    => estatein_asset( 'img/profile-2.png' ),
			'rating'   => 5,
		),
		array(
			'title'    => 'Trusted Advisors',
			'quote'    => 'The Estatein team guided us through the entire buying process. Their knowledge and commitment to our needs were impressive. Thank you for your support!',
			'name'     => 'John Mans',
			'location' => 'USA, Nevada',
			'photo'    => estatein_asset( 'img/profile-3.png' ),
			'rating'   => 5,
		),
	);
}

/**
 * Questions for the "Frequently Asked Questions" carousel.
 *
 * @param int $limit Maximum number of questions.
 */
function estatein_get_faqs( $limit = 12 ) {
	$posts = get_posts(
		array(
			'post_type'   => 'faq',
			'numberposts' => $limit,
		)
	);

	if ( $posts ) {
		$items = array();
		foreach ( $posts as $post ) {
			$items[] = array(
				'question' => get_the_title( $post ),
				'summary'  => wp_trim_words( get_the_excerpt( $post ), 20, '...' ),
				'url'      => get_permalink( $post ),
			);
		}
		return $items;
	}

	$url = get_post_type_archive_link( 'faq' );

	return array(
		array(
			'question' => 'How do I search for properties on Estatein?',
			'summary'  => 'Learn how to use our user-friendly search tools to find properties that match your criteria.',
			'url'      => $url,
		),
		array(
			'question' => 'What documents do I need to sell my property through Estatein?',
			'summary'  => 'Find out about the necessary documentation for listing your property with us.',
			'url'      => $url,
		),
		array(
			'question' => 'How can I contact an Estatein agent?',
			'summary'  => 'Discover the different ways you can get in touch with our experienced agents.',
			'url'      => $url,
		),
	);
}

/**
 * The four service tiles shown under the Home and Services heroes.
 */
function estatein_service_tiles() {
	$services = estatein_page_url( 'services' );

	return array(
		array( 'feature-home', __( 'Find Your Dream Home', 'estatein' ), get_post_type_archive_link( 'property' ) ),
		array( 'feature-value', __( 'Unlock Property Value', 'estatein' ), $services . '#valuation' ),
		array( 'feature-management', __( 'Effortless Property Management', 'estatein' ), $services . '#management' ),
		array( 'feature-invest', __( 'Smart Investments, Informed Decisions', 'estatein' ), $services . '#investment' ),
	);
}
