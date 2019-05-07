<?php
/**
 * Defines the Facebook section of the Builder.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

/**
 * Filters the Facebook pages that are available to select.
 *
 * @since 0.2.0
 *
 * @param array $pages Multi-dimensional array of Facebook pages and tokens.
 */
$pages = apply_filters( 'wpbr_facebook_pages', array() );

$config = array(
	'review_source' => array(
		'name'   => __( 'Review Source', 'wp-business-reviews' ),
		'icon'   => 'fab wpbr-icon wpbr-fw wpbr-facebook',
		'fields' => array(
			'platform' => array(
				'type'  => 'hidden',
				'value' => 'facebook',
			),
			'facebook_pages_select' => array(
				'name'    => __( 'Facebook Page', 'wp-business-reviews' ),
				'type'    => 'facebook_pages_select',
				'tooltip' => 'Defines the Facebook page from which reviews are sourced.',
				'value'   => $pages,
			),
		),
	),
);

return $config;
