<?php
$post_type          = get_query_var( 'post_type' );
$similar_taxonomies = apply_filters( 'motors_vl_get_nuxy_mod', '', 'stm_similar_query' );
if ( function_exists( 'stm_is_multilisting' ) && stm_is_multilisting() && apply_filters( 'stm_listings_post_type', 'listings' ) !== $post_type ) {
	$ml                 = new STMMultiListing();
	$similar_taxonomies = (string) $ml->stm_get_listing_type_settings( 'stm_similar_query', $post_type );
}
$similar_taxonomies = ! empty( $similar_taxonomies ) ? explode( ',', $similar_taxonomies ) : array();

$query = apply_filters( 'stm_similar_cars', null, $similar_taxonomies );

if ( ! is_null( $query ) ) {
	if ( $query->post_count < 3 && empty( $similar_taxonomies ) ) {
		$fallback_query = apply_filters( 'stm_similar_cars', null, array(), intval( 3 - $query->post_count ), wp_list_pluck( $query->posts, 'ID' ) );

		if ( $fallback_query instanceof WP_Query && ! empty( $fallback_query->posts ) ) {
			$query->posts       = array_merge( $query->posts, $fallback_query->posts );
			$query->post_count  = $query->post_count + $fallback_query->post_count;
			$query->found_posts = $query->post_count;
			$query->rewind_posts();
		}
	}

	if ( $query->have_posts() ) :
		?>

		<div class="stm-similar-cars-units">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				?>
				<a href="<?php the_permalink(); ?>" class="stm-similar-car clearfix">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="image">
							<?php the_post_thumbnail( 'stm-img-350-356', array( 'class' => 'img-responsive' ) ); ?>
						</div>
					<?php endif; ?>
					<div class="right-unit">
						<div class="title"><?php echo apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID() );//phpcs:ignore ?></div>
						<?php
						$user_added_by = get_post_meta( get_the_ID(), 'stm_car_user', true );
						if ( ! empty( $user_added_by ) ) {
							$user_exist = get_userdata( $user_added_by );
						}
						if ( boolval( apply_filters( 'is_listing', array() ) ) ) :
							?>

							<div class="stm-dealer-name">
								<?php if ( ! empty( $user_exist ) && $user_exist ) : ?>
									<?php echo stm_display_user_name( $user_added_by );//phpcs:ignore ?>
								<?php endif; ?>
							</div>
							<?php
						endif;
						$price_label = get_post_meta( get_the_ID(), 'car_price_form_label', true );
						$price       = get_post_meta( get_the_ID(), 'price', true );
						$sale_price  = get_post_meta( get_the_ID(), 'sale_price', true );

						if ( ! empty( $sale_price ) ) {
							$price = $sale_price;
						}

						if ( ! empty( $price_label ) ) {
							$price = $price_label;
						} else {
							$price = apply_filters( 'stm_filter_price_view', '', $price );
						}
						?>

						<div class="clearfix">

							<?php if ( ! empty( $price ) ) : ?>
								<div class="stm-price heading-font"><?php echo wp_kses_post( $price ); ?></div>
							<?php endif; ?>

							<?php
							$labels = apply_filters( 'stm_get_car_listings', array() );
							if ( ! empty( $labels[0] ) ) {
								$labels = $labels[0];
							}
							?>

							<?php if ( ! empty( $labels ) ) : ?>
								<div class="stm-car-similar-meta">
									<?php
									$value = '';
									if ( ! empty( $labels['numeric'] ) && $labels['numeric'] ) {
										$value = get_post_meta( get_the_ID(), $labels['slug'], true );
										if ( ! empty( $labels['number_field_affix'] ) ) {
											$value .= ' ' . $labels['number_field_affix'];
										}
									} else {
										$meta = get_post_meta( get_the_ID(), $labels['slug'], true );
										if ( ! empty( $meta ) ) {
											$meta = explode( ',', $meta );
											if ( ! empty( $meta[0] ) ) {
												$meta  = get_term_by( 'slug', $meta[0], $labels['slug'] );
												$value = $meta->name;
											}
										}
									}
									?>

									<?php if ( ! empty( $labels['font'] ) ) : ?>
										<i class="<?php echo esc_attr( $labels['font'] ); ?>"></i>
									<?php endif; ?>

									<?php if ( ! empty( $value ) ) : ?>
										<span><?php echo esc_attr( $value ); ?></span>
									<?php endif; ?>

								</div>
							<?php endif; ?>

						</div>

					</div>
				</a>
			<?php endwhile; ?>
		</div>
		<?php wp_reset_postdata(); ?>
		<?php
	endif;
}
