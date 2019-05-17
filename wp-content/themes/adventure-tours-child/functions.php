<?php

/**
 * Includes 'style.css'.
 * Disable this filter if you don't use child style.css file.
 *
 * @param  assoc $default_set set of styles that will be loaded to the page
 * @return assoc
 */
function filter_adventure_tours_get_theme_styles( $default_set ) {
	$default_set['child-style'] = get_stylesheet_uri();
	return $default_set;
}
add_filter( 'get-theme-styles', 'filter_adventure_tours_get_theme_styles' );

// This locks down my entire site to non-registered users.
if (preg_match('/build/', ABSPATH)) {// Lock down the site only on the remote site (which has a path containing the string 'build')
	add_action( 'template_redirect', 'redirect_func' );
}
function redirect_func() {
 if( ! is_user_logged_in() && !( $GLOBALS['pagenow'] === 'wp-login.php') ) { if ( ! is_public_page_post() ) { auth_redirect(); } }
}
// This opens up a page/post of my choice to the public.  Mark page with a custom field of "show" and a value of 1.
function is_public_page_post() {
    if ( ! ( is_single() || is_page () ) ) : return false; endif;// If you want to open up the blog page, comment out this line.
    $id = get_the_ID();
    $hide = get_post_meta ($id, 'show', true);
    if ( $hide == 1 ): return true; endif;
    return false;
}
// add_action( 'template_redirect', 'redirect_func' );

// This function displays the name of the template used at the bottom of the page.
function show_template() {
    if( is_super_admin() ){
        global $template;
        print_r($template);
    }
}
add_action('wp_footer', 'show_template');

add_filter( 'avatar_defaults', 'new_default_avatar' );
function new_default_avatar ( $avatar_defaults ) {
		//Set the URL where the image file for your avatar is located
        $new_avatar_url = "https://mrsamui.test/wp-content/uploads/2019/05/logo-ms-250.png";
        
		//Set the text that will appear to the right of your avatar in Settings>>Discussion
		$avatar_defaults[$new_avatar_url] = 'Default Avatar';
		return $avatar_defaults;
}

