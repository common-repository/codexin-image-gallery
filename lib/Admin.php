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

namespace Codexin\Cdxn_Gallery;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/admin
 * @author     Your Name <email@codexin.com>
 */
class Admin {

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
		$this->load_dependencies();
	}
	/**
	 * Enqueue css and js
	 *
	 * @return void
	 */
	public function enqueue() {

		$screen         = \get_current_screen();
		$post_type_name = CDXN_IG_POST_TYPE;
		if ( $post_type_name === $screen->post_type ) {
			$this->enqueue_styles()->enqueue_scripts();
		}
	}
	/**
	 * Register the stylesheets for the Dashboard. dependency
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cdxn_Ig_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cdxn_Ig_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		\wp_enqueue_style(
			$this->plugin->get_plugin_name(),
			CDXN_IG_ASSETS . '/styles/cdxn-ig-admin' . $suffix . '.css',
			array(),
			$this->plugin->get_version(),
			'all'
		);
		return $this;
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cdxn_Ig_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cdxn_Ig_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		\wp_enqueue_script(
			'cdxn-gallery-admin',
			CDXN_IG_ASSETS . '/scripts/cdxn-ig-admin' . $suffix . '.js',
			array( 'jquery', 'carbon-fields-metaboxes' ),
			$this->plugin->get_version(),
			true
		);

		wp_localize_script(
			'cdxn-gallery-admin',
			'admin_js_script',
			array(
				'admin_ajax' => admin_url( 'admin-ajax.php' ),
				'ajx_nonce'  => wp_create_nonce( 'ajax-nonce' ),
			)
		);

	}

	/**
	 * Load dependencies function.
	 *
	 * @return void
	 */
	private function load_dependencies() {}

	/**
	 * Carbon field metabox and settings page
	 *
	 * @return void
	 */
	public function boot() {
		if ( class_exists( '\Carbon_Fields\Carbon_Fields' ) ) {
			\Carbon_Fields\Carbon_Fields::boot();
		}
	}

}
