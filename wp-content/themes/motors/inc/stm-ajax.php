<?php
// Ajax filter cars remove unfiltered cars
function stm_ajax_filter_remove_hidden() {
	check_ajax_referer( 'stm_security_nonce', 'security' );
	$stm_listing_filter  = stm_get_filter();
	$response            = array();
	$response['binding'] = $stm_listing_filter['binding'];
	$response['length']  = count( $stm_listing_filter['posts'] );

	wp_send_json( $response );
	exit;
}

add_action( 'wp_ajax_stm_ajax_filter_remove_hidden', 'stm_ajax_filter_remove_hidden' );
add_action( 'wp_ajax_nopriv_stm_ajax_filter_remove_hidden', 'stm_ajax_filter_remove_hidden' );

// Ajax add to compare
function stm_ajax_add_to_compare() {

	check_ajax_referer( 'stm_security_nonce', 'security' );

	if ( empty( $_POST['post_id'] ) ) {
		return false;
	}

	$response['response']    = '';
	$response['status']      = '';
	$response['empty']       = '';
	$response['empty_table'] = '';
	$response['add_to_text'] = esc_html__( 'Add to compare', 'motors' );
	$response['in_com_text'] = esc_html__( 'In compare list', 'motors' );
	$response['remove_text'] = esc_html__( 'Remove from list', 'motors' );

	$post_id        = intval( filter_var( wp_unslash( $_POST['post_id'] ), FILTER_SANITIZE_NUMBER_INT ) );
	$post_title     = get_the_title( $post_id );
	$post_type      = get_post_type( $post_id );
	$compared_items = apply_filters( 'stm_get_compared_items', array(), $post_type );

	if ( ! empty( $_POST['post_action'] ) && 'remove' === $_POST['post_action'] ) {
		do_action( 'stm_remove_compared_item', $post_id );
		$response['status']   = 'success';
		$response['response'] = sprintf( esc_html__( '%s has been removed from compare', 'motors' ), $post_title );
	} else {
		if ( ! in_array( $post_id, $compared_items, true ) ) {
			if ( count( $compared_items ) < 3 ) {
				stm_set_compared_item( $post_id );
				$response['status']   = 'success';
				$response['response'] = sprintf( esc_html__( '%s has been added to compare!', 'motors' ), $post_title );
			} else {
				$response['status']   = 'danger';
				$response['response'] = sprintf( esc_html__( 'You have already added %d cars', 'motors' ), count( $compared_items ) );
			}
		} else {
			$response['status']   = 'warning';
			$response['response'] = sprintf( esc_html__( '%s has already been added', 'motors' ), $post_title );
		}
	}

	$all_compared_items = apply_filters( 'stm_get_compared_items', array() );
	$response['length'] = count( $all_compared_items );
	$response['ids']    = $all_compared_items;

	wp_send_json( $response );
	exit;
}

add_action( 'wp_ajax_stm_ajax_add_to_compare', 'stm_ajax_add_to_compare' );
add_action( 'wp_ajax_nopriv_stm_ajax_add_to_compare', 'stm_ajax_add_to_compare' );

// Load more cars
function stm_ajax_load_more_cars() {
	check_ajax_referer( 'stm_security_nonce', 'security' );

	$response             = array();
	$response['button']   = '';
	$response['content']  = '';
	$response['appendTo'] = '#car-listing-category-' . sanitize_text_field( $_POST['category'] );
	$category             = sanitize_text_field( $_POST['category'] );
	$taxonomy             = sanitize_text_field( $_POST['taxonomy'] );
	$offset               = intval( filter_var( $_POST['offset'], FILTER_SANITIZE_NUMBER_INT ) );
	$per_page             = intval( filter_var( $_POST['per_page'], FILTER_SANITIZE_NUMBER_INT ) );
	$new_offset           = $offset + $per_page;
	$random_int           = intval( filter_var( $_POST['random_int'], FILTER_SANITIZE_NUMBER_INT ) );

	$args                = array(
		'post_type'      => apply_filters( 'stm_listings_post_type', 'listings' ),
		'post_status'    => 'publish',
		'offset'         => $offset,
		'posts_per_page' => $per_page,
	);
	$args['tax_query'][] = array(
		'taxonomy' => $taxonomy,
		'field'    => 'slug',
		'terms'    => array( $category ),
	);
	$listings            = new WP_Query( $args );
	if ( $listings->have_posts() ) {
		ob_start();
		while ( $listings->have_posts() ) {
			$listings->the_post();
			get_template_part( 'partials/car-filter', 'loop' );
		}
		$response['content'] = ob_get_contents();
		ob_end_clean();

		if ( $listings->found_posts > $new_offset ) {
			$response['button'] = 'stm_loadMoreCars(jQuery(this),\'' . esc_js( $category ) . '\',\'' . esc_js( $taxonomy ) . '\',' . esc_js( $new_offset ) . ', ' . esc_js( $per_page ) . ', \'' . esc_js( $random_int ) . '\'); return false;';

		} else {
			$response['button'] = '';
		}

		$response['test'] = $listings->found_posts . ' > ' . $new_offset;

		wp_reset_postdata();
	}

	echo wp_json_encode( $response );
	exit;
}

