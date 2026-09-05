<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var WPBakeryShortCode $this
 * @var $quant_listing_on_grid
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
$css_class = ( ! empty( $css ) ) ? apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) ) : '';

$view_type = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', 'listing_view_type' );

if ( ! empty( $_GET['view_type'] ) && in_array( $_GET['view_type'], array( 'grid', 'list' ), true ) ) {
	$view_type = sanitize_text_field( $_GET['view_type'] );
}

if ( apply_filters( 'stm_is_motorcycle', false ) ) {
	get_template_part( 'partials/single-car-motorcycle/tabs' );
}

$listing_thumb_height = array();

if ( ! empty( $atts['listing_thumb_height_desktop'] ) ) {
	$listing_thumb_height['listing_thumb_height_desktop'] = $atts['listing_thumb_height_desktop'];
}
if ( ! empty( $atts['listing_thumb_height_tablet'] ) ) {
	$listing_thumb_height['listing_thumb_height_tablet'] = $atts['listing_thumb_height_tablet'];
}
if ( ! empty( $atts['listing_thumb_height_mobile'] ) ) {
	$listing_thumb_height['listing_thumb_height_mobile'] = $atts['listing_thumb_height_mobile'];
}

$template_args = array(
	'quantity_per_row' => ( ! empty( $quant_listing_on_grid ) ) ? $quant_listing_on_grid : 3,
	'custom_img_size'  => ( ! empty( ${$view_type . '_thumb_img_size'} ) ) ? ${$view_type . '_thumb_img_size'} : null,
);

$inline_img_size = null;

if ( ! empty( $listing_thumb_height ) ) {
	$inline_class    = 'inventory-image-height-' . uniqid();
	$css_class      .= sprintf( ' %s', $inline_class );
	$inline_img_size = '
            .' . $inline_class . ' .image img {
                object-fit: cover !important;
            }
            .stm-template-car_dealer_two .archive-listing-page .listing-list-loop.stm-listing-directory-list-loop .image a .image-inner img {
                width: 100%;
            }
            .stm-template-listing .archive-listing-page .listing-list-loop .image, .stm-template-listing_two #wrapper .archive-listing-page .listing-list-loop .image {
                max-height: max-content;
            }
        ';
	if ( ! empty( $listing_thumb_height['listing_thumb_height_desktop'] ) ) {
		$inline_img_size .= '
		        .' . $inline_class . ' .image img {
		            min-height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_desktop'] ) . ' !important;
		            height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_desktop'] ) . ' !important;
		        }
		        .' . $inline_class . ' .image .image-inner, .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-car_dealer_two .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-listing_three .' . $inline_class . ' .image .interactive-hoverable {
		            min-height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_desktop'] ) . ' !important;
		        }
            ';
	}
	if ( ! empty( $listing_thumb_height['listing_thumb_height_tablet'] ) ) {
		$inline_img_size .= '
            @media only screen and (max-width: 1025px) {
                .' . $inline_class . ' .image img {
		            min-height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_tablet'] ) . ' !important;
		            height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_tablet'] ) . ' !important;
		        }
		        .' . $inline_class . ' .image .image-inner, .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-car_dealer_two .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-listing_three .' . $inline_class . ' .image .interactive-hoverable {
		            min-height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_tablet'] ) . ' !important;
		        }
            }';
	}
	if ( ! empty( $listing_thumb_height['listing_thumb_height_mobile'] ) ) {
		$inline_img_size .= '
            @media only screen and (max-width: 768px) {
                .' . $inline_class . ' .image img {
		            min-height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_mobile'] ) . ' !important;
		            height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_mobile'] ) . ' !important;
		        }
		        .' . $inline_class . ' .image .image-inner, .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-car_dealer_two .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-listing_three .' . $inline_class . ' .image .interactive-hoverable {
		            min-height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_mobile'] ) . ' !important;
		        }
            }';
	}
}
?>

<div class="<?php echo esc_attr( $css_class ); ?>">
	<?php
	if ( $inline_img_size ) {
		echo '<style>';
		echo esc_attr( $inline_img_size );
		echo '</style>';
	}
	?>
	<?php do_action( 'stm_listings_load_template', 'filter/inventory/main', $template_args ); ?>
</div>
