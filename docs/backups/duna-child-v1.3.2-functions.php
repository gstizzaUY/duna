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
		'1.3.2'
	);

	wp_enqueue_script(
		'duna-child',
		get_stylesheet_directory_uri() . '/assets/js/duna-child.js',
		array( 'jquery' ),
		'1.3.2',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'duna_child_enqueue', 20 );

/**
 * Optimizacion de Google Fonts: el parent (Motors) encola una URL con 28
 * variantes (Open Sans 300-800 + italic, Exo 2 100-900 + italic, Montserrat
 * 100-900 + italic) porque asi vienen los variants en las opciones Nuxy.
 * Las fuentes REALMENTE usadas en el skin (verificado por CDP) son:
 *   - Open Sans: 400 (body), 600 (botones), 700 (precios/categorias)
 *   - Exo 2: 400/500/700 (titulos/menu/h5)
 *   - Montserrat: NO se usa.
 * Se desregistra la hoja del parent y se encola una URL recortada.
 */
function duna_child_optimize_google_fonts() {
	wp_dequeue_style( 'stm_default_google_font' );
	wp_deregister_style( 'stm_default_google_font' );

	wp_enqueue_style(
		'duna-google-fonts',
		'https://fonts.googleapis.com/css?family=Exo%202:400,500,600,700%7COpen%20Sans:400,600,700&display=swap&subset=latin,latin-ext',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'duna_child_optimize_google_fonts', 21 );

/**
 * Precarga la imagen del hero (slider RevSlider) SOLO en la home.
 * RevSlider la descarga de forma diferida (~4.5s en local); el <link rel=preload>
 * adelanta la descarga al inicio y RevSlider la reutiliza desde cache HTTP.
 */
function duna_child_preload_hero() {
	if ( ! is_front_page() ) {
		return;
	}
	echo '<link rel="preload" as="image" href="' . esc_url( home_url( '/wp-content/uploads/2026/08/fachada.webp' ) ) . '" />' . "\n";
}
add_action( 'wp_head', 'duna_child_preload_hero', -10 );

/**
 * SEO basico (opcion A, sin plugin): emite <meta name="description">
 * contextual por tipo de pagina. Textos es-UY de 120-155 caracteres.
 */
function duna_child_meta_description() {
	if ( defined( 'WPSEO_VERSION' ) ) {
		return;
	}

	if ( is_front_page() ) {
		$description = 'Venta de neum├íticos, llantas y bater├¡as en Uruguay: cubiertas para auto, camioneta, cami├│n, agro e industrial. Alineaci├│n y balanceo.';
	} elseif ( is_shop() ) {
		$description = 'Tienda de Duna Neum├íticos: neum├íticos para auto, camioneta, cami├│n y agro, llantas y bater├¡as. Busc├í por medida o veh├¡culo y cotiz├í en U$S o $U.';
	} elseif ( is_product_category() ) {
		$category = get_queried_object();
		if ( $category && ! empty( $category->name ) ) {
			$description = 'Compr├í ' . mb_strtolower( $category->name, 'UTF-8' ) . ' en Duna Neum├íticos: neum├íticos, llantas y bater├¡as con atenci├│n especializada en Las Piedras, Canelones, Uruguay.';
		}
	} elseif ( is_product() ) {
		$product = wc_get_product( get_queried_object_id() );
		if ( $product ) {
			$title      = $product->get_name();
			$sku        = $product->get_sku();
			$description = 'Compr├í ' . $title . ( $sku ? ' (' . $sku . ')' : '' ) . ' en Duna Neum├íticos. Env├¡os y atenci├│n en Las Piedras, Canelones, Uruguay.';
		}
	} elseif ( is_page( 'contact-us' ) || is_page( 'contacto' ) ) {
		$description = 'Contactate con Duna Neum├íticos: Av. Dr. Enrique Pouey 830, Las Piedras, Canelones, Uruguay. Tel├®fono 2364 4300. Respondemos tu consulta.';
	} elseif ( is_page( 'about-us' ) ) {
		$description = 'Conoc├® Duna Neum├íticos: m├ís de 30 a├▒os en venta de neum├íticos y servicios de alineaci├│n, balanceo, mec├ínica y reparaci├│n en Las Piedras.';
	} elseif ( is_page( 'pressure-pro' ) || is_page( 'pressure-pro-comercial' ) || is_page( 'pressure-pro-recreacional' ) || is_page( 'pressure-pro-pesados' ) || is_page( 'pressure-pro-portuarios' ) || is_page( 'pressure-pro-forestal' ) || is_page( 'pressure-pro-agricultura' ) || is_page( 'pressurepro-especiales' ) || is_page( 'pressure-pro-emergencias' ) ) {
		$description = 'PressurePro en Duna Neum├íticos: monitoreo de presi├│n de neum├íticos para flotas, transporte y maquinaria. M├ís seguridad y rendimiento.';
	} elseif ( is_page( 'buscador-neumaticos' ) ) {
		$description = 'Encontr├í el neum├ítico ideal para tu veh├¡culo en Duna Neum├íticos. Busc├í por medida o veh├¡culo y cotiz├í online en U$S o $U.';
	} elseif ( is_page( 'faq' ) ) {
		$description = 'Preguntas frecuentes sobre neum├íticos en Duna Neum├íticos: medidas, mantenimiento, servicios y compra online. Resolv├® tus dudas.';
	} elseif ( is_page( 'service' ) || is_page( 'inventory' ) ) {
		$description = 'Servicios de Duna Neum├íticos: alineaci├│n, balanceo, chequeo, mec├ínica y reparaci├│n de neum├íticos. Agend├í tu turno en Las Piedras.';
	} elseif ( is_page( 'cart' ) ) {
		$description = 'Revis├í tu carrito de compras en Duna Neum├íticos antes de finalizar. Neum├íticos, llantas y bater├¡as con precios en U$S o $U.';
	} elseif ( is_page( 'checkout' ) ) {
		$description = 'Finaliz├í tu compra en Duna Neum├íticos de forma segura. Neum├íticos, llantas y bater├¡as con env├¡o a todo Uruguay.';
	} elseif ( is_page( 'my-account' ) ) {
		$description = 'Acced├® a tu cuenta en Duna Neum├íticos para ver tus pedidos, direcciones y datos. Compr├í online neum├íticos, llantas y bater├¡as.';
	} elseif ( is_home() || is_post_type_archive( 'post' ) || is_page( 'blog' ) ) {
		$description = 'Novedades y consejos de Duna Neum├íticos: cuidado de neum├íticos, seguridad vial y noticias en Las Piedras, Canelones, Uruguay.';
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		if ( $post && has_excerpt( $post ) ) {
			$description = wp_strip_all_tags( get_the_excerpt( $post ) );
		} elseif ( $post ) {
			$description = $post->post_title . ' en Duna Neum├íticos. Informaci├│n, novedades y servicios de neum├íticos en Las Piedras, Canelones, Uruguay.';
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