add_action( 'wp_ajax_stm_ajax_load_more_cars', 'stm_ajax_load_more_cars' );
add_action( 'wp_ajax_nopriv_stm_ajax_load_more_cars', 'stm_ajax_load_more_cars' );

function stm_ajax_dealer_load_reviews() {
	check_ajax_referer( 'stm_security_nonce', 'security' );

	$response = array();
	$user_id  = intval( filter_var( $_POST['user_id'], FILTER_SANITIZE_NUMBER_INT ) );
	$offset   = intval( filter_var( $_POST['offset'], FILTER_SANITIZE_NUMBER_INT ) );

	$response['offset'] = $offset;

	$new_offset = 6 + $offset;

	$query = stm_get_dealer_reviews( $user_id, 'publish', 6, $offset );

	$html = '';
	if ( $query->have_posts() ) {
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'partials/user/dealer-single', 'review' );
		}
		$html = ob_get_clean();
	}

	$response['html'] = $html;

	$button = 'show';
	if ( $query->found_posts <= $new_offset ) {
		$button = 'hide';
	} else {
		$response['new_offset'] = $new_offset;
	}

	$response['button'] = $button;

	wp_send_json( $response );
	exit;
}

add_action( 'wp_ajax_stm_ajax_dealer_load_reviews', 'stm_ajax_dealer_load_reviews' );
add_action( 'wp_ajax_nopriv_stm_ajax_dealer_load_reviews', 'stm_ajax_dealer_load_reviews' );

