<?php
$user_page        = get_queried_object();
$user_id          = $user_page->data->ID;
$show_more_button = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_more_button_user_profile' );
$page             = ( ! empty( $_GET['page'] ) ) ? intval( $_GET['page'] ) : 1;
$posts_per_page   = apply_filters( 'motors_vl_get_nuxy_mod', 6, 'post_per_page_user_inventory' );
$offset           = ! empty( $_GET['sort_by'] ) && 'recent' === $_GET['sort_by'] ? $posts_per_page * ( $page - 1 ) : 0;
$offset_popular   = ! empty( $_GET['sort_by'] ) && 'popular' === $_GET['sort_by'] ? $posts_per_page * ( $page - 1 ) : 0;
$query            = ( function_exists( 'stm_user_listings_query' ) ) ? stm_user_listings_query( $user_id, 'publish', $posts_per_page, false, $offset, false, true ) : null;
$query_popular    = ( function_exists( 'stm_user_listings_query' ) ) ? stm_user_listings_query( $user_id, 'publish', $posts_per_page, true, $offset_popular, false, true ) : null;

$row    = 'row row-3';
$active = 'grid';
$list   = '';
$grid   = 'active';
if ( ! empty( $_GET['view_type'] ) && 'list' === $_GET['view_type'] ) {
	$list   = 'active';
	$grid   = '';
	$active = 'list';
	$row    = 'row-no-border-last';
}

$additional_class = '';

$skin = apply_filters( 'motors_vl_get_nuxy_mod', 'default', $active . '_card_skin' );

if ( 'default' !== $skin ) {
	$additional_class = 'mvl-card-skin';
}

?>

