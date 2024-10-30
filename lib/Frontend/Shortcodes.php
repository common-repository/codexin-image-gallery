<?php
/**
 * Shortcode functionality
 *
 * @package  shortcode
 */

namespace Codexin\Cdxn_Gallery\Frontend;

use Codexin\Cdxn_Gallery\Common\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Redister shortcode
 */
class Shortcodes {

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
	 * SHortcode Function Registered here
	 *
	 * @return void
	 */
	public function shortcode_list() {
		$shortcodes = array(
			'cdxn_gallery',
		);

		foreach ( $shortcodes as $shortcode ) :
			add_shortcode( $shortcode, array( $this, $shortcode . '_shortcode' ) );
		endforeach;
	}

	/**
	 * Photo gallery shortcode
	 *
	 * @param array  $atts Shortcode attributes.
	 * @param string $content shortcode content.
	 * @return mixed
	 */
	public function cdxn_gallery_shortcode( $atts, $content = null ) {

		$ngatts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts
		);
		$id     = $ngatts['id'];
		$result = '';
		if ( ! empty( $id ) ) {
			wp_dequeue_script( 'cdxn-ig-activation' );
			$ids = explode( ',', $id );
			ob_start();
			$args = array(
				'post_type'      => CDXN_IG_POST_TYPE,
				'posts_per_page' => -1,
				'orderby'        => 'post__in',
				'post__in'       => $ids,
			);
			$loop = new \WP_Query( $args ); ?>
			<?php if ( $loop->have_posts() ) : ?>
				<?php
				while ( $loop->have_posts() ) :
					$loop->the_post();
					$this->render_content();
				endwhile;
				?>
				<?php
			endif;
			\wp_reset_postdata();
			wp_enqueue_script( 'cdxn-ig-vendorjs' );
			wp_enqueue_script( 'cdxn-ig-activation' );
			$result .= ob_get_clean();
		}
		return $result;
	}
	/**
	 * Retunr column number.
	 *
	 * @param   string $column_number shortcode column number.
	 * @param   int    $post_id Post id.
	 * @return  int
	 */
	private function column_number( $column_number = 0, $post_id ) {
		$number = 4; // default.
		if ( 'column-6' === $column_number ) {
			$number = 6;
		} elseif ( 'column-5' === $column_number ) {
			$number = 5;
		} elseif ( 'column-4' === $column_number ) {
			$number = 4;
		} elseif ( 'column-3' === $column_number ) {
			$number = 3;
		} elseif ( 'column-2' === $column_number ) {
			$number = 2;
		}
		return $number;
	}

	/**
	 * Retunr column number.
	 *
	 * @return mixed
	 */
	public function render_content() {
		$images                     = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_media_gallery' );
		$layout                     = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_layout' );
		$column                     = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_column' );
		$column_gap                 = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_column_gap' );
		$border_width               = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_border_width' );
		$border_style               = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_border_style' );
		$border_color               = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_border_color' );
		$hover_style                = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_hover_style' );
		$hover_icon                 = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_hover_icon' );
		$border_radius              = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_border_radius' );
		$column_tablet              = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_column_tablet' );
		$column_mobile              = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_column_mobile' );
		$image_caption              = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_image_caption' );
		$image_desc                 = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_image_desc' );
		$image_lightbox             = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_image_lightbox' );
		$row_height                 = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_row_height' );
		$justify_last_row           = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_justify_last_row' );
		$image_mobile_height        = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_grid_image_mobile_height' );
		$image_tablet_height        = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_grid_image_tablet_height' );
		$image_desktop_height       = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_grid_image_desktop_height' );
		$grid_last_row_position     = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_last_row_position' );
		$icon_color                 = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_icon_color' );
		$cdxn_ig_display_image_icon = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_display_image_icon' );
		$image_hover_color          = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_image_hover_color' );
		$image_share_button         = carbon_get_post_meta( get_the_ID(), 'cdxn_ig_image_share_button' );

		$column_gap               = ( '0' <= $column_gap ) ? $column_gap : '15';
		$grid_column              = $this->column_number( $column, get_the_ID() );
		$gallery_additional_style = array(
			'column_gap'          => $column_gap,
			'border_width'        => $border_width ? $border_width . 'px' : '0px',
			'border_style'        => $border_style ? $border_style : 'solid',
			'border_color'        => $border_color ? Helpers::crb_hex_to_rgba( $border_color ) : 'transparent',
			'icon_color'          => $icon_color ? Helpers::crb_hex_to_rgba( $icon_color ) : 'transparent',
			'image_hover_color'   => $image_hover_color ? Helpers::crb_hex_to_rgba( $image_hover_color ) : 'transparent',
			'grid_column'         => $grid_column,
			'layout'              => $layout,
			'grid_desktop_height' => $image_desktop_height,
			'grid_tablet_height'  => $image_tablet_height,
			'grid_mobile_height'  => $image_mobile_height,
			'border_radius'       => $border_radius ? $border_radius : '',
			'share_button'        => 'no' === $image_share_button ? false : true,
		);

		$image_size = 'cdxn-ig-image-square';
		$hover_icon = ( 'yes' === $cdxn_ig_display_image_icon ) ? $hover_icon : 'no-icon';
		$classes    = array(
			'cdxn-ig-thumb-wrapper',
			$layout,
			$hover_icon ? 'has-icon hover-' . $hover_icon : '',
			$hover_style ? 'hover-default-overlay ' . $hover_style : '',
			'yes' === $image_lightbox ? 'lightbox-enable' : '',
		);

		/**
		* Mesonary pggd automatic loade imageloded plugin.
		*/
		if ( 'masonry-layout' === $layout ) {
			$image_size = 'full';
			wp_enqueue_script( 'cdxn-ig-masonry-pkgd' );
		}
		if ( 'justified-layout' === $layout ) {
			$column_mobile                          = '';
			$column_tablet                          = '';
			$column                                 = '';
			$image_size                             = 'full';
			$gallery_additional_style['row_height'] = $row_height ? $row_height : 200;
			$gallery_additional_style['last_row']   = $justify_last_row ? $justify_last_row : 'justify';
			wp_enqueue_script( 'cdxn-ig-justified-gallery' );
		}

		if ( 'justified-layout' !== $layout ) {
			$classes[] = $column_tablet;
			$classes[] = $column_mobile;
			$classes[] = $column;
			$classes[] = 'd-flex';
		}

		if ( 'grid-layout' === $layout ) {
			$classes[] = $grid_last_row_position;
		}

		$post_classes = get_post_class( $classes );
		$link_class   = array();

		$more_additional_style    = apply_filters( 'cdxn_ig_add_more_additional_style', array() );
		$gallery_additional_style = wp_parse_args( $more_additional_style, $gallery_additional_style );
		echo '<div class="cdxn-ig-container" data-gallery="' . \esc_attr( \wp_json_encode( $gallery_additional_style ) ) . '"><div  class="' . \esc_attr( implode( ' ', $post_classes ) ) . '" >';
		if ( $images ) {
			foreach ( $images as $image_id ) {
				$image     = \wp_get_attachment_image_src( $image_id, 'full' );
				$popup_url = $image[0];
				$im_width  = $image[1];
				$im_height = $image[2];
				if ( 1 > $im_width || 1 > $im_height ) {
					list( $width, $height, $type, $attr ) = getimagesize( $popup_url );
					$im_width                             = $width;
					$im_height                            = $height;
				}
				$attachment = get_post( $image_id );

				$caption     = ! empty( $attachment->post_excerpt ) ? $attachment->post_excerpt : '';
				$description = ! empty( $attachment->post_content ) ? $attachment->post_content : '';

				?>
				<figure class="cdxn-thumb-single" >
					<div class="cdxn-ig-content-wraper">
						<a class="<?php echo 'no' === $image_lightbox ? 'no-lightbox' : 'cdxn-ig-lightbox'; ?>" href="<?php echo esc_attr( wp_get_attachment_url( $image_id ) ); ?>" data-src="<?php echo esc_attr( wp_get_attachment_url( $image_id ) ); ?>" data-size="<?php echo esc_attr( $im_width ) . 'x' . esc_attr( $im_height ); ?>"
						<?php echo did_action( 'elementor/loaded' ) ? ' data-elementor-open-lightbox="no" ' : ''; ?>
						>
							<?php if ( 'yes' === $cdxn_ig_display_image_icon && $hover_icon ) { ?>
								<i class="cdxn-ig-icon <?php echo esc_attr( $hover_icon ); ?>"></i>
							<?php } ?>

							<?php if ( 'grid-layout' === $layout ) { ?>
								<div class="grid-wraper" data-size="<?php echo esc_attr( $im_width ) . 'x' . esc_attr( $im_height ); ?>"></div>
							<?php } ?>
							<?php
							if ( 'grid-layout' !== $layout ) {
								echo \wp_get_attachment_image( $image_id, $image_size );
							}
							?>
						</a>
						<?php
						if ( ( 'yes' === $image_caption ) || 'yes' === $image_desc ) {
							if ( ! empty( $caption ) || ! empty( $description ) ) {
								?>
								<figcaption>
									<?php
									if ( 'yes' === $image_caption ) {
										echo '<span class="cdxn-ig-caption">' . esc_html( $caption ) . '</span>';
									}
									if ( 'yes' === $image_desc ) {
										echo '<span class="cdxn-ig-caption">';
											echo wp_kses(
												$description,
												array(
													'a'    => array(
														'href'   => array(),
														'title'  => array(),
														'target' => array(),
													),
													'br'   => array(),
													'em'   => array(),
													'strong' => array(),
													'blockquote' => array(),
													'del'  => array(
														'datetime' => array(),
													),
													'ins'  => array(
														'datetime' => array(),
													),
													'img'  => array(
														'src' => array(),
														'alt' => array(),
													),
													'ul'   => array(),
													'ol'   => array(),
													'li'   => array(),
													'code' => array(),
												)
											);
										echo '</span>';
									}

									?>
								</figcaption>
								<?php
							}
						}
						?>
					</div>

				</figure>
				<?php
			}
		} // End if
		echo '</div></div>';

	}


}
