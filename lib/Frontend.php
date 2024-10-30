<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Cdxn_Gallery
 * @subpackage Cdxn_Gallery/Frontend
 */

namespace Codexin\Cdxn_Gallery;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Cdxn_Gallery
 * @subpackage Cdxn_Gallery/Frontend
 * @author     Your Name <email@codexin.com>
 */
class Frontend {

	/**
	 * The plugin's instance.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    Plugin $plugin This plugin's instance.
	 */
	private $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 *
	 * @param Plugin $plugin This plugin's instance.
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined in that particular
		 * class.
		 *
		 * The Loader will then create the relationship between the defined
		 * hooks and the functions defined in this class.
		 */
		\wp_enqueue_style(
			'cdxn-ig-vendorcss',
			CDXN_IG_ASSETS . '/vendor/styles/plugins.css',
			array(),
			$this->plugin->get_version(),
			'all'
		);
		\wp_enqueue_style(
			$this->plugin->get_plugin_name(),
			CDXN_IG_ASSETS . '/styles/cdxn-ig' . $suffix . '.css',
			array(),
			$this->plugin->get_version(),
			'all'
		);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined in that particular
		 * class.
		 *
		 * The Loader will then create the relationship between the defined
		 * hooks and the functions defined in this class.
		 */
		\wp_register_script(
			'cdxn-ig-vendorjs',
			CDXN_IG_ASSETS . '/vendor/scripts/plugins.js',
			array( 'jquery' ),
			$this->plugin->get_version(),
			true
		);
		// Image loded script only for mesonry layour.
		\wp_register_script(
			'cdxn-ig-imagesloaded-pkgd',
			CDXN_IG_ASSETS . '/vendor/scripts/imagesloaded.pkgd.min.js',
			array( 'jquery' ),
			$this->plugin->get_version(),
			true
		);
		// Image loded script only for mesonry layour.
		\wp_register_script(
			'cdxn-ig-justified-gallery',
			CDXN_IG_ASSETS . '/vendor/scripts/jquery.justifiedGallery.min.js',
			array( 'jquery' ),
			$this->plugin->get_version(),
			true
		);
		// Masonry script only for mesonry layour.
		\wp_register_script(
			'cdxn-ig-masonry-pkgd',
			CDXN_IG_ASSETS . '/vendor/scripts/masonry.pkgd.min.js',
			array( 'jquery', 'cdxn-ig-imagesloaded-pkgd' ),
			$this->plugin->get_version(),
			true
		);
		\wp_register_script(
			'cdxn-ig-activation',
			CDXN_IG_ASSETS . '/scripts/cdxn-ig' . $suffix . '.js',
			array( 'jquery' ),
			$this->plugin->get_version(),
			true
		);

	}

}
