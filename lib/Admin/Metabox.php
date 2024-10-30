<?php
/**
 * Metabox functionality of the plugin.
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/admin
 */

namespace Codexin\Cdxn_Gallery\Admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Codexin\Cdxn_Gallery\Common\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}


/**
 * Return Metabox.
 */
class Metabox {
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
	 * Register Metabox
	 *
	 * @return void
	 */
	public function register_metabox() {
		$this->image_upload()->gallery_settings();
	}

	/**
	 * Media upload metabox.
	 *
	 * @return object
	 */
	private function image_upload() {
		Container::make( 'post_meta', __( 'Add Images', 'codexin-image-gallery' ) )
		->where( 'post_type', '=', 'cdxn-gallery' )
		->set_classes( 'cdxn_ig_vertical_tab' )
		->add_fields(
			array(
				Field::make( 'gallery', 'cdxn_ig_media_gallery', __( '', 'codexin-image-gallery' ) )
				->set_duplicates_allowed( false )
				->set_classes( 'cdxn-ig-upload-image' ),
			)
		);

		return $this;
	}

	/**
	 * Gallery settings metabox.
	 *
	 * @return void
	 */
	private function gallery_settings() {
		Container::make( 'post_meta', __( 'Gallery Settings', 'codexin-image-gallery' ) )
			->where( 'post_type', '=', 'cdxn-gallery' )
			->add_tab( __( 'Gallery styles', 'codexin-image-gallery' ), $this->gallery_style() )
			->add_tab( __( 'Layout settings', 'codexin-image-gallery' ), $this->layout_settings() )
			->add_tab( __( 'Border settings', 'codexin-image-gallery' ), $this->border_styles() )
			->add_tab( __( 'Lightbox settings ', 'codexin-image-gallery' ), $this->lightbox_settings() )
			->add_tab( __( 'Image hover settings ', 'codexin-image-gallery' ), $this->image_settings() );
	}

	/**
	 * Gallery style
	 *
	 * @return array
	 */
	private function gallery_style() {
		$fields          = array();
		$defaults_layout = array(
			'grid-layout'      => CDXN_IG_ASSETS . '/images/grid-style.jpg',
			'masonry-layout'   => CDXN_IG_ASSETS . '/images/masonry-style.jpg',
			'justified-layout' => CDXN_IG_ASSETS . '/images/justified-style.jpg',
		);
		$layout          = apply_filters( 'cdxn_ig_gallery_layout', $defaults_layout );
		$fields[]        = Field::make( 'radio_image', 'cdxn_ig_layout', __( 'Select your gallery style', 'codexin-image-gallery' ) )
			->set_classes( 'cdxn-ig-radio-image layout-image three-col-field' )
			->set_options( $layout )
			->set_default_value( 'grid-layout' );

		return $fields;
	}

	/**
	 * General style.
	 *
	 * @return array
	 */
	private function layout_settings() {
		$fields = array();

		$fields[] = Field::make( 'select', 'cdxn_ig_column', __( 'Select number of columns in desktop (1025px or higher)', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_layout',
					'value'   => 'justified-layout',
					'compare' => '!=',
				),
			)
		)
		->set_options(
			array(
				'column-2'  => 2,
				'column-3'  => 3,
				'column-4'  => 4,
				'column-5'  => 5,
				'column-6'  => 6,
				'column-7'  => 7,
				'column-8'  => 8,
				'column-9'  => 9,
				'column-10' => 10,
				'column-11' => 11,
				'column-12' => 12,
				'column-13' => 13,
				'column-14' => 14,
				'column-15' => 15,
				'column-16' => 16,
			)
		)
		->set_classes( 'cdxn-ig-text two-col' )
		->set_default_value( 'column-5' );