// Implements possibility to group tours availability by the same "shared resource group" using additional custom meta field with name "tour_resource_group" + some tour may have "full" duration and some only partial one.
function custom_setup_custom_tour_booking_service( $di, $config ) {
	// Based on theme version 3.5.8, AtTourBookingService 2.4.1
	class CustomTourBookingService extends AtTourBookingService
	{
		public $group_meta_name = 'tour_resource_group'; // any string unique for a "group"

		public $booking_duration_meta_name = 'tour_full_day_booking'; // yes/no

		protected $_groups_cache = array();

		protected $_tour_group_cache = array();

		protected $_tour_booking_duration_cache = array();

		public function get_tour_ids_in_group( $group, $allow_cache = true ) {
			if ( $group && $this->group_meta_name) {
				if ( ! $allow_cache || ! isset( $this->_groups_cache[ $group ] ) ) {
					$query = new WP_Query( array(
						'fields' => 'ids',
						'post_type' => 'product',
						'wc_query' => 'tours',
						'meta_query' => array(
							array(
								'key' => $this->group_meta_name,
								'value' => $group,
							),
						),
						'posts_per_page' => -1,
					) );

					$this->_groups_cache[ $group ] = $query->get_posts();
				}
				return $this->_groups_cache[ $group ];
			}

			return array();
		}

		public function get_tour_ids_in_group_by_member_id( $tour_id, $allow_cache = true ) {
			if ( $tour_id > 0 && $this->group_meta_name ) {
				if ( $allow_cache && isset( $this->_tour_group_cache[ $tour_id ] ) ) {
					$group_name = $this->_tour_group_cache[ $tour_id ];
				} else {
					$this->_tour_group_cache[ $tour_id ] = $group_name = get_post_meta( $tour_id, $this->group_meta_name, true );
				}

				if ( $group_name ) {
					return $this->get_tour_ids_in_group( $group_name, $allow_cache );
				}
			}
			return array( $tour_id );
		}

		public function is_full_day_bookable_tour( $tour_id, $allow_cache = true ) {
			$result = null;
			if ( $tour_id > 0 && $this->booking_duration_meta_name ) {
				if ( $allow_cache && isset( $this->_tour_booking_duration_cache[ $tour_id ] ) ) {
					$result = $this->_tour_booking_duration_cache[ $tour_id ];
				} else {
					$result = $this->_tour_booking_duration_cache[ $tour_id ] = in_array(
						get_post_meta( $tour_id, $this->booking_duration_meta_name, true ),
						array('1','yes')
					);
				}
			}
			return $result;
		}

		public function expand_periods( $periods, $exclude_for_tour_id = 0, $from_date = null, $to_date = null, $price_rules = false ) {
			$result = array();

			if ( $periods ) {
				foreach ( $periods as $period ) {
					$expandedDays = $this->expand_period( $period, $price_rules );
					if ( $expandedDays ) {
						if ( ! $price_rules && $this->sum_limits ) {
							foreach ( $expandedDays as $time => $new_limit_value ) {
								if ( isset($result[ $time ]) ) {
									$result[ $time ] = $result[ $time ] + $new_limit_value;
								} else {
									$result[ $time ] = $new_limit_value;
								}
							}
						} else {
							$result = array_merge( $result, $expandedDays );
						}
					}
				}

				if ( $result && $exclude_for_tour_id > 0 && ! $price_rules ) {
					$other_group_members = $this->get_tour_ids_in_group_by_member_id( $exclude_for_tour_id );

					$booked_tickets = $this->get_booking_data( $exclude_for_tour_id, $from_date, $to_date );
					if ( $booked_tickets ) {
						foreach ( $booked_tickets as $booking_date => $qnt ) {
							if ( isset( $result[$booking_date] ) ) {
								$result[$booking_date] -= $qnt;
								if ( $result[$booking_date] < 1 ) {
									unset( $result[$booking_date] );
								}
							}
						}
					}

					if ( $other_group_members ) {
						$exclude_tour_is_full_date = $this->is_full_day_bookable_tour( $exclude_for_tour_id );
						foreach ($other_group_members as $_tid) {
							if ($_tid == $exclude_for_tour_id) {
								continue;
							}

							$related_booked_tickets = $this->get_booking_data( $_tid, $from_date, $to_date );
							if ( $related_booked_tickets ) {
								$rel_is_full_day = $this->is_full_day_bookable_tour( $_tid );
								foreach ( $related_booked_tickets as $booking_date => $qnt ) {
									$check_pattern = null;
									if ($exclude_tour_is_full_date || $rel_is_full_day ) {
										$check_pattern = substr($booking_date, 0, 10);
									} 

									if (!$check_pattern) {
										if ( isset( $result[$booking_date] ) ) {
											$result[$booking_date] -= $qnt;
											if ( $result[$booking_date] < 1 ) {
												unset( $result[$booking_date] );
											}
										}
									} else {
										foreach ($result as $expanded_date => $left_qnt) {
											if ( false !== strpos( $expanded_date, $check_pattern ) ){
												$result[$expanded_date] -= $qnt;
												if ( $result[$expanded_date] < 1 ) {
													unset( $result[$expanded_date] );
												}
											}
										}
									}
								}
							}
						}
					}
				}

				if ( $result && ! $price_rules ) {
					foreach( $result as $booking_date => $qnt ) {
						if ( $qnt < 1 ) {
							unset( $result[ $booking_date ] );
						}
					}
				}
			}

			return $result;
		}
	}

	$booking_service = 'tour_booking_service';
	$cfg = isset($config[ $booking_service ][1]) ? $config[ $booking_service ][1] : array();
	// To exclude dates only after order has "Completed" status only.
	$cfg['order_statuses_with_active_tour_booking'] = array('wc-completed');
	$di[ $booking_service ] = new CustomTourBookingService( $cfg );
}
add_action( 'adventure_tours_init_di', 'custom_setup_custom_tour_booking_service', 5, 2 );




// Setting a custom timeout value for cURL. Using a high value for priority to ensure the function runs after any other added to the same action hook.
add_action('http_api_curl', 'sar_custom_curl_timeout', 9999, 1);
function sar_custom_curl_timeout( $handle ){
	curl_setopt( $handle, CURLOPT_CONNECTTIMEOUT, 30 ); // 30 seconds. Too much for production, only for testing.
	curl_setopt( $handle, CURLOPT_TIMEOUT, 30 ); // 30 seconds. Too much for production, only for testing.
}
// Setting custom timeout for the HTTP request
add_filter( 'http_request_timeout', 'sar_custom_http_request_timeout', 9999 );
function sar_custom_http_request_timeout( $timeout_value ) {
	return 30; // 30 seconds. Too much for production, only for testing.
}
// Setting custom timeout in HTTP request args
add_filter('http_request_args', 'sar_custom_http_request_args', 9999, 1);
function sar_custom_http_request_args( $r ){
	$r['timeout'] = 30; // 30 seconds. Too much for production, only for testing.
	return $r;
}