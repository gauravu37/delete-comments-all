<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://prontoinfosys.com
 * @since             1.0.0
 * @package           Delete_Comments_All
 *
 * @wordpress-plugin
 * Plugin Name:       Delete Comments 
 * Plugin URI:        https://prontoinfosys.com/plugins/delete-comments-all
 * Description:       To delete all comments
 * Version:           1.0.0
 * Author:            Gaurav Mittal
 * Author URI:        https://prontoinfosys.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       delete-comments-all
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DELETE_COMMENTS_ALL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-delete-comments-all-activator.php
 */
function activate_delete_comments_all() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-delete-comments-all-activator.php';
	Delete_Comments_All_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-delete-comments-all-deactivator.php
 */
function deactivate_delete_comments_all() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-delete-comments-all-deactivator.php';
	Delete_Comments_All_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_delete_comments_all' );
register_deactivation_hook( __FILE__, 'deactivate_delete_comments_all' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-delete-comments-all.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_delete_comments_all() {

	$plugin = new Delete_Comments_All();
	$plugin->run();

}
run_delete_comments_all();
