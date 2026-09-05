<?php
$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );
$show_compare              = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_compare' );

$cars_in_compare    = apply_filters( 'stm_get_compared_items', array() );
$in_compare         = '';
$car_compare_status = esc_html__( 'Add to compare', 'motors' );

if ( ! empty( $cars_in_compare ) && in_array( get_the_ID(), $cars_in_compare, true ) ) {
	$in_compare         = 'active';
	$car_compare_status = esc_html__( 'Remove from compare', 'motors' );
}

$size        = 'stm-img-255';
$thumb_width = 255;
$grid_col_w  = '33vw';

$placeholder_path = 'plchldr255.png';
if ( apply_filters( 'stm_is_boats', false ) ) {
	$placeholder_path = 'boats-placeholders/Boat-small.jpg';
} elseif ( apply_filters( 'stm_is_aircrafts', false ) ) {
	$placeholder_path = 'Plane-small.jpg';
} elseif ( apply_filters( 'stm_is_motorcycle', false ) ) {
	$placeholder_path = 'Motor-small.jpg';
}

if ( wp_is_mobile() ) {
	if ( apply_filters( 'stm_is_boats', false ) ) {
		$placeholder_path = 'boats-placeholders/Boat.jpg';
	}
}

$col = ( ! empty( get_post_meta( stm_get_listing_archive_page_id(), 'quant_grid_items', true ) ) ) ? 12 / get_post_meta( stm_get_listing_archive_page_id(), 'quant_grid_items', true ) : 4;

if ( 6 === $col ) {
	$size        = 'stm-img-398';
	$thumb_width = 398;
	$grid_col_w  = '50vw';
	$placeholder = 'plchldr-398.jpg';
}

if ( ! empty( $custom_img_size ) ) {
	$size          = $custom_img_size;
	$img_size_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $custom_img_size );
	if ( ! empty( $img_size_data ) && isset( $img_size_data[1] ) ) {
		$thumb_width = $img_size_data[1];
	}
}

$thumbs = apply_filters( 'stm_get_hoverable_thumbs', array(), get_the_ID(), $size );

$img_attrs = array(
	'sizes'   => '(max-width: 767px) 100vw, (max-width: 1023px) ' . esc_attr( $grid_col_w ) . ', ' . esc_attr( $thumb_width ) . 'px',
	'class'   => 'img-responsive',
	'alt'     => get_the_title(),
	'loading' => 'lazy',
);
?>

<div class="image">
	<?php do_action( 'stm_listings_load_template', 'loop/default/list/badge' ); ?>

	<?php if ( $gallery_hover_interaction && count( $thumbs['gallery'] ) > 1 ) : ?>
		<!-- "interactive-hoverable" -->
		<?php do_action( 'stm_listing_image_hover_gallery', $thumbs, $size, $img_attrs ); ?>

	<?php elseif ( has_post_thumbnail( get_the_ID() ) ) : ?>

		<?php echo wp_kses_post( wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $size, false, $img_attrs, ) ); ?>

	<?php else : ?>

		<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>" class="img-responsive" loading="lazy" />

	<?php endif; ?>

	<?php
	$tooltip_position = 'left';

	if ( apply_filters( 'stm_is_boats', false ) ) {
		stm_get_boats_image_hover( get_the_ID() );
	}

	// Compare.
	if ( ! empty( $show_compare ) && $show_compare ) :
		?>
		<div
			class="stm-listing-compare stm-compare-directory-new"
			data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
			data-id="<?php echo esc_attr( get_the_id() ); ?>"
			data-title="<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), false ) ); ?>"
			data-toggle="tooltip"
			data-placement="<?php echo esc_attr( $tooltip_position ); ?>"
			title="<?php echo esc_attr( $car_compare_status ); ?>">
			<i class="stm-boats-icon-add-to-compare"></i>
		</div>
		<?php
	endif;
	?>
</div>
