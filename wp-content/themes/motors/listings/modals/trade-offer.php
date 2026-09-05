<?php
$listing_id    = get_queried_object_id();
$listing_title = apply_filters( 'stm_generate_title_from_slugs', get_the_title( $listing_id ), $listing_id );

$form_html = apply_filters(
	'mvl_get_form_html',
	'',
	'offer_price',
	array(
		'listing_id'    => $listing_id,
		'listing_title' => $listing_title,
		'is_modal'      => true,
	)
);

$is_forms_editor       = apply_filters( 'mvl_is_addon_enabled', false, 'forms_editor' );
$use_template_directly = $is_forms_editor && ! empty( $form_html );
?>
<?php if ( ! $use_template_directly ) : ?>
<div class="modal" id="trade-offer" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTradeOffer">
	<form id="request-trade-offer-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-iconed">
					<?php if ( apply_filters( 'stm_is_motorcycle', false ) ) : ?>
						<i class="stm-moto-icon-trade"></i>
						<h3 class="modal-title" id="myModalLabelTestDrive">
							<?php esc_html_e( 'Trade Offer', 'motors' ); ?>
						</h3>
						<div class="test-drive-car-name">
							<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_queried_object_id() ), get_queried_object_id() ) ); ?>
						</div>
					<?php else : ?>
						<i class="stm-moto-icon-cash"></i>
						<h3 class="modal-title" id="myModalLabelTestDrive">
							<?php esc_html_e( 'Offer Price', 'motors' ); ?>
						</h3>
						<div class="test-drive-car-name">
							<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_queried_object_id() ), get_queried_object_id() ) ); ?>
						</div>
					<?php endif; ?>
					<div class="mobile-close-modal" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times" aria-hidden="true"></i>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Name', 'motors' ); ?></div>
								<input name="name" type="text"/>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Email', 'motors' ); ?></div>
								<input name="email" type="email" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Phone', 'motors' ); ?></div>
								<input name="phone" type="tel" />
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<div class="form-modal-label"><?php esc_html_e( 'Trade price', 'motors' ); ?></div>
								<div class="stm-trade-input-icon">
									<input name="trade_price" type="text" />
								</div>
							</div>
						</div>
					</div>
					<div class="mg-bt-25px"></div>
					<div class="row">
						<div class="col-md-7 col-sm-7"></div>
						<div class="col-md-5 col-sm-5">
							<?php
							$recaptcha_enabled    = apply_filters( 'motors_vl_get_nuxy_mod', 0, 'enable_recaptcha' );
							$recaptcha_public_key = apply_filters( 'motors_vl_get_nuxy_mod', '', 'recaptcha_public_key' );
							$recaptcha_secret_key = apply_filters( 'motors_vl_get_nuxy_mod', '', 'recaptcha_secret_key' );

							if ( ! empty( $recaptcha_enabled ) && $recaptcha_enabled && ! empty( $recaptcha_public_key ) && ! empty( $recaptcha_secret_key ) ) :
								?>
								<script>
									function onSubmitTradeOffer(token) {
										var form = $("#request-trade-offer-form");

										$.ajax({
											url: ajaxurl,
											type: "POST",
											dataType: 'json',
											context: this,
											data: form.serialize() + '&action=stm_ajax_add_trade_offer&security=' + stm_security_nonce,
											beforeSend: function () {
												$('.alert-modal').remove();
												form.find('input').removeClass('form-error');
												form.find('.stm-ajax-loader').addClass('loading');
											},
											success: function (data) {
												form.find('.stm-ajax-loader').removeClass('loading');
												form.find('.modal-body').append('<div class="alert-modal alert alert-' + data.status + ' text-left">' + data.response + '</div>')
												for (var key in data.errors) {
													$('#request-trade-offer-form input[name="' + key + '"]').addClass('form-error');
												}
											}
										});

										form.find('.form-error').on('hover', function () {
											$(this).removeClass('form-error');
										});
									}
								</script>
								<button class="g-recaptcha" data-sitekey="<?php echo esc_attr( $recaptcha_public_key ); ?>" data-callback='onSubmitTradeOffer' type="submit" class="stm-request-test-drive"><?php esc_html_e( 'Request', 'motors' ); ?></button>
							<?php else : ?>
								<button type="submit" class="stm-request-test-drive"><?php esc_html_e( 'Request', 'motors' ); ?></button>
							<?php endif; ?>
							<div class="stm-ajax-loader" style="margin-top:10px;">
								<i class="stm-icon-load1"></i>
							</div>
						</div>
					</div>
					<div class="mg-bt-25px"></div>
					<input name="vehicle_id" type="hidden" value="<?php echo esc_attr( get_queried_object_id() ); ?>" />
				</div>
			</div>
		</div>
	</form>
</div>
<?php else : ?>
	<?php
	// Load template directly to preserve scripts (reCAPTCHA, etc.)
	if ( class_exists( '\MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\Config' ) && class_exists( '\MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\FormConfig' ) ) {
		/** @var \MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\FormConfig|null $form_config */
		$form_config = \MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\Config::instance_of( 'offer_price' );
		if ( $form_config ) {
			$form_data    = $form_config->data();
			$saved_values = $form_config->get_values();
			$fields       = $form_data['fields'] ?? array();

			$template_data = array(
				'form_slug'    => 'offer_price',
				'args'         => array(
					'listing_id'    => $listing_id,
					'listing_title' => $listing_title,
					'is_modal'      => true,
				),
				'fields'       => $fields,
				'saved_values' => $saved_values,
			);

			do_action( 'stm_listings_load_template', 'addons/forms-editor/page/partials/forms/offer-price', $template_data );
		}
	}
	?>
<?php endif; ?>
