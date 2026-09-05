<?php
/**
 * Plugin Name: Wheels Size Finder
 * Plugin URI: https://wheelsfinder.com
 * Description: Buscador profesional de neumaticos por vehiculo o por medidas. Se integra con WooCommerce para encontrar productos por SKU.
 * Version: 1.6.7
 * Author: Wheels
 * Author URI: https://wheelsfinder.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wheels-size-finder
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * WC requires at least: 7.0
 * WC tested up to: 9.0
 *
 * @package WheelsSizeFinder
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WSF_VERSION', '1.6.7' );
define( 'WSF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WSF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WSF_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'WSF_MINIMUM_WP_VERSION', '6.0' );
define( 'WSF_MINIMUM_PHP_VERSION', '7.4' );
define( 'WSF_LICENSE_OPTION', 'wsf_license_key' );
define( 'WSF_LICENSE_STATUS', 'wsf_license_status' );
define( 'WSF_SETTINGS_OPTION', 'wsf_settings' );

require_once WSF_PLUGIN_DIR . 'includes/class-plugin.php';

register_activation_hook( __FILE__, array( 'Wheels_Size_Finder_Plugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Wheels_Size_Finder_Plugin', 'deactivate' ) );

Wheels_Size_Finder_Plugin::instance();
