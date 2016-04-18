<?php
/*
	Plugin Name: WP Notification Center
	Plugin URI: http://www.never5.com/
	Description: Adds a notification center to WordPress, no more pages that are cluttered with notifications
	Version: 1.0.1
	Author: Never5
	Author URI: http://www.never5.com/
	License: GPL v2

	WP Notification Center
	Copyright (C) 2012-2015, Never5 - www.never5.com

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

// autoloader
require 'vendor/autoload.php';

/**
 * @return \Never5\WPNotificationCenter\Plugin
 */
function wp_notification_center() {

	static $instance;
	if ( is_null( $instance ) ) {
		$instance = new \Never5\WPNotificationCenter\Plugin( '1.0.1', __FILE__ );
	}

	return $instance;

}

function __load_wp_notification_center() {
	// fetch instance and store in global
	return wp_notification_center();
}

// check PHP version
$updatePhp = new WPUpdatePhp( '5.3.0' );
if ( $updatePhp->does_it_meet_required_php_version( PHP_VERSION ) ) {
	// create plugin object
	add_action( 'plugins_loaded', '__load_wp_notification_center', 20 );
}
