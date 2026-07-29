<?php
/**
 * Block Styles
 *
 * @package multi_purpose
 * @since 1.0
 */

if ( function_exists( 'register_block_style' ) ) {
	function multi_purpose_register_block_styles() {

		//Wp Block Padding Zero
		register_block_style(
			'core/group',
			array(
				'name'  => 'multi-purpose-padding-0',
				'label' => esc_html__( 'No Padding', 'multi-purpose' ),
			)
		);

		//Wp Block Post Author Style
		register_block_style(
			'core/post-author',
			array(
				'name'  => 'multi-purpose-post-author-card',
				'label' => esc_html__( 'Theme Style', 'multi-purpose' ),
			)
		);

		//Wp Block Button Style
		register_block_style(
			'core/button',
			array(
				'name'         => 'multi-purpose-button',
				'label'        => esc_html__( 'Plain', 'multi-purpose' ),
			)
		);

		//Post Comments Style
		register_block_style(
			'core/post-comments',
			array(
				'name'         => 'multi-purpose-post-comments',
				'label'        => esc_html__( 'Theme Style', 'multi-purpose' ),
			)
		);

		//Latest Comments Style
		register_block_style(
			'core/latest-comments',
			array(
				'name'         => 'multi-purpose-latest-comments',
				'label'        => esc_html__( 'Theme Style', 'multi-purpose' ),
			)
		);


		//Wp Block Table Style
		register_block_style(
			'core/table',
			array(
				'name'         => 'multi-purpose-wp-table',
				'label'        => esc_html__( 'Theme Style', 'multi-purpose' ),
			)
		);


		//Wp Block Pre Style
		register_block_style(
			'core/preformatted',
			array(
				'name'         => 'multi-purpose-wp-preformatted',
				'label'        => esc_html__( 'Theme Style', 'multi-purpose' ),
			)
		);

		//Wp Block Verse Style
		register_block_style(
			'core/verse',
			array(
				'name'         => 'multi-purpose-wp-verse',
				'label'        => esc_html__( 'Theme Style', 'multi-purpose' ),
			)
		);
	}
	add_action( 'init', 'multi_purpose_register_block_styles' );
}
