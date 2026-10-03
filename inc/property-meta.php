<?php
/**
 * Property fields: the "Property details" box in the editor, the search
 * filters on the Properties page, and helpers for reading the values.
 *
 * @package Estatein
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Property fields as key => array( label, group, help text ).
 */
function estatein_property_fields() {
	return array(
		'estatein_price'           => array( __( 'Price', 'estatein' ), 'details', __( 'e.g. $1,250,000', 'estatein' ) ),
		'estatein_location'        => array( __( 'Location', 'estatein' ), 'details', __( 'e.g. Malibu, California', 'estatein' ) ),
		'estatein_type'            => array( __( 'Property type', 'estatein' ), 'details', __( 'e.g. Villa', 'estatein' ) ),
		'estatein_bedrooms'        => array( __( 'Bedrooms', 'estatein' ), 'details', '' ),
		'estatein_bathrooms'       => array( __( 'Bathrooms', 'estatein' ), 'details', '' ),
		'estatein_area'            => array( __( 'Area (square feet)', 'estatein' ), 'details', __( 'e.g. 2,500', 'estatein' ) ),
		'estatein_build_year'      => array( __( 'Build year', 'estatein' ), 'details', '' ),
		'estatein_tagline'         => array( __( 'Card tagline', 'estatein' ), 'details', __( 'Shown on the Properties page, e.g. Coastal Escapes - Where Waves Beckon', 'estatein' ) ),
		'estatein_features'        => array( __( 'Key features and amenities', 'estatein' ), 'features', __( 'One per line.', 'estatein' ) ),
		'estatein_transfer_tax'    => array( __( 'Property transfer tax', 'estatein' ), 'pricing', '' ),
		'estatein_legal_fees'      => array( __( 'Legal fees', 'estatein' ), 'pricing', '' ),
		'estatein_home_inspection' => array( __( 'Home inspection', 'estatein' ), 'pricing', '' ),
		'estatein_insurance'       => array( __( 'Property insurance (per year)', 'estatein' ), 'pricing', '' ),
		'estatein_mortgage_fees'   => array( __( 'Mortgage fees', 'estatein' ), 'pricing', __( 'An amount, or text such as "Varies"', 'estatein' ) ),
		'estatein_property_tax'    => array( __( 'Property taxes (per month)', 'estatein' ), 'pricing', '' ),
		'estatein_hoa_fee'         => array( __( "Homeowners' association fee (per month)", 'estatein' ), 'pricing', '' ),
	);
}

/**
 * Number contained in a value like "$1,250,000", or null when there isn't one.
 *
 * @param string $value Raw field value.
 */
function estatein_number( $value ) {
	$digits = preg_replace( '/[^0-9.]/', '', (string) $value );
	return is_numeric( $digits ) ? (float) $digits : null;
}

/**
 * Format an amount as dollars. Text that isn't a number is returned as is.
 *
 * @param string|float $value Amount.
 */
function estatein_money( $value ) {
	$number = is_string( $value ) ? estatein_number( $value ) : $value;
	return null === $number ? (string) $value : '$' . number_format( $number );
}

/* ---------------------------------------------------------------------------
   Editor box
--------------------------------------------------------------------------- */

/**
 * Add the "Property details" box to the property editor.
 */
