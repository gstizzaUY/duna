<?php

require_once STM_MOTORS_EXTENDS_PATH . '/stm-post-type/post_type.class.php';

function stm_register_custom_post_types() {
	$choosen_template = get_option( 'stm_motors_chosen_template' );

	STM_PostType::registerPostType(
		'stm_office',
		__( 'Office', 'stm_motors_extends' ),
		array(
			'menu_icon'           => 'dashicons-admin-multisite',
			'supports'            => array( 'title' ),
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
		)
	);

	STM_PostType::registerPostType(
		'sidebar',
		__( 'Sidebar', 'stm_motors_extends' ),
		array(
			'menu_icon'           => 'dashicons-schedule',
			'supports'            => array( 'title', 'editor' ),
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
		)
	);

	STM_PostType::registerPostType(
		'test_drive_request',
		__( 'Test Drive Requests', 'stm_motors_extends' ),
		array(
			'pluralTitle'         => __( 'Test drives', 'stm_motors_extends' ),
			'supports'            => array( 'title' ),
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_in_menu'        => 'admin.php?page=mvl_plugin_settings',
		)
	);

	$listing_templates = array(
		'listing',
		'listing_two',
		'listing_two_elementor',
		'listing_three',
		'listing_three_elementor',
		'listing_four',
		'listing_four_elementor',
		'listing_five',
		'listing_five_elementor',
		'listing_one_elementor',
	);

	if ( in_array( $choosen_template, $listing_templates, true ) ) {
		STM_PostType::registerPostType(
			'dealer_review',
			__( 'Dealer Review', 'stm_motors_extends' ),
			array(
				'menu_icon'           => 'dashicons-groups',
				'supports'            => array( 'title', 'editor' ),
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
			)
		);
	}

	if ( in_array( $choosen_template, array( 'listing_two', 'listing_two_elementor' ), true ) ) {
		STM_PostType::registerPostType(
			'car_value',
			__( 'Value My Car', 'stm_motors_extends' ),
			array(
				'menu_icon'           => 'dashicons-groups',
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'show_in_menu'        => false,
			)
		);
	}
}
