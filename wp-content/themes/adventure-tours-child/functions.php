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

function new_default_avatar ( $avatar_defaults ) {
		//Set the URL where the image file for your avatar is located
		$new_avatar_url = content_url() . "/uploads/2019/05/logo-ms-rev-140.png";
        
		//Set the text that will appear to the right of your avatar in Settings>>Discussion
		$avatar_defaults[$new_avatar_url] = "Mr. Samui Avatar";
		return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'new_default_avatar' );

// Implements possibility to group tours availability by the same "shared resource group" using additional custom meta field with name "tour_resource_group" + some tour may have "full" duration and some only partial one.

class DummyBlockedPeriodsProvider{
    public static function all(){

		//Create the array containing all resources, and all dates of unavailability.
		$arr_unavail = [];
		$csv = array_map('str_getcsv', file('wp-content/themes/adventure-tours-child/data/tours/unavailable.csv'));
		for($i=0;$i<count($csv);$i++) {
			for($j=0;$j<count($csv[$i]);$j++) {
				$arr_unavail[$i]['group'] = $csv[$i][0];
				$arr_unavail[$i]['from'] = $csv[$i][1];
				$arr_unavail[$i]['to'] = $csv[$i][2];
			}
		}
		
		return $arr_unavail;

    }
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

        protected function get_tour_group_name_by_member_id( $tour_id, $allow_cache = true ){
            if ( $tour_id > 0 && $this->group_meta_name ) {
                if ( !$allow_cache || !isset( $this->_tour_group_cache[ $tour_id ] ) ) {
                    $this->_tour_group_cache[ $tour_id ] = get_post_meta( $tour_id, $this->group_meta_name, true );
                }
                return $this->_tour_group_cache[ $tour_id ];
            }
            return null;
        }

        protected function get_blocked_periods_for_group( $group_name, $from_date = null, $to_date = null ){
            $result = array();
            if ( $group_name ){
                $all_blocked_periods = DummyBlockedPeriodsProvider::all();
                if ($all_blocked_periods){
                    foreach ($all_blocked_periods as $item) {
                        if ($group_name == $item['group']) {
                            $active_period = $this->get_inersected_period($item, array(
                                'from' => $from_date,
                                'to' => $to_date
                            ));

                            if ($active_period){
                                $result[] = $active_period;
                            }
                        }
                    }
                }
            }
            return $result;
        }

