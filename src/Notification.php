<?php

namespace Never5\WPNotificationCenter;

class Notification {

	private $types = array();
	private $message = '';

	/**
	 * Notification constructor.
	 *
	 * @param array $types
	 * @param string $message
	 */
	public function __construct( array $types, $message ) {
		$this->types   = $types;
		$this->message = $message;
	}

	/**
	 * @return array
	 */
	public function get_types() {
		return $this->types;
	}

	/**
	 * @param array $types
	 */
	public function set_types( $types ) {
		$this->types = $types;
	}

	/**
	 * @return string
	 */
	public function get_message() {
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function set_message( $message ) {
		$this->message = $message;
	}
}