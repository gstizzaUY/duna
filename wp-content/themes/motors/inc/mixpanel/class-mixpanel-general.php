<?php

namespace Motors\Mixpanel;

class Mixpanel_General extends Mixpanel {
	public static function register_data() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		self::add_data( 'Admin Email', get_bloginfo( 'admin_email' ) );

		if ( defined( 'STM_LISTINGS_V' ) ) {
			self::add_data( 'Motors Free Plugin', STM_LISTINGS_V );
		}

		$theme_data = wp_get_theme();

		if ( $theme_data->parent() ) {
			$theme_data = $theme_data->parent();
		}

		self::add_data( 'Theme Name', $theme_data->get( 'Name' ) );
		self::add_data( 'Theme Version', $theme_data->get( 'Version' ) );
		self::add_data( 'Selected Layout', get_option( 'stm_motors_chosen_template', '' ) );

		self::motors_count_dealers();
		self::motors_count_pricing_plans();
		self::motors_check_add_car_page();
	}

	public static function motors_count_dealers() {
		$dealers = get_users( array( 'role' => 'stm_dealer' ) );
		if ( count( $dealers ) > 0 ) {
			self::add_data( 'Dealers qty', count( $dealers ) );
		}
	}

	public static function motors_count_pricing_plans() {
		if ( class_exists( 'Subscriptio' ) || class_exists( 'RP_SUB' ) ) {
			self::add_data( 'Subscriptio', 'active' );

			$plans = new \WP_Query( array(
				'post_type'      => 'product',
				'posts_per_page' => - 1,
				'post_status'    => 'publish',
				'meta_query'     => array(
					array(
						'key'   => '_rp_sub:subscription_product',
						'value' => 'yes',
					),
				),
			) );

			if ( $plans->found_posts > 0 ) {
				self::add_data( 'Pricing Plans qty', $plans->found_posts );
			}

			wp_reset_postdata();
		}
	}

	public static function motors_check_add_car_page() {
		$add_car_page = apply_filters( 'motors_vl_get_nuxy_mod', 0, 'user_add_car_page' );
		if ( ! empty( $add_car_page ) ) {
			self::add_data( 'Add a car Page', 'created' );
		}
	}

	public static function is_dev( $domain ) {
		$devs = array( '.loc', '.local', 'stylemix', 'localhost', 'stm' );
		foreach ( $devs as $dev ) {
			if ( false !== stripos( $domain, $dev ) ) {
				return true;
			}
		}

		return false;
	}
}
