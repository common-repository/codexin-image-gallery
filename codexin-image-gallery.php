<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://codexin.com
 * @since             1.0.0
 * @package           Cdxn_Gallery
 *
 * @wordpress-plugin
 * Plugin Name:       Photo Gallery by Codexin - Image Gallery
 * Plugin URI:        http://wordpress.org/plugins/codexin-image-gallery/
 * Description:       This plugin will help you to create beautiful, stunning and responsive image galleries with just a few clicks. You can create an unlimited number of galleries with different types of layout and image hover effects with minimum settings.
 * Version:           1.1.0
 * Author:            Codexin Technologies
 * Author URI:        https://codexin.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       codexin-image-gallery
 * Domain Path:       /languages
 */

/*
Copyright 2020 Codexin Technologies (https://codexin.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */


if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {
	add_action( 'admin_notices', 'cdxn_ig_gallery_fail_php_version' );
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	deactivate_plugins( plugin_basename( __FILE__ ) );
} elseif ( ! version_compare( get_bloginfo( 'version' ), '5.0', '>=' ) ) {
	add_action( 'admin_notices', 'cdxn_ig_gallery_fail_wp_version' );
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	deactivate_plugins( plugin_basename( __FILE__ ) );
} else {
	\add_action( 'plugins_loaded', 'cdxn_ig_activate_photogallery' );
}

/**
 * Plugin activation.
 *
 * @return void
 */
function cdxn_ig_activate_photogallery() {
	define( 'CDXN_IG_VERSION', '1.1.0' );
	define( 'CDXN_IG_PLUGIN_NAME', 'codexin-image-gallery' );
	define( 'CDXN_IG_FILE', __FILE__ );
	define( 'CDXN_IG_POST_TYPE', 'cdxn-gallery' );
	define( 'CDXN_IG_PATH', __DIR__ );
	define( 'CDXN_IG_URL', plugins_url( '', CDXN_IG_FILE ) );
	define( 'CDXN_IG_ASSETS', CDXN_IG_URL . '/assets' );
	$plugin = new \Codexin\Cdxn_Gallery\Plugin();
	$plugin->run();
}

/**
 * The code that runs during plugin activation.
 * This action is documented in lib/Activator.php
 */
\register_activation_hook( __FILE__, '\Codexin\Cdxn_Gallery\Activator::activate' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in lib/Deactivator.php
 */
\register_deactivation_hook( __FILE__, '\Codexin\Cdxn_Gallery\Deactivator::deactivate' );



/**
 * Photo gallery admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 1.0.0
 *
 * @return void
 */
function cdxn_ig_gallery_fail_php_version() {
	/* translators: %s: PHP version */
	$message      = sprintf( esc_html__( 'Photo Gallery by Codexin - Image Gallery requires PHP version %s+, plugin is currently NOT RUNNING.', 'codexin-image-gallery' ), '5.6' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Photo gallery admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 *
 * @since 1.5.0
 *
 * @return void
 */
function cdxn_ig_gallery_fail_wp_version() {
	/* translators: %s: WordPress version */
	$message      = sprintf( esc_html__( 'Photo Gallery by Codexin - Image Gallery requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'codexin-image-gallery' ), '5.0' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}
