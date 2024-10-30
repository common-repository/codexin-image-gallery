<?php
/**
 * Custom Post Type functionality of the plugin.
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/admin
 */

namespace Codexin\Cdxn_Gallery\Admin;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Register custom post type.
 */
class Custom_Post_Type {
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	private $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
	 */
	private $version;

	/**
	 * Class constructor.
	 *
	 * @param  string $plugin_name Plugin name.
	 * @param  string $version Plugin Version.
	 * @access public
	 * @since  1.0
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}
	/**
	 * CPT activatate and permalink rewrite
	 *
	 * @return void
	 */
	public function cpt_activate() {
		$this->post_type();
		if ( is_admin() && ! get_option( 'cdxn_ig_plugin_permalinks_flushed' ) ) {
			flush_rewrite_rules(); // Default true for hard.
			update_option( 'cdxn_ig_plugin_permalinks_flushed', 1 );
		}
	}
	/**
	 * Register post type
	 *
	 * @return void
	 */
	public function post_type() {
		$labels = array(
			'name'               => __( 'Photo gallery', 'codexin-image-gallery' ),
			'singular_name'      => __( 'Photo gallery', 'codexin-image-gallery' ),
			'add_new'            => __( 'Add New Gallery', 'codexin-image-gallery' ),
			'all_items'          => __( 'All Galleries', 'codexin-image-gallery' ),
			'add_new_item'       => __( 'Add New Gallery', 'codexin-image-gallery' ),
			'edit_item'          => __( 'Edit Gallery', 'codexin-image-gallery' ),
			'new_item'           => __( 'New Gallery', 'codexin-image-gallery' ),
			'view_item'          => __( 'View Gallery', 'codexin-image-gallery' ),
			'search_item'        => __( 'Search Gallery', 'codexin-image-gallery' ),
			'not_found'          => __( 'No Gallery Found', 'codexin-image-gallery' ),
			'not_found_in_trash' => __( 'No Gallery Found In Trash', 'codexin-image-gallery' ),
			'parent_item_colon'  => __( 'Parent Gallery', 'codexin-image-gallery' ),
		);
		$args   = array(
			'labels'              => $labels,
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => false,
			'query_var'           => true,
			're-write'            => true,
			'capability_type'     => 'post',
			'hierarchical'        => true,
			'menu_icon'           => 'dashicons-format-gallery',
			'supports'            => array(
				'title',
			),
			'rewrite'             => array(
				'slug'       => 'cdxn-gallery',
				'with_front' => false,
			),
			'taxonomies'          => array(),
			'menu_position'       => 5,
			'exclude_from_search' => false,
		);
		register_post_type( CDXN_IG_POST_TYPE , $args );
	}

}

