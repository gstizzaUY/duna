<?php
/**
 * WooCommerce product search integration.
 *
 * @package WheelsSizeFinder
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Wheels_Size_Finder_WooCommerce {

    public function __construct() {
        if ( ! $this->is_woocommerce_active() ) {
            return;
        }

        add_action( 'woocommerce_single_product_summary', array( $this, 'display_tire_size' ), 5 );
        add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'display_tire_size' ), 5 );
    }

    public function is_woocommerce_active() {
        return class_exists( 'WooCommerce' );
    }

    /**
     * Muestra la medida (_wsf_tire_size) en la ficha y en las cards del shop.
     */
    public function display_tire_size() {
        global $product;

        if ( ! $product ) {
            return;
        }

        $size = get_post_meta( $product->get_id(), '_wsf_tire_size', true );

        if ( empty( $size ) ) {
            return;
        }

        echo '<div class="wsf-product-measure"><span class="wsf-product-measure-label">'
            . esc_html__( 'Medida', 'wheels-size-finder' )
            . ':</span> ' . esc_html( $size ) . '</div>';
    }

    public function find_by_sku( $tire_size, $page = 1 ) {
        if ( ! $this->is_woocommerce_active() ) {
            return array(
                'products' => array(),
                'total'    => 0,
                'pages'    => 0,
                'page'     => $page,
                'message'  => __( 'WooCommerce no esta instalado.', 'wheels-size-finder' ),
            );
        }

        $settings = get_option( WSF_SETTINGS_OPTION, array() );
        $per_page = isset( $settings['wsf_per_page'] ) ? absint( $settings['wsf_per_page'] ) : 12;
        $per_page = max( 1, min( $per_page, 100 ) );

        $tire_size_clean = strtoupper( preg_replace( '/\s+/', '', trim( $tire_size ) ) );

        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'paged'          => $page,
            'meta_query'     => array(
                'relation' => 'OR',
                array(
                    'key'     => '_sku',
                    'value'   => $tire_size_clean,
                    'compare' => '=',
                ),
                array(
                    'key'     => '_sku',
                    'value'   => $tire_size_clean,
                    'compare' => 'LIKE',
                ),
                array(
                    'key'     => '_wsf_tire_size',
                    'value'   => $tire_size_clean,
                    'compare' => '=',
                ),
                array(
                    'key'     => '_wsf_tire_size',
                    'value'   => $tire_size_clean,
                    'compare' => 'LIKE',
                ),
            ),
        );

        $query = new WP_Query( $args );

        $products = array();

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $product = wc_get_product( get_the_ID() );

                if ( ! $product ) {
                    continue;
                }

                $image_id  = $product->get_image_id();
                $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'woocommerce_thumbnail' ) : wc_placeholder_img_src( 'woocommerce_thumbnail' );

                if ( $product->is_type( 'variable' ) ) {
                    $add_to_cart_url = $product->get_permalink();
                } elseif ( $product->is_purchasable() && $product->is_in_stock() ) {
                    $add_to_cart_url = add_query_arg( 'add-to-cart', $product->get_id(), wc_get_cart_url() );
                } else {
                    $add_to_cart_url = $product->get_permalink();
                }

                $products[] = array(
                    'id'              => $product->get_id(),
                    'title'           => $product->get_name(),
                    'permalink'       => get_permalink( $product->get_id() ),
                    'price'           => $product->get_price_html(),
                    'image'           => $image_url,
                    'sku'             => $product->get_sku(),
                    'stock_status'    => $product->get_stock_status(),
                    'add_to_cart_url' => $add_to_cart_url,
                );
            }
            wp_reset_postdata();
        }

        return array(
            'products' => $products,
            'total'    => $query->found_posts,
            'pages'    => $query->max_num_pages,
            'page'     => $page,
            'size'     => $tire_size_clean,
        );
    }
}
