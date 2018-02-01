<?php
/**
 * Plugin Name: WooCommerce Thumbnails Slider    
 * Plugin URI: https://wordpress.org/plugins/woo-thumbnails-slider
 * Description: Product images slider for thumbnails image navigator in detail product page.
 * Version: 1.0.2
 * Author: WeDesignWeBuild
 * Author URI: https://profiles.wordpress.org/wedesignwebuild
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Requires at least: 4.5
 * Tested up to: 4.9
 * 
 * WC requires at least: 2.6.0
 * WC tested up to: 3.3.0
 * 
 * Text Domain: woo-thumbnails-slider
 * Domain Path: /languages/
 *
 * @package WTS
 */

/**
 * First, we need autoload via Composer to make everything works.
 */
require trailingslashit( __DIR__ ) . '/vendor/autoload.php';

/**
 * Include function files
 */
define( 'WTS_VER', '1.0.2' );
define( 'WTS_URL', plugin_dir_url( __FILE__ ) );
define( 'WTS_DIR', plugin_dir_path( __FILE__ ) );
define( 'WTS_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Make WTS\\WTS as WooThumnailsSlider alias.
 */
class_alias( 'WTS\\WTS', 'WTS' );

/**
 * Init Plugin
 */
$GLOBALS['woo_thumbnails_slider'] = new WTS();
