<?php
/**
 * Defines the Yelp section of the Builder.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'review_source' => array(
		'name'   => __( 'Yelp Review Source', 'wp-business-reviews' ),
		'icon'   => 'fab wpbr-icon wpbr-fw wpbr-yelp',
		'fields' => array(
			'platform' => array(
				'type'  => 'hidden',
				'value' => 'yelp',
			),
			'platform_search' => array(
				'type'             => 'platform_search',
				'powered_by_image' => WPBR_ASSETS_URL . 'images/powered-by-yelp.png',
				'powered_by_text'  => __( 'Powered by Yelp', 'wp-business-reviews' ),
				'subfields'        => array(
					'platform' => array(
						'type'        => 'hidden',
						'value'       => 'yelp',
					),
					'platform_search_terms' => array(
						'name'        => __( 'Search Terms', 'wp-business-reviews' ),
						'type'        => 'text',
						'tooltip'     => __( 'Defines the terms used when searching the Yelp API.', 'wp-business-reviews' ),
						'placeholder' => __( 'Business Name', 'wp-business-reviews' ),
						'required'    => 'required',
					),
					'platform_search_location' => array(
						'name'        => __( 'Location', 'wp-business-reviews' ),
						'type'        => 'text',
						'tooltip'     => __( 'Defines the location used when searching the Yelp API.', 'wp-business-reviews' ),
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