        public function get_tour_ids_in_group_by_member_id( $tour_id, $allow_cache = true ) {
            $group_name = $this->get_tour_group_name_by_member_id( $tour_id, $allow_cache );
            if ( $group_name ) {
                return $this->get_tour_ids_in_group( $group_name, $allow_cache );
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

                    $group_members = $this->get_tour_ids_in_group_by_member_id( $exclude_for_tour_id );
                    if ( $group_members ) {
                        $exclude_tour_is_full_date = $this->is_full_day_bookable_tour( $exclude_for_tour_id );
                        foreach ($group_members as $_tid) {
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
                    $group_name = $this->get_tour_group_name_by_member_id( $exclude_for_tour_id );
                    $get_blocked_periods = $this->get_blocked_periods_for_group( $group_name, $from_date, $to_date );
                    if ($get_blocked_periods) {
                        foreach ($get_blocked_periods as $_blocking_period) {
                            $blocked_dates = $this->expand_period(
                                array_merge(
                                    $_blocking_period,
                                    array(
                                        'days' => array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'),
                                        'type' => '1',
                                        'limit' => 0,
                                    )
                                )
                            );
                            if ($blocked_dates) {
                                // $result = array_merge( $result, $blocked_dates );
                                // To avoid cases when booking date has time.
                                foreach ($blocked_dates as $_blocked_date => $_zero ) {
                                    foreach ($result as $_ticket_date => $_qnt) {
                                        if ( 0 === strpos( $_ticket_date, $_blocked_date ) ) {
                                            unset($result[$_ticket_date]);
                                        }
                                    }
                                }
                            }
                        }
                    }

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


// Hides "remaining tickets" from tour booking form.
function custom_adventure_tours_init_di_callback( $di, $config ) {
	$di['booking_form']->setConfig( array(
		'calendar_show_left_tickets_format' => '',
	));
}
add_action( 'adventure_tours_init_di', 'custom_adventure_tours_init_di_callback', 11, 2 );

/* Change the price qualifier text on each tour.  Ensure it displays the value of the custom field 'custom_price_label' which needs to be set on every tour.*/
function custom_text_adventure_tours_price_decoration_label( $text, $tour ) {
    $custom_text = get_post_meta( $tour->get_id(), 'custom_price_label', true );
    return $custom_text ? $custom_text : $text;
}
add_filter( 'adventure_tours_price_decoration_label', 'custom_text_adventure_tours_price_decoration_label', 20, 2 );
add_filter( 'adventure_tours_list_price_decoration_label', 'custom_text_adventure_tours_price_decoration_label', 20, 2 ); //comment this line if you don't want to replace 'per person' text on tours archive page with custom text defined in "custom_price_label" field

// Renders min variation price for variable tours items.
function custom_variable_price_filter( $price_html, $product ) {
	if ( $product && $product->is_type( 'tour' ) && $product->is_variable_tour() ) {
		return wc_price( $product->get_variation_price( 'min' ) );
	}
	return $price_html;
}
add_filter( 'woocommerce_get_price_html', 'custom_variable_price_filter', 20, 2 );

// Customizes the tour booking form to hide quantity field for items that belong(or don't) to specific tour category.
function custom_adventure_tours_booking_form( $di, $config ) {
    class CustomBookingForm extends AtBookingForm
    {
        public function get_fields_config( $product ) {
            $config = parent::get_fields_config( $product );

			// The third and final conditional comparison is to ensure any tour with custom field show_qty == "yes" does display the Quantity field in the form.  Use this so the Overnight Sailing Charter tour can show the Quantity field, which will represent the desired number of days for the tour.
			if ( ! empty( $config['quantity'] ) && ! has_term( 'land-tours', 'tour_category', $product->get_id() ) && !(get_post_meta( $product->get_id(), 'show_qty', true ) == "yes") ) {
                $config['quantity']['type'] = 'hidden';
                $this->errors_movement['quantity'] = 'date';
            }
            
            // Ensure the multi-day tours have the 'Quantity' placeholder changed to '# of Days' in the booking form.
            if (get_post_meta( $product->get_id(), 'is_multi_day', true ) == "yes") {
                $config['quantity']['placeholder'] = '# of Days';
            }



            if ( $this->is_time_picker_required( $product ) ) {
                $field_labels = $this->get_booking_fields( true );
                $time_label = isset( $field_labels['taxi_time'] ) ? $field_labels['taxi_time'] : '';

                $config['taxi_time'] = array(
                    'label' => $time_label,
                    'placeholder' => $time_label,
                    'class' => 'selectpicker',
                    'icon_class' => 'td-clock-2',
                    'type' => 'text',
                    // 'rules' => array( 'required' ),
                );
            }
            return $config;
        }

        protected function is_time_picker_required( $product ){
            $ms_needs_time = false;
            if (get_post_meta( $product->get_id(), 'add_time_input', true ) == "yes") {//Check if tour has custom field 'add_time_input' set to 'yes.'  If so, add the text input field.
                $ms_needs_time = true;
            }
            return $ms_needs_time;
        }

        public function get_booking_fields( $withLabels = false ) {
            $list = parent::get_booking_fields( true );

            $list['taxi_time'] = 'Time';

            return $withLabels ? $list : array_keys( $list );
        }
    }

    $bf_config = isset( $config['booking_form'][1] ) ? $config['booking_form'][1] : array();
    $di['booking_form'] = new CustomBookingForm( $bf_config );
}
add_action( 'adventure_tours_init_di', 'custom_adventure_tours_booking_form', 2, 2 );


















/* Load Google fonts on front page. */
function ms_add_fonts() {
	if (is_front_page()) {
		echo "<link href='https://fonts.googleapis.com/css?family=Abhaya+Libre:800&display=swap' rel='stylesheet'>";
	}
};
add_filter('wp_head', 'ms_add_fonts');

/* Enqueue script to add badge to home page images. */
function ms_enqueue_scripts() {
	error_log(print_r("testy",true));
	wp_enqueue_script( 'ms-js-badge', get_stylesheet_directory_uri() . '/assets/js/ms-badge.js', array(), NULL, TRUE);
}
add_action('wp_enqueue_scripts', 'ms_enqueue_scripts');

// removes photos tab from tour details page
function custom_remove_photos_tab_from_tour_page( $tabs ){
    if (get_post_meta( get_the_id(), 'hide_photos', true) == "yes") {
    
        if ( isset( $tabs['photos'] ) ) {
            unset( $tabs['photos'] );
        }
    }
    return $tabs;
}
add_filter( 'adventure_tours_tour_tabs', 'custom_remove_photos_tab_from_tour_page', 11 );

