<?php
/**
 * Inquiry forms: save each submission as an Inquiry and email the site admin.
 *
 * @package Estatein
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Form fields as key => label.
 */
function estatein_inquiry_fields() {
	return array(
		'first_name'     => __( 'First name', 'estatein' ),
		'last_name'      => __( 'Last name', 'estatein' ),
		'email'          => __( 'Email', 'estatein' ),
		'phone'          => __( 'Phone', 'estatein' ),
		'property'       => __( 'Property', 'estatein' ),
		'location'       => __( 'Preferred location', 'estatein' ),
		'property_type'  => __( 'Property type', 'estatein' ),
		'bathrooms'      => __( 'Bathrooms', 'estatein' ),
		'bedrooms'       => __( 'Bedrooms', 'estatein' ),
		'budget'         => __( 'Budget', 'estatein' ),
		'inquiry_type'   => __( 'Inquiry type', 'estatein' ),
		'heard_from'     => __( 'How they heard about us', 'estatein' ),
		'contact_method' => __( 'Preferred contact method', 'estatein' ),
		'contact_phone'  => __( 'Contact number', 'estatein' ),
		'contact_email'  => __( 'Contact email', 'estatein' ),
		'message'        => __( 'Message', 'estatein' ),
	);
}

/**
 * Handle a submitted inquiry form.
 */
function estatein_handle_inquiry() {
	$back = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$back = remove_query_arg( 'inquiry', $back );

	$valid = isset( $_POST['estatein_inquiry_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['estatein_inquiry_nonce'] ), 'estatein_inquiry' );

	$data = array();
	foreach ( array_keys( estatein_inquiry_fields() ) as $key ) {
		$raw          = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$data[ $key ] = 'message' === $key ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
	}

	// "website" is a hidden field real visitors leave empty.
	$is_bot = ! empty( $_POST['website'] );

	if ( ! $valid || $is_bot || ! $data['first_name'] || ! is_email( $data['email'] ) || empty( $_POST['agree'] ) ) {
		wp_safe_redirect( add_query_arg( 'inquiry', 'error', $back ) . '#inquire' );
		exit;
	}

	$lines = array();
	foreach ( estatein_inquiry_fields() as $key => $label ) {
		if ( '' !== $data[ $key ] ) {
			$lines[] = $label . ': ' . $data[ $key ];
		}
	}
	$body  = implode( "\n", $lines );
	$name  = trim( $data['first_name'] . ' ' . $data['last_name'] );
	$about = $data['property'] ? $data['property'] : __( 'General inquiry', 'estatein' );
	$title = $name . ' — ' . $about;

	wp_insert_post(
		array(
			'post_type'    => 'inquiry',
			'post_status'  => 'private',
			'post_title'   => $title,
			'post_content' => $body,
		)
	);

	wp_mail(
		get_option( 'admin_email' ),
		/* translators: %s: inquiry title. */
		sprintf( __( 'New inquiry: %s', 'estatein' ), $title ),
		$body,
		array( 'Reply-To: ' . $data['email'] )
	);

	wp_safe_redirect( add_query_arg( 'inquiry', 'sent', $back ) . '#inquire' );
	exit;
}
add_action( 'admin_post_estatein_inquiry', 'estatein_handle_inquiry' );
add_action( 'admin_post_nopriv_estatein_inquiry', 'estatein_handle_inquiry' );

/**
 * Print a labelled text input.
 *
 * @param string $name        Field name.
 * @param string $label       Label.
 * @param string $placeholder Placeholder.
 * @param string $type        Input type.
 * @param bool   $required    Whether the field is required.
 */
function estatein_form_input( $name, $label, $placeholder, $type = 'text', $required = false ) {
	printf(
		'<p class="field"><label for="inquiry-%1$s">%2$s</label><input class="field__control" id="inquiry-%1$s" name="%1$s" type="%3$s" placeholder="%4$s"%5$s></p>',
		esc_attr( $name ),
		esc_html( $label ),
		esc_attr( $type ),
		esc_attr( $placeholder ),
		$required ? ' required' : ''
	);
}

/**
 * Print a labelled dropdown.
 *
 * @param string $name        Field name.
 * @param string $label       Label.
 * @param string $placeholder First, empty option.
 * @param array  $options     Option labels.
 */
function estatein_form_select( $name, $label, $placeholder, $options ) {
	printf( '<p class="field"><label for="inquiry-%1$s">%2$s</label><span class="field__select">', esc_attr( $name ), esc_html( $label ) );
	printf( '<select class="field__control" id="inquiry-%1$s" name="%1$s"><option value="">%2$s</option>', esc_attr( $name ), esc_html( $placeholder ) );
	foreach ( $options as $option ) {
		printf( '<option>%s</option>', esc_html( $option ) );
	}
	echo '</select>';
	estatein_icon( 'select-chevron', 24 );
	echo '</span></p>';
}