function estatein_add_property_box() {
	add_meta_box( 'estatein-property', __( 'Property details', 'estatein' ), 'estatein_render_property_box', 'property', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'estatein_add_property_box' );

/**
 * Print the fields.
 *
 * @param WP_Post $post Property being edited.
 */
function estatein_render_property_box( $post ) {
	wp_nonce_field( 'estatein_property', 'estatein_property_nonce' );

	$groups = array(
		'details'  => __( 'Details', 'estatein' ),
		'features' => __( 'Features', 'estatein' ),
		'pricing'  => __( 'Pricing details', 'estatein' ),
	);

	echo '<style>.estatein-fields{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:12px 16px}.estatein-fields label{display:block;font-weight:600;margin-bottom:4px}.estatein-fields input,.estatein-fields textarea{width:100%}.estatein-fields .wide{grid-column:1/-1}</style>';

	foreach ( $groups as $group => $title ) {
		echo '<h4>' . esc_html( $title ) . '</h4><div class="estatein-fields">';
		foreach ( estatein_property_fields() as $key => $field ) {
			if ( $field[1] !== $group ) {
				continue;
			}
			$value = get_post_meta( $post->ID, $key, true );
			$wide  = in_array( $key, array( 'estatein_features', 'estatein_tagline' ), true );

			echo '<p class="' . ( $wide ? 'wide' : '' ) . '"><label for="' . esc_attr( $key ) . '">' . esc_html( $field[0] ) . '</label>';
			if ( 'estatein_features' === $key ) {
				echo '<textarea id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" rows="5">' . esc_textarea( $value ) . '</textarea>';
			} else {
				echo '<input type="text" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
			}
			if ( $field[2] ) {
				echo '<span class="description">' . esc_html( $field[2] ) . '</span>';
			}
			echo '</p>';
		}
		echo '</div>';
	}

	echo '<p class="description">' . esc_html__( 'Photo gallery: the featured image comes first, followed by any other images uploaded to this property.', 'estatein' ) . '</p>';
}

/**
 * Save the fields.
 *
 * @param int $post_id Property ID.
 */
function estatein_save_property( $post_id ) {
	if ( ! isset( $_POST['estatein_property_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['estatein_property_nonce'] ), 'estatein_property' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array_keys( estatein_property_fields() ) as $key ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$raw   = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$value = 'estatein_features' === $key ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		update_post_meta( $post_id, $key, $value );
	}

	estatein_index_property( $post_id );
}
add_action( 'save_post_property', 'estatein_save_property' );

/**
 * Store price and area as plain numbers so the Properties page can filter by range.
 *
 * @param int $post_id Property ID.
 */
function estatein_index_property( $post_id ) {
	foreach ( array( 'price', 'area' ) as $field ) {
		$number = estatein_number( get_post_meta( $post_id, 'estatein_' . $field, true ) );
		if ( null === $number ) {
			delete_post_meta( $post_id, '_estatein_' . $field . '_num' );
		} else {
			update_post_meta( $post_id, '_estatein_' . $field . '_num', $number );
		}
	}
}

/**
 * Index properties created before the numeric copies existed.
 */
function estatein_index_existing_properties() {
	if ( get_option( 'estatein_index_version' ) ) {
		return;
	}
	$ids = get_posts(
		array(
			'post_type'   => 'property',
			'post_status' => 'any',
			'numberposts' => -1,
			'fields'      => 'ids',
		)
	);
	array_map( 'estatein_index_property', $ids );
	update_option( 'estatein_index_version', 1 );
}
add_action( 'init', 'estatein_index_existing_properties', 20 );

/* ---------------------------------------------------------------------------
   Properties page search
--------------------------------------------------------------------------- */

/**
 * Price and size ranges offered in the filters, as "min-max" => label.
 */
function estatein_filter_ranges() {
	return array(
		'price' => array(
			'0-250000'         => __( 'Under $250,000', 'estatein' ),
			'250000-500000'    => __( '$250,000 – $500,000', 'estatein' ),
			'500000-1000000'   => __( '$500,000 – $1,000,000', 'estatein' ),
			'1000000-2000000'  => __( '$1,000,000 – $2,000,000', 'estatein' ),
			'2000000-99999999' => __( 'Over $2,000,000', 'estatein' ),
		),
		'size'  => array(
			'0-1000'       => __( 'Under 1,000 sq ft', 'estatein' ),
			'1000-2000'    => __( '1,000 – 2,000 sq ft', 'estatein' ),
			'2000-3000'    => __( '2,000 – 3,000 sq ft', 'estatein' ),
			'3000-9999999' => __( 'Over 3,000 sq ft', 'estatein' ),
		),
	);
}

/**
 * Distinct values of a field across published properties, for a dropdown.
 *
 * @param string $key Meta key.
 */
function estatein_property_options( $key ) {
	global $wpdb;

	return $wpdb->get_col(
		$wpdb->prepare(
			"SELECT DISTINCT m.meta_value FROM {$wpdb->postmeta} m
			INNER JOIN {$wpdb->posts} p ON p.ID = m.post_id
			WHERE m.meta_key = %s AND m.meta_value <> '' AND p.post_type = 'property' AND p.post_status = 'publish'
			ORDER BY m.meta_value",
			$key
		)
	);
}

/**
 * A search filter from the URL.
 *
 * @param string $name Query parameter.
 */
function estatein_filter_value( $name ) {
	return isset( $_GET[ $name ] ) ? sanitize_text_field( wp_unslash( $_GET[ $name ] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
}

/**
 * Apply the search box and filters to the Properties page.
 *
 * @param WP_Query $query Query being built.
 */
function estatein_filter_properties( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'property' ) ) {
		return;
	}

	$query->set( 'posts_per_page', 60 );

	if ( estatein_filter_value( 'q' ) ) {
		$query->set( 's', estatein_filter_value( 'q' ) );
	}

	$meta   = array();
	$exact  = array(
		'location' => 'estatein_location',
		'ptype'    => 'estatein_type',
		'year'     => 'estatein_build_year',
	);
	$ranges = estatein_filter_ranges();

	foreach ( $exact as $param => $key ) {
		if ( estatein_filter_value( $param ) ) {
			$meta[] = array(
				'key'   => $key,
				'value' => estatein_filter_value( $param ),
			);
		}
	}

	foreach ( array( 'price' => '_estatein_price_num', 'size' => '_estatein_area_num' ) as $param => $key ) {
		$range = estatein_filter_value( $param );
		if ( isset( $ranges[ $param ][ $range ] ) ) {
			$meta[] = array(
				'key'     => $key,
				'value'   => array_map( 'floatval', explode( '-', $range ) ),
				'type'    => 'NUMERIC',
				'compare' => 'BETWEEN',
			);
		}
	}

	if ( $meta ) {
		$query->set( 'meta_query', $meta );
	}
}
add_action( 'pre_get_posts', 'estatein_filter_properties' );
