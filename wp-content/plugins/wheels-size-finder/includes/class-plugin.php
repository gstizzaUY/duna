<?php
/**
 * Main plugin bootstrap class.
 *
 * @package WheelsSizeFinder
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once WSF_PLUGIN_DIR . 'includes/class-api.php';
require_once WSF_PLUGIN_DIR . 'includes/class-license.php';
require_once WSF_PLUGIN_DIR . 'includes/class-assets.php';
require_once WSF_PLUGIN_DIR . 'includes/class-shortcode.php';
require_once WSF_PLUGIN_DIR . 'includes/class-woocommerce.php';
require_once WSF_PLUGIN_DIR . 'includes/class-admin.php';

class Wheels_Size_Finder_Plugin {

    private static $instance = null;

    public $api;
    public $license;
    public $assets;
    public $shortcode;
    public $woocommerce;
    public $admin;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'init', array( $this, 'maybe_upgrade' ) );
        add_action( 'admin_notices', array( $this, 'check_requirements' ) );
    }

    public function init() {
        if ( ! $this->meets_requirements() ) {
            return;
        }

        $this->api         = new Wheels_Size_Finder_API();
        $this->license     = new Wheels_Size_Finder_License();
        $this->assets      = new Wheels_Size_Finder_Assets();
        $this->woocommerce = new Wheels_Size_Finder_WooCommerce();
        $this->shortcode   = new Wheels_Size_Finder_Shortcode( $this->api, $this->license, $this->woocommerce );
        $this->admin       = new Wheels_Size_Finder_Admin( $this->api, $this->license, $this->shortcode, $this->assets );

        load_plugin_textdomain( 'wheels-size-finder', false, dirname( WSF_PLUGIN_BASENAME ) . '/languages' );
    }

    public static function activate() {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        $defaults = array(
            'wsf_api_url'             => '',
            'wsf_search_mode'         => 'tire',
            'wsf_title'               => '',
            'wsf_title_tag'           => 'h2',
            'wsf_title_classes'       => '',
            'wsf_primary_color'       => '',
            'wsf_accent_color'        => '',
            'wsf_button_bg'           => '',
            'wsf_button_text'         => '',
            'wsf_bg_color'            => '',
            'wsf_card_bg'             => '',
            'wsf_input_bg'            => '',
            'wsf_text_color'          => '',
            'wsf_label_color'         => '',
            'wsf_border_color'        => '',
            'wsf_font_family'         => '',
            'wsf_input_font_size'     => '',
            'wsf_input_border_radius' => '6',
            'wsf_input_padding'       => '12',
            'wsf_redirect'            => '',
            'wsf_per_page'            => '12',
        );

        if ( ! get_option( WSF_SETTINGS_OPTION ) ) {
            add_option( WSF_SETTINGS_OPTION, $defaults );
        }
    }

    /**
     * Upgrade routine: migrates sites that still use the old dark-theme
     * defaults so they inherit the active theme styles instead.
     */
    public function maybe_upgrade() {
        if ( get_option( 'wsf_version' ) === WSF_VERSION ) {
            return;
        }

        $settings = get_option( WSF_SETTINGS_OPTION, array() );

        if ( is_array( $settings ) ) {
            $legacy_defaults = array(
                'wsf_primary_color' => '#3fb950',
                'wsf_accent_color'  => '#58a6ff',
                'wsf_button_bg'     => '#238636',
                'wsf_button_text'   => '#ffffff',
                'wsf_bg_color'      => '#0f1117',
                'wsf_card_bg'       => '#161b22',
                'wsf_input_bg'      => '#0d1117',
                'wsf_text_color'    => '#e1e4e8',
                'wsf_border_color'  => '#30363d',
            );

            $changed = false;
            foreach ( $legacy_defaults as $key => $value ) {
                if ( isset( $settings[ $key ] ) && $settings[ $key ] === $value ) {
                    $settings[ $key ] = '';
                    $changed          = true;
                }
            }

            if ( $changed ) {
                update_option( WSF_SETTINGS_OPTION, $settings );
            }
        }

        update_option( 'wsf_version', WSF_VERSION );
    }

    public static function deactivate() {
        wp_clear_scheduled_hook( 'wsf_license_check' );
    }

    private function meets_requirements() {
        global $wp_version;

        if ( version_compare( PHP_VERSION, WSF_MINIMUM_PHP_VERSION, '<' ) ) {
            return false;
        }

        if ( version_compare( $wp_version, WSF_MINIMUM_WP_VERSION, '<' ) ) {
            return false;
        }

        return true;
    }

    public function check_requirements() {
        global $wp_version;

        if ( version_compare( PHP_VERSION, WSF_MINIMUM_PHP_VERSION, '<' ) ) {
            echo '<div class="notice notice-error"><p>';
            printf(
                esc_html__( 'Wheels Size Finder requiere PHP %s o superior. Tu versión actual es %s.', 'wheels-size-finder' ),
                esc_html( WSF_MINIMUM_PHP_VERSION ),
                esc_html( PHP_VERSION )
            );
            echo '</p></div>';
        }

        if ( version_compare( $wp_version, WSF_MINIMUM_WP_VERSION, '<' ) ) {
            echo '<div class="notice notice-error"><p>';
            printf(
                esc_html__( 'Wheels Size Finder requiere WordPress %s o superior.', 'wheels-size-finder' ),
                esc_html( WSF_MINIMUM_WP_VERSION )
            );
            echo '</p></div>';
        }

        if ( ! class_exists( 'WooCommerce' ) ) {
            echo '<div class="notice notice-warning"><p>';
            esc_html_e( 'Wheels Size Finder: WooCommerce no esta instalado. La busqueda de productos no funcionara.', 'wheels-size-finder' );
            echo '</p></div>';
        }
    }
}