<div class="stm_listing_tabs_style_2 stm-car-listing-sort-units stm-car-listing-directory-sort-units clearfix">
	<input type="hidden" id="stm_user_dealer_view_type" value="<?php echo esc_attr( $active ); ?>">
	<ul role="tablist" class="hidden">
		<li role="presentation">
			<a href="#popular" aria-controls="popular" role="tab" data-toggle="tab">p</a>
		</li>
		<li role="presentation">
			<a href="#recent" aria-controls="recent" role="tab" data-toggle="tab" class="active">r</a>
		</li>
	</ul>
	<h4 class="stm-seller-title"><?php esc_html_e( 'Dealer Inventory', 'motors' ); ?></h4>

	<div class="stm-directory-listing-top__right">
		<div class="clearfix">
			<div class="stm-view-by">
				<a href="?view_type=grid#stm_d_inv" class="stm-modern-view view-grid view-type <?php echo esc_attr( $grid ); ?>">
					<i class="stm-icon-grid"></i>
				</a>
				<a href="?view_type=list#stm_d_inv" class="stm-modern-view view-list view-type <?php echo esc_attr( $list ); ?>">
					<i class="stm-icon-list"></i>
				</a>
			</div>
			<div class="stm-sort-by-options clearfix">
				<span><?php esc_html_e( 'Sort by', 'motors' ); ?>:</span>
				<div class="stm-select-sorting">
					<select id="stm-dealer-view-type">
						<option value="popular"><?php esc_html_e( 'Popular items', 'motors' ); ?></option>
						<option value="recent" selected=""><?php esc_html_e( 'Recent items', 'motors' ); ?></option>
					</select>
				</div>
			</div>
			<?php if ( stm_is_multilisting() ) : ?>
				<div class="multilisting-select">
					<?php
					$listings = function_exists( 'mvl_listings_multi_type_labeled' ) ? mvl_listings_multi_type_labeled( true ) : stm_listings_multi_type_labeled( true );
					if ( ! empty( $listings ) ) :
						?>
						<div class="select-type select-listing-type" style="margin-right: 15px;">
							<div class="stm-label-type"><?php esc_html_e( 'Listing type', 'motors' ); ?></div>
							<select data-user="<?php echo esc_attr( $user_id ); ?>" data-posts-per-page="<?php echo esc_attr( $posts_per_page ); ?>" data-offset="<?php echo esc_attr( $offset ); ?>">
								<option value="all" selected><?php esc_html_e( 'All Listings', 'motors' ); ?></option>
								<?php foreach ( $listings as $slug => $label ) : ?>
									<option value="<?php echo esc_attr( $slug ); ?>" <?php echo ( isset( $_GET['listing_type'] ) && ! empty( $_GET['listing_type'] ) && $_GET['listing_type'] === $slug ) ? 'selected' : ''; ?>><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php if ( null !== $query && $query->have_posts() ) : ?>

	<div class="tab-content">
		<div class="tab-pane fade active in" role="tabpanel" id="recent">
			<?php if ( $query->have_posts() ) : ?>
				<div class="car-listing-row <?php echo esc_attr( $row ); ?> <?php echo esc_attr( $additional_class ); ?>">
					<?php
					$counter = 0;
					while ( $query->have_posts() && $counter < $posts_per_page ) :
						$query->the_post();
						if ( 'active' === $grid ) {
							do_action( 'stm_listings_load_template', 'listing-grid', array( 'columns' => 4 ) );
						} else {
							do_action( 'stm_listings_load_template', 'listing-list' );
						}
						$counter ++;
					endwhile;
					?>
				</div>
				<?php if ( $query->found_posts > $posts_per_page && $show_more_button ) : ?>
					<div class="stm-load-more-dealer-cars">
						<a data-offset="<?php echo esc_attr( $posts_per_page ); ?>" data-user="<?php echo esc_attr( $user_id ); ?>" data-popular="no" href="#" class="heading-font"><span><?php esc_html_e( 'Show more', 'motors' ); ?></span></a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<div class="tab-pane fade" role="tabpanel" id="popular">
			<?php if ( null !== $query_popular && $query_popular->have_posts() ) : ?>
				<div class="car-listing-row <?php echo esc_attr( $row ); ?> <?php echo esc_attr( $additional_class ); ?>">
					<?php
					while ( $query_popular->have_posts() ) :
						$query_popular->the_post();
						if ( 'active' === $grid ) {
							do_action( 'stm_listings_load_template', 'listing-grid', array( 'columns' => 4 ) );
						} else {
							do_action( 'stm_listings_load_template', 'listing-list' );
						}
					endwhile;
					?>
				</div>
				<?php if ( $query->found_posts > $posts_per_page && $show_more_button ) : ?>
					<div class="stm-load-more-dealer-cars">
						<a data-offset="<?php echo esc_attr( $posts_per_page ); ?>" data-user="<?php echo esc_attr( $user_id ); ?>" data-popular="yes" href="#" class="heading-font"><span><?php esc_html_e( 'Show more', 'motors' ); ?></span></a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<?php
	if ( ! $show_more_button ) :
		?>
		<div class="recent user-listings-pagination active">
			<?php
			do_action( 'delear_public_page_pagination', $query, $page, $posts_per_page, 'recent' );
			?>
		</div>
		<div class="popular user-listings-pagination">
			<?php
			do_action( 'delear_public_page_pagination', $query, $page, $posts_per_page, 'popular' );
			?>
		</div>
		<?php
	endif;
	?>
<?php else : ?>
	<h4 class="stm-seller-title"
		style="color:#aaa; margin-top:44px"><?php esc_html_e( 'No Inventory added yet.', 'motors' ); ?></h4>
<?php endif; ?>

<?php
$current_url = apply_filters( 'stm_get_author_link', '' );
$glue        = '?';

if ( isset( $_GET ) && ! empty( $_GET ) ) {
	$url_array = $_GET;
	if ( isset( $url_array['listing_type'] ) ) {
		unset( $url_array['listing_type'] );
	}

	if ( ! empty( $url_array ) ) {
		$current_url = add_query_arg( $url_array, apply_filters( 'stm_get_author_link', '' ) );
		$glue        = '&';
	}
}
?>
