<?php
$current = apply_filters( 'stm_account_current_page', '' );

motors_include_once_scripts_styles( array( 'jquery.countdown.js', 'chart-js' ) );

if ( 'inventory' === $current || stm_is_multilisting() ) {
	motors_include_once_scripts_styles( array( 'stmselect2', 'app-select2' ) );
}

if ( 'settings' === $current || 'become-dealer' === $current ) {
	do_action( 'stm_google_places_script', 'enqueue' );
}

$posts_per_page   = get_option( 'posts_per_page' );
$page             = ( ! empty( $_GET['page'] ) ) ? intval( $_GET['page'] ) : 1; //phpcs:ignore WordPress.Security.NonceVerification.Recommended
$offset           = ! empty( $_GET['sort_by'] ) && 'recent' === $_GET['sort_by'] ? $posts_per_page * ( $page - 1 ) : 0;
$show_more_button = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_more_button_user_profile' );
$skin             = apply_filters( 'motors_vl_get_nuxy_mod', 'default', 'list_card_skin' );
?>

<div class="stm-user-private-main">

	<?php if ( 'favourite' === $current ) : ?>

		<div class="archive-listing-page">
			<?php get_template_part( 'partials/user/private/user-favourite' ); ?>
		</div>

	<?php elseif ( 'my-plans' === $current ) : ?>
		<div class="my-plans-wrapper">
			<h4 class="stm-seller-title stm-main-title"><?php echo esc_html__( 'My Plans', 'motors' ); ?></h4>
			<?php get_template_part( 'partials/user/private/user-plans' ); ?>
		</div>
	<?php elseif ( 'settings' === $current ) : ?>

		<?php get_template_part( 'partials/user/private/' . ( apply_filters( 'stm_get_user_role', false, get_current_user_id() ) ? 'dealer-settings' : 'user-settings' ) ); ?>

	<?php elseif ( 'become-dealer' === $current ) : ?>

		<?php get_template_part( 'partials/user/private/become-dealer' ); ?>

	<?php elseif ( 'saved-searches' === $current ) : ?>
		<?php do_action( 'load_saved_searches_page' ); ?>
		<?php
	elseif ( 'inventory' === $current || ! empty( $_GET['page'] ) ) :
		$posts_per_page = get_option( 'posts_per_page' );

		$query       = ( function_exists( 'stm_user_listings_query' ) ) ? stm_user_listings_query( get_current_user_id(), 'any', $posts_per_page, false, $offset ) : null;
		$query_ppl   = ( function_exists( 'stm_user_pay_per_listings_query' ) ) ? stm_user_pay_per_listings_query( get_current_user_id(), 'any', $posts_per_page, false, $offset ) : null;
		$tabs_active = ( null !== $query && $query->have_posts() && null !== $query_ppl && $query_ppl->have_posts() ) ? true : false;
		?>

		<?php get_template_part( 'partials/user/private/user', 'inventory' ); ?>

		<?php if ( null !== $query && $query->have_posts() || null !== $query_ppl && $query_ppl->have_posts() ) : ?>
		<div class="archive-listing-page">
			<?php
			if ( $tabs_active ) :
				?>
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active">
						<a href="#pp" class="nav-link active heading-font" id="pp-tab" data-toggle="tab" role="tab" aria-controls="pp" aria-selected="true">
							<?php echo esc_html__( 'Subscription Listings', 'motors' ); ?>
						</a>
					</li>
					<li class="nav-item">
						<a href="#ppl" class="nav-link heading-font" id="ppl-tab" data-toggle="tab" role="tab" aria-controls="ppl" aria-selected="false">
							<?php echo esc_html__( 'Pay Per Listings', 'motors' ); ?>
						</a>
					</li>
				</ul>
				<?php
			endif;

			if ( $tabs_active ) :
				?>
			<div class="tab-content">
				<div class="tab-pane active" id="pp" role="tabpanel" aria-labelledby="pp-tab">
					<?php endif; ?>
					<div class="car-listing-row">
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							if ( 'default' !== $skin && is_mvl_pro() ) {
								?>
							<div class="stm_listing_edit_car <?php echo esc_attr( get_post_status( get_the_id() ) ); ?>">
								<?php
								do_action(
									'stm_listings_load_template',
									'listing-list',
									array(
										'list_action_buttons'    => apply_filters( 'mvl_list_action_buttons', array() ),
										'list_action_popup_btns' => apply_filters( 'mvl_list_action_popup_buttons', array() ),
									)
								);
								?>
								<div class="mvl-custom-skin-actions listing-list-loop">
									<div class="content">
										<div class="meta-bottom">
										<?php do_action( 'stm_listings_load_template', 'listing-cars/listing-list-owner-actions' ); ?>
										</div>	
									</div>
								</div>
							</div>
								<?php
							} else {
								get_template_part( 'partials/listing-cars/listing-list-directory-edit', 'loop' );
							}
							?>
						<?php endwhile; ?>
					</div>

					<?php if ( $query->found_posts > $posts_per_page && $show_more_button ) : ?>
						<div class="stm-load-more-dealer-cars">
							<a data-offset="<?php echo esc_attr( $posts_per_page ); ?>" data-user="<?php echo esc_attr( get_current_user_id() ); ?>" data-popular="no" data-profile="1" href="#" class="heading-font"><span><?php esc_html_e( 'Show more', 'motors' ); ?></span></a>
						</div>
						<?php
					else :
						do_action( 'delear_public_page_pagination', $query, $page, $posts_per_page, 'recent' );
					endif;
					?>

					<?php if ( $tabs_active ) : ?>
				</div>
				<?php endif; ?>

				<?php if ( $tabs_active ) : ?>
				<div class="tab-pane" id="ppl" role="tabpanel" aria-labelledby="ppl-tab">
					<?php endif; ?>

					<?php
					if ( null !== $query_ppl && $query_ppl->have_posts() ) :
						while ( $query_ppl->have_posts() ) :
							$query_ppl->the_post();
							?>
							<?php get_template_part( 'partials/listing-cars/listing-list-directory-edit', 'loop' ); ?>
							<?php
						endwhile;
					endif;
					?>

					<?php if ( $tabs_active ) : ?>
				</div>
			</div>
		<?php endif; ?>
		</div>
		<h4><?php esc_html_e( 'No listings yet', 'motors' ); ?></h4>
	<?php endif; ?>

		<?php
	else :

		do_action( 'stm_account_custom_page', $current );

	endif;
	?>

	<!-- Show "Site is on demo mode" modal alert -->
	<?php get_template_part( 'partials/user/private/demo-alert' ); ?>

</div>
