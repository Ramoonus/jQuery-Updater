<?php
/*
 * Plugin Name: jQuery Updater
 * Plugin URI: http://www.ramoonus.nl/wordpress/jquery-updater/
 * Description: This plugin updates jQuery to the latest  stable version.
 * Version: 2.2.0.1
 * Author: Ramoonus
 * Author URI: http://www.ramoonus.nl/
 * License: GPL3
 * Text Domain: jquery-updater
 * Domain Path: /languages
 */

/*
 * Replace jQuery with a newer version, load jQuery Migrate
 * @version 2.2.0.1
 * @since 1.0.0
 */
function rw_jquery_updater() {

		// jQuery
		// Deregister core jQuery
		wp_deregister_script('jquery');
	// Register
		wp_enqueue_script('jquery', plugins_url('/js/jquery-2.2.0.min.js', __FILE__), false, '2.2.0');

		// jQuery Migrate
		// @since 2.0.0
		// Deregister core jQuery Migrate
		wp_deregister_script('jquery-migrate');
		// Register
		wp_enqueue_script('jquery-migrate', plugins_url('/js/jquery-migrate-1.3.0.min.js', __FILE__), array('jquery'), '1.3.0'); // require jquery, as loaded above
}
// Front-End
add_action('wp_enqueue_scripts', 'rw_jquery_updater');

/*
 * Load translation
 * @since 2.2.0
 * @version 1.0
*/
function rw__load_plugin_textdomain() {
    load_plugin_textdomain( 'jquery-updater', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'rw__load_plugin_textdomain' );