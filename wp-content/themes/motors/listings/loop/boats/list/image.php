<?php
$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );

$img_size  = 'stm-img-280';
$thumbs    = apply_filters( 'stm_get_hoverable_thumbs', array(), get_the_ID(), $img_size );
$plchldr   = get_stylesheet_directory_uri() . '/assets/images/boats-placeholders/Boat-small.jpg';
$img_attrs = array(
	'sizes'   => '(max-width: 767px) 100vw, 280px',
	'class'   => 'img-responsive',
	'alt'     => get_the_title(),
	'loading' => 'lazy',
);
?>
<div class="image">
	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn">
		<div class="image-inner interactive-hoverable">

			<?php if ( $gallery_hover_interaction && count( $thumbs['gallery'] ) > 1 && ! wp_is_mobile() ) : ?>
				<!-- "interactive-hoverable" -->
				<?php do_action( 'stm_listing_image_hover_gallery', $thumbs, $img_size, $img_attrs, false ); ?>
				<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>

			<?php elseif ( has_post_thumbnail( get_the_ID() ) ) : ?>

				<?php echo wp_kses_post( wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $img_size, false, $img_attrs ) ); ?>
				<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>

			<?php else : ?>

				<img src="<?php echo esc_url( $plchldr ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>" class="img-responsive" loading="lazy"/>
				<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>

			<?php endif; ?>

		</div>
		<?php
		stm_get_boats_image_hover( get_the_ID() );
		?>
	</a>
</div>
