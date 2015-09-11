<?php

namespace Never5\WPNotificationCenter;

class AdminNoticeHandler {

	/** @var array $notices */
	private $notices = array();

	/**
	 * Get notices
	 *
	 * @return array
	 */
	public function get_notices() {
		return $this->notices;
	}

	/**
	 * Catch WordPress default admin notices
	 */
	public function catch_admin_notices() {
		add_action( 'in_admin_header', array( $this, 'parse_admin_notices' ), - 1 );
	}

	/**
	 * Parse WordPress admin notices, hooked into in_admin_header
	 */
	public function parse_admin_notices() {
		global $wp_filter;

		// check if there are notices
		if ( isset( $wp_filter['admin_notices'] ) ) {


			// loop through priorities
			foreach ( $wp_filter['admin_notices'] as $priority => $admin_notice_group ) {

				// loop through actions of this priority
				foreach ( (array) $admin_notice_group as $notice_key => $action ) {

					// check if a callback function isset for $action
					if ( ! is_null( $action['function'] ) ) {

						// run callback function and get output
						ob_start();
						call_user_func( $action['function'] );
						$output = trim( ob_get_clean() );

						// the regex
						$regexp = "`<div class=\"([^\"]+)\">(.*)</div>`is";

						// do preg match
						if ( false !== preg_match_all( $regexp, $output, $matches ) ) {
							if ( count( $matches[0] ) > 0 ) {

								// notification types
								$types = explode( ' ', $matches[1][0] );

								// notification message
								$message = trim( strip_tags( $matches[2][0], '' ) );

								// add to notices
								$this->notices[] = new Notification( $types, $message );

								// remove admin notice
								unset( $wp_filter['admin_notices'][$priority][ $notice_key ] );

							}
						}
					}
				}
			}

		}
	}

}