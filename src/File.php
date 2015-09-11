<?php
namespace Never5\WPNotificationCenter;

class File {

	/** @var String */
	private $file;

	public function __construct( $file ) {
		$this->file = $file;
	}

	/**
	 * Return plugin file
	 *
	 * @return String
	 */
	public function plugin_file() {
		return $this->file;
	}

	/**
	 * Return plugin path
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( $this->file ) );
	}

	/**
	 * Return plugin url
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	public function plugin_url( $path = '' ) {
		return plugins_url( $path, $this->file );
	}

	/**
	 * @param $image
	 *
	 * @return string
	 */
	public function image_url( $image ) {
		return $this->plugin_url( '/assets/images/' . $image );
	}
}