if ( ! function_exists( 'stm_submit_review' ) ) {
	function stm_submit_review() {
		check_ajax_referer( 'stm_security_nonce', 'security' );

		$response            = array();
		$response['message'] = '';
		$error               = false;
		$user_id             = 0;

		$demo = apply_filters( 'stm_site_demo_mode', false );

		if ( $demo ) {
			$error               = true;
			$response['message'] = esc_html__( 'Site is on demo mode.', 'motors' );
		}

		/*Post parts*/
		$title     = '';
		$content   = '';
		$recommend = 'yes';
		$ratings   = array();

		if ( ! empty( $_GET['stm_title'] ) ) {
			$title = sanitize_text_field( $_GET['stm_title'] );
		} else {
			$error               = true;
			$response['message'] = esc_html__( 'Please, enter review title.', 'motors' );
		}

		if ( empty( $_GET['stm_user_on'] ) ) {
			$error               = true;
			$response['message'] = esc_html__( 'Do not cheat!', 'motors' );
		} else {
			$user_on = intval( $_GET['stm_user_on'] );
		}

		if ( ! empty( $_GET['stm_content'] ) ) {
			$content = sanitize_text_field( $_GET['stm_content'] );
		} else {
			$error               = true;
			$response['message'] = esc_html__( 'Please, enter review text.', 'motors' );
		}

		if ( empty( $_GET['stm_required'] ) ) {
			$error               = true;
			$response['message'] = esc_html__( 'Please, check you are not a dealer.', 'motors' );
		} else {
			if ( 'on' !== $_GET['stm_required'] ) {
				$error               = true;
				$response['message'] = esc_html__( 'Please, check you are not a dealer.', 'motors' );
			}
		}

		if ( ! empty( $_GET['recommend'] ) && 'no' === $_GET['recommend'] ) {
			$recommend = 'no';
		}

		foreach ( $_GET as $get_key => $get_value ) {
			if ( strpos( $get_key, 'stm_rate' ) !== false ) {
				if ( empty( $get_value ) ) {
					$error               = true;
					$response['message'] = esc_html__( 'Please add rating', 'motors' );
				} else {
					if ( $get_value < 6 && $get_value > 0 ) {
						$ratings[ esc_attr( $get_key ) ] = intval( $get_value );
					}
				}
			}
		}

		/*Check if user already added comment*/
		$current_user = wp_get_current_user();
		if ( is_wp_error( $current_user ) ) {
			$error               = true;
			$response['message'] = esc_html__( 'You are not logged in', 'motors' );
		} else {
			if ( ! empty( $user_on ) ) {
				$user_id          = $current_user->ID;
				$get_user_reviews = stm_get_user_reviews( $user_id, $user_on );

				$response['q'] = $get_user_reviews;

				if ( ! empty( $get_user_reviews->posts ) ) {
					foreach ( $get_user_reviews->posts as $user_post ) {
						wp_delete_post( $user_post->ID, true );
					}
				}
			} else {
				$error               = true;
				$response['message'] = esc_html__( 'Do not cheat', 'motors' );
			}
		}

		if ( ! $error ) {

			if ( apply_filters( 'motors_vl_get_nuxy_mod', false, 'dealer_review_moderation' ) ) {
				$post_status         = 'pending';
				$response['message'] = esc_html__( 'Your review has been sent for moderation', 'motors' );
			} else {
				$post_status = 'publish';
			}

			$post_data = array(
				'post_type'    => 'dealer_review',
				'post_title'   => sanitize_text_field( $title ),
				'post_content' => sanitize_text_field( $content ),
				'post_status'  => $post_status,
			);

			$insert_post = wp_insert_post( $post_data, true );

			if ( is_wp_error( $insert_post ) ) {
				$response['message'] = $insert_post->get_error_message();
			} else {

				/*Ratings*/
				if ( ! empty( $ratings['stm_rate_1'] ) ) {
					update_post_meta( $insert_post, 'stm_rate_1', intval( $ratings['stm_rate_1'] ) );
				}
				if ( ! empty( $ratings['stm_rate_2'] ) ) {
					update_post_meta( $insert_post, 'stm_rate_2', intval( $ratings['stm_rate_2'] ) );
				}
				if ( ! empty( $ratings['stm_rate_3'] ) ) {
					update_post_meta( $insert_post, 'stm_rate_3', intval( $ratings['stm_rate_3'] ) );
				}

				/*Recommended*/
				update_post_meta( $insert_post, 'stm_recommended', $recommend );

				update_post_meta( $insert_post, 'stm_review_added_by', $user_id );
				update_post_meta( $insert_post, 'stm_review_added_on', $user_on );

				$response['updated'] = apply_filters( 'stm_get_author_link', $user_on );
			}
		}

		wp_send_json( $response );
		exit;
	}
}

add_action( 'wp_ajax_stm_submit_review', 'stm_submit_review' );
add_action( 'wp_ajax_nopriv_stm_submit_review', 'stm_submit_review' );

if ( ! function_exists( 'stm_report_review' ) ) {
	function stm_report_review() {

		check_ajax_referer( 'stm_security_nonce', 'security' );

		$response = array();

		if ( ! empty( $_POST['id'] ) ) {
			$report_id = intval( filter_var( $_POST['id'], FILTER_SANITIZE_NUMBER_INT ) );

			$user_added_on = get_post_meta( $report_id, 'stm_review_added_on', true );
			if ( ! empty( $user_added_on ) ) {
				$user_added_on = get_user_by( 'id', $user_added_on );
			}

			$title = get_the_title( $report_id );

			if ( ! empty( $title ) && ! empty( $user_added_on ) ) {

				/*Sending mail */
				$to   = array();
				$to[] = get_bloginfo( 'admin_email' );
				$to[] = $user_added_on->data->user_email;

				$args = array(
					'report_id'      => $report_id,
					'review_content' => get_post_field( 'post_content', $report_id ),
				);

				$subject = apply_filters( 'get_generate_subject_view', '', 'report_review', $args );
				$body    = apply_filters( 'get_generate_template_view', '', 'report_review', $args );

				do_action( 'stm_wp_mail', $to, $subject, $body, '' );

				$response['message'] = esc_html__( 'Reported', 'motors' );

			}
		}

		wp_send_json( $response );
		exit;
	}
}

