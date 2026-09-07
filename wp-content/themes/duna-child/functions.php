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
		'1.5.2'
	);

	wp_enqueue_script(
		'duna-child',
		get_stylesheet_directory_uri() . '/assets/js/duna-child.js',
		array( 'jquery' ),
		'1.5.2',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'duna_child_enqueue', 20 );

/**
 * A11y: el <meta name=viewport> del PARENT Motors trae user-scalable=no
 * (deshabilita el zoom en movil -> fallo meta-viewport de Lighthouse).
 * El parent lo imprime como HTML CRUDO en header.php (linea 5), ANTES de
 * wp_head, por lo que no se puede pisar agregando otro meta (el navegador usa
 * el primero). Regla de oro: no tocar el parent -> se filtra el HTML final con
 * un output-buffer (template_redirect) que elimina user-scalable=no del meta.
 */
function duna_child_a11y_viewport_buffer() {
	if ( is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( defined( 'DOING_CRON' ) && DOING_CRON ) || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
		return;
	}
	ob_start( 'duna_child_a11y_viewport_cb' );
}
add_action( 'template_redirect', 'duna_child_a11y_viewport_buffer', 0 );

/**
 * Callback del buffer: quita user-scalable=no del contenido del meta viewport.
 */
function duna_child_a11y_viewport_cb( $html ) {
	if ( false === strpos( $html, 'user-scalable' ) ) {
		return $html;
	}
	return str_replace(
		array(
			'width=device-width, initial-scale=1.0, user-scalable=no',
			'width=device-width,initial-scale=1.0,user-scalable=no',
			'user-scalable=no, ',
			', user-scalable=no',
			' user-scalable=no',
		),
		array(
			'width=device-width, initial-scale=1.0',
			'width=device-width,initial-scale=1.0',
			'',
			'',
			'',
		),
		$html
	);
}

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
