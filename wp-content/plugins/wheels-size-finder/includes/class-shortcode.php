<?php
/**
 * Shortcode rendering for the search form.
 *
 * @package WheelsSizeFinder
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Wheels_Size_Finder_Shortcode {

    private $api;
    private $license;
    private $woocommerce;

    public function __construct( Wheels_Size_Finder_API $api, Wheels_Size_Finder_License $license, Wheels_Size_Finder_WooCommerce $woocommerce ) {
        $this->api         = $api;
        $this->license     = $license;
        $this->woocommerce = $woocommerce;

        add_shortcode( 'wheels_finder', array( $this, 'render' ) );
        add_shortcode( 'wsf_categories', array( $this, 'render_categories' ) );
        add_shortcode( 'wsf_client_logos', array( $this, 'render_client_logos' ) );
        add_action( 'wp_ajax_wsf_search_products', array( $this, 'ajax_search_products' ) );
        add_action( 'wp_ajax_nopriv_wsf_search_products', array( $this, 'ajax_search_products' ) );
        add_action( 'wp_ajax_wsf_get_vehicle_data', array( $this, 'ajax_get_vehicle_data' ) );
        add_action( 'wp_ajax_nopriv_wsf_get_vehicle_data', array( $this, 'ajax_get_vehicle_data' ) );
    }

    public function render( $atts ) {
        if ( ! $this->license->is_valid() ) {
            return '<div class="wsf-error">' . esc_html__( 'Plugin no activado. Ingresa una clave de licencia valida.', 'wheels-size-finder' ) . '</div>';
        }

        $atts = shortcode_atts( array(
            'mode' => '',
        ), $atts, 'wheels_finder' );

        $settings = get_option( WSF_SETTINGS_OPTION, array() );
        $mode     = ! empty( $atts['mode'] ) ? $atts['mode'] : ( isset( $settings['wsf_search_mode'] ) ? $settings['wsf_search_mode'] : 'tire' );

        return $this->render_form( $settings, $mode );
    }

    /**
     * Renders the search form markup without license validation.
     * Used for the admin live preview.
     *
     * @param array $settings Plugin settings.
     * @return string
     */
    public function render_preview( $settings ) {
        $mode = isset( $settings['wsf_search_mode'] ) ? $settings['wsf_search_mode'] : 'tire';

        return $this->render_form( $settings, $mode );
    }

    private function render_form( $settings, $mode ) {
        $modes = array( 'tire', 'vehicle', 'both' );
        if ( ! in_array( $mode, $modes, true ) ) {
            $mode = 'tire';
        }

        $show_tabs = 'both' === $mode;

        $title          = isset( $settings['wsf_title'] ) ? $settings['wsf_title'] : '';
        $title_tag      = isset( $settings['wsf_title_tag'] ) && in_array( $settings['wsf_title_tag'], array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) ? $settings['wsf_title_tag'] : 'h2';
        $title_classes  = isset( $settings['wsf_title_classes'] ) ? $settings['wsf_title_classes'] : '';

        ob_start();

        if ( ! empty( $title ) ) {
            echo '<' . esc_attr( $title_tag ) . ' class="wsf-title' . ( ! empty( $title_classes ) ? ' ' . esc_attr( $title_classes ) : '' ) . '">' . esc_html( $title ) . '</' . esc_attr( $title_tag ) . '>';
        }
        ?>
        <div class="wsf-container"
             id="wsf-finder-<?php echo esc_attr( uniqid() ); ?>"
             data-nonce="<?php echo esc_attr( wp_create_nonce( 'wsf_ajax_nonce' ) ); ?>"
             data-redirect="<?php echo esc_attr( isset( $settings['wsf_redirect'] ) ? $settings['wsf_redirect'] : '' ); ?>"
             data-per-page="<?php echo esc_attr( isset( $settings['wsf_per_page'] ) ? absint( $settings['wsf_per_page'] ) : 12 ); ?>">

            <?php if ( $show_tabs ) : ?>
            <div class="wsf-tabs">
                <button class="wsf-tab wsf-active" data-tab="tire"><?php esc_html_e( 'Por medidas', 'wheels-size-finder' ); ?></button>
                <button class="wsf-tab" data-tab="vehicle"><?php esc_html_e( 'Por vehiculo', 'wheels-size-finder' ); ?></button>
            </div>
            <?php endif; ?>

            <?php if ( 'tire' === $mode || $show_tabs ) : ?>
            <div class="wsf-panel <?php echo ! $show_tabs || 'tire' === $mode ? 'wsf-active' : ''; ?>" data-panel="tire">
                <div class="wsf-select-group">
                    <div class="wsf-select-item">
                        <label><?php esc_html_e( 'Ancho', 'wheels-size-finder' ); ?></label>
                        <div class="wsf-select-wrap">
                            <select class="wsf-width-select" data-target="profile">
                                <option value="">--</option>
                            </select>
                        </div>
                    </div>
                    <div class="wsf-select-item">
                        <label><?php esc_html_e( 'Perfil', 'wheels-size-finder' ); ?></label>
                        <div class="wsf-select-wrap">
                            <select class="wsf-profile-select" data-target="rim" disabled>
                                <option value="">--</option>
                            </select>
                        </div>
                    </div>
                    <div class="wsf-select-item">
                        <label><?php esc_html_e( 'Aro', 'wheels-size-finder' ); ?></label>
                        <div class="wsf-select-wrap">
                            <select class="wsf-rim-select" disabled>
                                <option value="">--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="wsf-result-preview"></div>
                <button class="wsf-search-btn wsf-hidden" data-action="search">
                    <?php esc_html_e( 'Buscar productos', 'wheels-size-finder' ); ?>
                </button>
            </div>
            <?php endif; ?>

            <?php if ( 'vehicle' === $mode || $show_tabs ) : ?>
            <div class="wsf-panel <?php echo 'vehicle' === $mode && ! $show_tabs ? 'wsf-active' : ''; ?>" data-panel="vehicle">
                <div class="wsf-select-group">
                    <div class="wsf-select-item">
                        <label><?php esc_html_e( 'Marca', 'wheels-size-finder' ); ?></label>
                        <div class="wsf-select-wrap">
                            <select class="wsf-brand-select" data-target="model">
                                <option value="">--</option>
                            </select>
                        </div>
                    </div>
                    <div class="wsf-select-item">
                        <label><?php esc_html_e( 'Modelo', 'wheels-size-finder' ); ?></label>
                        <div class="wsf-select-wrap">
                            <select class="wsf-model-select" data-target="year" disabled>
                                <option value="">--</option>
                            </select>
                        </div>
                    </div>
                    <div class="wsf-select-item">
                        <label><?php esc_html_e( 'Año', 'wheels-size-finder' ); ?></label>
                        <div class="wsf-select-wrap">
                            <select class="wsf-year-select" data-target="version" disabled>
                                <option value="">--</option>
                            </select>
                        </div>
                    </div>
                    <div class="wsf-select-item">
                        <label><?php esc_html_e( 'Version', 'wheels-size-finder' ); ?></label>
                        <div class="wsf-select-wrap">
                            <select class="wsf-version-select" disabled>
                                <option value="">--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="wsf-result-preview"></div>
                <button class="wsf-search-btn wsf-hidden" data-action="search">
                    <?php esc_html_e( 'Buscar productos', 'wheels-size-finder' ); ?>
                </button>
            </div>
            <?php endif; ?>

            <div class="wsf-results-container wsf-hidden"></div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function ajax_search_products() {
        check_ajax_referer( 'wsf_ajax_nonce', 'nonce' );

        $tire_size = isset( $_POST['tire_size'] ) ? sanitize_text_field( wp_unslash( $_POST['tire_size'] ) ) : '';

        if ( empty( $tire_size ) ) {
            wp_send_json_error( array( 'message' => __( 'No se especifico medida.', 'wheels-size-finder' ) ) );
        }

        $page = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;

        $products = $this->woocommerce->find_by_sku( $tire_size, $page );

        wp_send_json_success( $products );
    }

    public function ajax_get_vehicle_data() {
        check_ajax_referer( 'wsf_ajax_nonce', 'nonce' );

        $type = isset( $_POST['data_type'] ) ? sanitize_text_field( wp_unslash( $_POST['data_type'] ) ) : '';

        switch ( $type ) {
            case 'brands':
                $data = $this->api->get_brands();
                break;

            case 'models':
                $brand = isset( $_POST['brand'] ) ? sanitize_text_field( wp_unslash( $_POST['brand'] ) ) : '';
                $data  = $this->api->get_models( $brand );
                break;

            case 'years':
                $brand = isset( $_POST['brand'] ) ? sanitize_text_field( wp_unslash( $_POST['brand'] ) ) : '';
                $model = isset( $_POST['model'] ) ? sanitize_text_field( wp_unslash( $_POST['model'] ) ) : '';
                $data  = $this->api->get_years( $brand, $model );
                break;

            case 'versions':
                $brand = isset( $_POST['brand'] ) ? sanitize_text_field( wp_unslash( $_POST['brand'] ) ) : '';
                $model = isset( $_POST['model'] ) ? sanitize_text_field( wp_unslash( $_POST['model'] ) ) : '';
                $year  = isset( $_POST['year'] ) ? sanitize_text_field( wp_unslash( $_POST['year'] ) ) : '';
                $data  = $this->api->get_versions( $brand, $model, $year );
                break;

            case 'tire':
                $brand   = isset( $_POST['brand'] ) ? sanitize_text_field( wp_unslash( $_POST['brand'] ) ) : '';
                $model   = isset( $_POST['model'] ) ? sanitize_text_field( wp_unslash( $_POST['model'] ) ) : '';
                $year    = isset( $_POST['year'] ) ? sanitize_text_field( wp_unslash( $_POST['year'] ) ) : '';
                $version = isset( $_POST['version'] ) ? sanitize_text_field( wp_unslash( $_POST['version'] ) ) : '';
                $data    = $this->api->get_vehicle_tire( $brand, $model, $year, $version );
                break;

            default:
                wp_send_json_error( array( 'message' => __( 'Tipo de datos invalido.', 'wheels-size-finder' ) ) );
        }

        if ( is_wp_error( $data ) ) {
            wp_send_json_error( array( 'message' => $data->get_error_message() ) );
        }

        wp_send_json_success( $data );
    }

    /**
     * Grid de categorias de WooCommerce.
     *
     * @param array $atts slugs (lista separada por comas), count, title.
     * @return string
     */
    public function render_categories( $atts ) {
        if ( ! class_exists( 'WooCommerce' ) ) {
            return '';
        }

        $atts = shortcode_atts( array(
            'slugs' => '',
            'count' => 6,
            'title' => '',
        ), $atts, 'wsf_categories' );

        $count = max( 1, min( absint( $atts['count'] ), 12 ) );

        if ( ! empty( $atts['slugs'] ) ) {
            $slugs = array_filter( array_map( 'sanitize_title', explode( ',', $atts['slugs'] ) ) );
            $terms = array();
            foreach ( $slugs as $slug ) {
                $term = get_term_by( 'slug', $slug, 'product_cat' );
                if ( $term && ! is_wp_error( $term ) ) {
                    $terms[] = $term;
                }
            }
            $terms = array_slice( $terms, 0, $count );
        } else {
            $terms = get_terms( array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => $count * 2,
            ) );
            if ( is_wp_error( $terms ) ) {
                return '';
            }
            $terms = array_values( array_filter( $terms, function ( $t ) {
                return 'uncategorized' !== $t->slug;
            } ) );
            $terms = array_slice( $terms, 0, $count );
        }

        if ( empty( $terms ) ) {
            return '';
        }

        ob_start();

        if ( ! empty( $atts['title'] ) ) {
            echo '<h2 class="wsf-categories-title">' . esc_html( $atts['title'] ) . '</h2>';
        }
        ?>
        <div class="wsf-categories">
            <?php foreach ( $terms as $term ) : ?>
                <a class="wsf-category-card" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
                    <span class="wsf-category-image">
                        <?php $image_url = $this->get_category_image( $term ); ?>
                        <?php if ( $image_url ) : ?>
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $term->name ); ?>" loading="lazy">
                        <?php endif; ?>
                    </span>
                    <span class="wsf-category-name"><?php echo esc_html( $term->name ); ?></span>
                    <span class="wsf-category-count"><?php echo esc_html( sprintf( _n( '%d producto', '%d productos', $term->count, 'wheels-size-finder' ), $term->count ) ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Imagen de una categoria: thumbnail propio o primera imagen de producto.
     */
    private function get_category_image( $term ) {
        $thumb = get_term_meta( $term->term_id, 'thumbnail_id', true );
        if ( $thumb ) {
            $src = wp_get_attachment_image_url( $thumb, 'medium_large' );
            if ( $src ) {
                return $src;
            }
        }

        $products = get_posts( array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 5,
            'fields'         => 'ids',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                ),
            ),
        ) );

        foreach ( $products as $product_id ) {
            $img = get_post_thumbnail_id( $product_id );
            if ( $img ) {
                $src = wp_get_attachment_image_url( $img, 'medium_large' );
                if ( $src ) {
                    return $src;
                }
            }
        }

        return wc_placeholder_img_src( 'medium_large' );
    }

    /**
     * Logos de clientes. Muestra los attachments marcados con _wsf_client_logo=1.
     *
     * @param array $atts ids (opcional, lista de attachment IDs separados por coma), title.
     * @return string
     */
    public function render_client_logos( $atts ) {
        $atts = shortcode_atts( array(
            'ids'   => '',
            'title' => '',
        ), $atts, 'wsf_client_logos' );

        if ( ! empty( $atts['ids'] ) ) {
            $ids = array_filter( array_map( 'absint', explode( ',', $atts['ids'] ) ) );
            $logos = array();
            foreach ( $ids as $id ) {
                $src = wp_get_attachment_image_url( $id, 'medium' );
                if ( $src ) {
                    $logos[] = array( 'src' => $src, 'color' => ( '1' === get_post_meta( $id, '_wsf_client_logo_color', true ) ) );
                }
            }
        } else {
            $ids = get_posts( array(
                'post_type'      => 'attachment',
                'post_status'    => 'inherit',
                'post_mime_type' => 'image',
                'posts_per_page' => 30,
                'fields'         => 'ids',
                'meta_query'     => array(
                    array( 'key' => '_wsf_client_logo', 'value' => '1' ),
                ),
            ) );
            $logos = array();
            foreach ( $ids as $id ) {
                $src = wp_get_attachment_image_url( $id, 'medium' );
                if ( $src ) {
                    $logos[] = array( 'src' => $src, 'color' => ( '1' === get_post_meta( $id, '_wsf_client_logo_color', true ) ) );
                }
            }
        }

        ob_start();

        if ( ! empty( $atts['title'] ) ) {
            echo '<h3 class="wsf-logos-title">' . esc_html( $atts['title'] ) . '</h3>';
        }
        echo '<div class="wsf-logos"><div class="wsf-logos-track">';
        foreach ( $logos as $logo ) {
            $extra = $logo['color'] ? ' wsf-logo-color' : '';
            echo '<span class="wsf-logo-card"><img class="wsf-logo' . esc_attr( $extra ) . '" src="' . esc_url( $logo['src'] ) . '" alt="' . esc_attr__( 'Logo de cliente', 'wheels-size-finder' ) . '" loading="lazy"></span>';
        }
        echo '</div></div>';

        return ob_get_clean();
    }
}
