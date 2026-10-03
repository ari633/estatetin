<?php
/**
 * Custom post types that feed the home page sections.
 *
 * @package Estatein
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Property, Testimonial and FAQ post types and their fields.
 */
function estatein_register_post_types() {
	register_post_type(
		'property',
		array(
			'labels'       => array(
				'name'          => __( 'Properties', 'estatein' ),
				'singular_name' => __( 'Property', 'estatein' ),
				'add_new_item'  => __( 'Add New Property', 'estatein' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'properties' ),
			'menu_icon'    => 'dashicons-building',
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		)
	);

	register_post_type(
		'testimonial',
		array(
			'labels'       => array(
				'name'          => __( 'Testimonials', 'estatein' ),
				'singular_name' => __( 'Testimonial', 'estatein' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'menu_icon'    => 'dashicons-format-quote',
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		)
	);

	register_post_type(
		'faq',
		array(
			'labels'       => array(
				'name'          => __( 'FAQs', 'estatein' ),
				'singular_name' => __( 'FAQ', 'estatein' ),
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'faqs' ),
			'menu_icon'    => 'dashicons-editor-help',
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'excerpt', 'custom-fields' ),
		)
	);

	register_post_type(
		'inquiry',
		array(
			'labels'       => array(
				'name'          => __( 'Inquiries', 'estatein' ),
				'singular_name' => __( 'Inquiry', 'estatein' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'menu_icon'    => 'dashicons-email',
			'supports'     => array( 'title', 'editor' ),
			'capabilities' => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap' => true,
		)
	);

	foreach ( array_keys( estatein_property_fields() ) as $key ) {
		register_post_meta(
			'property',
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'estatein_features' === $key ? 'sanitize_textarea_field' : 'sanitize_text_field',
			)
		);
	}

	foreach ( array( 'estatein_author', 'estatein_location', 'estatein_rating' ) as $key ) {
		register_post_meta(
			'testimonial',
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
	}
}
add_action( 'init', 'estatein_register_post_types' );

/**
 * Make the /properties/ and /faqs/ URLs work as soon as the theme is activated.
 */
function estatein_flush_rewrites() {
	estatein_register_post_types();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'estatein_flush_rewrites' );
