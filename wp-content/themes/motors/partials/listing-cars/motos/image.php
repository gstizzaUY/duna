<?php
	global $post;

	$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );

	$listing_id = $post->ID;

	/*Media*/
	$car_media   = apply_filters( 'stm_get_car_medias', array(), $listing_id );
	$col         = ( ! empty( get_post_meta( stm_get_listing_archive_page_id(), 'quant_grid_items', true ) ) ) ? 12 / get_post_meta( stm_get_listing_archive_page_id(), 'quant_grid_items', true ) : 4;
	$img_size    = 'stm-img-255';
	$thumb_width = 255;
	$grid_col_w  = '33vw';
	$placeholder = 'Motor-small.jpg';

if ( ! empty( $__vars['is_cars_on_top'] ) || ( ! empty( $__vars['vis_limit'] ) && intval( $__vars['vis_limit'] ) === 3 ) ) {
	$img_size    = 'stm-img-350';
	$thumb_width = 350;
}

if ( 6 === $col || ( ! empty( $__vars['vis_limit'] ) && intval( $__vars['vis_limit'] ) === 2 ) ) {
	$img_size    = 'stm-img-398';
	$thumb_width = 398;
	$grid_col_w  = '50vw';
}

if ( ! empty( $custom_img_size ) ) {
	$img_size = $custom_img_size;
}

$thumbs = apply_filters( 'stm_get_hoverable_thumbs', array(), $listing_id, $img_size );

$img_attrs = array(
	'sizes'   => '(max-width: 767px) 100vw, (max-width: 1023px) ' . esc_attr( $grid_col_w ) . ', ' . esc_attr( $thumb_width ) . 'px',
	'class'   => 'img-responsive',
	'alt'     => get_the_title(),
	'loading' => 'lazy',
);
?>

<?php if ( $gallery_hover_interaction && count( $thumbs['gallery'] ) > 1 ) : ?>
	<!-- "interactive-hoverable" -->
	<?php do_action( 'stm_listing_image_hover_gallery', $thumbs, $img_size, $img_attrs ); ?>

<?php elseif ( has_post_thumbnail( get_the_ID() ) ) : ?>

	<?php echo wp_kses_post( wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $img_size, false, $img_attrs ) ); ?>

<?php else : ?>

	<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>" class="img-responsive" loading="lazy"/>

<?php endif; ?>