add_action( 'wp_ajax_stm_report_review', 'stm_report_review' );
add_action( 'wp_ajax_nopriv_stm_report_review', 'stm_report_review' );

function stm_get_wpb_def_tmpl() {

	$temp_class = ( class_exists( 'Vc_Setting_Post_Type_Default_Template_Field' ) ) ? new Vc_Setting_Post_Type_Default_Template_Field( 'general', 'default_template_post_type' ) : false;

	if ( $temp_class ) {
		return $temp_class->getTemplateByPostType( 'listings' );
	}

	return false;
}

add_filter( 'stm_get_wpb_def_tmpl', 'stm_get_wpb_def_tmpl' );

function stm_ajax_get_cars_for_inventory_map() {
	check_ajax_referer( 'stm_security_nonce', 'security' );
	wp_reset_postdata();
	$response = new WP_Query(
		apply_filters(
			'_stm_listings_build_query_args',
			array(
				'post_type'      => apply_filters( 'stm_listings_post_type', 'listings' ),
				'order'          => 'DESC',
				'orderby'        => 'date',
				'sold_car'       => 'off',
				'nopaging'       => true,
				'posts_per_page' => - 1,
			)
		)
	);

	$map_location_car = array();
	$cars_data        = array();
	$markers          = array();
	$i                = 0;
	$cars_info        = array();

	$placeholder_path = 'plchldr255.png';
	if ( apply_filters( 'stm_is_boats', false ) ) {
		$placeholder_path = 'boats-placeholders/Boat-small.jpg';
	} elseif ( apply_filters( 'stm_is_aircrafts', false ) ) {
		$placeholder_path = 'Plane-small.jpg';
	} elseif ( apply_filters( 'stm_is_motorcycle', false ) ) {
		$placeholder_path = 'Motor-small.jpg';
	}

	foreach ( apply_filters( 'stm_get_map_listings', array() ) as $k => $val ) {
		if ( isset( $val['use_on_map_page'] ) && true === boolval( $val['use_on_map_page'] ) ) {
			$cars_info[ count( $cars_info ) ] = array(
				'key'  => $val['slug'],
				'icon' => $val['font'],
			);
		}
	}

	foreach ( $response->get_posts() as $k => $val ) {

		if ( ! empty( get_post_meta( $val->ID, 'stm_lat_car_admin' ) ) && 'publish' === $val->post_status || 'private' === $val->post_status ) {
			$car_meta = get_post_meta( $val->ID, '' );
			$img      = "<img src='" . get_stylesheet_directory_uri() . '/assets/images/' . $placeholder_path . "'/>";

			if ( has_post_thumbnail( $val->ID ) ) {
				$img = ( ! empty( get_the_post_thumbnail( $val->ID, 'full' ) ) ) ? get_the_post_thumbnail( $val->ID, 'full' ) : '';
			}

			$price = ( isset( $car_meta['price'] ) ) ? apply_filters( 'stm_filter_price_view', '', $car_meta['price'][0] ) : 0 . apply_filters( 'stm_get_price_currency', apply_filters( 'motors_vl_get_nuxy_mod', '$', 'price_currency' ) );
			if ( isset( $car_meta['sale_price'] ) && ! empty( $car_meta['sale_price'][0] ) && ! empty( $car_meta['sale_price'][0] ) ) {
				$price = apply_filters( 'stm_filter_price_view', '', $car_meta['sale_price'][0] );
			}

			$car_price_form_label = get_post_meta( $val->ID, 'car_price_form_label', true );
			if ( ! empty( $car_price_form_label ) ) {
				$price = $car_price_form_label;
			}

			$cars_data[ $i ]['id']                = $val->ID;
			$cars_data[ $i ]['link']              = get_the_permalink( $val->ID );
			$cars_data[ $i ]['title']             = urldecode( $val->post_title );
			$cars_data[ $i ]['image']             = $img;
			$cars_data[ $i ]['price']             = $price;
			$cars_data[ $i ]['year']              = ( isset( $car_meta['ca-year'] ) ) ? $car_meta['ca-year'][0] : '';
			$cars_data[ $i ]['condition']         = ( isset( $car_meta['condition'] ) ) ? urldecode( mb_strtoupper( str_replace( '-cars', '', $car_meta['condition'][0] ) ) ) : '';
			$cars_data[ $i ]['mileage']           = ( isset( $cars_info[0] ) && isset( $car_meta[ $cars_info[0]['key'] ] ) ) ? urldecode( $car_meta[ $cars_info[0]['key'] ][0] ) : '';
			$cars_data[ $i ]['engine']            = ( isset( $cars_info[1] ) && isset( $car_meta[ $cars_info[1]['key'] ] ) ) ? urldecode( $car_meta[ $cars_info[1]['key'] ][0] ) : '';
			$cars_data[ $i ]['transmission']      = ( isset( $cars_info[2] ) && isset( $car_meta[ $cars_info[2]['key'] ] ) ) ? urldecode( $car_meta[ $cars_info[2]['key'] ][0] ) : '';
			$cars_data[ $i ]['mileage_font']      = ( isset( $cars_info[0] ) && isset( $cars_info[0]['icon'] ) ) ? urldecode( $cars_info[0]['icon'] ) : '';
			$cars_data[ $i ]['engine_font']       = ( isset( $cars_info[1] ) && isset( $cars_info[1]['icon'] ) ) ? urldecode( $cars_info[1]['icon'] ) : '';
			$cars_data[ $i ]['transmission_font'] = ( isset( $cars_info[2] ) && isset( $cars_info[2]['icon'] ) ) ? urldecode( $cars_info[2]['icon'] ) : '';

			$markers[ $i ]['lat']      = round( floatval( $car_meta['stm_lat_car_admin'][0] ), 7 );
			$markers[ $i ]['lng']      = round( floatval( $car_meta['stm_lng_car_admin'][0] ), 7 );
			$markers[ $i ]['location'] = ( ! empty( $car_meta['stm_car_location'] ) ) ? $car_meta['stm_car_location'][0] : 'no location';

			$map_location_car[ (string) round( $markers[ $i ]['lat'], 7 ) ][] = $i;
			$i ++;
		}
	}

	wp_reset_postdata();

	$GLOBALS['listings_query'] = $response;
	$data                      = apply_filters(
		'stm_ajax_cars_for_map',
		array(
			'carsData'       => $cars_data,
			'markers'        => $markers,
			'mapLocationCar' => $map_location_car,
		)
	);
	echo wp_json_encode( $data );
	exit;
}
add_action( 'wp_ajax_stm_ajax_get_cars_for_inventory_map', 'stm_ajax_get_cars_for_inventory_map' );
add_action( 'wp_ajax_nopriv_stm_ajax_get_cars_for_inventory_map', 'stm_ajax_get_cars_for_inventory_map' );

