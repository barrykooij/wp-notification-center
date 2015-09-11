<?php

namespace Never5\WPNotificationCenter;

class AdminBar {

	/**
	 * Setup admin bar hook
	 */
	public function setup() {
		add_action( 'admin_bar_menu', array( $this, 'add_items' ), 999 );
	}

	/**
	 * Add items to admin bar
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar
	 */
	public function add_items( &$wp_admin_bar ) {

		// get Notifications
		$notifications = wp_notification_center()->service( 'admin_notice_handler' )->get_notices();

		// Add top menu
		$wp_admin_bar->add_menu( array(
			'id'     => 'wp-notification-center',
			'parent' => 'top-secondary',
			'title'  => sprintf( __( 'Notifications %s', 'wp-notification-center' ), '<span class="wpnc-count">' . count( $notifications ) . '</span>' ),
			'href'   => false
		) );


		// loop
		if ( count( $notifications ) > 0 ) {

			$i = 0;

			/** @var Notification $notification */
			foreach ( $notifications as $notification ) {

				$item_classes = implode( ' ', array_map( function ( $type ) {
					return 'wpnc-' . $type;
				}, $notification->get_types() ) );

				$wp_admin_bar->add_menu( array(
					'id'     => 'wp-notification-center-item-' . $i,
					'parent' => 'wp-notification-center',
					'title'  => $notification->get_message(),
					'href'   => false,
					'meta'   => array(
						'class' => $item_classes
					)
				) );

				$i ++;
			}
		}
	}

}