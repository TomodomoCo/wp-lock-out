<?php
/*
Plugin Name: WP Lock Out
Plugin URI: https://www.vanpattenmedia.com/
Description: Prevent users from logging in or using the admin panel
Author: Van Patten Media Inc.
Version: 1.0
Author URI: https://www.vanpattenmedia.com/
*/

class WpLockOut {
	public $url;
	public $version;

	function __construct() {
		$this->url     = plugins_url( 'wp-lock-out' );
		$this->version = '1.0';

		add_action( 'login_enqueue_scripts', array( $this, 'login_enqueue' ) );
		add_action( 'admin_footer', array( $this, 'admin_lock' ) );
	}

	/**
	 * login_enqueue
	 *
	 * Enqueue CSS and JS for the login locker
	 */
	function login_enqueue() {
		wp_enqueue_style(
			'login-lock-style',
			$this->url . '/assets/login-lock.css',
			false
		);

		wp_enqueue_script(
			'jquery-konami',
			$this->url . '/assets/jquery.konami.min.js',
			array(
				'jquery',
			)
		);

		wp_enqueue_script(
			'login-lock',
			$this->url . '/assets/login-lock.js',
			array(
				'jquery-konami',
			),
			$this->version
		);
	}

	/**
	 * admin_lock
	 *
	 * If the user is not an administrator, block their UI access
	 */
	function admin_lock() {
		if ( ! current_user_can( 'administrator' ) ) {
			echo '<div style="background: rgba( 0, 0, 0, 0.8 ); position: fixed; top: 0; right: 0; bottom: 0; left: 0; z-index: 100000;"><p style="color: white; text-shadow: 0 1px 1px black; width: 70%; margin: 150px auto 0; text-align: center; font-size: 30px;">The WordPress admin panel is currently disabled.<br>Please try back soon.</p></div>';
		}
	}

}

// Instantiate the class
new WpLockOut;
