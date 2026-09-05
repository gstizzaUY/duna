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
		'1.3.0'
	);

	wp_enqueue_script(
		'duna-child',
		get_stylesheet_directory_uri() . '/assets/js/duna-child.js',
		array( 'jquery' ),
		'1.3.0',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'duna_child_enqueue', 20 );

/**
 * SEO basico (opcion A, sin plugin): emite <meta name="description">
 * contextual por tipo de pagina. Textos es-UY de 120-155 caracteres.
 */
function duna_child_meta_description() {
	if ( defined( 'WPSEO_VERSION' ) ) {
		return;
	}

	if ( is_front_page() ) {
		$description = 'Venta de neumáticos, llantas y baterías en Uruguay: cubiertas para auto, camioneta, camión, agro e industrial. Alineación y balanceo.';
	} elseif ( is_shop() ) {
		$description = 'Tienda de Duna Neumáticos: neumáticos para auto, camioneta, camión y agro, llantas y baterías. Buscá por medida o vehículo y cotizá en U$S o $U.';
	} elseif ( is_product_category() ) {
		$category = get_queried_object();
		if ( $category && ! empty( $category->name ) ) {
			$description = 'Comprá ' . mb_strtolower( $category->name, 'UTF-8' ) . ' en Duna Neumáticos: neumáticos, llantas y baterías con atención especializada en Las Piedras, Canelones, Uruguay.';
		}
	} elseif ( is_product() ) {
		$product = wc_get_product( get_queried_object_id() );
		if ( $product ) {
			$title      = $product->get_name();
			$sku        = $product->get_sku();
			$description = 'Comprá ' . $title . ( $sku ? ' (' . $sku . ')' : '' ) . ' en Duna Neumáticos. Envíos y atención en Las Piedras, Canelones, Uruguay.';
		}
	} elseif ( is_page( 'contact-us' ) || is_page( 'contacto' ) ) {
		$description = 'Contactate con Duna Neumáticos: Av. Dr. Enrique Pouey 830, Las Piedras, Canelones, Uruguay. Teléfono 2364 4300. Respondemos tu consulta.';
	} elseif ( is_page( 'about-us' ) ) {
		$description = 'Conocé Duna Neumáticos: más de 30 años en venta de neumáticos y servicios de alineación, balanceo, mecánica y reparación en Las Piedras.';
	} elseif ( is_page( 'pressure-pro' ) || is_page( 'pressure-pro-comercial' ) || is_page( 'pressure-pro-recreacional' ) || is_page( 'pressure-pro-pesados' ) || is_page( 'pressure-pro-portuarios' ) || is_page( 'pressure-pro-forestal' ) || is_page( 'pressure-pro-agricultura' ) || is_page( 'pressurepro-especiales' ) || is_page( 'pressure-pro-emergencias' ) ) {
		$description = 'PressurePro en Duna Neumáticos: monitoreo de presión de neumáticos para flotas, transporte y maquinaria. Más seguridad y rendimiento.';
	} elseif ( is_page( 'buscador-neumaticos' ) ) {
		$description = 'Encontrá el neumático ideal para tu vehículo en Duna Neumáticos. Buscá por medida o vehículo y cotizá online en U$S o $U.';
	} elseif ( is_page( 'faq' ) ) {
		$description = 'Preguntas frecuentes sobre neumáticos en Duna Neumáticos: medidas, mantenimiento, servicios y compra online. Resolvé tus dudas.';
	} elseif ( is_page( 'service' ) || is_page( 'inventory' ) ) {
		$description = 'Servicios de Duna Neumáticos: alineación, balanceo, chequeo, mecánica y reparación de neumáticos. Agendá tu turno en Las Piedras.';
	} elseif ( is_page( 'cart' ) ) {
		$description = 'Revisá tu carrito de compras en Duna Neumáticos antes de finalizar. Neumáticos, llantas y baterías con precios en U$S o $U.';
	} elseif ( is_page( 'checkout' ) ) {
		$description = 'Finalizá tu compra en Duna Neumáticos de forma segura. Neumáticos, llantas y baterías con envío a todo Uruguay.';
	} elseif ( is_page( 'my-account' ) ) {
		$description = 'Accedé a tu cuenta en Duna Neumáticos para ver tus pedidos, direcciones y datos. Comprá online neumáticos, llantas y baterías.';
	} elseif ( is_home() || is_post_type_archive( 'post' ) || is_page( 'blog' ) ) {
		$description = 'Novedades y consejos de Duna Neumáticos: cuidado de neumáticos, seguridad vial y noticias en Las Piedras, Canelones, Uruguay.';
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		if ( $post && has_excerpt( $post ) ) {
			$description = wp_strip_all_tags( get_the_excerpt( $post ) );
		} elseif ( $post ) {
			$description = $post->post_title . ' en Duna Neumáticos. Información, novedades y servicios de neumáticos en Las Piedras, Canelones, Uruguay.';
		}
	}

	if ( ! empty( $description ) ) {
		$description = trim( preg_replace( '/\s+/', ' ', $description ) );
		echo '<meta name="description" content="' . esc_attr( $description ) . '" />' . "\n";
	}
}
add_action( 'wp_head', 'duna_child_meta_description', 1 );

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
