<?php
/*
 * Plugin Name: jQuery Updater
 * Plugin URI: https://github.com/Ramoonus/jQuery-Updater
 * Description: This plugin updates jQuery to the latest stable version.
 * Version: 4.0.0-beta
 * Author: Ramoonus and Remzi Cavdar
 * Author URI: http://www.ramoonus.nl/
 * Network: true
 * License: GPLv3
 * Text Domain: jquery-updater
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/ramoonus/jQuery-Updater/
 * GitHub Branch: master
 */
namespace Ramoonus\jQueryUpdater;

/**
 * Security
 * Exit if accessed directly.
 *
 * @since 2.1.4
 * @version 1.0.0
 */

// If this file is called directly, abort.
if (! defined('ABSPATH')) {
    exit();
}

/**
 * Check minimum required WordPress version
 *
 * @since 3.0
 * @version 2.0
 * @return boolean
 */
function rw_jqu_minimum_wp_version()
{
    global $wp_version;

    if (version_compare($wp_version, '4.9', '>=')) {
        add_action('admin_notices', 'rw_jqu_minimum_wp_version_notice');
    }
}

function rw_jqu_minimum_wp_version_notice()
{
    $class = 'notice notice-error';
    $message = __('jQuery Updater has disabled WP jQuery Updater', 'sample-text-domain');

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}

/**
 * Translation Loader
 *
 * @version 1.0
 */
function jqu_init_localization()
{
    load_plugin_textdomain('jquery_updater', false, basename(dirname(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'jqu_init_localization');

/**
 * Init jQuery (old function)
 *
 * @return void
 * @author Ramon "Ramoonus" van Belzen
 * @version 3.0.0
 * @since 2.0.0
 * @copyright 2015
 */
function jqu_init()
{
    //
}

add_action('init', 'jqu_init');

/**
 * Load front or backend scripts
 *
 * @since 2.1.4
 * @todo run updater only on activation
 */
define('rw_jquery_plugin_dir', plugin_dir_path(__FILE__));

// if is admin
if (is_admin()) {
    /* Back End */
    include_once (rw_jquery_plugin_dir . 'inc/db-update.php');

    /* Get options and aliases */
    include_once (rw_jquery_plugin_dir . 'inc/options.php');
} else {
    /* Front End */
    include_once (rw_jquery_plugin_dir . 'inc/engine.php');
}
/**
 * Always load compatibility and deprecated
 *
 * @since 2.1.4
 */
include_once (rw_jquery_plugin_dir . 'inc/compatibility.php');
// include_once( rw_jquery_plugin_dir . 'inc/deprecated.php' );

/**
 * Admin Page
 * version 1.0.0
 * 
 * @todo load CSS 
 */
include_once rw_jquery_plugin_dir . 'inc/admin.php';

add_action('admin_head', 'jqu_admin_css');
function jqu_admin_css() {
    // wp_enqueue_style($handle);
}

function jqu_admin_menu()
{
  //add_management_page( $page_title, $menu_title, $capability, $menu_slug, $function );
    add_management_page('jQuery Updater', 'jQuery Updater', 'manage_options', 'jqu_plugin_settings-id', 'jqu_plugin_settings');
    add_action('admin_init', 'wpj_updater_plugin_register_settings');
}
add_action('admin_menu', 'jqu_admin_menu');

/**
 * Process Admin Options changes
 */
function jqu_plugin_settings() {
    // jQuery and jQuery Migrate settings
    register_setting( 'jqu_plugin_settings-id', 'wpj_updater_jquery_url', 'jqu_option_validation' );
    register_setting( 'jqu_plugin_settings-id', 'wpj_updater_jquery_migrate_url', 'jqu_option_validation' );
}

/**
 * Sanitize all options
 * 
 * https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data
 */ 
function jqu_option_validation($input) {
    return sanitize_text_field($input);
}