<?php
/**
 * Frontend functionality.
 *
 * @package Frontend.
 */

namespace Codexin\Cdxn_Gallery\Frontend;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Gallery_Frontend
 */
class Gallery_Frontend {

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
	 * Photoswipe footer script
	 *
	 * @return void
	 */
	public function photoswipe_footer_script() {
		if ( has_shortcode( get_the_content(), 'cdxn_gallery' ) ) {
			?>
		<!-- Root element of PhotoSwipe. Must have class pswp. -->
		<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
			<!-- Background of PhotoSwipe. It's a separate element, as animating opacity is faster than rgba(). -->
			<div class="pswp__bg"></div>
			<!-- Slides wrapper with overflow:hidden. -->
			<div class="pswp__scroll-wrap cdxn-popups-wrapper">
				<!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
				<!-- don't modify these 3 pswp__item elements, data is added later on. -->
				<div class="pswp__container">
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
				</div>
				<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
				<div class="pswp__ui pswp__ui--hidden">
					<div class="pswp__top-bar">
						<!-- Controls are self-explanatory. Order can be changed. -->
						<div class="pswp__counter"></div>
						<button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
						<button class="pswp__button pswp__button--share" title="Share"></button>
						<button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
						<button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
						<!-- element will get class pswp__preloader-active when preloader is running -->
						<div class="pswp__preloader">
							<div class="pswp__preloader__icn">
								<div class="pswp__preloader__cut">
									<div class="pswp__preloader__donut"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
						<div class="pswp__share-tooltip"></div>
					</div>
					<button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
					</button>
					<button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
					</button>
					<div class="pswp__caption">
						<div class="pswp__caption__center"></div>
					</div>
				</div>
			</div>
		</div>
			<?php
		}
	}

	/**
	 *  Disable Lightbox with PhotoSwipe on WooCommerce product pages
	 *
	 * @param [type] $enabled lightbox return true.
	 * @param [type] $id post id.
	 * @return boolean
	 */
	public function lbwps_enabled( $enabled, $id ) {
		if ( has_shortcode( get_the_content(), 'cdxn_gallery' ) ) {
			return false;
		}
		return $enabled;
	}


}
