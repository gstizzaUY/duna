<?php
$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );
$show_compare              = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_compare' );
$show_favorite             = apply_filters( 'motors_vl_get_nuxy_mod', false, 'enable_favorite_items' );
$car_media                 = apply_filters( 'stm_get_car_medias', array(), get_the_id() );

if ( apply_filters( 'stm_is_dealer_two', false ) || apply_filters( 'stm_is_aircrafts', false ) ) {
	$show_favorite = false;
}

$img_size    = ( apply_filters( 'stm_is_dealer_two', false ) ) ? 'stm-img-275' : 'stm-img-280';
$thumb_width = ( apply_filters( 'stm_is_dealer_two', false ) ) ? 275 : 280;
if ( ! empty( $custom_img_size ) ) {
	$img_size = $custom_img_size;
}

$dynamic_class_photo = 'stm-car-photos-' . get_the_id() . '-' . wp_rand( 1, 99999 );
$dynamic_class_video = 'stm-car-videos-' . get_the_id() . '-' . wp_rand( 1, 99999 );

$img_attrs = array(
	'sizes'   => '(max-width: 767px) 100vw,' . esc_attr( $thumb_width ) . 'px',
	'class'   => 'img-responsive',
	'alt'     => get_the_title(),
	'loading' => 'lazy',
)
?>

<div class="image">
	<!---Media-->
	<div class="stm-car-medias">
		<?php if ( ! empty( $car_media['car_photos_count'] ) ) : ?>
			<div class="stm-listing-photos-unit stm-car-photos-<?php echo esc_attr( get_the_ID() ); ?> <?php echo esc_attr( $dynamic_class_photo ); ?>">
				<i class="stm-service-icon-photo"></i>
				<span><?php echo esc_html( $car_media['car_photos_count'] ); ?></span>
			</div>
<?php //phpcs:disable ?>
			<script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery(".<?php echo esc_attr( $dynamic_class_photo ); ?>").on('click', function () {
                        jQuery(this).lightGallery({
                            dynamic: true,
                            dynamicEl: [
								<?php foreach ( $car_media['car_photos'] as $car_photo ) : ?>
                                {
                                    src: "<?php echo esc_url( $car_photo ); ?>",
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
		<?php //phpcs:enable ?>
		<?php endif; ?>
		<?php if ( ! empty( $car_media['car_videos_count'] ) ) : ?>
			<div class="stm-listing-videos-unit stm-car-videos-<?php echo get_the_ID(); ?> <?php echo esc_attr( $dynamic_class_video ); ?>">
				<i class="fas fa-film"></i>
				<span><?php echo esc_html( $car_media['car_videos_count'] ); ?></span>
			</div>
		<?php //phpcs:disable ?>
			<script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery(".<?php echo esc_attr( $dynamic_class_video ); ?>").on('click', function () {

                        jQuery(this).lightGallery({
                            selector: 'this',
                            dynamic: true,
                            dynamicEl: [
								<?php foreach ( $car_media['car_videos'] as $car_video ) : ?>
                                {
                                    src: "<?php echo esc_url( $car_video ); ?>",
                                    thumb: ''
                                },
								<?php endforeach; ?>
                            ],
                            download: false,
                            mode: 'lg-video',
                        })
                    }); //click
                }); //ready

			</script>
			<?php //phpcs:enable ?>
		<?php endif; ?>
	</div>

	<!--Favorite-->
	<?php if ( ! empty( $show_favorite ) && $show_favorite ) : ?>
		<?php $favorite_tooltip_placement = ( apply_filters( 'stm_is_listing_four', false ) ) ? 'left' : 'right'; ?>
		<div
				class="stm-listing-favorite"
				data-id="<?php echo esc_attr( get_the_ID() ); ?>"
				data-toggle="tooltip" data-placement="<?php echo esc_attr( $favorite_tooltip_placement ); ?>"
				title="<?php esc_attr_e( 'Add to favorites', 'motors' ); ?>">
			<i class="stm-service-icon-staricon"></i>
		</div>
	<?php endif; ?>

	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
		<div class="image-inner interactive-hoverable">
			<?php
			get_template_part( 'partials/listing-cars/listing-directory', 'badges' );

			$plchldr = apply_filters( 'stm_is_aircrafts', false ) ? 'Plane-small.jpg' : 'plchldr255.png';


			$thumbs = apply_filters( 'stm_get_hoverable_thumbs', array(), get_the_ID(), $img_size );
			?>

			<?php if ( $gallery_hover_interaction && count( $thumbs['gallery'] ) > 1 ) : ?>
				<!-- "interactive-hoverable" -->
				<?php do_action( 'stm_listing_image_hover_gallery', $thumbs, $img_size, $img_attrs, false ); ?>

			<?php elseif ( has_post_thumbnail( get_the_ID() ) ) : ?>

				<?php echo wp_kses_post( wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $img_size, false, $img_attrs ) ); ?>

			<?php else : ?>

				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $plchldr ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>" class="img-responsive" loading="lazy"/>

			<?php endif; ?>

		</div>
	</a>
</div>
