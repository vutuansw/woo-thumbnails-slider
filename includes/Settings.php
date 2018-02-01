<?php

/**
 * Settings
 *
 * @author      WeDesignWeBuild
 * @package     WTS
 * @since     1.0
 */

namespace WTS;

/**
 * Settings Thumbnails Slider.
 */
class Settings extends \WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id = 'wts';
		$this->label = esc_html__( 'Thumbnails Slider', 'woo-thumbnails-slider' );

		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings() {

		$settings = apply_filters( 'wts_settings', array(
			array(
				'title' => esc_html__( 'Thumbnails slider', 'woo-thumbnails-slider' ),
				'type' => 'title',
				'desc' => esc_html__( 'Settings for the single product gallery slider.', 'woo-thumbnails-slider' ),
				'id' => 'wts_settings',
			),
			array(
				'title' => esc_html__( 'Thumbnails Size', 'woo-thumbnails-slider' ),
				'id' => 'wts_thumbnails_size',
				'default' => 100,
				'type' => 'text',
				'desc_tip' => true,
			),
			array(
				'title' => __( 'Thumbnails Margin', 'woo-thumbnails-slider' ),
				'id' => 'wts_thumbnails_margin',
				'default' => 5,
				'type' => 'text',
				'desc_tip' => true,
			),
			array(
				'title' => esc_html__( 'Image Zoom', 'woo-thumbnails-slider' ),
				'id' => 'wts_image_zoom',
				'default' => 'yes',
				'type' => 'checkbox',
				'desc'=> esc_html__( 'Enable image zoom effect in large image, disable to use popup.','woo-thumbnails-slider')
			),
			array(
				'title' => esc_html__( 'Direction Nav', 'woo-thumbnails-slider' ),
				'id' => 'wts_direction_nav',
				'default' => 'yes',
				'type' => 'checkbox',
				'desc' => esc_attr__( 'Enable previous/next arrow navigation.', 'woo-thumbnails-slider' )
			),
			array(
				'title' => esc_html__( 'Pagination Nav', 'woo-thumbnails-slider' ),
				'id' => 'wts_pagination_nav',
				'default' => 'no',
				'type' => 'checkbox',
				'desc'=> esc_html__( 'Enable pagination navigation','woo-thumbnails-slider')
			),
			
			array( 'type' => 'sectionend', 'id' => 'wts_settings_end' ),
				) );

		return apply_filters( 'wts_get_settings_' . $this->id, $settings );
	}

	/**
	 * Save settings.
	 */
	public function save() {

		$settings = $this->get_settings();

		\WC_Admin_Settings::save_fields( $settings );
	}

}