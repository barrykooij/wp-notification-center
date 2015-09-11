<?php

namespace Never5\WPNotificationCenter;

class PluginServiceProvider implements Pimple\ServiceProviderInterface {

	/**
	 * Registers services on the given container.
	 *
	 * This method should only be used to configure services and parameters.
	 * It should not get services.
	 *
	 * @param Pimple\Container $container An Container instance
	 */
	public function register( Pimple\Container $container ) {

		// admin notice handler
		$container['admin_notice_handler'] = function ( $c ) {
			return new AdminNoticeHandler( $c );
		};

	}

}