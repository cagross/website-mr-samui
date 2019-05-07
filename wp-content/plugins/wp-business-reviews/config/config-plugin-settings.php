<?php
/**
 * Defines the settings config.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

/**
 * Filters the active platform options provided by the settings config.
 *
 * @since 0.1.0
 *
 * @param array $platforms Array of platform slugs.
 */
$platforms = apply_filters( 'wpbr_settings_platforms', array() );

/**
 * Filters the default platforms provided by the settings config.
 *
 * @since 0.1.0
 *
 * @param array $platforms Array of default platform slugs.
 */
$default_platforms = apply_filters( 'wpbr_settings_default_platforms', array() );

$config = array(
	'platforms' => array(
		'name'     => __( 'Platforms', 'wp-business-reviews' ),
		'sections' => array(
			'platforms' => array(
				'name'        => __( 'Platforms', 'wp-business-reviews' ),
				'heading'     => __( 'Platform Settings', 'wp-business-reviews' ),
				// 'description' => sprintf(
				// 	/* translators: link to documentation */
				// 	__( 'Need help? View a tutorial on %1$sPlatform Management%2$s.', 'wp-business-reviews' ),
				// 	'<a href="' . admin_url( 'admin.php?page=wpbr-settings&wpbr_tab=help&wpbr_subtab=video-platform-management' ) . '">',
				// 	'</a>'
				// ),
				'icon'        => 'cogs',
				'fields'      => array(
					'active_platforms' => array(
						'name'          => __( 'Active Review Platforms', 'wp-business-reviews' ),
						'type'          => 'checkboxes',
						'description'   => __( 'Define which review platforms are visible throughout the plugin. Only the selected platforms appear in Settings and Collections.', 'wp-business-reviews' ),
						'default'       => $default_platforms,
						'options'       => $platforms,
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'save_platforms' => array(
						'type'          => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
			'google_places' => array(
				'name'        => __( 'Google', 'wp-business-reviews' ),
				'heading'     => __( 'Google Review Settings', 'wp-business-reviews' ),
				'description' => sprintf(
					/* translators: link to documentation */
					__( 'Need help? View a tutorial on %1$sConnecting to Google%2$s.', 'wp-business-reviews' ),
					'<a href="' . admin_url( 'admin.php?page=wpbr-settings&wpbr_tab=help&wpbr_subtab=video-google-places' ) . '">',
					'</a>'
				),
				'icon'        => 'status',
				'fields'      => array(
					'google_places_platform_status' => array(
						'name'     => __( 'Platform Status', 'wp-business-reviews' ),
						'type'     => 'platform_status',
						'default'  => 'disconnected',
						'platform' => 'google_places',
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'google_places_api_key' => array(
						'name'         => __( 'Google Places API Key', 'wp-business-reviews' ),
						'type'         => 'text',
						'description'  => sprintf(
							/* translators: link to documentation */
							__( 'Define the API key required to retrieve Google reviews. To get an API key, %1$svisit Google Places API documentation%2$s and click the \'Get a Key\' button.', 'wp-business-reviews' ),
							'<a href="https://developers.google.com/places/web-service/get-api-key#get_an_api_key" target="_blank" rel="noopener noreferrer">',
							'</a>'
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'save_google_places' => array(
						'type'    => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
			'facebook' => array(
				'name'        => __( 'Facebook', 'wp-business-reviews' ),
				'heading'     => __( 'Facebook Review Settings', 'wp-business-reviews' ),
				// 'description' => sprintf(
				// 	/* translators: link to documentation */
				// 	__( 'Need help? View a tutorial on %1$sConnecting to Facebook%2$s.', 'wp-business-reviews' ),
				// 	'<a href="' . admin_url( 'admin.php?page=wpbr-settings&wpbr_tab=help&wpbr_subtab=video-facebook' ) . '">',
				// 	'</a>'
				// ),
				'icon'        => 'status',
				'fields'      => array(
					'facebook_platform_status' => array(
						'name'     => __( 'Platform Status', 'wp-business-reviews' ),
						'type'     => 'platform_status',
						'default'  => 'disconnected',
						'platform' => 'facebook',
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'facebook_user_token' => array(
						'name' => __( 'Facebook User Token', 'wp-business-reviews' ),
						'type' => 'internal',
					),
					'facebook_pages' => array(
						'name'        => __( 'Facebook Pages', 'wp-business-reviews' ),
						'type'        => 'facebook_pages',
						'description' => __( 'Connect to Facebook with a role of Admin, Editor, Moderator, Advertiser, or Analyst in order to display reviews from that Page.', 'wp-business-reviews' ),
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
			'yelp' => array(
				'name'        => __( 'Yelp', 'wp-business-reviews' ),
				'heading'     => __( 'Yelp Review Settings', 'wp-business-reviews' ),
				'description' => sprintf(
					/* translators: link to documentation */
					__( 'Need help? View a tutorial on %1$sConnecting to Yelp%2$s.', 'wp-business-reviews' ),
					'<a href="' . admin_url( 'admin.php?page=wpbr-settings&wpbr_tab=help&wpbr_subtab=video-yelp' ) . '">',
					'</a>'
				),
				'icon'        => 'status',
				'fields'      => array(
					'yelp_platform_status' => array(
						'name'     => __( 'Platform Status', 'wp-business-reviews' ),
						'type'     => 'platform_status',

						'default'  => 'disconnected',
						'platform' => 'yelp',
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'yelp_api_key' => array(
						'name'         => __( 'Yelp API Key', 'wp-business-reviews' ),
						'type'         => 'text',
						'description'  => sprintf(
							/* translators: link to documentation */
							__( 'Define the API Key required to retrieve Yelp reviews. To get an API Key, %1$screate a Yelp App%2$s and then copy the API key provided on the \'Manage App\' page.', 'wp-business-reviews' ),
							'<a href="https://www.yelp.com/developers/v3/manage_app" target="_blank" rel="noopener noreferrer">',
							'</a>'
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'save_yelp' => array(
						'type'    => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				)
			),
			'yp' => array(
				'name'        => __( 'YP', 'wp-business-reviews' ),
				'heading'     => __( 'YP Review Settings', 'wp-business-reviews' ),
				'icon'        => 'status',
				'fields'      => array(
					'yp_platform_status' => array(
						'name'     => __( 'Platform Status', 'wp-business-reviews' ),
						'type'     => 'platform_status',
						'default'  => 'disconnected',
						'platform' => 'yp',
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'yp_api_key'         => array(
						'name'         => __( 'YP API Key', 'wp-business-reviews' ),
						'type'         => 'text',
						'description' => __( 'Define the API Key required to retrieve YP reviews. While the Yellow Pages API has discontinued registration of new API keys, existing API keys may still be used to access reviews.', 'wp-business-reviews' ),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'save_yp'            => array(
						'id'      => 'save_yp',
						'type'    => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
			// 'new_platform' => array(
			// 	'name'        => __( 'Add Platform', 'wp-business-reviews' ),
			// 	'heading'     => __( 'Add New Platform', 'wp-business-reviews' ),
			// 	'description' => sprintf(
			// 		/* translators: link to documentation */
			// 		__( 'Need help? View a tutorial on %1$sAdding New Platforms%2$s.', 'wp-business-reviews' ),
			// 		'<a href="' . admin_url( 'admin.php?page=wpbr-settings&wpbr_tab=help&wpbr_subtab=video-adding-platforms' ) . '">',
			// 		'</a>'
			// 	),
			// 	'icon'        => 'status',
			// 	'fields'      => array(
			// 		'new_platform_name' => array(
			// 			'name'          => __( 'Platform Name', 'wp-business-reviews' ),
			// 			'type'          => 'text',
			// 			'description'   => sprintf(
			// 				__( 'Define the platform name. For example, a %1$sWebsite%2$s platform might represent reviews added through your website.', 'wp-business-reviews' ),
			// 				'<code>',
			// 				'</code>'
			// 			),
			// 			'wrapper_class' => 'wpbr-field--spacious',
			// 		),
			// 		'new_platform_slug' => array(
			// 			'name'          => __( 'Platform Slug', 'wp-business-reviews' ),
			// 			'type'          => 'text',
			// 			'description'   => __( 'Define the platform slug using lowercase letters, numbers, and hyphens.', 'wp-business-reviews' ),
			// 			'wrapper_class' => 'wpbr-field--spacious',
			// 		),
			// 		'new_platform_description' => array(
			// 			'name'          => __( 'Platform Description', 'wp-business-reviews' ),
			// 			'type'          => 'textarea',
			// 			'placeholder'   => __( 'Display reviews from...', 'wp-business-reviews' ),
			// 			'description'   => sprintf(
			// 				__( 'Define the platform description, which appears on the %1$sBuilder%2$s launch screen.', 'wp-business-reviews' ),
			// 				'<a href="edit.php?post_type=wpbr_review&page=wpbr-builder">',
			// 				'</a>'
			// 			),
			// 			'wrapper_class' => 'wpbr-field--spacious',
			// 		),
			// 		'new_platform_star_color' => array(
			// 			'name'          => __( 'Star Color', 'wp-business-reviews' ),
			// 			'type'          => 'color',
			// 			'description'   => __( 'Define the color used for star ratings.', 'wp-business-reviews' ),
			// 			'wrapper_class' => 'wpbr-field--spacious',
			// 		),
			// 		'save_new_platform' => array(
			// 			'type'          => 'save',
			// 			'wrapper_class' => 'wpbr-field--spacious',
			// 		),
			// 	),
			// ),
		),
	),
	'advanced' => array(
		'name'     => __( 'Advanced', 'wp-business-reviews' ),
		'sections' => array(
			'advanced' => array(
				'name'        => __( 'Advanced', 'wp-business-reviews' ),
				'heading'     => __( 'Advanced Settings', 'wp-business-reviews' ),
				// 'description' => sprintf(
				// 	/* translators: link to documentation */
				// 	__( 'Need help? View a tutorial on %1$sAdvanced Settings%2$s.', 'wp-business-reviews' ),
				// 	'<a href="' . admin_url( 'admin.php?page=wpbr-settings&wpbr_tab=help&wpbr_subtab=video-advanced-settings' ) . '">',
				// 	'</a>'
				// ),
				'fields'      => array(
					// 'plugin_styles' => array(
					// 	'name'          => __( 'Plugin Styles', 'wp-business-reviews' ),
					// 	'type'          => 'radio',
					// 	'description'   => __( 'Enable to output CSS that styles the presentation of reviews.', 'wp-business-reviews' ),
					// 	'default'       => 'enabled',
					// 	'options'       => array(
					// 		'enabled'      => __( 'Enabled', 'wp-business-reviews' ),
					// 		'disabled'     => __( 'Disabled', 'wp-business-reviews' ),
					// 	),
					// 	'wrapper_class' => 'wpbr-field--spacious',
					// ),
					// 'nofollow_links' => array(
					// 	'name'        => __( 'Nofollow Links', 'wp-business-reviews' ),
					// 	'type'        => 'radio',
					// 	'description' => sprintf(
					// 		/* translators: anchor attribute to discourage search engines */
					// 		__( 'Enable to add %s to review links in order to discourage search engines from following them.', 'wp-business-reviews' ),
					// 		'<code>rel="nofollow"</code>'
					// 	),
					// 	'default'     => 'disabled',
					// 	'options'     => array(
					// 		'enabled'  => __( 'Enabled', 'wp-business-reviews' ),
					// 		'disabled' => __( 'Disabled', 'wp-business-reviews' ),
					// 	),
					// 	'wrapper_class' => 'wpbr-field--spacious',
					// ),
					// 'link_targeting' => array(
					// 	'name'        => __( 'Link Targeting', 'wp-business-reviews' ),
					// 	'type'        => 'radio',
					// 	'description' => sprintf(
					// 		/* translators: anchor attribute to open links in new tab */
					// 		__( 'Enable to add %s to review links in order to open them in a new tab.', 'wp-business-reviews' ),
					// 		'<code>target="_blank"</code>'
					// 	),
					// 	'default'     => '_self',
					// 	'options'     => array(
					// 		'_self'  => __( 'Open links in same tab.', 'wp-business-reviews' ),
					// 		'_blank' => __( 'Open links in new tab.', 'wp-business-reviews' ),
					// 	),
					// 	'wrapper_class' => 'wpbr-field--spacious',
					// ),
					'uninstall_behavior' => array(
						'name'    => __( 'Uninstall Behavior', 'wp-business-reviews' ),
						'type'    => 'radio',
						'default' => 'keep',
						'options' => array(
							'keep'   => __( 'Keep all plugin settings, collections, and reviews.', 'wp-business-reviews' ),
							'remove' => __( 'Remove all plugin settings, collections, and reviews.', 'wp-business-reviews' ),
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'save_advanced' => array(
						'type'    => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
		),
	),
);

/**
 * Filters the entire plugin settings config.
 *
 * @since 0.1.0
 *
 * @param array $config Array of tabs, sections, and fields.
 */
return apply_filters( 'wpbr_config_settings', $config );
