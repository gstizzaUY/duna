<?php
$car_price_form_label      = get_post_meta( get_the_ID(), 'car_price_form_label', true );
$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );

// Compare.
if ( apply_filters( 'stm_is_boats', false ) ) {
	$show_compare = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_compare' );
}

$placeholder_path = 'plchldr255.png';
if ( apply_filters( 'stm_is_boats', false ) ) {
	$placeholder_path = 'boats-placeholders/Boat-small.jpg';
} elseif ( apply_filters( 'stm_is_aircrafts', false ) ) {
	$placeholder_path = 'Plane-small.jpg';
} elseif ( apply_filters( 'stm_is_motorcycle', false ) ) {
	$placeholder_path = 'Motor-small.jpg';
}
if ( stm_check_if_car_imported( get_the_id() ) ) {
	$placeholder_path = 'automanager_placeholders/plchldr255automanager.png';
}

$image_size = 'stm-img-255';

if ( ! empty( $args['custom_img_size'] ) ) {
	$image_size = $args['custom_img_size'];
}

$thumbs    = apply_filters( 'stm_get_hoverable_thumbs', array(), get_the_ID(), $image_size );
$img_attrs = array(
	'sizes'   => '(max-width: 767px) 100vw, (max-width: 991px) 33vw, (max-width: 1160px) 25vw, 255px',
	'class'   => 'img-responsive',
	'alt'     => get_the_title(),
	'loading' => 'lazy',
);
?>
<div class="col-md-3 col-sm-4 col-xs-12 col-xxs-12 stm-template-front-loop">
	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn xx">

		<div class="image">

			<?php if ( $gallery_hover_interaction && count( $thumbs['gallery'] ) > 1 && ! wp_is_mobile() ) : ?>

				<div class="interactive-hoverable">
					<!-- "interactive-hoverable" -->
					<?php do_action( 'stm_listing_image_hover_gallery', $thumbs, $image_size, $img_attrs, false ); ?>

					<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>

				</div>

			<?php elseif ( has_post_thumbnail( get_the_ID() ) ) : ?>

				<?php echo wp_kses_post( wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $image_size, false, $img_attrs ) ); ?>

				<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>

			<?php else : ?>

				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>" class="img-responsive" loading="lazy" />

				<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>

			<?php endif; ?>

			<?php
			if ( apply_filters( 'stm_is_boats', false ) ) {
				stm_get_boats_image_hover( get_the_ID() );
				?>
				<!--Compare-->
				<?php if ( ! empty( $show_compare ) && $show_compare ) : ?>
					<div
							class="stm-listing-compare stm-compare-directory-new"
							data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
							data-id="<?php echo esc_attr( get_the_id() ); ?>"
							data-title="<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), false ) ); ?>"
							data-toggle="tooltip" data-placement="<?php echo ( apply_filters( 'stm_is_boats', false ) ) ? 'left' : 'bottom'; ?>"
							title="<?php esc_attr_e( 'Add to compare', 'motors' ); ?>"
					>
						<i class="stm-boats-icon-add-to-compare"></i>
					</div>
					<?php
				endif;
			}
			?>

		</div>

		<div class="listing-car-item-meta">
			<div class="car-meta-top heading-font clearfix">
				<?php
				$price      = get_post_meta( get_the_id(), 'price', true );
				$sale_price = get_post_meta( get_the_id(), 'sale_price', true );
				if ( empty( $price ) && ! empty( $sale_price ) ) {
					$price = $sale_price;
				}
				?>
				<?php if ( ! empty( $car_price_form_label ) ) : ?>
					<div class="price">
							<div class="normal-price"><?php echo esc_html( $car_price_form_label ); ?></div>
						</div>
				<?php else : ?>
					<?php if ( ! empty( $price ) && ! empty( $sale_price ) && $price !== $sale_price ) : ?>
						<div class="price discounted-price">
							<div class="regular-price"><?php echo esc_html( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></div>
							<div class="sale-price"><?php echo esc_html( apply_filters( 'stm_filter_price_view', '', $sale_price ) ); ?></div>
						</div>
					<?php elseif ( ! empty( $price ) ) : ?>
						<div class="price">
							<div class="normal-price"><?php echo esc_html( apply_filters( 'stm_filter_price_view', '', $price ) ); ?></div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<?php $title_max_length = apply_filters( 'motors_vl_get_nuxy_mod', 44, 'grid_title_max_length' ); ?>
				<div class="car-title" data-max-char="<?php echo esc_attr( $title_max_length ); ?>">
					<?php echo esc_html( trim( preg_replace( '/\s+/', ' ', substr( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID() ), 0, intval( $title_max_length ) ) ) ) ); ?>
					<?php
					if ( strlen( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID() ) ) > intval( $title_max_length ) ) {
						echo '...';
					}
					?>
				</div>
			</div>

			<?php $labels = apply_filters( 'stm_get_car_listings', array() ); ?>
			<?php if ( ! empty( $labels ) ) : ?>
			<div class="car-meta-bottom">
				<ul>
					<?php foreach ( $labels as $label ) : ?>
						<?php $label_meta = get_post_meta( get_the_id(), $label['slug'], true ); ?>
						<?php if ( ! apply_filters( 'is_empty_value', $label_meta ) && '' !== $label_meta && ! apply_filters( 'stm_is_listing_price_field', true, $label['slug'] ) ) : ?>
							<li>
								<?php if ( ! empty( $label['font'] ) ) : ?>
									<i class="<?php echo esc_attr( $label['font'] ); ?>"></i>
								<?php endif; ?>

								<?php if ( ! empty( $label['numeric'] ) && $label['numeric'] ) : ?>
									<?php if ( ! empty( $label['number_field_affix'] ) ) : ?>
										<span><?php echo esc_html( $label_meta ) . ' ' . esc_html( $label['number_field_affix'] ); ?></span>
									<?php else : ?>
										<span><?php echo esc_html( $label_meta ); ?></span>
									<?php endif; ?>
								<?php else : ?>

									<?php
										$data_meta_array = explode( ',', $label_meta );
										$datas           = array();

									if ( ! empty( $data_meta_array ) ) {
										foreach ( $data_meta_array as $data_meta_single ) {
											$data_meta = get_term_by( 'slug', $data_meta_single, $label['slug'] );
											if ( ! empty( $data_meta->name ) ) {
												$datas[] = esc_attr( $data_meta->name );
											}
										}
									}

									if ( ! empty( $datas ) ) :
										if ( count( $datas ) > 1 ) :
											?>
												<span
													class="stm-tooltip-link"
													data-toggle="tooltip"
													data-placement="bottom"
													title="<?php echo esc_attr( implode( ', ', $datas ) ); ?>">
													<?php echo esc_html( $datas[0] ) . '<span class="stm-dots dots-aligned">...</span>'; ?>
												</span>
											<?php else : ?>
												<span><?php echo esc_html( implode( ', ', $datas ) ); ?></span>
											<?php endif; ?>
									<?php endif; ?>

								<?php endif; ?>
							</li>
						<?php endif; ?>

					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

		</div>
	</a>
</div>
