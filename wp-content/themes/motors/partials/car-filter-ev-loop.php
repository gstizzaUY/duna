<?php
$gallery_hover_interaction = apply_filters( 'motors_vl_get_nuxy_mod', false, 'gallery_hover_interaction' );
$show_compare              = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_compare' );

$size             = 'stm-img-275';
$thumbs           = apply_filters( 'stm_get_hoverable_thumbs', array(), get_the_ID(), $size );
$placeholder_path = 'plchldr255.png';
$img_attrs        = array(
	'sizes'   => '(max-width: 767px) 100vw, (max-width: 991px) 33vw, (max-width: 1190px) 25vw, 275px',
	'class'   => 'img-responsive',
	'alt'     => get_the_title(),
	'loading' => 'lazy',
);
?>
<div class="col-md-3 col-sm-4 col-xs-12 col-xxs-12 stm-template-front-loop ev-filter-loop">
	<a href="<?php the_permalink(); ?>" class="rmv_txt_drctn xx">
		<div class="image">

			<?php if ( $gallery_hover_interaction && count( $thumbs['gallery'] ) > 1 && ! wp_is_mobile() ) : ?>
				<!-- "interactive-hoverable" -->
				<div class="interactive-hoverable">
					<?php do_action( 'stm_listing_image_hover_gallery', $thumbs, $size, $img_attrs, false ); ?>
					<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>
					<?php get_template_part( 'partials/price-electric', 'badge' ); ?>
				</div>

			<?php elseif ( has_post_thumbnail( get_the_ID() ) ) : ?>

				<?php echo wp_kses_post( wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), $size, false, $img_attrs ) ); ?>
				<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>
				<?php get_template_part( 'partials/price-electric', 'badge' ); ?>

			<?php else : ?>

				<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path ); ?>" alt="<?php esc_attr_e( 'Placeholder', 'motors' ); ?>" class="img-responsive" loading="lazy"/>
				<?php get_template_part( 'partials/listing-cars/listing-directory', 'badges' ); ?>
				<?php get_template_part( 'partials/price-electric', 'badge' ); ?>

			<?php endif; ?>

			<?php if ( ! empty( $show_compare ) && true === $show_compare ) : ?>
				<div
						class="stm-listing-compare stm-compare-directory-new"
						data-post-type="<?php echo esc_attr( get_post_type( get_the_ID() ) ); ?>"
						data-id="<?php echo esc_attr( get_the_ID() ); ?>"
						data-title="<?php echo esc_attr( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), false ) ); ?>"
						data-toggle="tooltip" data-placement="right"
						title="<?php esc_attr_e( 'Add to compare', 'motors' ); ?>"
				>
					<i class="stm-boats-icon-add-to-compare"></i>
				</div>
			<?php endif; ?>
		</div>

		<div class="listing-car-item-meta">
			<div class="car-meta-top heading-font clearfix">
				<div class="car-title">
					<?php
					$listing_title = apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), true );
					if ( ! empty( $listing_title ) ) {
						echo wp_kses( $listing_title, array( 'div' => array( 'class' => array() ) ) );
					}
					?>
				</div>
			</div>

			<?php
			$labels = apply_filters( 'stm_get_car_listings', array() );
			if ( ! empty( $labels ) ) :
				?>

			<div class="car-meta-bottom">
				<ul>
					<?php
					foreach ( $labels as $label ) :
						$label_meta = get_post_meta( get_the_ID(), $label['slug'], true );
						if ( empty( $label_meta ) ) {
							continue;
						}

						if ( ! apply_filters( 'stm_is_listing_price_field', true, $label['slug'] ) ) :
							$single_name = esc_attr__( 'Listing attribute', 'motors' );

							if ( ! empty( $label['single_name'] ) ) {
								$single_name = $label['single_name'];
							}
							?>
							<li title="<?php echo esc_attr( $single_name ); ?>">
								<?php if ( ! empty( $label['font'] ) ) : ?>
									<i class="<?php echo esc_attr( $label['font'] ); ?>"></i>
								<?php endif; ?>

								<?php
								if ( ! empty( $label['numeric'] ) && $label['numeric'] ) :
									$affix = '';
									if ( ! empty( $label['number_field_affix'] ) ) {
										$affix = $label['number_field_affix'];
									}
									?>
									<span><?php echo esc_html( $label_meta . $affix ); ?></span>
								<?php else : ?>

									<?php
										$data_meta_array = explode( ',', $label_meta );
										$datas           = array();

									if ( ! empty( $data_meta_array ) ) {
										foreach ( $data_meta_array as $data_meta_single ) {
											$data_meta = get_term_by( 'slug', $data_meta_single, $label['slug'] );
											if ( is_object( $data_meta ) && ! empty( $data_meta->name ) ) {
												$datas[] = esc_attr( $data_meta->name );
											} else {
												echo '---';
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
