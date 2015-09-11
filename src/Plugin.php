<?php

namespace Never5\WPNotificationCenter;

class Plugin extends Pimple\Container {

	/** @var string */
	private $version = '1.0';

	/**
	 * Constructor
	 *
	 * @param string $version
	 * @param string $file
	 */
	public function __construct( $version, $file ) {

		// set version
		$this->version = $version;

		// Pimple Container construct
		parent::__construct();

		// register file service
		$this['file'] = function () use ( $file ) {
			return new File( $file );
		};

		// register services early since some add-ons need 'm
		$this->register_services();

		// this complete plugin is pretty much admin only
		if ( is_admin() ) {
			// alias for Pimple container
			$c = $this;

			// enqueue CSS
			add_action( 'admin_enqueue_scripts', function () use ( $c ) {
				wp_enqueue_style(
					'wpcm_admin',
					$c['file']->plugin_url( '/assets/css/wp-notification-center.css' ),
					array(),
					$c->get_version()
				);
			} );

			// catch admin notices
			$this['admin_notice_handler']->catch_admin_notices();

			// setup admin bar
			$admin_bar = new AdminBar();
			$admin_bar->setup();

			// setup plugin links
			$plugin_links = new PluginLinks();
			$plugin_links->setup();
		}

	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register services
	 */
	private function register_services() {
		$provider = new PluginServiceProvider();
		$provider->register( $this );
	}

	/**
	 * Get service
	 *
	 * @param String $key
	 *
	 * @return mixed
	 */
	public function service( $key ) {
		return $this[ $key ];
	}
}