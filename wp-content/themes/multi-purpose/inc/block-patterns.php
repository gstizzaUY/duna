<?php
/**
 * Block Patterns
 *
 * @package multi_purpose
 * @since 1.0
 */

function multi_purpose_register_block_patterns() {
	$multi_purpose_block_pattern_categories = array(
		'multi-purpose' => array( 'label' => esc_html__( 'Multi Purpose', 'multi-purpose' ) ),
		'pages' => array( 'label' => esc_html__( 'Pages', 'multi-purpose' ) ),
	);

	$multi_purpose_block_pattern_categories = apply_filters( 'multi_purpose_multi_purpose_block_pattern_categories', $multi_purpose_block_pattern_categories );

	foreach ( $multi_purpose_block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}
}
add_action( 'init', 'multi_purpose_register_block_patterns', 9 );