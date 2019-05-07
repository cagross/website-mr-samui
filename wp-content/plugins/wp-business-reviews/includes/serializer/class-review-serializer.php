<?php
/**
 * Defines the Review_Serializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Serializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Serializer;

use \DateTime;

/**
 * Saves reviews to the database.
 *
 * @since 0.1.0
 */
class Review_Serializer extends Post_Serializer {
	/**
	 * The post type being saved.
	 *
	 * @since 0.1.0
	 * @var string $post_type
	 */
	protected $post_type = 'wpbr_review';

	/**
	 * The WordPress date format.
	 *
	 * @since 1.1.0
	 * @var string $date_format
	 */
	protected $date_format;

	/**
	 * Instantiates the Review_Serializer object.
	 *
	 * @since 1.1.0
	 *
	 * @param Deserializer $deserializer Retriever of collections.
	 */
	public function __construct( $date_format ) {
		$this->date_format = $date_format;
	}

	/**
	* Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wpbr_review_source_determine_post_id', array( $this, 'set_post_parent' ) );
		add_action( 'admin_post_wpbr_collection_save', array( $this, 'save_from_post_json' ), 20 );
	}

	/**
	 * Prepares the post data in a ready-to-save format.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_data Raw, unstructured post data.
	 * @return array Array of elements that make up a post.
	 */
	public function prepare_post_array( array $raw_data ) {
		$platform      = '';
		$rating        = 0;
		$rating_normal = 0;

		// Define the raw data ($r) from which a post will be created.
		$r = $raw_data;

		// Define the post array ($p) that will hold all post elements.
		$p = array(
			'post_type'   => $this->post_type,
			'post_status' => 'publish',
		);

		// Check for duplicates if saving a collection.
		if ( 'admin_post_wpbr_collection_save' === current_action() ) {
			if ( $this->get_duplicate( $r ) ) {
				// Bail early because review already exists.
				return array();
			}
		}

		// Set post ID.
		if ( isset( $r['post_id'] ) ) {
			$p['ID'] = $this->clean( $r['post_id'] );
		}

		// Set post parent.
		if ( ! empty( $this->post_parent ) ) {
			$p['post_parent'] = $this->post_parent;
		} elseif ( isset( $r['post_parent'] ) ) {
			$p['post_parent'] = $this->clean( $r['post_parent'] );
		}

		// Set timestamp.
		if ( ! empty( $r['components']['timestamp'] ) ) {
			$timestamp = $this->clean( $r['components']['timestamp'] );
			$p['meta_input']["{$this->prefix}timestamp"] = $timestamp;
			unset( $r['components']['timestamp'] );
		} elseif ( ! empty( $r['components']['custom_timestamp'] ) ) {
			// Timestamps from custom reviews need normalized using WP date format.
			$date_time = DateTime::createFromFormat(
				'Y-m-d',
				$this->clean( $r['components']['custom_timestamp'] )
			);
			$timestamp = $date_time->format( 'Y-m-d H:i:s' );
			$p['meta_input']["{$this->prefix}timestamp"] = $timestamp;
			unset( $r['components']['custom_timestamp'] );
		}

		// Process content before title in case it's needed to generate title.
		if ( ! empty( $r['components']['content'] ) ) {
			$p['post_content'] = $this->clean_multiline( $r['components']['content'] );
			unset( $r['components']['content'] );
		} else {
			// Content is empty, so add 'blank' attribute for filtering.
			$p['tax_input']['wpbr_attribute'] = 'blank';
		}

		// Set title from raw data, post title field, or content.
		if ( isset( $r['title'] ) ) {
			$p['post_title'] = $this->clean( $r['title'] );
		} else if ( ! empty( $_POST['post_title'] ) ) {
			// Use title from title field
			$p['post_title'] = $this->clean( $_POST['post_title'] );
		} else if ( isset( $p['post_content'] ) ) {
			// Generate post title from content.
			$p['post_title'] = $this->generate_title_from_excerpt( $p['post_content'] );
		}

		// Set platform.
		if ( isset( $r['platform'] ) ) {
			$platform = $this->clean( $r['platform'] );

			// Convert platform to slug if ID provided.
			if ( absint( $platform ) ) {
				$term_obj = get_term_by( 'id', $platform, 'wpbr_platform' );
				$platform = $term_obj ? $term_obj->slug : '';
			}

			$p['tax_input']['wpbr_platform'] = $platform;
		}

		// Process rating.
		if ( isset( $r['components']['rating'] ) ) {
			$rating = $this->clean( $r['components']['rating'] );
			unset( $r['components']['rating'] );

			$rating_normal = $this->normalize_rating(
				$rating,
				$platform
			);
		}

		// Set rating and normalized rating.
		$p['meta_input']["{$this->prefix}rating"]        = $rating;
		$p['meta_input']["{$this->prefix}rating_normal"] = $rating_normal;

		// Denote recommendation as a taxonomy term for filtering.
		if ( ! is_numeric( $rating ) ) {
			$p['tax_input']['wpbr_attribute'] = 'recommendation';
		}

		// Store review source ID as post meta.
		if ( isset( $r['review_source_id'] ) ) {
			$p['meta_input']["{$this->prefix}review_source_id"] = $this->clean( $r['review_source_id'] );
		}

		// Do not store formatted date as it is generated dynamically.
		unset( $r['components']['formatted_date'] );

		// Store all remaining components as post meta.
		if ( isset( $r['components'] ) ) {
			foreach ( $r['components'] as $key => $value ) {
				if ( null !== $value ) {
					$p['meta_input']["{$this->prefix}{$key}"] = $this->clean( $value );
				}
			}
		}

		return $p;
	}

