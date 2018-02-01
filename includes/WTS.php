<?php

/**
 * WooThumbnailsSlider Class
 *
 * @package     WTS
 * @author      WeDesignWeBuild
 * @license     GPLv3
 *
 * @since 1.0.0
 */

namespace WTS;

class WTS {

	public function __construct() {

		add_action( 'admin_init', array( $this, 'activation' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
		add_filter( 'woocommerce_single_product_carousel_options', array( $this, 'carouselOptions' ) );
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'settings' ) );
		add_filter( 'woocommerce_single_product_zoom_enabled', array( $this, 'zoomEnabled' ) );
		add_filter( 'plugin_action_links_' . WTS_BASENAME, array( $this, 'addActionLinks' ) );
		add_action( 'after_setup_theme', array( $this, 'setupTheme' ) );
	}
	
	/**
	 * Add theme support woocommrece gallery
	 * @since 1.0.1
	 */
	public function setupTheme() {
		
		if ( !current_theme_supports( 'wc-product-gallery-zoom' ) ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}
		if ( !current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
		}
		if ( !current_theme_supports( 'wc-product-gallery-slider' ) ) {
			add_theme_support( 'wc-product-gallery-slider' );
		}
		
	}

	/**
	 * WooCommerce Admin Settings
	 */
	public function settings( $pages ) {

		$pages[] = new Settings();

		return $pages;
	}

	/**
	 * Modify zoom enabled
	 */
	public function zoomEnabled( $value ) {
		return get_option( 'wts_image_zoom', 1 ) == 'yes';
	}

	/**
	 * Modify product carousel options
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function carouselOptions( $options ) {

		$options['directionNav'] = false;
		$options['slideshow'] = false;
		$options['controlNav'] = false;
		$options['animation'] = 'slide';

		return $options;
	}

	/**
	 * Front-end enqueue scripts
	 */
	public function enqueueScripts() {

		if ( is_singular( 'product' ) ) {
			$min = WP_DEBUG ? '' : '.min';
			add_action( 'woocommerce_product_thumbnails', array( $this, 'controlNav' ) );
			wp_enqueue_script( 'wts', WTS_URL . 'assets/js/wts' . $min . '.js', array( 'jquery' ), true );
			wp_enqueue_style( 'wts', WTS_URL . 'assets/css/styles' . $min . '.css' );
		}
	}

	/**
	 * Display Control nav
	 */
	public function controlNav() {

		global $product;

		$attachment_ids = $product->get_gallery_image_ids();

		if ( has_post_thumbnail() ) {
			$thumbnail_id = array( get_post_thumbnail_id() );
			$attachment_ids = array_merge( $thumbnail_id, $attachment_ids );
		}

		$options = apply_filters( 'wts_control_nav_options', array(
			'animation' => 'slide',
			'controlNav' => get_option( 'wts_pagination_nav', 'no' ) == 'yes' ? true : false,
			'directionNav' => get_option( 'wts_direction_nav', 'yes' ) == 'yes' ? true : false,
			'animationLoop' => false,
			'slideshow' => false,
			'itemWidth' => absint( get_option( 'wts_thumbnails_size', 100 ) ),
			'itemMargin' => absint( get_option( 'wts_thumbnails_margin', 5 ) ),
			'asNavFor' => '.woocommerce-product-gallery'
				) );

		if ( $attachment_ids && has_post_thumbnail() ) {

			$html = '<div class="wts_control_nav" data-options="' . esc_attr( json_encode( $options ) ) . '">';
			$html .= '<ul class="slides flex-control-nav">';

			foreach ( $attachment_ids as $attachment_id ) {

				$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
				$attributes = array(
					'title' => get_post_field( 'post_title', $attachment_id ),
					'data-caption' => get_post_field( 'post_excerpt', $attachment_id ),
					'data-src' => $full_size_image[0],
					'data-large_image' => $full_size_image[0],
					'data-large_image_width' => $full_size_image[1],
					'data-large_image_height' => $full_size_image[2],
				);

				$html .= '<li class="wts_control_nav__item">';
				$html .= wp_get_attachment_image( $attachment_id, 'shop_thumbnail', false, $attributes );
				$html .= '</li>';
			}

			$html .= '</ul></div>';

			echo apply_filters( 'wts_thumbnails_html', $html, $attachment_ids );
		}
	}

	/**
	 * Activation function fires when the plugin is activated.
	 *
	 * @since 1.0
	 * @return void
	 */
	public function activation() {
		if ( !class_exists( '\WooCommerce' ) ) {
			// is this plugin active?
			if ( is_plugin_active( WTS_BASENAME ) ) {
				// unset activation notice
				unset( $_GET['activate'] );
				// display notice
				add_action( 'admin_notices', array( $this, 'admin_notices' ) );
			}
		}
	}

	/**
	 * Admin notices
	 * @since 1.0
	 * @return void
	 */
	public function admin_notices() {
		echo '<div class="notice notice-warning"><p>';
		echo wp_kses_post( __( '<strong>WooCommerce</strong> Plugin should be activated to enable WooCommerce Thumbnails Slider.', 'woo-thumbnails-slider' ) );
		echo '</p></div>';
	}

	/**
	 * Add setting link
	 * @return array
	 */
	public function addActionLinks( $links ) {

		if ( !class_exists( '\WooCommerce' ) ) {
			return $links;
		}

		$plugin_links = array(
			'page' => '<a href="' . esc_url( apply_filters( 'wts_settings_page_url', admin_url( 'admin.php?page=wc-settings&tab=wts' ) ) ) . '" aria-label="' . esc_attr__( 'Settings', 'woo-thumbnails-slider' ) . '">' . esc_html__( 'Settings', 'woo-thumbnails-slider' ) . '</a>',
		);

		return array_merge( $links, $plugin_links );
	}

}
