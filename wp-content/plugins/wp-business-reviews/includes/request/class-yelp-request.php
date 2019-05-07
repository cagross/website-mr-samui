<?php
/**
 * Defines the Yelp_Request class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves data from Yelp API.
 *
 * @since 0.1.0
 */
class Yelp_Request extends Request {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'yelp';

	/**
	 * Yelp API key.
	 *
	 * @since 0.1.0
	 * @var string $key
	 */
	private $key;

	/**
	 * Instantiates the Yelp_Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Yelp API key.
	 */
	public function __construct( $key ) {
		$this->key = $key;
	}

	/**
	 * Retrieves the platform status based on a test request.
	 *
	 * @since 1.0.1
	 *
	 * @return string The platform status.
	 */
	public function get_platform_status() {
		$response = $this->search_review_source( 'PNC Park', 'Pittsburgh' );

		if ( is_wp_error( $response ) ) {
			return 'disconnected';
		}

		return 'connected';
	}

	/**
	 * Searches review sources based on search terms and location.
	 *
	 * @since 0.1.0
	 *
	 * @param string $terms    The search terms, usually a business name.
	 * @param string $location The location within which to search.
	 * @return array|WP_Error Associative array containing response or WP_Error
	 *                        if response structure is invalid.
	 */
	public function search_review_source( $terms, $location ) {
		$url = add_query_arg(
			array(
				'term'     => $terms,
				'location' => $location,
				'limit'    => 10,
			),
			'https://api.yelp.com/v3/businesses/search'
		);

		$args = array(
			'user-agent' => '',
			'headers'    => array(
				'authorization' => 'Bearer ' . $this->key,
			),
		);

		$response = $this->get( $url, $args );

		if ( ! isset( $response['businesses'] ) ) {
			return new \WP_Error( 'wpbr_no_review_sources', __( 'No results found. For best results, enter the entire business name, city, and state as they appear on the platform.', 'wp-business-reviews' ) );
		}

		return $response['businesses'];
	}

	/**
	 * Retrieves review source details based on Yelp business ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Yelp business ID.
	 * @return array|WP_Error Associative array containing response or WP_Error
	 *                        if response structure is invalid.
	 */
	public function get_review_source( $id ) {
		$url = 'https://api.yelp.com/v3/businesses/' . $id;

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->key,
			),
		);

		$response = $this->get( $url, $args );

		return $response;
	}

	/**
	 * Retrieves reviews based on Yelp business ID.
	 *
	 * @since 1.2.0 Return reviews in reverse chronological order.
	 * @since 0.1.0
	 *
	 * @param string $id The Yelp business ID.
	 * @return array|WP_Error Associative array containing response or WP_Error
	 *                        if response structure is invalid.
	 */
	public function get_reviews( $id ) {
		$url = 'https://api.yelp.com/v3/businesses/' . $id . '/reviews';

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->key,
			),
		);

		$response = $this->get( $url, $args );

		if ( ! isset( $response['reviews'] ) ) {
			return new \WP_Error( 'wpbr_no_reviews', __( 'No reviews found. Although reviews may exist on the platform, none were returned from the platform API.', 'wp-business-reviews' ) );
		}

		$reviews = $response['reviews'];
		usort( $reviews, array( $this, 'compare_timestamps' ) );

		return $reviews;
	}

	/**
	 * Compares the timestamps of two reviews.
	 *
	 * @since 1.2.0
	 *
	 * @param array $review1 Array of review data with a timestamp.
	 * @param array $review2 Array of review data with a timestamp.
	 * @return int Difference between two timestamps.
	 */
	protected function compare_timestamps( $review1, $review2 ) {
		$timestamp1 = strtotime( $review1['time_created'] );
		$timestamp2 = strtotime( $review2['time_created'] );

		return $timestamp2 - $timestamp1;
	}
}
