<?php
$recaptcha_enabled    = apply_filters( 'motors_vl_get_nuxy_mod', false, 'enable_recaptcha' );
$recaptcha_public_key = apply_filters( 'motors_vl_get_nuxy_mod', false, 'recaptcha_public_key' );
$recaptcha_secret_key = apply_filters( 'motors_vl_get_nuxy_mod', false, 'recaptcha_secret_key' );

if ( ! empty( $recaptcha_enabled ) && $recaptcha_enabled && ! empty( $recaptcha_public_key ) && ! empty( $recaptcha_secret_key ) ) {
	wp_enqueue_script( 'stm_grecaptcha' );
}

$listing_id    = get_queried_object_id();
$listing_title = apply_filters( 'stm_generate_title_from_slugs', get_the_title( $listing_id ), $listing_id );

$form_html = apply_filters(
	'mvl_get_form_html',
	'',
	'request_car_price',
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
<div class="modal" id="get-car-price" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<form id="get-car-price-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-iconed">
					<i class="stm-icon-steering_wheel"></i>
					<h3 class="modal-title" id="myModalLabel"><?php esc_html_e( 'Request car price', 'motors' ); ?></h3>
					<div class="test-drive-car-name">
						<?php echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_queried_object_id() ), get_queried_object_id() ) ); ?>
					</div>
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
					</div>
					<div class="row">
						<div class="col-md-7 col-sm-7"></div>
						<div class="col-md-5 col-sm-5">
							<?php if ( ! empty( $recaptcha_enabled ) && $recaptcha_enabled && ! empty( $recaptcha_public_key ) && ! empty( $recaptcha_secret_key ) ) : ?>
								<button type="submit" class="stm-request-test-drive g-recaptcha" data-sitekey="<?php echo esc_attr( $recaptcha_public_key ); ?>" data-callback='onSubmitGetCarPrice'><?php esc_html_e( 'Request', 'motors' ); ?></button>
								<script>
									function onSubmitGetCarPrice(token) {
										console.log(token);
										jQuery("form#get-car-price-form").trigger('submit');
									}
								</script>
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
		$form_config = \MotorsVehiclesListing\Pro\Addons\FormsEditor\Config\Config::instance_of( 'request_car_price' );
		if ( $form_config ) {
			$form_data    = $form_config->data();
			$saved_values = $form_config->get_values();
			$fields       = $form_data['fields'] ?? array();

			$template_data = array(
				'form_slug'    => 'request_car_price',
				'args'         => array(
					'listing_id'    => $listing_id,
					'listing_title' => $listing_title,
					'is_modal'      => true,
				),
				'fields'       => $fields,
				'saved_values' => $saved_values,
			);

			do_action( 'stm_listings_load_template', 'addons/forms-editor/page/partials/forms/request-car-price', $template_data );
		}
	}
	?>
<?php endif; ?>
