<?php
/**
 * Customizer
 * 
 * @package WordPress
 * @subpackage Multi Purpose
 * @since Multi Purpose 1.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function multi_purpose_customize_register( $wp_customize ) {
    // Check for existence of WP_Customize_Manager before proceeding
	if ( ! class_exists( 'WP_Customize_Manager' ) ) {
        return;
    }
    
	$wp_customize->add_section( new multi_purpose_Customizer_Pro_Button( $wp_customize, 'multi_purpose_upsell_premium_section', array(
		'title'       => __( 'Buy Multi Purpose Pro', 'multi-purpose' ),
		'button_text' => __( 'Buy Pro Theme', 'multi-purpose' ),
		'url'         => esc_url( MULTI_PURPOSE_BUY_NOW ),
		'priority'    => 0,
	)));

	$wp_customize->add_section( new multi_purpose_Customizer_Pro_Button( $wp_customize, 'multi_purpose_upsell_live_preview_section', array(
		'title'       => __( 'Preview Pro Theme', 'multi-purpose' ),
		'button_text' => __( 'View Live Demo', 'multi-purpose' ),
		'url'         => esc_url( MULTI_PURPOSE_LIVE_DEMO ),
		'priority'    => 0,
	)));

}
add_action( 'customize_register', 'multi_purpose_customize_register' );

if ( class_exists( 'WP_Customize_Section' ) ) {
	class multi_purpose_Customizer_Pro_Button extends WP_Customize_Section {
		public $type = 'multi-purpose-buynow';
		public $button_text = '';
		public $url = '';

		protected function render() {
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="multi_purpose_customizer_pro_button accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
				<h3 class="accordion-section-title premium-details">
					<?php echo esc_html( $this->title ); ?>
					<a href="<?php echo esc_url( $this->url ); ?>" class="button button-secondary alignright" target="_blank" style="margin-top: -4px;"><?php echo esc_html( $this->button_text ); ?></a>
				</h3>
			</li>
			<?php
		}
	}
}

/**
 * Enqueue script for custom customize control.
 */
function multi_purpose_custom_control_scripts() {
	wp_enqueue_script( 'multi-purpose-custom-controls-js', get_template_directory_uri() . '/assets/js/custom-controls.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), '1.0', true );

    wp_enqueue_style( 'multi-purpose-customizer-css', get_template_directory_uri() . '/assets/css/customizer.css', array(), '1.0' );
}
add_action( 'customize_controls_enqueue_scripts', 'multi_purpose_custom_control_scripts' );