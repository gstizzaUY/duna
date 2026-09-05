<?php
add_filter( 'stm_me_get_nuxy_mod', 'stm_me_get_nuxy_mod', 10, 3 );
function stm_me_get_nuxy_mod( $default = '', $opt_name = '', $return_default = false ) {
	$wpcfto_option_name = 'wpcfto_motors_' . stm_me_get_current_layout() . '_settings';
	$options            = get_option( $wpcfto_option_name, array() );

	$value_or_false = ( isset( $options[ $opt_name ] ) ) ? $options[ $opt_name ] : $default;

	if ( has_filter( 'wpcfto_motors_' . $opt_name ) ) {
		return apply_filters( 'wpcfto_motors_' . $opt_name, $value_or_false, $opt_name );
	}

	if ( is_bool( $value_or_false ) || ! empty( $value_or_false ) ) {
		return $value_or_false;
	}

	if ( $return_default ) {
		return $default;
	}

	return false;
}

function stm_me_set_wpcfto_mod( $opt_name, $value ) {
	$settings_name = 'wpcfto_motors_' . stm_me_get_current_layout() . '_settings';
	$options       = get_option( $settings_name, array() );

	if ( ! empty( $options[ $opt_name ] ) ) {
		$options[ $opt_name ] = apply_filters( 'wpcfto_motors_set_option_' . $opt_name, $value );
	}

	update_option( $settings_name, $options );
}

add_filter( 'stm_me_wpcfto_parse_spacing', 'stm_me_wpcfto_parse_spacing', 100, 2 );
function stm_me_wpcfto_parse_spacing( $default, $settings ) {
	if ( empty( $settings ) ) {
		return '';
	}

	$style  = ( ! empty( $settings['top'] ) ) ? 'margin-top: ' . $settings['top'] . 'px; ' : '';
	$style .= ( ! empty( $settings['right'] ) ) ? 'margin-right: ' . $settings['right'] . 'px; ' : '';
	$style .= ( ! empty( $settings['bottom'] ) ) ? 'margin-bottom: ' . $settings['bottom'] . 'px; ' : '';
	$style .= ( ! empty( $settings['left'] ) ) ? 'margin-left: ' . $settings['left'] . 'px; ' : '';

	return $style;
}

add_filter( 'stm_me_get_wpcfto_icon', 'stm_me_motors_get_wpcfto_icon', 100, 3 );
function stm_me_motors_get_wpcfto_icon( $option_name, $default_icon, $other_classes = '' ) {
	$icon_array = stm_me_get_nuxy_mod( $default_icon, $option_name, false );

	$style_array = array();

	// if color is not default.
	if ( ! empty( $icon_array['color'] ) && '#000' !== $icon_array['color'] ) {
		$style_array['color'] = $icon_array['color'];
	}

	// if icon size is not default.
	if ( ! empty( $icon_array['size'] ) && 15 !== $icon_array['size'] ) {
		$style_array['size'] = $icon_array['size'];
	}

	// if icon is set.
	if ( $icon_array && ! empty( $icon_array['icon'] ) ) {
		$default_icon = $icon_array['icon'];
	}

	// style string.
	$style_string = '';
	if ( ! empty( $style_array['color'] ) ) {
		$style_string .= 'color: ' . $style_array['color'] . '; ';
	}
	if ( ! empty( $style_array['size'] ) ) {
		$style_string .= 'font-size: ' . $style_array['size'] . 'px;';
	}

	$icon_element = '<i class="' . esc_attr( $default_icon . ' ' . $other_classes ) . '" style="' . esc_attr( $style_string ) . '"></i>';

	return $icon_element;
}

add_filter( 'stm_me_get_nuxy_img_src', 'stm_me_get_nuxy_img_src', 10, 3 );
function stm_me_get_nuxy_img_src( $default, $opt_name, $size = 'full' ) {
	$image = stm_me_get_nuxy_mod( $default, $opt_name, true );
	if ( is_numeric( $image ) && $image > 0 ) {
		$image = wp_get_attachment_image_url( $image, $size );

		// always return original full size image for logo.
		if ( 'logo' === $opt_name && is_string( $image ) && preg_match( '/-\d+[Xx]\d+\./', $image ) ) {
			$image = preg_replace( '/-\d+[Xx]\d+\./', '.', $image );
		}
	}

	return $image;
}

