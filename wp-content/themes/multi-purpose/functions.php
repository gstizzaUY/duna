<?php
/**
 * Multi Purpose functions and definitions
 *
 * @package multi_purpose
 * @since 1.0
 */

if ( ! defined( 'MULTI_PURPOSE_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'MULTI_PURPOSE_VERSION', wp_get_theme()->get( 'Version' ) );
}

if ( ! function_exists( 'multi_purpose_support' ) ) :
	function multi_purpose_support() {

		load_theme_textdomain( 'multi-purpose', get_template_directory() . '/languages' );

		add_theme_support( 'custom-background', apply_filters( 'multi_purpose_custom_background', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		add_theme_support('woocommerce');

		// Enqueue editor styles.
		add_editor_style(get_stylesheet_directory_uri() . '/assets/css/editor-style.css');

			// Enqueue editor styles.
		add_editor_style(get_stylesheet_directory_uri() . '/assets/css/editor-style.css');

		define('MULTI_PURPOSE_FREE_BUY_NOW',__('https://www.themepixels.net/products/multi-purpose/','multi-purpose'));
		define('MULTI_PURPOSE_BUY_NOW',__('https://www.themepixels.net/products/multi-purpose-wordpress-theme','multi-purpose'));
		define('MULTI_PURPOSE_LIVE_DEMO',__('themepixels.net/demo-site/multi-purpose-pro/','multi-purpose'));
		define('MULTI_PURPOSE_FREE_DOC',__('https://www.themepixels.net/docs/multi-purpose-free/','multi-purpose'));
		define('MULTI_PURPOSE_BUNDLE',__('https://www.themepixels.net/products/wp-theme-bundle','multi-purpose'));
		define('MULTI_PURPOSE_THEME_SUPPORT',__('https://wordpress.org/support/theme/multi-purpose','multi-purpose'));
    	require_once get_theme_file_path( '/inc/customizer.php' );
	}
endif;

add_action( 'after_setup_theme', 'multi_purpose_support' );

if ( ! function_exists( 'multi_purpose_styles' ) ) :
	function multi_purpose_styles() {
		// Register theme stylesheet.
		$multi_purpose_theme_version = wp_get_theme()->get( 'Version' );

		$multi_purpose_version_string = is_string( $multi_purpose_theme_version ) ? $multi_purpose_theme_version : false;
		wp_enqueue_style(
			'multi-purpose-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$multi_purpose_version_string
		);

		wp_style_add_data('multi-purpose', 'style-rtl', 'replace');

		wp_enqueue_style( 'dashicons' );

		wp_enqueue_style( 'animate-css', esc_url(get_template_directory_uri()).'/assets/css/animate.css' );

		wp_enqueue_script( 'jquery-wow', esc_url(get_template_directory_uri()) . '/assets/js/wow.js', array('jquery') );
	    
		 //font-awesome
		 wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/inc/fontawesome/css/all.css'
		 	, array(), '6.7.0' );

		 wp_enqueue_style( 'owl.carousel-style', get_template_directory_uri().'/assets/css/owl.carousel.css', array(), MULTI_PURPOSE_VERSION );
		wp_enqueue_script( 'owl.carousel-js', get_template_directory_uri(). '/assets/js/owl.carousel.js', array('jquery') ,MULTI_PURPOSE_VERSION,true);

		 wp_enqueue_script('multi-purpose-custom-scripts', get_template_directory_uri() . '/assets/js/custom-script.js',  array('jquery'),'' ,true );
	}
endif;

add_action( 'wp_enqueue_scripts', 'multi_purpose_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

// Add block styles
require get_template_directory() . '/inc/block-styles.php';

// Block Filters
require get_template_directory() . '/inc/block-filters.php';

// Svg icons
require get_template_directory() . '/inc/icon-function.php';

// TGM
require get_template_directory() . '/inc/TGM/tgm.php';

/**
* GET START.
*/
require get_template_directory() . '/themeinfo/multi_purpose_themeinfo_page.php';

// NOTICE FUNCTION
function multi_purpose_activation_notice() {

    if ( get_option( 'multi_purpose_notice_dismissed' ) ) {
        return;
    }

    if ( isset( $_GET['page'] ) && $_GET['page'] === 'multi-purpose-themeinfo-page' ) {
        return;
    }
    multi_purpose_theme_notice_content( true, false, true );
}

function multi_purpose_theme_notice_content(
    $multi_purpose_show_theme_info = true,
    $multi_purpose_show_box_1 = false,
    $multi_purpose_show_dismiss = true
) {
?>
	<div class="updated notice notice-theme-info-class <?php echo $multi_purpose_show_dismiss ? 'is-dismissible' : ''; ?>" data-notice="theme_info">
        <div class="multi-purpose-theme-info-notice clearfix">
            <div class="multi-purpose-theme-notice-content">
				<div class="notice-content">
					<div class="inner-notice-contetn">
						<h4 class="best-value"><?php esc_html_e( 'Best Value', 'multi-purpose' ); ?></h4>
						<h2 class="multi-purpose-notice-h2">
							<?php
							printf(
								/* translators: 1: Theme name */
								esc_html__('Get 30+ Premium WordPress Themes in One Bundle', 'multi-purpose'), '<strong>' . esc_html(wp_get_theme()->get('Name')) . '</strong>'
							);
							?>
						</h2>

						<p class="multi-purpose-notice-p">
							<?php
							printf(
								/* translators: 1: Theme name */
								esc_html__('Premium WordPress Themes for Business, Ecommerce, Blogs, Portfolio and more. Our themes are light & easy to customize ', 'multi-purpose'), '<strong>' . esc_html(wp_get_theme()->get('Name')) . '</strong>'
							);
							?>
						</p>
					</div>
					<div class="inner-notice-buttons">
						<?php if ( $multi_purpose_show_theme_info ) : ?>
							<a class="multi-purpose-btn-theme-info button button-primary bundlee"
								href="<?php echo esc_url( admin_url( 'themes.php?page=multi-purpose-themeinfo-page' ) ); ?>">
								<?php esc_html_e( 'Theme Info', 'multi-purpose' ); ?>
							</a>
						<?php endif; ?>
						<a class="multi-purpose-btn-theme-info button button-primary live-demoo" target="_blank" href="<?php echo esc_url(MULTI_PURPOSE_BUY_NOW); ?>" id="multi-purpose-bundle-button"> <?php esc_html_e('Buy Now', 'multi-purpose') ?></a>
						<a class="multi-purpose-btn-theme-info button button-primary bundlee" target="_blank" href="<?php echo esc_url(MULTI_PURPOSE_LIVE_DEMO); ?>" id="multi-purpose-collection-button"> <?php esc_html_e('Live Demo', 'multi-purpose') ?></a>
						<a class="multi-purpose-btn-theme-info button button-primary bundlee" target="_blank" href="<?php echo esc_url(MULTI_PURPOSE_BUNDLE); ?>" 
						id="multi-purpose-collection-button"> <?php esc_html_e('Get Bundle', 'multi-purpose') ?></a>
					</div>
				</div>
				<div class="middle-box">
					<?php if ( $multi_purpose_show_box_1 ) : ?>
						<div class="box-1">
							<div class="box-info">
								<span class="dashicons dashicons-yes-alt"></span>
								<div>
									<p><?php esc_html_e( '30+ Premium', 'multi-purpose' ); ?></p>
									<p><?php esc_html_e( 'WordPress Themes', 'multi-purpose' ); ?></p>
								</div>
							</div>
							<div class="box-info">
								<span class="dashicons dashicons-yes-alt"></span>
								<div>
									<p><?php esc_html_e( 'Single Theme', 'multi-purpose' ); ?></p>
									<p><?php esc_html_e( 'Starting at $40', 'multi-purpose' ); ?></p>
								</div>
							</div>
							<div class="box-info">
								<span class="dashicons dashicons-yes-alt"></span>
								<div>
									<p><?php esc_html_e( 'One Time Payment -', 'multi-purpose' ); ?></p>
									<p><?php esc_html_e( 'no hidden charges', 'multi-purpose' ); ?></p>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<div class="box-2">
						<p class="box-2-para"><?php esc_html_e( 'Total Value', 'multi-purpose' ); ?></p>
						<h4><?php esc_html_e( '$2499', 'multi-purpose' ); ?></h4>
						<p><?php esc_html_e( 'Bundle Price', 'multi-purpose' ); ?></p>
						<span><sup><?php esc_html_e( '$', 'multi-purpose' ); ?></sup><h2><?php esc_html_e( '59', 'multi-purpose' ); ?></h2></span>
						<p class="box-para"><?php esc_html_e( 'One Time Payement', 'multi-purpose' ); ?></p>
						<p class="box-btn"><?php esc_html_e( 'You Save $2430', 'multi-purpose' ); ?></p>
					</div>
				</div>
				<div class="notice-image">
					<a href="<?php echo esc_url( MULTI_PURPOSE_BUNDLE ); ?>" target="_blank" rel="noopener noreferrer">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/bundle-img.png' ); ?>" alt="<?php esc_attr_e( 'Theme Screenshot', 'multi-purpose' ); ?>">
					</a>
				</div>
            </div>
        </div>
    </div>
<?php
}

add_action('admin_notices', 'multi_purpose_activation_notice');

add_action('wp_ajax_multi_purpose_dismiss_notice', 'multi_purpose_dismiss_notice');

function multi_purpose_notice_status() {
    delete_option('multi_purpose_notice_dismissed');
}
add_action('after_switch_theme', 'multi_purpose_notice_status');

function multi_purpose_dismiss_notice() {
    update_option('multi_purpose_notice_dismissed', true);
    wp_send_json_success();
}

function multi_purpose_admin_enqueue_scripts(){
	wp_enqueue_style('multi-purpose-admin-style', esc_url( get_template_directory_uri() ) . '/assets/css/multi-purpose-notice.css');
	wp_enqueue_script('multi-purpose-dismiss-notice-script', get_stylesheet_directory_uri() . '/assets/js/multi-purpose-notice.js', array('jquery'), null, true);
}
add_action( 'admin_enqueue_scripts', 'multi_purpose_admin_enqueue_scripts' );