function stm_ajax_rental_check_car_in_current_office() {
	check_ajax_referer( 'stm_security_nonce', 'security' );

	$cart_items           = stm_get_cart_items();
	$car_rent             = $cart_items['car_class'];
	$pickup_location_meta = explode( ',', get_post_meta( $car_rent['id'], 'stm_rental_office', true ) );

	wp_send_json( ( array_search( $_GET['rental_office_id'], $pickup_location_meta, true ) === false && ! empty( $car_rent['id'] ) ) ? $responce['responce'] = 'EMPTY' : $responce['responce'] = 'INSTOCK' );
	exit;
}

add_action( 'wp_ajax_stm_ajax_rental_check_car_in_current_office', 'stm_ajax_rental_check_car_in_current_office' );
add_action( 'wp_ajax_nopriv_stm_ajax_rental_check_car_in_current_office', 'stm_ajax_rental_check_car_in_current_office' );

function stm_ajax_check_is_available_car_date() {
	check_ajax_referer( 'stm_security_nonce', 'security' );

	$start_date = sanitize_text_field( $_GET['startDate'] );
	$end_date   = sanitize_text_field( $_GET['endDate'] );
	$cart_items = stm_get_cart_items();
	$car_rent   = $cart_items['car_class'];
	$id         = $car_rent['id'];

	if ( ! $id ) {
		wp_send_json( array() );
	}

	$check_order_available = stm_check_order_available( $id, $start_date, $end_date );

	$formated_dates = array();
	foreach ( $check_order_available as $val ) {
		$formated_dates[] = stm_get_formated_date( $val, 'd M' );
	}

	wp_send_json( ( count( $check_order_available ) > 0 ) ? $responce['responce'] = esc_html__( 'This Class is already booked in: ', 'motors' ) . '<span>' . implode( ', ', $formated_dates ) . '</span>.' : $responce['responce'] = '' );
}

