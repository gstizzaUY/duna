<?php
if ( function_exists( 'motors_include_once_scripts_styles' ) ) {
	motors_include_once_scripts_styles( array( 'stmdatetimepicker', 'app-datetime' ) );
}

$listing_id    = get_queried_object_id();
$listing_title = apply_filters( 'stm_generate_title_from_slugs', get_the_title( $listing_id ), $listing_id );

$form_html = apply_filters(
	'mvl_get_form_html',
	'',
	'test_drive',
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
<div class="modal" id="test-drive" tabindex="-1" role="dialog" aria-labelledby="myModalLabelTestDrive">
	<form id="request-test-drive-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-iconed">
					<i class="stm-icon-steering_wheel"></i>
					<h3 class="modal-title" id="myModalLabelTestDrive">
						<?php esc_html_e( 'Schedule a Test Drive', 'motors' ); ?>
					</h3>
					<div class="test-drive-car-name">
						<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_queried_object_id() ), get_queried_object_id() ) ); ?>
					</div>
					<div class="mobile-close-modal" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times" aria-hidden="true"></i>
					</div>
				</div>
				<div class="modal-body">
					<div class="modal-body-fields">
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
									<div class="form-modal-label"><?php esc_html_e( 'Best time', 'motors' ); ?></div>
									<div class="stm-datepicker-input-icon">
										<input name="date" class="stm-date-timepicker" type="text" />
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
										function onSubmitTestDrive(token) {
											var form = $("#request-test-drive-form");

											$.ajax({
												url: ajaxurl,
												type: "POST",
												dataType: 'json',
												context: this,
												data: form.serialize() + '&action=stm_ajax_add_test_drive&security=' + stm_security_nonce,
												beforeSend: function () {
													$('.alert-modal').remove();
													form.find('input').removeClass('form-error');
													form.find('.stm-ajax-loader').addClass('loading');
												},
												success: function (data) {
													form.find('.stm-ajax-loader').removeClass('loading');
													form.find('.modal-body').append('<div class="alert-modal alert alert-' + data.status + ' text-left">' + data.response + '</div>')
													for (var key in data.errors) {
														$('#request-test-drive-form input[name="' + key + '"]').addClass('form-error');
													}
												}
											});
											form.find('.form-error').on('hover', function () {
												$(this).removeClass('form-error');
											});
										}
									</script>
									<button class="g-recaptcha" data-sitekey="<?php echo esc_attr( $recaptcha_public_key ); ?>" data-callback='onSubmitTestDrive' type="submit" class="stm-request-test-drive"><?php esc_html_e( 'Request', 'motors' ); ?></button>
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
						<input name="vehicle_name" type="hidden" value="<?php echo esc_attr( get_the_title( get_queried_object_id() ) ); ?>" />
					</div>
					<div class="modal-body-message"></div>
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
		$form_config = \MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\Config::instance_of( 'test_drive' );
		if ( $form_config ) {
			$form_data    = $form_config->data();
			$saved_values = $form_config->get_values();
			$fields       = $form_data['fields'] ?? array();

			$template_data = array(
				'form_slug'    => 'test_drive',
				'args'         => array(
					'listing_id'    => $listing_id,
					'listing_title' => $listing_title,
					'is_modal'      => true,
				),
				'fields'       => $fields,
				'saved_values' => $saved_values,
			);

			do_action( 'stm_listings_load_template', 'addons/forms-editor/page/partials/forms/test-drive', $template_data );
		}
	}
	?>
<?php endif; ?>
