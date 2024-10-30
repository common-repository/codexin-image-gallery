<?php
/**
 * Fired during plugin deactivation
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/includes
 */

namespace Codexin\Cdxn_Gallery;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/includes
 * @author     Your Name <email@codexin.com>
 */
class Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option( 'cdxn_ig_plugin_permalinks_flushed' );
		delete_option( 'cdxn_ig_plugin_activation_time' );
	}

}
