<?php
/**
 * Duna Child - tema hijo de Motors.
 *
 * Assets (cargados DESPUES de los estilos del parent y del plugin)
 * + hooks de tema que estan en el skin del sitio (toggle claro/oscuro).
 *
 * @package DunaChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Encola los assets del child DESPUES de todos los del parent/plugin
 * (prioridad 20) para ganar la cascada.
 */
function duna_child_enqueue() {
	wp_enqueue_style(
		'duna-child',
		get_stylesheet_directory_uri() . '/assets/css/duna-child.css',
		array(),
		'1.0.3'
	);

	wp_enqueue_script(
		'duna-child',
		get_stylesheet_directory_uri() . '/assets/js/duna-child.js',
		array( 'jquery' ),
		'1.0.3',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'duna_child_enqueue', 20 );

/**
 * Marca el body si el usuario puede alternar el tema (admin).
 */
function duna_admin_body_class( $classes ) {
	if ( current_user_can( 'manage_options' ) ) {
		$classes[] = 'wsf-can-toggle';
	}
	return $classes;
}
add_filter( 'body_class', 'duna_admin_body_class' );

/**
 * Agrega el boton de alternar tema al menu primario (solo administradores).
 */
function duna_menu_theme_toggle( $items, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return $items;
	}

	$items .= '<li class="wsf-theme-toggle-li">'
		. '<button type="button" class="wsf-theme-toggle" aria-label="' . esc_attr__( 'Cambiar tema', 'duna-child' ) . '">'
		. '<span class="wsf-theme-icon">&#9788;</span></button></li>';

	return $items;
}
add_filter( 'wp_nav_menu_items', 'duna_menu_theme_toggle', 10, 2 );