function stm_me_wpcfto_sidebars() {
	$sidebars = array(
		'no_sidebar' => esc_html__( 'Without sidebar', 'stm_motors_extends' ),
		'default'    => esc_html__( 'Primary sidebar', 'stm_motors_extends' ),
	);

	$query = get_posts(
		array(
			'post_type'      => 'sidebar',
			'posts_per_page' => -1,
		)
	);

	if ( $query ) {
		foreach ( $query as $post ) {
			$sidebars[ $post->ID ] = get_the_title( $post->ID );
		}
	}

	$sidebars = apply_filters( 'stm_me_wpcfto_sidebars_list', $sidebars );

	return $sidebars;
}

function stm_me_wpcfto_pages_list() {
	$post_types[] = __( '--- Default ---', 'stm_motors_extends' );
	$query        = get_posts(
		array(
			'post_type'      => 'page',
			'posts_per_page' => -1,
		)
	);

	if ( $query ) {
		foreach ( $query as $post ) {
			$post_types[ $post->ID ] = get_the_title( $post->ID );
		}
	}

	return $post_types;
}

function stm_me_wpcfto_socials() {
	$socials = array(
		'facebook'     => esc_html__( 'Facebook', 'stm_motors_extends' ),
		'x-twitter'    => esc_html__( 'Twitter', 'stm_motors_extends' ),
		'vk'           => esc_html__( 'VK', 'stm_motors_extends' ),
		'instagram'    => esc_html__( 'Instagram', 'stm_motors_extends' ),
		'behance'      => esc_html__( 'Behance', 'stm_motors_extends' ),
		'dribbble'     => esc_html__( 'Dribbble', 'stm_motors_extends' ),
		'flickr'       => esc_html__( 'Flickr', 'stm_motors_extends' ),
		'git'          => esc_html__( 'Git', 'stm_motors_extends' ),
		'linkedin'     => esc_html__( 'Linkedin', 'stm_motors_extends' ),
		'pinterest'    => esc_html__( 'Pinterest', 'stm_motors_extends' ),
		'yahoo'        => esc_html__( 'Yahoo', 'stm_motors_extends' ),
		'delicious'    => esc_html__( 'Delicious', 'stm_motors_extends' ),
		'dropbox'      => esc_html__( 'Dropbox', 'stm_motors_extends' ),
		'reddit'       => esc_html__( 'Reddit', 'stm_motors_extends' ),
		'soundcloud'   => esc_html__( 'Soundcloud', 'stm_motors_extends' ),
		'google'       => esc_html__( 'Google', 'stm_motors_extends' ),
		'skype'        => esc_html__( 'Skype', 'stm_motors_extends' ),
		'youtube'      => esc_html__( 'Youtube', 'stm_motors_extends' ),
		'youtube-play' => esc_html__( 'Youtube Play', 'stm_motors_extends' ),
		'tumblr'       => esc_html__( 'Tumblr', 'stm_motors_extends' ),
		'whatsapp'     => esc_html__( 'Whatsapp', 'stm_motors_extends' ),
		'tiktok'       => esc_html__( 'Tiktok', 'stm_motors_extends' ),
	);

	return $socials;
}

function stm_me_wpcfto_kv_socials() {
	$socials          = stm_me_wpcfto_socials();
	$response_socials = array();

	foreach ( $socials as $k => $social ) {
		$response_socials[] = array(
			'key'   => $k,
			'label' => $social,
		);
	}

	return $response_socials;
}

function stm_me_wpcfto_headers_list() {
	$headers = array(
		'car_dealer'     => esc_html__( 'Dealer', 'stm_motors_extends' ),
		'car_dealer_two' => esc_html__( 'Dealer Two', 'stm_motors_extends' ),
		'ev_dealer'      => esc_html__( 'EV Dealer', 'stm_motors_extends' ),
		'listing'        => esc_html__( 'Classified', 'stm_motors_extends' ),
		'listing_five'   => esc_html__( 'Classified Five', 'stm_motors_extends' ),
		'boats'          => esc_html__( 'Boats', 'stm_motors_extends' ),
		'motorcycle'     => esc_html__( 'Motorcycle', 'stm_motors_extends' ),
		'car_rental'     => esc_html__( 'Rental', 'stm_motors_extends' ),
		'car_magazine'   => esc_html__( 'Magazine', 'stm_motors_extends' ),
		'aircrafts'      => esc_html__( 'Aircrafts', 'stm_motors_extends' ),
		'equipment'      => esc_html__( 'Equipment', 'stm_motors_extends' ),
		'service'        => esc_html__( 'Service', 'stm_motors_extends' ),
	);

	return $headers;
}

add_filter( 'stm_selected_header', 'stm_me_get_header_layout' );

