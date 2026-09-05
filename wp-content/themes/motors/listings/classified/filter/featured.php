<?php
$args = ( is_object( apply_filters( 'stm_listings_query', null ) ) ) ? apply_filters( 'stm_listings_query', null )->query : array();

if ( boolval( apply_filters( 'is_listing', array() ) ) ) {
	$args['meta_query'][] = array(
		'key'     => 'special_car',
		'value'   => 'on',
		'compare' => '=',
	);
} else {
	$args['meta_query'][] = array(
		'key'     => 'special_car',
		'value'   => 'on',
		'compare' => '=',
	);
}

if ( sort_distance_nearby() ) {
	$args['orderby'] = 'stm_distance';
} else {
	$args['orderby'] = 'rand';
}

$nuxy_mod_option        = apply_filters( 'motors_vl_get_nuxy_mod', 'list', 'listing_view_type' );
$view_type              = apply_filters( 'stm_listings_input', $nuxy_mod_option, 'view_type' );
$skin                   = apply_filters( 'motors_vl_get_nuxy_mod', 'default', $view_type . '_card_skin' );
$args['posts_per_page'] = apply_filters( 'motors_vl_get_nuxy_mod', 3, 'list' === $view_type ? 'featured_listings_list_amount' : 'featured_listings_grid_amount' );
$featured               = new WP_Query( $args );

if ( 'default' !== $skin ) {
	motors_include_once_scripts_styles( 'list-grid-card-styles' );
}

if ( wp_is_mobile() ) {
	$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', 'listing_view_type_mobile' );
}
$view_type              = apply_filters( 'stm_listings_input', $nuxy_mod_option, 'view_type' );
$args['posts_per_page'] = apply_filters( 'motors_vl_get_nuxy_mod', 3, 'list' === $view_type ? 'featured_listings_list_amount' : 'featured_listings_grid_amount' );
$featured               = new WP_Query( $args );
$url_args               = $_GET; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
if ( isset( $url_args['ajax_action'] ) ) {
	unset( $url_args['ajax_action'] );
}
if ( isset( $url_args['posttype'] ) && 'undefined' === $url_args['posttype'] ) {
	unset( $url_args['posttype'] );
}

if ( isset( $url_args['featured_top'] ) && $url_args['featured_top'] ) {
	$inventory_link = false;
} elseif ( stm_is_multilisting() ) {
	$inventory_link = add_query_arg( array_merge( $url_args, array( 'featured_top' => 'true' ) ), apply_filters( 'stm_inventory_page_url', '', $args['post_type'] ) );
} else {
	$inventory_link = add_query_arg( array_merge( $url_args, array( 'featured_top' => 'true' ) ), apply_filters( 'stm_filter_listing_link', '' ) );
}

$template_args = array();
if ( ! empty( $args['custom_img_size'] ) ) {
	$template_args['custom_img_size'] = $args['custom_img_size'];
}
if ( isset( $listings_grid_view_skin ) && isset( $listing_list_view_skin ) ) {
	$template_args['listings_grid_view_skin'] = $listings_grid_view_skin;
	$template_args['listings_list_view_skin'] = $listing_list_view_skin;
	$skin                                     = $template_args[ 'listings_' . $view_type . '_view_skin' ];
	$template_args['skin']                    = $skin;
}

if ( $featured->have_posts() && ! empty( $args['posts_per_page'] ) ) : ?>
	<div class="stm-featured-top-cars-title">
		<div class="heading-font"><?php esc_html_e( 'Featured Classified', 'motors' ); ?></div>
		<?php if ( $inventory_link ) : ?>
			<a href="<?php echo esc_url( $inventory_link ); ?>">
				<?php esc_html_e( 'Show all', 'motors' ); ?>
			</a>
		<?php endif; ?>
	</div>

	<?php if ( ! apply_filters( 'stm_listings_input', null, 'featured_top' ) ) : ?>
		<?php if ( 'grid' === $view_type ) : ?>
			<div class="row row-3 car-listing-row car-listing-modern-grid <?php echo esc_attr( 'default' !== $skin ? '' . $skin . ' skin_card' : '' ); ?>">
		<?php endif; ?>

			<div class="stm-isotope-sorting stm-isotope-sorting-featured-top stm-isotope-sorting-<?php echo esc_attr( $view_type ); ?> <?php echo esc_attr( 'default' !== $skin ? 'mvl-card-skin ' . $skin : '' ); ?>">

				<?php
					$template = 'partials/listing-cars/listing-' . $view_type . '-directory-loop';
				while ( $featured->have_posts() ) :
					$featured->the_post();
					if ( 'default' !== $skin ) {
						do_action( 'stm_listings_load_template', 'listing-' . $view_type );
					} else {
						if ( apply_filters( 'stm_is_listing_four', false ) ) {
							get_template_part( 'partials/listing-cars/listing-four-' . $view_type . '-loop', null, $template_args );
						} else {
							get_template_part( 'partials/listing-cars/listing-' . $view_type . '-directory-loop', null, $template_args );
						}
					}
					endwhile;
				?>

			</div>

		<?php if ( 'grid' === $view_type ) : ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
