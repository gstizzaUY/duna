<?php
/**
 * Asset enqueuing and dynamic CSS generation.
 *
 * @package WheelsSizeFinder
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Wheels_Size_Finder_Assets {

    private $js_src  = 'assets/js/wheels-finder.js';
    private $css_src = 'assets/css/wheels-finder.css';

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
    }

    public function enqueue() {
        if ( is_admin() ) {
            return;
        }

        $settings = get_option( WSF_SETTINGS_OPTION, array() );

        wp_enqueue_style(
            'wheels-size-finder',
            WSF_PLUGIN_URL . $this->css_src,
            array(),
            WSF_VERSION . '-' . substr( md5( serialize( $settings ) ), 0, 8 )
        );

        wp_add_inline_style( 'wheels-size-finder', $this->build_dynamic_css( $settings ) );

        wp_enqueue_script(
            'wheels-size-finder',
            WSF_PLUGIN_URL . $this->js_src,
            array( 'jquery' ),
            WSF_VERSION,
            true
        );

        wp_localize_script( 'wheels-size-finder', 'wsfData', array(
            'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
            'apiUrl'      => isset( $settings['wsf_api_url'] ) ? untrailingslashit( $settings['wsf_api_url'] ) : '',
            'searchMode'  => isset( $settings['wsf_search_mode'] ) ? $settings['wsf_search_mode'] : 'tire',
            'redirectUrl' => isset( $settings['wsf_redirect'] ) ? $settings['wsf_redirect'] : '',
            'perPage'     => isset( $settings['wsf_per_page'] ) ? absint( $settings['wsf_per_page'] ) : 12,
            'i18n'        => array(
                'select'         => __( 'Seleccionar', 'wheels-size-finder' ),
                'loading'        => __( 'Cargando...', 'wheels-size-finder' ),
                'searchProducts' => __( 'Buscar productos', 'wheels-size-finder' ),
                'noResults'      => __( 'Sin resultados', 'wheels-size-finder' ),
                'error'          => __( 'Error al conectar con el servidor', 'wheels-size-finder' ),
                'prev'           => __( 'Anterior', 'wheels-size-finder' ),
                'next'           => __( 'Siguiente', 'wheels-size-finder' ),
                'page'           => __( 'Pagina', 'wheels-size-finder' ),
                'of'             => __( 'de', 'wheels-size-finder' ),
                'addToCart'      => __( 'Agregar al carrito', 'wheels-size-finder' ),
                'outOfStock'     => __( 'Sin stock', 'wheels-size-finder' ),
                'inStock'        => __( 'En stock', 'wheels-size-finder' ),
            ),
        ) );
    }

    /**
     * Returns the CSS custom properties (name => value) derived from settings.
     * Empty/inherited values are omitted.
     *
     * @param array $settings Plugin settings.
     * @return array
     */
    public function get_style_vars( $settings ) {
        $color_map = array(
            'wsf_primary_color' => '--wsf-primary',
            'wsf_bg_color'      => '--wsf-bg',
            'wsf_card_bg'       => '--wsf-card',
            'wsf_text_color'    => '--wsf-text',
            'wsf_label_color'   => '--wsf-label',
            'wsf_border_color'  => '--wsf-border',
            'wsf_input_bg'      => '--wsf-input',
            'wsf_option_bg'     => '--wsf-option-bg',
            'wsf_option_text'   => '--wsf-option-text',
            'wsf_arrow_color'   => '--wsf-arrow',
            'wsf_result_color'  => '--wsf-result-color',
            'wsf_button_bg'     => '--wsf-btn-bg',
            'wsf_button_text'   => '--wsf-btn-text',
            'wsf_button_hover'  => '--wsf-btn-hover',
            'wsf_button_border' => '--wsf-btn-border',
            'wsf_accent_color'  => '--wsf-accent',
            'wsf_font_family'   => '--wsf-font',
        );

        $vars = array();

        foreach ( $color_map as $key => $var ) {
            if ( ! empty( $settings[ $key ] ) ) {
                $vars[ $var ] = $settings[ $key ];
            }
        }

        if ( ! empty( $settings['wsf_input_font_size'] ) ) {
            $vars['--wsf-input-font-size'] = absint( $settings['wsf_input_font_size'] ) . 'px';
        }

        if ( isset( $settings['wsf_input_border_radius'] ) && '' !== $settings['wsf_input_border_radius'] ) {
            $vars['--wsf-radius'] = absint( $settings['wsf_input_border_radius'] ) . 'px';
        }

        if ( isset( $settings['wsf_input_padding'] ) && '' !== $settings['wsf_input_padding'] ) {
            $vars['--wsf-input-pad'] = absint( $settings['wsf_input_padding'] ) . 'px';
        }

        if ( isset( $settings['wsf_result_size'] ) && '' !== $settings['wsf_result_size'] ) {
            $vars['--wsf-result-size'] = absint( $settings['wsf_result_size'] ) . 'px';
        }

        if ( isset( $settings['wsf_button_radius'] ) && '' !== $settings['wsf_button_radius'] ) {
            $vars['--wsf-btn-radius'] = absint( $settings['wsf_button_radius'] ) . 'px';
        }

        if ( ! empty( $settings['wsf_input_bg'] ) ) {
            $vars['--wsf-scheme'] = $this->color_scheme( $settings['wsf_input_bg'] );
        }

        return $vars;
    }

    private function build_dynamic_css( $settings ) {
        $vars = $this->get_style_vars( $settings );

        $css = ':root{';

        foreach ( $vars as $var => $value ) {
            $css .= $var . ':' . $value . ';';
        }

        $css .= '}';

        // Keep native selects usable on themes that hide/stylize them.
        $css .= '.wsf-select-item select{-webkit-appearance:none;-moz-appearance:none;appearance:none;opacity:1 !important;visibility:visible !important;}';

        return $css;
    }

    private function color_scheme( $hex ) {
        $rgb = sscanf( $hex, '#%2x%2x%2x' );

        if ( ! is_array( $rgb ) || count( $rgb ) < 3 ) {
            return 'dark';
        }

        $luminance = ( $rgb[0] * 299 + $rgb[1] * 587 + $rgb[2] * 114 ) / 1000;

        return $luminance > 128 ? 'light' : 'dark';
    }
}
