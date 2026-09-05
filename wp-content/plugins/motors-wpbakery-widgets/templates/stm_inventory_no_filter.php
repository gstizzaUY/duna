<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

if ( empty( $posts_per_page ) ) {
	$posts_per_page = 4;
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
		        .' . $inline_class . ' .image .image-inner, .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-car_dealer_two .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-listing_three .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-motorcycle .stm-inventory-no-filter-wrap.' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-listing_five .stm-inventory-no-filter-wrap .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-car_dealer_two .stm-inventory-no-filter-wrap.' . $inline_class . ' .image .interactive-hoverable {
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
		        .' . $inline_class . ' .image .image-inner, .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-car_dealer_two .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-listing_three .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-motorcycle .stm-inventory-no-filter-wrap.' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-car_dealer_two .stm-inventory-no-filter-wrap.' . $inline_class . ' .image .interactive-hoverable {
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
		        .' . $inline_class . ' .image .image-inner, .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-car_dealer_two .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-listing_three .' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-motorcycle .stm-inventory-no-filter-wrap.' . $inline_class . ' .image .interactive-hoverable, .stm-hoverable-interactive-galleries.stm-template-car_dealer_two .stm-inventory-no-filter-wrap.' . $inline_class . ' .image .interactive-hoverable {
		            min-height: ' . esc_attr( $listing_thumb_height['listing_thumb_height_mobile'] ) . ' !important;
		        }
		        .stm-hoverable-interactive-galleries.stm-template-listing_five .' . $inline_class . ' .image .interactive-hoverable img, .stm-hoverable-interactive-galleries.stm-template-listing_three .' . $inline_class . ' .image .interactive-hoverable img {
		            max-width: 100%;
		        }
            }';
	}
}

$args = array(
	'post_type'        => apply_filters( 'stm_listings_post_type', 'listings' ),
	'post_status'      => 'publish',
	'posts_per_page'   => $posts_per_page,
	'suppress_filters' => 0,
	'order_by'         => 'ID',
	'order'            => $order_by,
);

if ( apply_filters( 'stm_sold_status_enabled', true ) ) {
	$args['meta_query'][] = array(
		'key'     => 'car_mark_as_sold',
		'value'   => '',
		'compare' => '=',
	);
}

$query = new WP_Query( $args );

if ( $inline_img_size ) {
	echo '<style>';
	echo esc_attr( $inline_img_size );
	echo '</style>';
}

?>

<div class="stm-inventory-no-filter-wrap <?php echo esc_attr( $css_class ); ?>">
	<div class="stm-isotope-sorting stm-isotope-sorting-list" data-per-page="<?php echo esc_attr( $posts_per_page ); ?>">
	<?php
	if ( $query->have_posts() ) :

		$template = 'partials/vc_loop/inventory-no-filter-loop';

		while ( $query->have_posts() ) :
			$query->the_post();
			get_template_part( $template );
			endwhile;

		endif;
	?>
	</div>
	<div class="stm_ajax_pagination stm-blog-pagination">
		<?php
		echo wp_kses_post(
			paginate_links(
				array(
					'type'      => 'list',
					'total'     => $query->found_posts / $posts_per_page,
					'prev_text' => '<i class="fas fa-angle-left"></i>',
					'next_text' => '<i class="fas fa-angle-right"></i>',
				)
			)
		);
		?>
	</div>
	<?php wp_reset_postdata(); ?>
</div>
