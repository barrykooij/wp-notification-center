<?php

namespace Never5\WPNotificationCenter;

class PluginLinks {

	/**
	 * Setup filter
	 */
	public function setup() {
		add_filter( 'plugin_action_links_wp-notification-center/wp-notification-center.php', array( $this, 'add_links' ) );
	}

	/**
	 * Add to links
	 *
	 * @param array $links
	 *
	 * @return array
	 */
	public function add_links( $links ) {
		array_unshift( $links, '<a href="http://www.never5.com/?utm_source=plugin&utm_medium=link&utm_campaign=wp-notification-manager" target="_blank" style="color:#ffa100;font-weight:bold;">' . __( 'More Never5 Plugins', 'wp-notification-center' ) . '</a>' );
		return $links;
	}
}