<?php
/**
 * Settings Page functionality of the plugin.
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
 * Post column.
 */
class Post_Column {

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
	 * Class constructor.
	 *
	 * @param  string $columns Modify column name.
	 * @access public
	 * @since  1.0
	 */
	public function set_custom_columns( $columns ) {
		unset( $columns['date'] );
		$columns['shortcode']     = __( 'Shortcode', 'codexin-image-gallery' );
		$columns['gallery_style'] = __( 'Gallery Style', 'codexin-image-gallery' );
		$columns['date']          = __( 'Date published', 'codexin-image-gallery' );
		return $columns;
	}
	/**
	 * Class constructor.
	 *
	 * @param  string $column Modify column value.
	 * @param  int    $post_id post id.
	 * @access public
	 * @since  1.0
	 */
	public function custom_column_value( $column, $post_id ) {
		switch ( $column ) {
			case 'shortcode':
				$shortcode = '[cdxn_gallery id="' . $post_id . '"]';
				$shortcode = '<div class="tooltip"><span class="copy-button"  ><span class="tooltiptext" >Copy to clipboard</span><input class="copy_shortcode" type="text" value="' . esc_html( $shortcode ) . '" readonly></code></span></div>';
				echo wp_kses(
					$shortcode,
					array(
						'input' => array(
							'class'    => array(),
							'type'     => 'text',
							'value'    => array(),
							'disabled' => true,
							'readonly' => true,
						),
						'div'   => array(
							'class' => array(),
						),
						'span'  => array(
							'class' => array(),
						),

					)
				);
				break;
			case 'gallery_style':
				$layout      = carbon_get_post_meta( $post_id, 'cdxn_ig_layout' );
				$layout_name = '';
				if ( 'grid-layout' === $layout ) {
					$layout_name = 'Grid';
				} elseif ( 'masonry-layout' === $layout ) {
					$layout_name = 'Masonry';
				} elseif ( 'justified-layout' === $layout ) {
					$layout_name = 'Justified';
				}
				echo esc_html( $layout_name );
				break;
			default:
				break;
		}
	}
}