add_action( 'wp_ajax_stm_ajax_check_is_available_car_date', 'stm_ajax_check_is_available_car_date' );
add_action( 'wp_ajax_nopriv_stm_ajax_check_is_available_car_date', 'stm_ajax_check_is_available_car_date' );

function stm_ajax_get_recent_posts_magazine() {
	check_ajax_referer( 'stm_ajax_get_recent_posts_magazine', 'security' );

	$posts_per_page = sanitize_text_field( $_GET['posts_per_page'] );

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => $posts_per_page,
		'ignore_sticky_posts' => true,
	);

	if ( isset( $_GET['category'] ) && 'all' !== $_GET['category'] ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $_GET['category'] ),
			),
		);
	}

	$r = new WP_Query( $args );

	ob_start();

	if ( $r->have_posts() && class_exists( 'WPBMap' ) ) {
		WPBMap::addAllMappedShortcodes();
		while ( $r->have_posts() ) {
			$r->the_post();
			get_template_part( 'partials/blog/content-list-magazine-loop' );
		}
	}

	$result['html'] = ob_get_clean();
	wp_send_json( $result );
	exit;
}

add_action( 'wp_ajax_stm_ajax_get_recent_posts_magazine', 'stm_ajax_get_recent_posts_magazine' );
add_action( 'wp_ajax_nopriv_stm_ajax_get_recent_posts_magazine', 'stm_ajax_get_recent_posts_magazine' );

function stm_ajax_sticky_posts_magazine() {
	check_ajax_referer( 'stm_security_nonce', 'security' );

	$sticky = get_option( 'sticky_posts' );

	$args = array(
		'post_type'   => 'any',
		'post__in'    => $sticky,
		'post_status' => 'publish',
	);

	if ( isset( $_GET['category'] ) && 'all' !== $_GET['category'] ) {
		$args['tax_query'] = array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $_GET['category'] ),
			),
			array(
				'taxonomy' => 'review_category',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $_GET['category'] ),
			),
			array(
				'taxonomy' => 'event_category',
				'field'    => 'slug',
				'terms'    => sanitize_text_field( $_GET['category'] ),
			),
		);
	}

	$r = new WP_Query( $args );

	ob_start();
	if ( $r->have_posts() ) {
		$num = 0;
		while ( $r->have_posts() ) {
			$r->the_post();
			if ( 0 === $num ) {
				get_template_part( 'partials/vc_loop/features_posts_big_loop' );
			} else {
				if ( $_GET['adsense_position'] === $num && 'yes' === $_GET['use_adsense'] ) {
					?>
					<div class="adsense-200-200"></div>
					<?php
				}
				if ( $num > $_GET['hidenWrap'] ) {
					echo '<div class="features_hiden">';
				}
				get_template_part( 'partials/vc_loop/features_posts_small_loop' );
				if ( $num > $_GET['hidenWrap'] ) {
					echo '</div>';
				}
			}

			$num ++;
		}
	}
	$result['html'] = ob_get_clean();

	wp_reset_postdata();
	wp_send_json( $result );
	exit;
}

add_action( 'wp_ajax_stm_ajax_sticky_posts_magazine', 'stm_ajax_sticky_posts_magazine' );
add_action( 'wp_ajax_nopriv_stm_ajax_sticky_posts_magazine', 'stm_ajax_sticky_posts_magazine' );

