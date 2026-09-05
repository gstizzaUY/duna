<?php
/**
 * @var $type
 * @var $navigation_type
*/

$query = $GLOBALS['wp_query'];

mvl_enqueue_header_scripts_styles( 'listing-search-empty-results' );

$grid_action_buttons = array(
	'listing_test_drive' => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_test_drive_grid_as_btn' ),
	'listing_share'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_share_grid_as_btn' ),
	'listing_pdf'        => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_pdf_grid_as_btn' ),
	'listing_quote'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_quote_grid_as_btn' ),
	'listing_trade'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_trade_grid_as_btn' ),
);

$grid_action_popup_btns = array(
	'listing_test_drive' => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_test_drive_grid' ),
	'listing_share'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_share_grid' ),
	'listing_pdf'        => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_pdf_grid' ),
	'listing_quote'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_quote_grid' ),
	'listing_trade'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_trade_grid' ),
);

$list_action_buttons = array(
	'listing_test_drive' => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_test_drive_as_btn' ),
	'listing_share'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_share_as_btn' ),
	'listing_pdf'        => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_pdf_as_btn' ),
	'listing_quote'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_quote_as_btn' ),
	'listing_trade'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_trade_as_btn' ),
);

$list_action_popup_btns = array(
	'listing_test_drive' => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_test_drive' ),
	'listing_share'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_share' ),
	'listing_pdf'        => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_pdf' ),
	'listing_quote'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_quote' ),
	'listing_trade'      => apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_listing_trade' ),
);

$action_buttons_hover = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_actions_button_on_hover_grid' );
$veiw_details_grid    = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_view_details_button_grid' );
$veiw_details_list    = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_view_details_button' );

$__vars['grid_action_buttons']     = isset( $grid_action_buttons ) ? $grid_action_buttons : array();
$__vars['grid_action_popup_btns']  = isset( $grid_action_popup_btns ) ? $grid_action_popup_btns : array();
$__vars['list_action_buttons']     = isset( $list_action_buttons ) ? $list_action_buttons : array();
$__vars['list_action_popup_btns']  = isset( $list_action_popup_btns ) ? $list_action_popup_btns : array();
$__vars['veiw_details_grid']       = isset( $veiw_details_grid ) ? $veiw_details_grid : false;
$__vars['veiw_details_list']       = isset( $veiw_details_list ) ? $veiw_details_list : false;
$__vars['action_buttons_hover']    = isset( $action_buttons_hover ) ? $action_buttons_hover : false;
$__vars['listings_grid_view_skin'] = isset( $listings_grid_view_skin ) ? $listings_grid_view_skin : false;
$__vars['listings_list_view_skin'] = isset( $listings_list_view_skin ) ? $listings_list_view_skin : false;

$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'list', 'listing_view_type' );

if ( wp_is_mobile() ) {
	$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', 'listing_view_type_mobile' );
}

if ( function_exists( 'stm_is_multilisting' ) && stm_is_multilisting() && wp_is_mobile() ) {
	$nuxy_mod_option = apply_filters( 'motors_vl_get_nuxy_mod', 'grid', get_query_var( 'post_type' ) . '_view_type_mobile' );
}

$view_type = apply_filters( 'stm_listings_input', $nuxy_mod_option, 'view_type' );
$skin      = apply_filters( 'motors_vl_get_nuxy_mod', 'default', $view_type . '_card_skin' );


if ( is_mvl_pro() ) {
	$skin_key = 'listings_' . $view_type . '_view_skin';
	$skin     = isset( $__vars[ $skin_key ] ) && $__vars[ $skin_key ] && 'default' !== $__vars[ $skin_key ] ? $__vars[ $skin_key ] : $skin;
} else {
	$skin = 'default';
}

$__vars['skin'] = $skin;


if ( 'default' !== apply_filters( 'motors_vl_get_nuxy_mod', 'default', 'inventory_skin' ) ) {
	motors_include_once_scripts_styles( 'custom-fields-styles' );
	wp_deregister_script( 'stm-theme-script-filter' );
}

