<?php
/**
 * Defines the YP section of the Builder.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'review_source' => array(
		'name'   => __( 'YP Review Source', 'wp-business-reviews' ),
		'icon'   => 'fas wpbr-icon wpbr-fw wpbr-building',
		'fields' => array(
			'platform' => array(
				'type'  => 'hidden',
				'value' => 'yp',
			),
			'platform_search' => array(
				'type'             => 'platform_search',
				'powered_by_image' => WPBR_ASSETS_URL . 'images/powered-by-yp.png',
				'powered_by_text'  => __( 'Powered by YP', 'wp-business-reviews' ),
				'subfields'        => array(
					'platform' => array(
						'type'        => 'hidden',
						'value'       => 'yp',
					),
					'platform_search_terms' => array(
						'name'        => __( 'Search Terms', 'wp-business-reviews' ),
						'type'        => 'text',
						'tooltip'     => __( 'Defines the terms used when searching the YP API.', 'wp-business-reviews' ),
						'placeholder' => __( 'Business Name', 'wp-business-reviews' ),
						'required'    => 'required',
					),
					'platform_search_location' => array(
						'name'        => __( 'Location', 'wp-business-reviews' ),
						'type'        => 'text',
						'tooltip'     => __( 'Defines the location used when searching the YP API.', 'wp-business-reviews' ),
						'placeholder' => __( 'City, State', 'wp-business-reviews' ),
						'required'    => 'required',
					),
					'platform_search_button' => array(
						'type'        => 'button',
						'button_text' => __( 'Search', 'wp-business-reviews' ),
						'value'       => 'search',
						'icon'        => 'search',
					),
				),
			),
		),
	),
);

return $config;
