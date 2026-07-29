<?php

require get_template_directory() . '/inc/TGM/class-tgm-plugin-activation.php';
/**
 * Recommended plugins.
 */
function multi_purpose_register_recommended_plugins() {
	$plugins = array(
		array(
            'name'             => __( 'woocommerce', 'multi-purpose' ),
            'slug'             => 'woocommerce',
            'required'         => false,
            'force_activation' => false,
        ),
		array(
            'name'             => __( 'Gutentor', 'multi-purpose' ),
            'slug'             => 'gutentor',
            'required'         => false,
            'force_activation' => false,
        ),
        array(
            'name'             => __( 'Currency Switcher for WooCommerce', 'multi-purpose' ),
            'slug'             => 'currency-switcher-woocommerce',
            'required'         => false,
            'force_activation' => false,
        ),
        array(
            'name'             => __( 'Translate WordPress with GTranslate', 'multi-purpose' ),
            'slug'             => 'gtranslate',
            'required'         => false,
            'force_activation' => false,
        ),
	);
	$config = array();
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'multi_purpose_register_recommended_plugins' );
