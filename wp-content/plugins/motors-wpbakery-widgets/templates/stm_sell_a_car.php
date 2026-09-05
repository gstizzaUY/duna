<?php
/**
 * Sell Your Car widget template
 */

$is_forms_editor = apply_filters( 'mvl_is_addon_enabled', false, 'forms_editor' );

if ( $is_forms_editor && class_exists( '\MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\Config' ) && class_exists( '\MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\FormConfig' ) ) {
	/** @var \MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\FormConfig|null $form_config */
	$form_config = \MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\Config::instance_of( 'sell_your_car' );
	if ( $form_config ) {
		$form_data    = $form_config->data();
		$saved_values = $form_config->get_values();
		$fields       = $form_data['fields'] ?? array();

		$steps = array();
		foreach ( $fields as $field_id => $field_config ) {
			if ( isset( $field_config['type'] ) && 'steps_wizard' === $field_config['type'] ) {
				if ( isset( $saved_values[ $field_id ]['steps'] ) ) {
					$steps = $saved_values[ $field_id ]['steps'];
				} elseif ( isset( $field_config['steps'] ) ) {
					$steps = $field_config['steps'];
				}
				break;
			}
		}
		$template_data = array(
			'form_slug'    => 'sell_your_car',
			'args'         => array(),
			'fields'       => $fields,
			'saved_values' => $saved_values,
			'steps'        => $steps,
		);

		do_action( 'stm_listings_load_template', 'addons/forms-editor/page/partials/forms/sell-your-car', $template_data );
	}
} else {
	do_action( 'stm_listings_load_template', 'trade-in' );
}