function stm_me_get_header_layout() {
	$selected_layout = get_option( 'stm_motors_chosen_template' );

	if ( empty( $selected_layout ) ) {
		return 'car_dealer';
	}

	$headers_array = array(
		'service'                  => 'service',
		'listing_two'              => 'listing',
		'listing_two_elementor'    => 'listing',
		'listing_three'            => 'listing',
		'listing_three_elementor'  => 'listing',
		'listing_four'             => 'car_dealer',
		'listing_four_elementor'   => 'car_dealer',
		'ev_dealer'                => 'ev_dealer',
		'car_dealer_elementor_rtl' => 'car_dealer',
		'auto_parts'               => 'auto_parts',
	);

	$default_header = ( ! empty( $headers_array[ $selected_layout ] ) ) ? $headers_array[ $selected_layout ] : $selected_layout;

	/*
	* aircrafts
	* boats
	* car_dealer
	* car_dealer_two
	* equipment
	* listing
	* listing_five
	* magazine
	* motorcycle
	* car_rental
	* car_rental_elementor
	*/

	if ( apply_filters( 'stm_is_listing_six', false ) ) {
		return 'listing_five';
	}

	return stm_me_get_nuxy_mod( $default_header, 'header_layout', true );
}

function stm_me_wpcfto_positions() {
	$positions = array(
		'left'  => esc_html__( 'Left', 'stm_motors_extends' ),
		'right' => esc_html__( 'Right', 'stm_motors_extends' ),
	);

	return $positions;
}

function stm_me_wpcfto_sort_options() {
	$options = array();

	if ( function_exists( 'stm_listings_attributes' ) ) {
		$numeric_filters = array_keys(
			stm_listings_attributes(
				array(
					'where'  => array(
						'numeric' => true,
					),
					'key_by' => 'slug',
				)
			)
		);

		if ( ! empty( $numeric_filters ) ) {
			foreach ( $numeric_filters as $tax_name ) {
				$tax = get_taxonomy( $tax_name );
				if ( $tax ) {
					$options[ $tax->name ] = $tax->labels->singular_name;
				}
			}
		}
	}

	return $options;
}

function stm_me_wpcfto_sortby() {
	$sorts = array(
		'date_high' => esc_html__( 'Date: newest first', 'stm_motors_extends' ),
		'date_low'  => esc_html__( 'Date: oldest first', 'stm_motors_extends' ),
	);

	$options = stm_me_wpcfto_sort_options();
	if ( ! empty( $options ) ) {
		foreach ( $options as $slug => $name ) {
			/* translators: option name */
			$sorts[ $slug . '_high' ] = sprintf( esc_html__( '%s: highest first', 'stm_motors_extends' ), $name );
			/* translators: option name */
			$sorts[ $slug . '_low' ] = sprintf( esc_html__( '%s: lowest first', 'stm_motors_extends' ), $name );
		}
	}

	return $sorts;
}
add_filter( 'stm_me_wpcfto_sortby', 'stm_me_wpcfto_sortby' );

add_filter( 'wpcfto_icons_set', 'stm_me_get_theme_icons_set' );
function stm_me_get_theme_icons_set( $iconset ) {
	if ( ! empty( get_transient( 'theme_icons_set' ) ) ) {
		return array_merge( $iconset, get_transient( 'theme_icons_set' ) );
	}

	return $iconset;
}

add_filter( 'wpcfto_icons_set', 'stm_custom_icons_set' );
function stm_custom_icons_set( $icons ) {
	if ( function_exists( 'stm_get_cat_icons' ) ) {
		$external_icons = stm_get_cat_icons( 'external' );
		if ( ! empty( $external_icons ) ) {
			$custom_icons = array_map(
				function ( $icon ) {
					return array(
						'title'       => $icon,
						'searchTerms' => array( $icon ),
					);
				},
				$external_icons
			);
			return array_merge(
				$icons,
				$custom_icons
			);
		}
	}
	return $icons;
}

function wpcfto_print_settings( $settings_name = null ) {
	if ( empty( $settings_name ) ) {
		$settings_name = 'wpcfto_motors_' . get_option( 'stm_motors_chosen_template', 'car_dealer' ) . '_settings';
	}

	echo wp_json_encode( get_option( $settings_name ), true );
	exit;
}

function stm_me_get_all_pages() {
	$pages = array();
	$query = get_posts(
		array(
			'post_type'      => 'page',
			'posts_per_page' => - 1,
		)
	);
	if ( $query ) {
		foreach ( $query as $page ) {
			$pages[ $page->ID ] = get_the_title( $page->ID );
		}
	}
	return $pages;
}
