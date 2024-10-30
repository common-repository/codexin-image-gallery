<?php
/**
 * Create Gallery_Field
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/includes
 */

namespace Carbon_Field_Gallery;

use Carbon_Fields\Field\Media_Gallery_Field;
/**
 * Gallery_Field
 */
class Gallery_Field extends Media_Gallery_Field {
	/**
	 * Prepare the field type for use.
	 * Called once per field type when activated.
	 *
	 * @static
	 * @access public
	 *
	 * @return void
	 */
	public static function field_type_activated() {
		$dir    = \Carbon_Field_Gallery\DIR . '/languages/';
		$locale = get_locale();
		$path   = $dir . $locale . '.mo';
		load_textdomain( 'carbon-field-gallery', $path );
	}

	/**
	 * Enqueue scripts and styles in admin.
	 * Called once per field type.
	 *
	 * @static
	 * @access public
	 *
	 * @return void
	 */
	public static function admin_enqueue_scripts() {
		$root_uri = \Carbon_Fields\Carbon_Fields::directory_to_url( \Carbon_Field_Gallery\DIR );

		// Enqueue field styles.
		wp_enqueue_style( 'carbon-field-gallery', $root_uri . '/build/bundle.min.css' );

		// Enqueue field scripts.
		wp_enqueue_script( 'carbon-field-gallery', $root_uri . '/build/bundle.min.js', array( 'carbon-fields-core' ) );

		wp_localize_script(
			'carbon-field-gallery',
			'admin_js_obj',
			array(
				'admin_url' => admin_url( '/' ),
			)
		);
	}
}
