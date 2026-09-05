<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$trade_in   = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_trade_in' );
$make_offer = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_offer_price' );

?>

<div class="stm_deal_buttons_wrap <?php echo esc_attr( $css_class ); ?>">
	<div class="action-links">
		<?php if ( $trade_in ) : ?>
			<a class="action-btn" href="#!" data-toggle="modal" data-target="#trade-in">
				<?php esc_html_e( 'Trande in Form', 'motors-wpbakery-widgets' ); ?>
			</a>
		<?php endif; ?>
		<?php if ( $make_offer ) : ?>
			<a class="action-btn" href="#!" data-toggle="modal" data-target="#trade-offer">
				<?php esc_html_e( 'Make an Offer Price', 'motors-wpbakery-widgets' ); ?>
			</a>
		<?php endif; ?>
	</div>
</div>