function stm_ajax_get_events() {
	check_ajax_referer( 'stm_security_nonce', 'security' );

	$id   = intval( $_GET['post_id'] );
	$date = get_the_date( 'd M Y', $id );

	$date_start      = get_post_meta( $id, 'date_start', true );
	$date_start_time = get_post_meta( $id, 'date_start_time', true );
	$date_end        = get_post_meta( $id, 'date_end', true );
	$date_end_time   = get_post_meta( $id, 'date_end_time', true );
	$address         = get_post_meta( $id, 'address', true );
	$participants    = get_post_meta( $id, 'cur_participants', true );
	$category        = event_get_terms_array( $id, 'event_category', 'name', false );

	if ( empty( $participants ) ) {
		$participants = 0;
	}

	$time           = '';
	$date_prev      = ( ! empty( $date_start ) ) ? apply_filters( 'stm_motors_get_formatted_date', $date_start, 'd M Y' ) : '';
	$time_format    = apply_filters( 'stm_motors_get_formatted_date', strtotime( $date_end_time ), 'H:i:s' );
	$countdown_date = apply_filters( 'stm_motors_get_formatted_date', $date_end, 'Y-m-d ' ) . $time_format;

	if ( ! empty( $date_start_time ) ) {
		$time .= $date_start_time;
	}
	if ( ! empty( $date_end_time ) ) {
		$time .= ' - ' . $date_end_time;
	}

	ob_start();

	$url = ( ! empty( get_the_post_thumbnail( $id, 'stm-img-690-410' ) ) ) ? get_the_post_thumbnail( $id, 'stm-img-690-410' ) : '';

	echo '
            <div class="title">
                <h3>' . esc_html( get_the_title( $id ) ) . '</h3>
            </div>
            <div class="event-data">
                <div class="address">
                    <i class="me-ico_event_pin"></i>
                    <div>' . wp_kses_post( $address ) . '</div>
                </div>
                <div class="date">
                    <i class="stm-icon-ico_mag_calendar"></i>
                    <div>' . wp_kses_post( $date_prev ) . '</div>
                </div>
                <div class="time">
                    <i class="me-ico_event_clock"></i>
                    <div>' . wp_kses_post( $time ) . '</div>
                </div>
            </div>
            <div class="event-single-wrap">
                <div class="img">
                    ' . wp_kses_post( $url ) . '
                </div>
                <div class="timer">
                    <div class="stm-countdown-wrapper">
                        <time class="heading-font" datetime="' . esc_attr( $countdown_date ) . '"  data-countdown="' . esc_attr( str_replace( '-', '/', $countdown_date ) ) . '" ></time>
                    </div>
                </div>
                <div class="timer timerFullHeight">
                    <div class="stm-countdown-wrapper">
                        <time class="heading-font" datetime="' . esc_attr( $countdown_date ) . '"  data-countdown="' . esc_attr( str_replace( '-', '/', $countdown_date ) ) . '" ></time>
                    </div>
                </div>
                <div class="participants">
                    <i class="me-ico_profile"></i>
                    <div class="prticipants_count heading-font">
                        ' . wp_kses_post( $participants ) . '
                    </div>
                </div>
                <div class="event_more_btn">
                    <a href="' . esc_url( get_the_permalink( $id ) ) . '" class="stm-button">' . esc_html__( 'More Details', 'motors' ) . '</a>
                </div>
            </div>
    ';

	$result['html'] = ob_get_clean();

	wp_send_json( $result );
	exit;
}

add_action( 'wp_ajax_stm_ajax_get_events', 'stm_ajax_get_events' );
add_action( 'wp_ajax_nopriv_stm_ajax_get_events', 'stm_ajax_get_events' );

function stm_ajax_clear_data() {
	check_ajax_referer( 'stm_security_nonce', 'security' );
	WC()->cart->empty_cart();
	WC()->session->destroy_session();
}

add_action( 'wp_ajax_stm_ajax_clear_data', 'stm_ajax_clear_data' );
add_action( 'wp_ajax_nopriv_stm_ajax_clear_data', 'stm_ajax_clear_data' );


