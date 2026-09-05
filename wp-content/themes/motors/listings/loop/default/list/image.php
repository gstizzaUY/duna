<?php
$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );
$thumbnail_size            = 'stm-img-280';

$placeholder_path = 'plchldr255.png';
if ( apply_filters( 'stm_is_boats', false ) ) {
	$placeholder_path = 'boats-placeholders/Boat-small.jpg';
} elseif ( apply_filters( 'stm_is_aircrafts', false ) ) {
	$placeholder_path = 'Plane-small.jpg';
} elseif ( apply_filters( 'stm_is_motorcycle', false ) ) {
	$placeholder_path = 'Motor-small.jpg';
}
if ( ! empty( $custom_img_size ) ) {
	$thumbnail_size = $custom_img_size;
}
$thumbs = apply_filters( 'stm_get_hoverable_thumbs', array(), get_the_ID(), $thumbnail_size );

$img_attrs   = array(
	'sizes'   => '(max-width: 767px) 100vw, 257px',
	'class'   => 'img-responsive',
	'alt'     => get_the_title(),
	'loading' => 'lazy',
);
?>
<div class="image">
	<!-- Video button with count -->
	<?php do_action( 'stm_listings_load_template', 'loop/video' ); ?>
	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">

		<div class="image-inner interactive-hoverable">
			<?php
			// sold/featured badge.
			do_action( 'stm_listings_load_template', 'loop/default/list/badge' );
			?>

			<?php if ( $gallery_hover_interaction && count( $thumbs['gallery'] ) > 1 ) : ?>
				<!-- "interactive-hoverable" -->
				<?php do_action( 'stm_listing_image_hover_gallery', $thumbs, $thumbnail_size, $img_attrs, false ); ?>

			<?php elseif ( has_post_thumbnail( get_the_ID() ) ) : ?>

				<?php echo wp_kses_post( wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $thumbnail_size, false, $img_attrs ) ); ?>

			<?php else : ?>

				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>" class="img-responsive" loading="lazy"/>

			<?php endif; ?>

		</div>

	</a>
</div>
