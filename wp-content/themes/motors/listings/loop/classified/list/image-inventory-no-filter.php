<?php
$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );
$show_compare              = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_compare' );
$show_favorite             = apply_filters( 'motors_vl_get_nuxy_mod', false, 'enable_favorite_items' );
$car_media                 = apply_filters( 'stm_get_car_medias', array(), get_the_ID() );
$unique_class              = 'stm-car-videos-' . wp_rand( 1, 10000 );
$placeholder_path          = 'plchldr255.png';
if ( apply_filters( 'stm_is_boats', false ) ) {
	$placeholder_path = 'boats-placeholders/Boat-small.jpg';
} elseif ( apply_filters( 'stm_is_aircrafts', false ) ) {
	$placeholder_path = 'Plane-small.jpg';
} elseif ( apply_filters( 'stm_is_motorcycle', false ) ) {
	$placeholder_path = 'Motor-small.jpg';
}

$img_size  = 'stm-img-280';
$thumbs    = apply_filters( 'stm_get_hoverable_thumbs', array(), get_the_ID(), $img_size );
$img_attrs = array(
	'sizes'   => '(max-width: 767px) 100vw, 280px',
	'class'   => 'img-responsive',
	'alt'     => get_the_title(),
	'loading' => 'lazy',
);
?>

<div class="image">

	<!--Hover blocks-->
	<!---Media-->
	<div class="stm-car-medias">
		<?php if ( ! empty( $car_media['car_photos_count'] ) ) : ?>
			<div class="stm-listing-photos-unit stm-car-photos-<?php echo esc_attr( get_the_ID() ); ?>">
				<i class="stm-service-icon-photo"></i>
				<span><?php echo esc_html( $car_media['car_photos_count'] ); ?></span>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function(){

					jQuery(".stm-car-photos-<?php echo esc_js( get_the_ID() ); ?>").on('click', function() {
						jQuery(this).lightGallery({
							dynamic: true,
							dynamicEl: [
								<?php foreach ( $car_media['car_photos'] as $car_photo ) : ?>
								{
									src  : "<?php echo esc_url( $car_photo ); ?>",
									thumb: "<?php echo esc_url( $car_photo ); ?>"
								},
								<?php endforeach; ?>
							],
							download: false,
							mode: 'lg-fade',
						})
					});
				});

			</script>
		<?php endif; ?>
		<?php if ( ! empty( $car_media['car_videos_count'] ) ) : ?>
			<div class="stm-listing-videos-unit stm-car-videos-<?php echo esc_attr( get_the_ID() ); ?> <?php echo esc_attr( $unique_class ); ?>">
				<i class="fas fa-film"></i>
				<span><?php echo esc_html( $car_media['car_videos_count'] ); ?></span>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery(".<?php echo esc_attr( $unique_class ); ?>").on('click', function() {
						jQuery(this).lightGallery({
							dynamic: true,
							dynamicEl: [
								<?php foreach ( $car_media['car_videos'] as $car_video ) : ?>
								{
									src  : "<?php echo esc_url( $car_video ); ?>"
								},
								<?php endforeach; ?>
							],
							download: false,
							mode: 'lg-fade',
						})
					}); //click
				}); //ready

			</script>
		<?php endif; ?>
	</div>
	<!--Compare-->
	<?php if ( ! empty( $show_compare ) && $show_compare ) : ?>
		<div
			class="stm-listing-compare"
			data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
			data-id="<?php echo esc_attr( get_the_ID() ); ?>"
			data-title="<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), false ) ); ?>"
			data-toggle="tooltip" data-placement="left" title="<?php esc_attr_e( 'Add to compare', 'motors' ); ?>">
			<i class="stm-service-icon-compare-new"></i>
		</div>
	<?php endif; ?>

	<!--Favorite-->
	<?php if ( ! empty( $show_favorite ) && $show_favorite ) : ?>
		<div
			class="stm-listing-favorite"
			data-id="<?php echo esc_attr( get_the_ID() ); ?>"
			data-toggle="tooltip" data-placement="right" title="<?php esc_attr_e( 'Add to favorites', 'motors' ); ?>">
			<i class="stm-service-icon-staricon"></i>
		</div>
	<?php endif; ?>

	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
		<div class="image-inner interactive-hoverable">
			<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>

			<?php if ( $gallery_hover_interaction && count( $thumbs['gallery'] ) > 1 && ! wp_is_mobile() ) : ?>
				<!-- "interactive-hoverable" -->
				<?php do_action( 'stm_listing_image_hover_gallery', $thumbs, $img_size, $img_attrs, false ); ?>

			<?php elseif ( has_post_thumbnail( get_the_ID() ) ) : ?>

				<?php echo wp_kses_post( wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $img_size, false, $img_attrs ) ); ?>

			<?php else : ?>

				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>" class="img-responsive" loading="lazy"/>

			<?php endif; ?>
		</div>
	</a>
</div>
