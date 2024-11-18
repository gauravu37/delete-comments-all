<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://prontoinfosys.com
 * @since      1.0.0
 *
 * @package    Delete_Comments_All
 * @subpackage Delete_Comments_All/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Delete_Comments_All
 * @subpackage Delete_Comments_All/includes
 * @author     Gaurav Mittal <er.gauravmittal1989@gmail.com>
 */
class Delete_Comments_All_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'delete-comments-all',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