if ( have_posts() ) :

	if ( 'default' !== $skin ) {
		motors_include_once_scripts_styles( 'list-grid-card-styles' );
	}

	$template_args = array();
	if ( ! empty( $custom_img_size ) && ( in_array( $custom_img_size, get_intermediate_image_sizes(), true ) || 'full' === $custom_img_size ) ) {
		$template_args['custom_img_size'] = $custom_img_size;
	}

	/*Filter Badges*/
	if ( 'default' === apply_filters( 'motors_vl_get_nuxy_mod', 'default', 'inventory_skin' ) ) {
		do_action( 'stm_listings_load_template', 'filter/badges' );
	}

	if ( apply_filters( 'is_listing', array() ) && 'sold_car' !== $type ) {
		$template = ( 'default' === $skin ) ? 'classified/filter/featured' : 'filter/featured';
		do_action( 'stm_listings_load_template', $template, $__vars );
	}

	?>

	<div class="stm-isotope-sorting stm-isotope-sorting-main stm-isotope-sorting-<?php echo esc_attr( $view_type ); ?> <?php echo esc_attr( 'default' !== $skin ? '' . $skin : '' ); ?>">
		<?php
		if ( 'grid' === $view_type ) :
			?>
		<div class="row row-3 car-listing-row car-listing-modern-grid <?php echo esc_attr( 'default' !== $skin ? '' . $skin . ' skin_card' : '' ); ?>">
			<?php
		endif;

			$template = 'partials/listing-cars/listing-' . $view_type . '-loop';

		if ( apply_filters( 'stm_is_ev_dealer', false ) || apply_filters( 'is_listing', array( 'listing', 'listing_two', 'listing_two_elementor', 'listing_three', 'listing_three_elementor', 'listing_one_elementor' ) ) || apply_filters( 'stm_is_dealer_two', false ) || apply_filters( 'stm_is_listing_five', false ) || apply_filters( 'stm_is_listing_six', false ) ) {
			$template = 'partials/listing-cars/listing-' . $view_type . '-directory-loop';
		} elseif ( apply_filters( 'stm_is_listing_four', false ) ) {
			$template = 'partials/listing-cars/listing-four-' . $view_type . '-loop';
		} elseif ( apply_filters( 'stm_is_boats', false ) && 'list' === $view_type ) {
			$template = 'partials/listing-cars/listing-' . $view_type . '-loop-boats';
		} elseif ( apply_filters( 'stm_is_motorcycle', false ) ) {
			$template = 'partials/listing-cars/motos/' . $view_type;
		} elseif ( apply_filters( 'stm_is_aircrafts', false ) ) {
			$template = 'partials/listing-cars/listing-aircrafts-' . $view_type;
		}

		while ( have_posts() ) :
			the_post();

			if ( 'default' !== $skin ) {
				do_action( 'stm_listings_load_template', 'listing-' . $view_type, $__vars );
			} else {
				get_template_part( $template, null, $template_args );
			}

		endwhile;
		if ( 'grid' === $view_type ) :
			?>
		</div>
	<?php endif; ?>

	</div>
	<?php
	if ( is_null( $navigation_type ) || 'pagination' === $navigation_type ) :
		stm_listings_load_pagination( $__vars['posts_per_page'] );
	else :
		$ppp   = $query->query['posts_per_page'];
		$paged = ( ! empty( $query->query['paged'] ) && 1 !== $query->query['paged'] ) ? $query->query['paged'] + 1 : 2;

		if ( $ppp < $query->found_posts ) {
			echo "<a class='btn stm-inventory-load-more-btn' href='#' data-ppp='" . esc_attr( $ppp ) . "' data-page='" . esc_attr( $paged ) . "' data-nav='load_more' data-offset='1'>" . esc_html__( 'Load More', 'motors' ) . '</a>';
		}
	endif;

	wp_reset_query(); //phpcs:ignore
	?>
<?php else : ?>

	<div class="stm-listings-empty">
		<span class="stm-icon-search-list"></span>
		<span class="stm-listings-empty__not-found"><?php esc_html_e( 'Not found any vehicle based on your filter', 'motors' ); ?></span>
		<span class="stm-listings-empty__another"><?php esc_html_e( 'Try another filter, location or keywords', 'motors' ); ?></span>
		<?php
		$reset_url = ( ! apply_filters( 'motors_vl_get_nuxy_mod', false, 'friendly_url' ) ) ? strtok( $_SERVER['REQUEST_URI'], '?' ) : apply_filters( 'stm_inventory_page_url', '', get_query_var( 'post_type' ) );
		?>
		<a href="<?php echo esc_url( $reset_url ); ?>" class="stm-listings-empty__button">
			<span><?php esc_html_e( 'Reset filters', 'motors' ); ?></span>
		</a>
	</div>

	<?php
	if ( ! apply_filters( 'motors_vl_get_nuxy_mod', true, 'enable_distance_search' ) && apply_filters( 'motors_vl_get_nuxy_mod', false, 'recommend_items_empty_result' ) ) {
		do_action( 'stm_listings_load_template', 'filter/inventory/items-empty' );
	}

	endif;
?>
<?php if ( apply_filters( 'stm_is_aircrafts', false ) ) : ?>
	<script>
		jQuery(document).ready(function (){
			var showing = '<?php echo esc_html( $query->found_posts ); ?>';

			jQuery('.ac-total').text('<?php echo esc_html( $query->found_posts ); ?>');

			if(showing === '0') {
				jQuery('.ac-showing').text('0');
			}
		});
	</script>
<?php endif; ?>