function stm_ajax_inventory_no_filter() {
	check_ajax_referer( 'stm_security_nonce', 'security' );

	$args = array(
		'post_type'        => apply_filters( 'stm_listings_post_type', 'listings' ),
		'post_status'      => 'publish',
		'posts_per_page'   => sanitize_text_field( $_GET['posts_per_page'] ),
		'suppress_filters' => 0,
		'order_by'         => 'ID',
		'order'            => 'DESC',
		'paged'            => sanitize_text_field( $_GET['paged'] ),
	);

	if ( apply_filters( 'stm_sold_status_enabled', false ) ) {
		$args['meta_query'][] = array(
			'key'     => 'car_mark_as_sold',
			'value'   => '',
			'compare' => '=',
		);
	}

	$listings = new WP_Query( $args );

	if ( $listings->have_posts() ) {
		ob_start();
		while ( $listings->have_posts() ) {
			$listings->the_post();
			get_template_part( 'partials/vc_loop/inventory-no-filter-loop' );
		}
		$response['content'] = ob_get_contents();
		$response['pagina']  = paginate_links(
			array(
				'type'      => 'list',
				'current'   => sanitize_text_field( $_GET['paged'] ),
				'total'     => $listings->found_posts / intval( sanitize_text_field( $_GET['posts_per_page'] ) ),
				'prev_text' => '<i class="fas fa-angle-left"></i>',
				'next_text' => '<i class="fas fa-angle-right"></i>',
			)
		);
		ob_end_clean();

		wp_reset_postdata();
	}

	echo wp_json_encode( $response );
	exit;
}

add_action( 'wp_ajax_stm_ajax_inventory_no_filter', 'stm_ajax_inventory_no_filter' );
add_action( 'wp_ajax_nopriv_stm_ajax_inventory_no_filter', 'stm_ajax_inventory_no_filter' );

if ( ! function_exists( 'stm_ajax_subscriptio_change_status' ) ) {
	function stm_ajax_subscriptio_change_status() {

		check_ajax_referer( 'stm_security_nonce', 'security' );

		$response = array();

		try {
			$subscription = subscriptio_get_subscription( sanitize_text_field( $_POST['subs_id'] ) );
			$subscription->set_status( RightPress_Help::clean_wc_status( wc_clean( wp_unslash( $_POST['subs_status'] ) ) ), 'admin' );
			$response = array(
				'status' => 'success',
			);
		} catch ( Exception $e ) {
			$response = array(
				'status' => $e->getMessage(),
			);
		}

		wp_send_json( $response );
	}
}

add_action( 'wp_ajax_clear_woo_cart', 'clear_woo_cart' );
add_action( 'wp_ajax_nopriv_clear_woo_cart', 'clear_woo_cart' );

function clear_woo_cart() {
	WC()->cart->empty_cart();
	wp_send_json_success( array( 'message' => esc_html__( 'Clear woocommerce cart', 'motors' ) ) );
}

add_action( 'wp_ajax_stm_ajax_subscriptio_change_status', 'stm_ajax_subscriptio_change_status' );
add_action( 'wp_ajax_nopriv_stm_ajax_subscriptio_change_status', 'stm_ajax_subscriptio_change_status' );

// Listings List - Ajax Pagination
add_action( 'wp_ajax_stm_ajax_load_listings_list_items', 'stm_ajax_load_listings_list_items' );
add_action( 'wp_ajax_nopriv_stm_ajax_load_listings_list_items', 'stm_ajax_load_listings_list_items' );

function stm_ajax_load_listings_list_items() {
	check_ajax_referer( 'stm_security_nonce', 'security' );

	global $wp;

	$query_args          = array_map( 'sanitize_text_field', $_POST['query_args'] );
	$query_args['paged'] = sanitize_text_field( $_POST['paged'] );
	$img_size            = sanitize_text_field( $_POST['img_size'] );
	$template_args       = array();
	if ( ! empty( $img_size ) ) {
		$template_args = array(
			'custom_img_size' => $img_size,
		);
	}

	$query = new WP_Query( $query_args );

	$html       = '';
	$pagination = '';

	if ( $query->have_posts() ) {
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'partials/listing-cars/listing-list-directory', 'loop', $template_args );
		}
		$html = ob_get_contents();
		ob_end_clean();
		wp_reset_postdata();
		$pagination = paginate_links(
			array(
				'base'      => home_url( add_query_arg( array(), $wp->request ) ) . '/%_%',
				'type'      => 'list',
				'total'     => ceil( $query->found_posts / $query_args['posts_per_page'] ),
				'prev_text' => '<i class="fas fa-angle-left"></i>',
				'next_text' => '<i class="fas fa-angle-right"></i>',
				'current'   => $query_args['paged'],
			)
		);
	}

	$result = array(
		'html'       => $html,
		'pagination' => $pagination,
	);

	echo wp_json_encode( $result );
	exit;
}
