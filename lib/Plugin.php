<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/includes
 */

namespace Codexin\Cdxn_Gallery;

use Codexin\Cdxn_Gallery\Admin\Custom_Post_Type;
use Codexin\Cdxn_Gallery\Admin\Metabox;
use Codexin\Cdxn_Gallery\Admin\Post_Column;
use Codexin\Cdxn_Gallery\Admin\Notice;
use Codexin\Cdxn_Gallery\Frontend\Shortcodes;
use Codexin\Cdxn_Gallery\Frontend\Gallery_Frontend;
use Codexin\Cdxn_Gallery\Common\Images;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/includes
 * @author     Your Name <email@codexin.com>
 */
class Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cdxn_Ig_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CDXN_IG_VERSION' ) ) {
			$this->version = CDXN_IG_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		if ( defined( 'CDXN_IG_PLUGIN_NAME' ) ) {
			$this->plugin_name = CDXN_IG_PLUGIN_NAME;
		} else {
			$this->plugin_name = 'codexin-image-gallery';
		}
		$this->loader = new Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );
		$plugin_i18n->load_plugin_textdomain();

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin   = new Admin( $this );
		$post_type      = new Custom_Post_Type( $this->get_plugin_name(), $this->get_version() );
		$metabox        = new Metabox( $this->get_plugin_name(), $this->get_version() );
		$post_column    = new Post_Column( $this->get_plugin_name(), $this->get_version() );
		$images         = new Images();
		$notice         = new Notice();
		$post_type_name = CDXN_IG_POST_TYPE;

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue' );
		$this->loader->add_action( 'init', $post_type, 'cpt_activate' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'boot' );
		$this->loader->add_action( 'carbon_fields_register_fields', $metabox, 'register_metabox' );
		$this->loader->add_filter( 'manage_' . $post_type_name . '_posts_columns', $post_column, 'set_custom_columns' );
		$this->loader->add_action( 'manage_' . $post_type_name . '_posts_custom_column', $post_column, 'custom_column_value', 10, 2 );
		$this->loader->add_action( 'add_meta_boxes', $metabox, 'shortcode_register_meta_box' );
		$this->loader->add_action( 'after_setup_theme', $images, 'image_size' );
		$this->loader->add_action( 'admin_notices', $notice, 'gallery_notice' );
		$this->loader->add_action( 'wp_ajax_rate_the_plugin', $notice, 'rate_the_plugin_action' );
		$this->loader->add_action( 'wp_ajax_nopriv_rate_the_plugin', $notice, 'rate_the_plugin_action' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_frontend_hooks() {

		$plugin_frontend  = new Frontend( $this );
		$ng_shortcode     = new Shortcodes( $this->get_plugin_name(), $this->get_version() );
		$cdxn_ig_frontend = new Gallery_Frontend( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_frontend, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $ng_shortcode, 'shortcode_list' );
		$this->loader->add_action( 'wp_footer', $cdxn_ig_frontend, 'photoswipe_footer_script', 101 );
		// Conflict Lightbox with PhotoSwipe   resolve.
		$this->loader->add_filter( 'lbwps_enabled', $cdxn_ig_frontend, 'lbwps_enabled', 10, 2 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_frontend_hooks();
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Cdxn_Ig_Plugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}


}
