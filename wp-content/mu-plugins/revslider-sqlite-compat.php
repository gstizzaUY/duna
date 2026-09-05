<?php
/**
 * Plugin Name: RevSlider SQLite Compatibility
 * Description: Corrige consultas de RevSlider incompatibles con SQLite (WordPress Studio). Reemplaza el truco MySQL `ORDER BY 'id' 'ASC'` por `ORDER BY 1 ASC`, valido en MySQL y SQLite. Sin efecto en hosting con MySQL: el filtro solo existe en el driver SQLite.
 * Author: Wheels
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter(
	'query',
	static function ( $query ) {
		if ( ! is_string( $query ) || false === stripos( $query, 'ORDER BY' ) ) {
			return $query;
		}

		// RevSlider usa $wpdb->prepare("... ORDER BY %s %s", array('id', 'ASC')),
		// lo que genera ORDER BY 'id' 'ASC': valido en MySQL (literal de cadena),
		// pero error de sintaxis en SQLite.
		return preg_replace(
			"/ORDER BY '((?:id|sid))' '(ASC|DESC)'/i",
			'ORDER BY 1 $2',
			$query
		);
	}
);
