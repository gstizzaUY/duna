<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists( 'multi_purpose_Welcome' ) ) {

	class multi_purpose_Welcome {
		public $multi_purpose_theme_fields;

		public function __construct( $multi_purpose_fields = array() ) {
			$this->multi_purpose_theme_fields = $multi_purpose_fields;
			add_action ('admin_init' , array( $this, 'admin_scripts' ) );
			add_action('admin_menu', array( $this, 'multi_purpose_themeinfo_page_menu' ));
		}

		public function admin_scripts() {
			global $pagenow;
			$multi_purpose_file_dir = get_template_directory_uri() . '/themeinfo/assets/';

			if ( $pagenow === 'themes.php' && isset($_GET['page']) && $_GET['page'] === 'multi-purpose-themeinfo-page' ) {

				wp_enqueue_style (
					'multi-purpose-themeinfo-page-style',
					$multi_purpose_file_dir . 'multi_purpose_themeinfo_page.css',
					array(), '1.0.0'
				);

				wp_enqueue_script (
					'multi-purpose-themeinfo-page-functions',
					$multi_purpose_file_dir . 'multi_purpose_themeinfo_page.js',
					array('jquery'),
					'1.0.0',
					true
				);
			}
		}

        public function multi_purpose_theme_info($multi_purpose_id, $multi_purpose_screenshot = false) {
            $multi_purpose_themedata = wp_get_theme();
            return ($multi_purpose_screenshot === true) ? esc_url($multi_purpose_themedata->get_screenshot()) : esc_html($multi_purpose_themedata->get($multi_purpose_id));
        }

        public function multi_purpose_themeinfo_page_menu() {
            add_theme_page(
                /* translators: 1: Theme Name. */
                sprintf(esc_html__('%1$s Info', 'multi-purpose'), $this->multi_purpose_theme_info('Name')),
                sprintf(esc_html__('%1$s Info', 'multi-purpose'), $this->multi_purpose_theme_info('Name')),
                'edit_theme_options',
                'multi-purpose-themeinfo-page',
                array( $this, 'multi_purpose_themeinfo_page' )
            );
		}

        public function multi_purpose_themeinfo_page() {
            // Define tabs with proper escaping and prefixes
            $multi_purpose_tabs = array(
                'multi_purpose_home'      => esc_html__('Home', 'multi-purpose'),
                'multi_purpose_free_pro'  => esc_html__('Free VS Pro', 'multi-purpose'),
                'multi_purpose_faqs'      => esc_html__('FAQs', 'multi-purpose'),
                'multi_purpose_support'   => esc_html__('Free Theme Supports', 'multi-purpose'),
                'multi_purpose_review'    => esc_html__('Please Rate Us', 'multi-purpose'),
                // 'multi_purpose_free_demo_content'    => esc_html__('Click Here For Free Demo Content', 'multi-purpose'),
            );
            ?>
            <div class="wrap about-wrap access-wrap">
                <div class="test">
                    <div class="nav-tab-wrapper clearfix">
                        <?php
                        $tabHTML = '';
        
                        foreach ($multi_purpose_tabs as $multi_purpose_id => $multi_purpose_label) :
        
                            $multi_purpose_target = '';
                            $multi_purpose_nav_class = 'nav-tab';
                            $multi_purpose_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : 'multi_purpose_home';
        
                            if ($multi_purpose_id === $multi_purpose_section) {
                                $multi_purpose_nav_class .= ' nav-tab-active';
                            }
        
                            if ($multi_purpose_id === 'multi_purpose_free_pro') {
                                $multi_purpose_nav_class .= ' upgrade-button';
                            }

                            if ($multi_purpose_id === 'multi_purpose_review') {
                                $multi_purpose_nav_class .= ' review-button';
                            }

                            if ($multi_purpose_id === 'multi_purpose_free_demo_content') {
                                $multi_purpose_nav_class .= ' demo-content-button';
                            }
        
                            switch ($multi_purpose_id) {
        
                                case 'multi_purpose_support':
                                    $multi_purpose_target = 'target="_blank"';
                                    $multi_purpose_url = esc_url('https://wordpress.org/support/theme/' . esc_html($this->multi_purpose_theme_info('TextDomain')));
                                break;
        
                                case 'multi_purpose_review':
                                    $multi_purpose_target = 'target="_blank"';
                                    $multi_purpose_url = esc_url('https://wordpress.org/support/theme/' . esc_html($this->multi_purpose_theme_info('TextDomain')) . '/reviews/#new-post');
                                break;

                                case 'multi_purpose_free_demo_content':
                                $multi_purpose_target = 'target="_blank"';
                                $multi_purpose_url = esc_url(admin_url('themes.php?page=multi-purpose-freedemocontent'));
                                break;
                                
                                
                                case 'multi_purpose_home':
                                    $multi_purpose_url = esc_url(admin_url('themes.php?page=multi-purpose-themeinfo-page'));
                                break;
        
                                default:
                                    $multi_purpose_url = esc_url(admin_url('themes.php?page=multi-purpose-themeinfo-page&section=' . esc_attr($multi_purpose_id)));
                                break;
        
                            }
        
                            $tabHTML .= '<a ';
                            $tabHTML .= $multi_purpose_target;
                            $tabHTML .= ' href="' . esc_url($multi_purpose_url) . '"';
                            $tabHTML .= ' class="' . esc_attr($multi_purpose_nav_class) . '"';
                            $tabHTML .= '>';

                            if ($multi_purpose_id === 'multi_purpose_free_demo_content') {
                                $tabHTML .= '<span>' . esc_html($multi_purpose_label) . '</span>';
                            } else {
                                $tabHTML .= esc_html($multi_purpose_label);
                            }

                            $tabHTML .= '</a>';
        
                        endforeach;
        
                        echo $tabHTML;
                        ?>
                    </div>
                    <div class="second-div">
                        <div class="themeinfo-section-wrapper">
                            <div class="themeinfo-section multi_purpose_home clearfix">
                                <?php
                                $multi_purpose_section = isset($_GET['section']) ? sanitize_text_field($_GET['section']) : 'multi_purpose_home';
                                switch ($multi_purpose_section) {
            
                                    case 'multi_purpose_free_pro':
                                        $this->multi_purpose_free_pro();
                                    break;
            
                                    case 'multi_purpose_faqs':
                                        $this->multi_purpose_faqs();
                                    break;
            
                                    case 'multi_purpose_home':
                                    default:
                                        $this->multi_purpose_home();
                                    break;
            
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="customizer-settings">
                        <h4><?php esc_html_e( 'Quick Customizer Settings', 'multi-purpose' ); ?></h4>
                        <div class="setting-box">
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon1.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Site Identity', 'multi-purpose' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=title_tagline' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'multi-purpose' ); ?></a>
                                </div>
                            </div>
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon2.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Color Options', 'multi-purpose' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?p=%2Fstyles&section=%2Fvariations' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'multi-purpose' ); ?></a>
                                </div>
                            </div>
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon3.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Header Options', 'multi-purpose' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?path=%2Fpatterns&postType=wp_template_part&categoryId=header' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'multi-purpose' ); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="setting-box">
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon4.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Footer Options', 'multi-purpose' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?path=%2Fpatterns&postType=wp_template_part&categoryId=footer' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'multi-purpose' ); ?></a>
                                </div>
                            </div>
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon5.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Homepage Option', 'multi-purpose' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?p=%2F&canvas=edit' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'multi-purpose' ); ?></a>
                                </div>
                            </div>
                            <div class="custom-links">
                                <div class="icon-box">
                                    <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/icon6.png'; ?>" />
                                </div>
                                <div class="icon-info">
                                    <h5><?php esc_html_e( 'Templates', 'multi-purpose' ); ?></h5>
                                    <a href="<?php echo esc_url( admin_url( 'site-editor.php?p=%2Ftemplate' ) ); ?>" target="_blank" class=""><?php esc_html_e( 'Start Edit', 'multi-purpose' ); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="theme-steps-list">
                    <div class="theme-steps">
                        <h3><?php echo esc_html__('Documentation', 'multi-purpose'); ?></h3>
                        <p><?php echo esc_html__('Need help? Our detailed docs will guide you through everything.', 'multi-purpose'); ?></p>
                        <a target="_blank" class="button button-primary" href="<?php echo esc_url(MULTI_PURPOSE_FREE_DOC); ?>"><?php echo esc_html__('Go to Docs', 'multi-purpose'); ?></a>
                    </div>    
                    <div class="theme-steps">
                        <h3><?php echo esc_html__('Preview Pro Theme', 'multi-purpose'); ?></h3>
                        <p><?php echo esc_html__('Explore our Pro theme demo and see the power of customization.', 'multi-purpose'); ?></p>
                        <div class="pro-screenshot">
                            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/pro-img.png' ); ?>" alt="<?php esc_attr_e( 'Premium Theme Screenshot', 'multi-purpose' ); ?>">
                        </div>
                        <strong>Get 20% OFF </strong><span>WordPress Themes</span><br>
                        <strong>Code: EARLY20</strong>
                        <h6 class="price"><?php echo esc_html__('Just ','multi-purpose'); ?><span class="reg-price"><?php echo esc_html__('$59.00','multi-purpose'); ?></span><span class="sel-price"><?php echo esc_html__('$39.00','multi-purpose'); ?></span></h6>
                        <div class="pro-info-buttons">
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url(MULTI_PURPOSE_LIVE_DEMO); ?>"><?php echo esc_html__('View Live Demo', 'multi-purpose'); ?></a>
                            <a target="_blank" class="button button-primary" href="<?php echo esc_url(MULTI_PURPOSE_BUY_NOW); ?>"><?php echo esc_html__('Buy Pro Theme', 'multi-purpose'); ?></a>
                        </div>
                    </div>              
                    <div class="theme-steps">
                        <h3><?php echo esc_html__('Get the Bundle At Just $59 ', 'multi-purpose'); ?></h3>
                        <div class="bundle-img">
                            <img src="<?php echo esc_url(get_template_directory_uri()) .'/assets/images/bundle-img-2.png'; ?>" />
                        </div>
                        <br>
                        <a target="_blank" class="button button-primary" href="<?php echo esc_url(MULTI_PURPOSE_BUNDLE); ?>"><?php echo esc_html__('Get All Themes', 'multi-purpose'); ?></a>
                    </div>          
                </div>
            </div>
            <?php
        }

        public function multi_purpose_home() {
            ?>
            <div class="theme-info-top-wrap clearfix">
                <div class="theme-details">
                    <div class="theme-screenshot">
                        <img src="<?php echo esc_url( $this->multi_purpose_theme_info( 'Screenshot', true ) ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'multi-purpose' ); ?>" />
                    </div>
                    <div class="about-text"><?php echo esc_html( $this->multi_purpose_theme_info( 'Description' ) ); ?></div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php
        }        

		public function multi_purpose_free_pro() {
            ?>
            <div class="freeandpro">
                <table class="card table free-pro" cellspacing="0" cellpadding="0">
                    <tbody class="table-body">
                        <tr class="table-head">
                            <th class="large"><?php echo esc_html__( 'Features', 'multi-purpose' ); ?></th>
                            <th class="indicator"><?php echo esc_html__( 'Free theme', 'multi-purpose' ); ?></th>
                            <th class="indicator"><?php echo esc_html__( 'Pro Theme', 'multi-purpose' ); ?></th>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Responsive Design', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Site Logo upload', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Footer Copyright text', 'multi-purpose' ); ?></h4>
                                    <div class="feature-inline-row">
                                        <span class="info-icon dashicon dashicons dashicons-info"></span>
                                        <span class="feature-description">
                                            <?php echo esc_html__( 'Remove the copyright text from the Footer.', 'multi-purpose' ); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Easy Customization', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Lightweight & Fast Loading', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Global Color', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Regular Bug Fixes', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>
                        
                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Premium Support', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Theme Sections', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="abc"><?php echo esc_html__( '2 Sections', 'multi-purpose' ); ?></span></td>
                            <td class="indicator"><span class="abc"><?php echo esc_html__( '15+ Sections', 'multi-purpose' ); ?></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Custom colors', 'multi-purpose' ); ?></h4>
                                    <div class="feature-inline-row">
                                        <span class="info-icon dashicon dashicons dashicons-info"></span>
                                        <span class="feature-description">
                                            <?php echo esc_html__( 'Choose a color for links, buttons, icons and so on.', 'multi-purpose' ); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Google fonts', 'multi-purpose' ); ?></h4>
                                    <div class="feature-inline-row">
                                        <span class="info-icon dashicon dashicons dashicons-info"></span>
                                        <span class="feature-description">
                                            <?php echo esc_html__( 'You can choose and use over 600 different fonts, for the logo, the menu and the titles.', 'multi-purpose' ); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Compatible with Popular Plugins', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Translation & WPML Ready', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'SEO Optimized', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Premium Support', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Extensive Customization', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'Custom Post Types', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>

                        <tr class="feature-row">
                            <td class="large">
                                <div class="feature-wrap">
                                    <h4><?php echo esc_html__( 'High-Level Compatibility with Modern Browsers', 'multi-purpose' ); ?></h4>
                                </div>
                            </td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-no-alt" size="30"></span></td>
                            <td class="indicator"><span class="dashicon dashicons dashicons-yes" size="30"></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
        }

        public function multi_purpose_faqs() {
            ?>
            <div class="faq-container">
                <div class="accordion" id="ShoeOutletFaqAccordion">
                    <!-- FAQ 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseOne" aria-expanded="true" aria-controls="ShoeOutletCollapseOne">
                                <?php echo esc_html__('What is the difference between Free and Pro?', 'multi-purpose'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseOne" class="accordion-collapse collapse show" aria-labelledby="ShoeOutletHeadingOne" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('The themes are well-made in both their free and premium versions. But there are a lot more features in the Pro edition.', 'multi-purpose'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('You may quickly alter the appearance and feel of your website with the Pro version. You can alter your websites color and typeface with a few clicks. With more customization choices, the premium version gives you greater control over the theme. In addition, the theme offers more layout options and sections than the free version.', 'multi-purpose'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseTwo" aria-expanded="false" aria-controls="ShoeOutletCollapseTwo">
                                <?php echo esc_html__('What are the advantages of upgrading to the Premium version?', 'multi-purpose'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseTwo" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingTwo" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('In addition to the additional features and regular upgrades, the Premium version comes with premium support. Compared to the free assistance, you will receive a much faster response if you encounter any theme problems.', 'multi-purpose'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseThree" aria-expanded="false" aria-controls="ShoeOutletCollapseThree">
                                <?php echo esc_html__('Upgrading to the Pro version- will I lose my changes?', 'multi-purpose'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseThree" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingThree" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('Your posts, pages, media, categories, and other data will all be preserved when you upgrade to the Pro theme.', 'multi-purpose'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('You will need to configure the extra features via the customizer, though, because the Pro edition has more features and options. It just takes a few minutes to complete this easy process.', 'multi-purpose'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('There is a lot of flexibility in the Pro version to accommodate future updates. As a result, it differs slightly from the free theme yet is incredibly versatile and user-friendly.', 'multi-purpose'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseFour" aria-expanded="false" aria-controls="ShoeOutletCollapseFour">
                                <?php echo esc_html__('How do I change the copyright text?', 'multi-purpose'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseFour" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingFour" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('You can change the copyright text going to Appearance > Customize > Footer Option > And here you can find (Edit Footer Copyright Text)', 'multi-purpose'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 5 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseFour" aria-expanded="false" aria-controls="ShoeOutletCollapseFour">
                                <?php echo esc_html__('Why is my theme not working well?', 'multi-purpose'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseFour" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingFour" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('It could be a plugin conflict if your customizer is not loading correctly or if you are experiencing problems with the theme.', 'multi-purpose'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('Deactivate every plugin first, with the exception of those the theme suggests, to resolve the problem. After that, use "Ctrl+Shift+R" on Windows to force a new page load. Once the problems have been resolved, begin turning on each plugin individually, then refresh and verify your website each time. This will assist you in identifying the problematic plugin.', 'multi-purpose'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('Please get in touch with us if this was not helpful.', 'multi-purpose'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- FAQ 5 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ShoeOutletHeadingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ShoeOutletCollapseFour" aria-expanded="false" aria-controls="ShoeOutletCollapseFour">
                                <?php echo esc_html__('How can I solve my issues quickly and get faster support?', 'multi-purpose'); ?>
                            </button>
                        </h2>
                        <div id="ShoeOutletCollapseFour" class="accordion-collapse collapse" aria-labelledby="ShoeOutletHeadingFour" data-bs-parent="#ShoeOutletFaqAccordion">
                            <div class="accordion-body">
                                <p>
                                    <?php echo esc_html__('Please make sure you have updated the theme to the most recent version before sending us a support ticket for any problems. The theme update may have resolved the issue.', 'multi-purpose'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('Please try to include as much information as you can in your support ticket submission so that we can address your issue more quickly. We advise you to email us one or more screenshots that clearly illustrate the problems and include the URL of your website.', 'multi-purpose'); ?>
                                </p>
                                <p>
                                    <?php echo esc_html__('Please be patient with us as we may have a delayed response time during the weekend.', 'multi-purpose'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        
	}

}
new multi_purpose_Welcome();
?>