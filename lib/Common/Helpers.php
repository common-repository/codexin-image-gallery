<?php
/**
 * ALl helpers function's are here
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
 * Helper functions all are static function
 */
class Helpers {

	/**
	 * Helper function to convert hex color to RGBA
	 *
	 * @param   string $hex_color     The color code in hexadecimal.
	 * @return  string
	 * @since   v1.0
	 */
	public static function crb_hex_to_rgba( $hex_color ) {
		$hex_color = carbon_hex_to_rgba( $hex_color );
		$rgba      = 'rgba(' . $hex_color['red'] . ',' . $hex_color['green'] . ',' . $hex_color['blue'] . ',' . $hex_color['alpha'] . ')';
		return $rgba;
	}

	/**
	 * Border settings.
	 *
	 * @param   string $overly overly style class.
	 * @return mixed
	 */
	public static function hovar_normar_overly( $overly = '' ) {
		ob_start() ?>
		<div class="cdxn-ig-container">
			<h3><?php echo esc_html__( 'Image hover preview', 'codexin-image-gallery' ); ?></h3>
			<div class="cdxn-ig-thumb-wrapper has-icon column-1 d-flex   hover-default-overlay <?php echo esc_attr( $overly ); ?> " >
				<figure class="cdxn-thumb-single">
					<div class="cdxn-ig-content-wraper">
						<a class="">
							<i class="cdxn-ig-icon icon-plus"></i>
							<div class="grid-wraper" style="background-image: url(<?php echo esc_url( CDXN_IG_ASSETS . '/images/photo-23.jpg' ); ?>); background-size: cover; background-position: center center; padding-top: 80%;"></div>
						</a>
					</div>
				</figure>

			</div>
		</div>
		<?php
		return \ob_get_clean();
	}

}