	/**
	 * Generates a truncated title from a string of content.
	 *
	 * @since 0.1.0
	 *
	 * @param string  $content The review content to trim.
	 * @param integer $length  Maximum number of characters in the review title.
	 * @return string The truncated title.
	 */
	protected function generate_title_from_excerpt( $content, $length = 60 ) {
		/**
		 * Filters the number of characters in the review title.
		 *
		 * @since 0.1.0
		 *
		 * @param int $length Maximum number of characters in the review title.
		 */
		$length = apply_filters( 'wpbr_review_title_length', $length );

		if ( $length >= strlen( $content ) ) {
			return $content;
		}

		$title = mb_substr( $content, 0, strrpos( mb_substr( $content, 0, $length - 3 ), ' ' ) );
		$last_char = mb_substr( $title, -1 );

		if ( '.' === $last_char ) {
			$title .= '..';
		} else {
			$title .= '...';
		}

		return $title;
	}

	/**
	 * Determines if a review is a duplicate.
	 *
	 * A review is considered a duplicate if an existing post is found with the
	 * same post parent and identical timestamp or reviewer name. Identifying
	 * duplicates helps to prevent reviews from displaying twice within collections.
	 *
	 * @since 1.1.0
	 *
	 * @param array $review Array of review data from the platform API.
	 * @return int|bool Post ID of the existing post if duplicate, false otherwise.
	 */
	protected function get_duplicate( $review ) {
		$args = array(
			'no_found_rows'          => true,
			'numberposts'            => 1,
			'post_status'            => array( 'any' ),
			'post_type'              => $this->post_type,
			'update_post_meta_cache' => false,
		);

		// Only check for dupes if post parent is set.
		if ( ! empty( $this->post_parent ) ) {
			$args['post_parent'] = $this->post_parent;
		} elseif ( isset( $review['post_parent'] ) ) {
			$args['post_parent'] = $this->clean( $review['post_parent'] );
		} else {
			return false;
		}

		// Identical timestamps can indicate a duplicate.
		if ( ! empty( $review['components']['timestamp'] ) ) {
			$args['meta_query']['timestamp_clause'] = array(
				'key'   => 'wpbr_timestamp',
				'value' => $review['components']['timestamp'],
			);
		}

		// Identical reviewer name can indicate a duplicate.
		if ( ! empty( $review['components']['reviewer_name'] ) ) {
			$args['meta_query']['reviewer_name_clause'] = array(
				'key'   => 'wpbr_reviewer_name',
				'value' => $review['components']['reviewer_name'],
			);
		}

		// Duplicate cannot be determine without a timestamp or name.
		if ( empty( $args['meta_query'] ) ) {
			return false;
		}

		$args['meta_query']['relation'] = 'OR';
		$posts = get_posts( $args );

		if ( ! empty( $posts ) ) {
			return $posts[0]->ID;
		}

		return false;
	}
}