		$fields[] = Field::make( 'select', 'cdxn_ig_column_tablet', __( 'Select number of columns in tablet (768px to 1024px)', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_layout',
					'value'   => 'justified-layout',
					'compare' => '!=',
				),
			)
		)
		->set_options(
			array(
				'tablet-column-2' => 2,
				'tablet-column-3' => 3,
				'tablet-column-4' => 4,
				'tablet-column-5' => 5,
				'tablet-column-6' => 6,
				'tablet-column-7' => 7,
				'tablet-column-8' => 8,
			)
		)
		->set_classes( 'cdxn-ig-text two-col' )
		->set_default_value( 'tablet-column-3' );

		$fields[] = Field::make( 'select', 'cdxn_ig_column_mobile', __( 'Select number of columns in mobile (767px or lower)', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_layout',
					'value'   => 'justified-layout',
					'compare' => '!=',
				),
			)
		)
		->set_options(
			array(
				'mobile-column-2' => 2,
				'mobile-column-3' => 3,
				'mobile-column-4' => 4,
			)
		)
		->set_classes( 'cdxn-ig-text two-col' )
		->set_default_value( 'mobile-column-2' );

		$fields[] = Field::make( 'text', 'cdxn_ig_grid_image_desktop_height', __( 'Set image height for desktop (px)', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_layout',
					'value'   => 'grid-layout',
					'compare' => '=',
				),
			)
		)
		->set_classes( 'cdxn-ig-text two-col flex-wrap justify-content-end' )
		->set_attribute( 'type', 'number' )
		->set_help_text( 'Example:200. Keep it blank to get a default height.' );

		$fields[] = Field::make( 'text', 'cdxn_ig_grid_image_tablet_height', __( 'Set image height for tablet (px)', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_layout',
					'value'   => 'grid-layout',
					'compare' => '=',
				),
			)
		)
		->set_classes( 'cdxn-ig-text two-col flex-wrap justify-content-end' )
		->set_attribute( 'type', 'number' )
		->set_help_text( 'Example:150. Keep it blank to get a default height.' );

		$fields[] = Field::make( 'text', 'cdxn_ig_grid_image_mobile_height', __( 'Set image height for Mobile (px)', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_layout',
					'value'   => 'grid-layout',
					'compare' => '=',
				),
			)
		)
		->set_classes( 'cdxn-ig-text two-col flex-wrap justify-content-end' )
		->set_attribute( 'type', 'number' )
		->set_help_text( 'Example:100. Keep it blank to get a default height.' );

		$fields[] = Field::make( 'radio', 'cdxn_ig_last_row_position', __( 'Select image alignment for the last row', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_layout',
					'value'   => 'grid-layout',
					'compare' => '=',
				),
			)
		)
		->set_options(
			array(
				'justify-content-left'   => __( 'Left', 'codexin-image-gallery' ),
				'justify-content-center' => __( 'Center', 'codexin-image-gallery' ),
				'justify-content-end'    => __( 'Right', 'codexin-image-gallery' ),
			)
		)
		->set_classes( 'cdxn-ig-radio font-medium two-col' )
		->set_default_value( 'justify-content-left' );

		$fields[] = Field::make( 'text', 'cdxn_ig_row_height', __( 'Set row height (px)', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_layout',
					'value'   => 'justified-layout',
					'compare' => '=',
				),
			)
		)
		->set_classes( 'cdxn-ig-text two-col flex-wrap justify-content-end' )
		->set_default_value( 200 )
		->set_attribute( 'type', 'number' )
		->set_help_text( 'Default Value: 200' );

		$fields[] = Field::make( 'radio', 'cdxn_ig_justify_last_row', __( 'Justify the last row', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_layout',
					'value'   => 'justified-layout',
					'compare' => '=',
				),
			)
		)
		->set_options(
			array(
				'justify'   => __( 'Yes', 'codexin-image-gallery' ),
				'nojustify' => __( 'No', 'codexin-image-gallery' ),
			)
		)
		->set_classes( 'cdxn-ig-radio font-medium two-col flex-wrap justify-content-end' )
		->set_default_value( 'justify' )
		->set_help_text( 'Setting it \'Yes\' will make the last row as justified' );

		$fields[] = Field::make( 'text', 'cdxn_ig_column_gap', __( 'Set spacing between columns (px)', 'codexin-image-gallery' ) )
		->set_classes( 'cdxn-ig-text two-col flex-wrap justify-content-end' )
		->set_default_value( 15 )
		->set_attribute( 'type', 'number' )
		->set_help_text( 'Default spacing: 15' );

		$fields = apply_filters( 'cdxn_ig_add_more_layout_settings', $fields );

		return $fields;
	}
	/**
	 * Lightbos settings
	 *
	 * @return array
	 */
	private function lightbox_settings() {
		$fields = array();

		$fields[] = Field::make( 'radio', 'cdxn_ig_image_lightbox', __( 'Enable image lightbox?', 'codexin-image-gallery' ) )
		->set_options(
			array(
				'yes' => __( 'Enable', 'codexin-image-gallery' ),
				'no'  => __( 'Disable', 'codexin-image-gallery' ),
			)
		)
		->set_classes( 'cdxn-ig-radio font-medium two-col' )
		->set_default_value( 'yes' );
		$fields[] = Field::make( 'radio', 'cdxn_ig_image_share_button', __( 'Enable share button?', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_image_lightbox',
					'value'   => 'yes',
					'compare' => '=',
				),
			)
		)
		->set_options(
			array(
				'yes' => __( 'Enable', 'codexin-image-gallery' ),
				'no'  => __( 'Disable', 'codexin-image-gallery' ),
			)
		)
		->set_classes( 'cdxn-ig-radio font-medium two-col' )
		->set_default_value( 'yes' );
		$fields[] = Field::make( 'radio', 'cdxn_ig_image_caption', __( 'Show image captions in lightbox?', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_image_lightbox',
					'value'   => 'yes',
					'compare' => '=',
				),
			)
		)
		->set_options(
			array(
				'yes' => __( 'Yes', 'codexin-image-gallery' ),
				'no'  => __( 'No', 'codexin-image-gallery' ),
			)
		)
		->set_classes( 'cdxn-ig-radio font-medium two-col' )
		->set_default_value( 'no' );

		$fields[] = Field::make( 'radio', 'cdxn_ig_image_desc', __( 'Show image descriptions in lightbox?', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_image_lightbox',
					'value'   => 'yes',
					'compare' => '=',
				),
			)
		)
		->set_options(
			array(
				'yes' => __( 'Yes', 'codexin-image-gallery' ),
				'no'  => __( 'No', 'codexin-image-gallery' ),
			)
		)
		->set_classes( 'cdxn-ig-radio font-medium two-col' )
		->set_default_value( 'no' );
		$fields  = apply_filters( 'cdxn_ig_add_more_lightbox_settings', $fields );

		return $fields;
	}

	/**
	 * Image setting for hover and others setings for image
	 *
	 * @return array
	 */
	private function image_settings() {
		$fields = array();
		// Hover icon.
		$defaults_icon = array(
			'icon-plus'       => CDXN_IG_ASSETS . '/images/icon/plus.png',
			'icon-eye'        => CDXN_IG_ASSETS . '/images/icon/eye.png',
			'icon-fullscreen' => CDXN_IG_ASSETS . '/images/icon/fullscreen.png',
			'icon-heart'      => CDXN_IG_ASSETS . '/images/icon/heart.png',
			'icon-link'       => CDXN_IG_ASSETS . '/images/icon/link.png',
			'icon-leafs'      => CDXN_IG_ASSETS . '/images/icon/plant-leafs.png',
		);
		$hover_icon    = apply_filters( 'cdxn_ig_add_more_hover_icon', $defaults_icon );

		$defaults_hover_style = array(
			'hover-normal-overlay'   => __( 'Effect 01', 'codexin-image-gallery' ),
			'hover-image-zoom'       => __( 'Effect 02', 'codexin-image-gallery' ),
			'hover-zoom-out'         => __( 'Effect 03', 'codexin-image-gallery' ),
			'hover-left-transform'   => __( 'Effect 04', 'codexin-image-gallery' ),
			'hover-square-transform' => __( 'Effect 05', 'codexin-image-gallery' ),
		);
		$hover_style          = apply_filters( 'cdxn_ig_hover_style', $defaults_hover_style );
		$fields[] = Field::make( 'radio', 'cdxn_ig_display_image_icon', __( 'Display image icon?', 'codexin-image-gallery' ) )
		->set_options(
			array(
				'yes' => __( 'Yes', 'codexin-image-gallery' ),
				'no'  => __( 'No', 'codexin-image-gallery' ),
			)
		)
		->set_classes( 'cdxn-ig-radio font-medium two-col display-image-icon' )
		->set_default_value( 'yes' );

		$fields[] = Field::make( 'radio_image', 'cdxn_ig_hover_icon', __( 'Select hover icon', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_display_image_icon',
					'value'   => 'yes',
					'compare' => '=',
				),
			)
		)
		->set_options( $hover_icon )
		->set_classes( 'cdxn-ig-radio-image two-col icon-images' )
		->set_default_value( 'icon-fullscreen' );

		$fields[] = Field::make( 'color', 'cdxn_ig_icon_color', __( 'Select icon color', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_display_image_icon',
					'value'   => 'yes',
					'compare' => '=',
				),
			)
		)
		->set_palette( array( 'white', 'black', 'brown', 'red', 'green', 'blue', 'violet', 'skyblue' ) )
		->set_alpha_enabled( true )
		->set_default_value( '#ffffff' )
		->set_classes( 'cdxn-ig-text two-col icon-color-selector' );

		$fields[] = Field::make( 'color', 'cdxn_ig_image_hover_color', __( 'Image hover color', 'codexin-image-gallery' ) )
		->set_palette( array( 'white', 'black', 'brown', 'red', 'green', 'blue', 'violet', 'skyblue' ) )
		->set_alpha_enabled( true )
		->set_default_value( '#00000066' )
		->set_classes( 'cdxn-ig-text two-col image-hover-color' );

		$fields = apply_filters( 'cdxn_ig_image_settings', $fields );

		$fields[] = Field::make( 'radio', 'cdxn_ig_hover_style', __( 'Image hover effects', 'codexin-image-gallery' ) )
		->set_options( $hover_style )
		->set_classes( 'cdxn-ig-radio font-medium two-col image-hover-effect-btn' )
		->set_default_value( 'hover-left-transform' );

		$fields = wp_parse_args( $this->image_preview(), $fields );

		return $fields;
	}
	/**
	 * Image preview.
	 *
	 * @return array
	 */
	private function image_preview() {
		$fields = array();
		$fields[] = Field::make( 'html', 'cdxn_ig_preview_html', __( '', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_hover_style',
					'value'   => 'hover-normal-overlay',
					'compare' => '=',
				),
			)
		)
		->set_html( Helpers::hovar_normar_overly( 'hover-normal-overlay' ) )
		->set_classes( 'image-preview two-col align-items-start' )
		->set_default_value( 'yes' );

		$fields[] = Field::make( 'html', 'cdxn_ig_image_zoom_preview_html', __( '', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_hover_style',
					'value'   => 'hover-image-zoom',
					'compare' => '=',
				),
			)
		)
		->set_html( Helpers::hovar_normar_overly( 'hover-image-zoom' ) )
		->set_classes( 'image-preview two-col align-items-start' )
		->set_default_value( 'yes' );

		$fields[] = Field::make( 'html', 'cdxn_ig_image_zoom_out_preview_html', __( '', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_hover_style',
					'value'   => 'hover-zoom-out',
					'compare' => '=',
				),
			)
		)
		->set_html( Helpers::hovar_normar_overly( 'hover-zoom-out' ) )
		->set_classes( 'image-preview two-col align-items-start' )
		->set_default_value( 'yes' );

		$fields[] = Field::make( 'html', 'cdxn_ig_image_hover_left_transform_preview', __( '', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_hover_style',
					'value'   => 'hover-left-transform',
					'compare' => '=',
				),
			)
		)
		->set_html( Helpers::hovar_normar_overly( 'hover-left-transform' ) )
		->set_classes( 'image-preview two-col align-items-start' )
		->set_default_value( 'yes' );

		$fields[] = Field::make( 'html', 'cdxn_ig_image_hover_square_transform_preview', __( '', 'codexin-image-gallery' ) )
		->set_conditional_logic(
			array(
				array(
					'field'   => 'cdxn_ig_hover_style',
					'value'   => 'hover-square-transform',
					'compare' => '=',
				),
			)
		)
		->set_html( Helpers::hovar_normar_overly( 'hover-square-transform' ) )
		->set_classes( 'image-preview two-col align-items-start' )
		->set_default_value( 'yes' );

		$fields = apply_filters( 'cdxn_ig_gallery_preview', $fields );

		return $fields;
	}
	/**
	 * Border settings.
	 *
	 * @return array
	 */
	private function border_styles() {
		$fields = array();

		$fields[] = Field::make( 'text', 'cdxn_ig_border_radius', __( 'Set border radius for each image (px)', 'codexin-image-gallery' ) )
		->set_classes( 'cdxn-ig-text two-col border-radius' )
		->set_default_value( '0' )
		->set_attribute( 'type', 'number' );

		$fields[] = Field::make( 'text', 'cdxn_ig_border_width', __( 'Set border size/width for each image (px)', 'codexin-image-gallery' ) )
		->set_classes( 'cdxn-ig-text two-col border-width-selector' )
		->set_default_value( 0 )
		->set_attribute( 'type', 'number' );

		$fields[] = Field::make( 'select', 'cdxn_ig_border_style', __( 'Select border style for each image', 'codexin-image-gallery' ) )
		->set_options(
			array(
				'solid'  => __( 'Solid', 'codexin-image-gallery' ),
				'dotted' => __( 'Dotted', 'codexin-image-gallery' ),
				'dashed' => __( 'Dashed', 'codexin-image-gallery' ),
				'double' => __( 'Double', 'codexin-image-gallery' ),
			)
		)
		->set_classes( 'cdxn-ig-text two-col border-style-selector' )
		->set_default_value( 'solid' );

		$fields[] = Field::make( 'color', 'cdxn_ig_border_color', __( 'Select border color for each image', 'codexin-image-gallery' ) )
		->set_alpha_enabled( true )
		->set_default_value( '#ffffff' )
		->set_classes( 'cdxn-ig-text two-col border-color-selector' );

		return $fields;
	}
	/**
	 * Register Custom Meta Box
	 *
	 * @param mixed $post_type current post type name.
	 * @return void
	 */
	public function shortcode_register_meta_box( $post_type ) {

		$types = array( CDXN_IG_POST_TYPE );

		if ( in_array( $post_type, $types, true ) ) {
			add_meta_box(
				'cdxn-ig-metabox-shortcode',
				esc_html__( 'Shortcode', 'codexin-image-gallery' ),
				array( $this, 'shortcode_meta_box_callback' ),
				$types,
				'side',
				'low'
			);
		}

	}

	/**
	 * Add shortcode field
	 *
	 * @param object $post Post Object.
	 * @return void
	 */
	public function shortcode_meta_box_callback( $post ) {
		$outline   = '';
		$shortcode = '[cdxn_gallery id="' . $post->ID . '"]';
		$before    = esc_html__( 'Click to copy the shortcode', 'codexin-image-gallery' );
		$after     = esc_html__( 'Copy and paste this shortcode inside your WordPress Post, Pages and widgets.', 'codexin-image-gallery' );
		$outline   = '<div class="cdxn-ig-tooltip"><div class="tooltip-before">' . $before . '</div><div class="tooltip"><span class="copy-button"><span class="tooltiptext" >' . __( 'Copy to clipboard', 'codexin-image-gallery' ) . '</span><input class="copy_shortcode" type="text" value="' . esc_attr( $shortcode ) . '" readonly></code></span></div><div class="tooltip-before">' . $after . '</div></div>';

		echo wp_kses(
			$outline,
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
	}
}

