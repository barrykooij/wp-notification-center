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
		add_action( 'in_admin_header', array( $this, 'catch_notices' ), - 1 );
	}

	/**
	 * Parse WordPress admin notices, hooked into in_admin_header
	 */
	public function catch_notices() {
		global $wp_filter;

		// parse default 'admin_notices'
		$this->parse_notices( $wp_filter['admin_notices'] );

		// parse default 'all_admin_notices'
		$this->parse_notices( $wp_filter['all_admin_notices'] );

	}

	/**
	 * @param array &$collection
	 *
	 * $collection is passed as pointer because we need to be able to remove entries from original GLOBAL array (yah globals)
	 */
	private function parse_notices( &$collection ) {

		// check if there are notices
		if ( isset( $collection ) ) {

			// loop through priorities
			foreach ( $collection as $priority => $admin_notice_group ) {

				// loop through actions of this priority
				foreach ( (array) $admin_notice_group as $notice_key => $action ) {

					// check if a callback function isset for $action
					if ( ! is_null( $action['function'] ) ) {

						// run callback function and get output
						ob_start();
						call_user_func( $action['function'] );
						$output = trim( ob_get_clean() );

						// the regex
						$regexp = "`<div([^<>]*)>(.*)</div>`is";

						// do preg match
						if ( false !== preg_match_all( $regexp, $output, $matches ) ) {

							/**
							 * 0 = FULL STRING
							 * 1 = ATTRIBUTES
							 * 2 = CONTENT
							 */

							if ( count( $matches[0] ) > 0 ) {

								// fetch class attribute values from all attributes
								$class_regexp = '`class=\"([^\"]+)\"`iS';

								// regex on class values
								if ( false !== preg_match_all( $class_regexp, $matches[1][0], $class_values ) ) {

									// check if we got results
									if ( count( $class_values[0] ) > 0 ) {

										// notification types
										$types = explode( ' ', $class_values[1][0] );

										// notification message
										$message = trim( strip_tags( $matches[2][0], '<a>' ) );

										// add to notices
										$this->notices[] = new Notification( $types, $message );

										// remove admin notice
										unset( $collection[ $priority ][ $notice_key ] );

									}

								}

							}
						}
					}
				}
			}

		}

	}

}