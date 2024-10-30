<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/admin
 */

namespace Codexin\Cdxn_Gallery\Common;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Images functionality of the plugin.
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/admin
 * @author     Your Name <email@codexin.com>
 */
class Images {
	/**
	 * Register image size
	 *
	 * @return void
	 */
	public function image_size() {
		add_image_size( 'cdxn-ig-image-square', 600, 600, true );
	}

}
