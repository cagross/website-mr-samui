<?php
/**
 * Defines the Assets class
 *
 * @package WP_Business_Reviews\Includes
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes;

/**
 * Loads the plugin's assets.
 *
 * Registers and enqueues plugin styles and scripts. Asset versions are based
 * on the current plugin version.
 *
 * All script and style handles should be registered in this class even if they
 * are enqueued dynamically by other classes.
 *
 * @since 0.1.0
 */
class Assets {
	/**
	 * URL of the assets directory.
	 *
	 * @since  0.1.0
	 * @var    string
	 * @access private
	 */
	private $url;

	/**
	 * Assets version.
	 *
	 * @since  0.1.0
	 * @var    string
	 * @access private
	 */
	private $version;

	/**
	 * Suffix used when loading minified assets.
	 *
	 * @since  0.1.0
	 * @var    string
	 * @access private
	 */
	private $suffix;

	/**
	 * Instantiates the Assets class.
	 *
	 * @since 0.1.0
	 *
	 * @param $string $url     Path to the assets directory.
	 * @param $string $version Assets version, usually same as plugin version.
	 */
	public function __construct( $url, $version ) {
		$this->url     = $url;
		$this->version = $version;
		$this->suffix = '';
	}

	/**
	 * Registers assets via WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'register_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'localize_strings' ) );
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'localize_strings' ) );
		}
	}

	/**
	 * Registers all plugin styles.
	 *
	 * @since 0.1.0
	 */
	public function register_styles() {
		wp_register_style( 'wpbr-admin-main-styles', $this->url . 'css/wpbr-admin-main' . $this->suffix . '.css', array(), $this->version );
		wp_register_style( 'wpbr-public-main-styles', $this->url . 'css/wpbr-public-main' . $this->suffix . '.css', array(), $this->version );
	}

	/**
	 * Registers all plugin scripts.
	 *
	 * @since 0.1.0
	 */
	public function register_scripts() {
		wp_register_script( 'wpbr-admin-main-script', $this->url . 'js/wpbr-admin-main' . $this->suffix . '.js', array( 'jquery', 'media-views' ), $this->version, true );
		wp_register_script( 'wpbr-public-main-script', $this->url . 'js/wpbr-public-main' . $this->suffix . '.js', array(), $this->version, true );
		wp_register_script( 'wpbr-system-info', $this->url . 'js/wpbr-system-info' . $this->suffix . '.js', array( 'jquery' ), $this->version, true );
	}

	/**
	 * Enqueues admin styles.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_admin_styles() {
		wp_enqueue_style( 'wpbr-admin-main-styles' );
	}

	/**
	 * Enqueues public styles.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_public_styles() {
		wp_enqueue_style( 'wpbr-public-main-styles' );
	}

	/**
	 * Enqueues admin scripts.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_admin_scripts() {
		if ( 'wpbr_review' === get_post_type() ) {
			wp_enqueue_media();
			wp_enqueue_script( 'jquery-ui-datepicker' );
		}

		if ( isset( $_GET['page'] ) && 'wpbr-system-info' === $_GET['page'] ) {
			wp_enqueue_script( 'wpbr-system-info' );

			wp_localize_script( 'wpbr-system-info', 'wpbrSystemInfo', array(
				'strings' => array(
					'copied' => esc_html__( 'Copied!', 'wp-business-reviews' ),
				),
			) );
		}

		wp_enqueue_script( 'wpbr-admin-main-script' );
	}

	/**
	 * Enqueues public scripts.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_public_scripts() {
		wp_enqueue_script( 'wpbr-public-main-script' );
	}

	/**
	 * Localizes strings for use in JavaScript.
	 *
	 * @since 1.2.1
	 */
	public function localize_strings() {
		$handle = 'wpbr-public-main-script';

		// Define public strings.
		$strings = array(
			'via'               => __( 'via', 'wp-business-reviews' ),
			'recommendPositive' => __( 'recommends', 'wp-business-reviews' ),
			'recommendNegative' => __( 'doesn\'t recommend', 'wp-business-reviews' ),
			'readMore'          => __( 'Read more', 'wp-business-reviews' ),
		);

		if ( is_admin() ) {
			$handle = 'wpbr-admin-main-script';

			// Define admin strings.
			$admin_strings = array(
				'getReviews'         => __( 'Get Reviews', 'wp-business-reviews' ),
				'resetSearch'        => __( 'Reset Search', 'wp-business-reviews' ),
				'reviewsBeforeSave'  => __( 'This collection cannot be saved yet. Please select a review source and get reviews before saving.', 'wp-business-reviews' ),
				'saveAndRefresh'     => __( 'Save and Refresh', 'wp-business-reviews' ),
				'maxReviewsExceeded' => __( 'The Maximum Reviews setting exceeds the number of loaded reviews. Refresh the collection to look for more reviews.', 'wp-business-reviews' ),
				'orderUpdated'       => __( 'The updated order will take effect after the collection is saved.', 'wp-business-reviews' ),
				'filterUpdated'      => __( 'The updated filter will take effect after the collection is saved.', 'wp-business-reviews' ),
			);

			// Merge public and admin strings.
			$strings = array_merge( $strings, $admin_strings );
		}

		/**
		 * Filters localized strings for use in JavaScript.
		 *
		 * @since 1.2.1
		 */
		$strings = apply_filters( 'wpbr_localized_strings', $strings );

		wp_localize_script( $handle, 'wpbrStrings', $strings );
	}
}
