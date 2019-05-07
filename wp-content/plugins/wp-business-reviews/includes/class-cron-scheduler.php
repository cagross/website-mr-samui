<?php
/**
 * Defines the Cron_Scheduler class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes
 * @since 1.2.1
 */

namespace WP_Business_Reviews\Includes;

 /**
 * Schedules cron events for the plugin.
 *
 * @since 1.2.1
 */
class Cron_Scheduler {
	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 1.2.1
	 */
	public function register() {
		add_action( 'wp', array( $this, 'schedule_events' ) );
		add_action( 'wpbr_run_daily_events', array( $this, 'update_last_scheduled_event' ) );
	}

	/**
	 * Updates the time of the last scheduled event in database.
	 *
	 * @since 1.2.1
	 */
	public function update_last_scheduled_event() {
		$timestamp = current_time( 'mysql' );
		update_option( 'wpbr_last_scheduled_event', $timestamp, false );
	}

	/**
	 * Schedules all cron events.
	 *
	 * @since 1.2.1
	 */
	public function schedule_events() {
		$this->schedule_daily_events();
	}

	/**
	 * Unschedules cron events.
	 *
	 * @since 1.2.1
	 */
	public function unschedule_events() {
		$timestamp = wp_next_scheduled( 'wpbr_run_daily_events' );
		wp_unschedule_event( $timestamp, 'wpbr_run_daily_events' );
	}

	/**
	 * Schedules daily events.
	 *
	 * @since 1.2.1
	 */
	private function schedule_daily_events() {
		if ( ! wp_next_scheduled( 'wpbr_run_daily_events' ) ) {
			wp_schedule_event( time(), 'daily', 'wpbr_run_daily_events' );
		}
	}
}
