<?php
/**
 * Admin settings page with license and style customization.
 *
 * @package WheelsSizeFinder
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Wheels_Size_Finder_Admin {

    private $api;
    private $license;
    private $shortcode;
    private $assets;

    public function __construct( Wheels_Size_Finder_API $api, Wheels_Size_Finder_License $license, Wheels_Size_Finder_Shortcode $shortcode, Wheels_Size_Finder_Assets $assets ) {
        $this->api       = $api;
        $this->license   = $license;
        $this->shortcode = $shortcode;
        $this->assets    = $assets;

        add_action( 'admin_menu', array( $this, 'add_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
        add_action( 'admin_post_wsf_activate_license', array( $this, 'handle_license_activation' ) );
        add_action( 'admin_post_wsf_deactivate_license', array( $this, 'handle_license_deactivation' ) );
    }

    public function add_menu() {
        add_menu_page(
            __( 'Wheels Size Finder', 'wheels-size-finder' ),
            __( 'Wheels Finder', 'wheels-size-finder' ),
            'manage_options',
            'wheels-size-finder',
            array( $this, 'render_page' ),
            'dashicons-search',
            56
        );
    }

    public function register_settings() {
        register_setting( 'wsf_settings_group', WSF_SETTINGS_OPTION, array(
            'type'              => 'array',
            'sanitize_callback' => array( $this, 'sanitize_settings' ),
            'default'           => array(),
        ) );
    }

    public function sanitize_settings( $input ) {
        $sanitized = array();

        $sanitized['wsf_api_url']             = isset( $input['wsf_api_url'] ) ? esc_url_raw( $input['wsf_api_url'] ) : '';
        $sanitized['wsf_search_mode']         = isset( $input['wsf_search_mode'] ) && in_array( $input['wsf_search_mode'], array( 'tire', 'vehicle', 'both' ), true ) ? $input['wsf_search_mode'] : 'tire';
        $sanitized['wsf_title']               = isset( $input['wsf_title'] ) ? sanitize_text_field( $input['wsf_title'] ) : '';
        $sanitized['wsf_title_tag']           = isset( $input['wsf_title_tag'] ) && in_array( $input['wsf_title_tag'], array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) ? $input['wsf_title_tag'] : 'h2';
        $sanitized['wsf_title_classes']       = isset( $input['wsf_title_classes'] ) ? $this->sanitize_css_classes( $input['wsf_title_classes'] ) : '';
        $sanitized['wsf_font_family']         = isset( $input['wsf_font_family'] ) ? sanitize_text_field( $input['wsf_font_family'] ) : '';
        $sanitized['wsf_primary_color']       = $this->sanitize_color( $input, 'wsf_primary_color' );
        $sanitized['wsf_bg_color']            = $this->sanitize_color( $input, 'wsf_bg_color' );
        $sanitized['wsf_card_bg']             = $this->sanitize_color( $input, 'wsf_card_bg' );
        $sanitized['wsf_text_color']          = $this->sanitize_color( $input, 'wsf_text_color' );
        $sanitized['wsf_label_color']         = $this->sanitize_color( $input, 'wsf_label_color' );
        $sanitized['wsf_border_color']        = $this->sanitize_color( $input, 'wsf_border_color' );
        $sanitized['wsf_input_bg']            = $this->sanitize_color( $input, 'wsf_input_bg' );
        $sanitized['wsf_option_bg']           = $this->sanitize_color( $input, 'wsf_option_bg' );
        $sanitized['wsf_option_text']         = $this->sanitize_color( $input, 'wsf_option_text' );
        $sanitized['wsf_arrow_color']         = $this->sanitize_color( $input, 'wsf_arrow_color' );
        $sanitized['wsf_result_color']        = $this->sanitize_color( $input, 'wsf_result_color' );
        $sanitized['wsf_button_bg']           = $this->sanitize_color( $input, 'wsf_button_bg' );
        $sanitized['wsf_button_text']         = $this->sanitize_color( $input, 'wsf_button_text' );
        $sanitized['wsf_button_hover']        = $this->sanitize_color( $input, 'wsf_button_hover' );
        $sanitized['wsf_button_border']       = $this->sanitize_color( $input, 'wsf_button_border' );
        $sanitized['wsf_accent_color']        = $this->sanitize_color( $input, 'wsf_accent_color' );
        $sanitized['wsf_input_font_size']     = isset( $input['wsf_input_font_size'] ) && '' !== $input['wsf_input_font_size'] ? absint( $input['wsf_input_font_size'] ) : '';
        $sanitized['wsf_input_border_radius'] = isset( $input['wsf_input_border_radius'] ) && '' !== $input['wsf_input_border_radius'] ? absint( $input['wsf_input_border_radius'] ) : '';
        $sanitized['wsf_input_padding']       = isset( $input['wsf_input_padding'] ) && '' !== $input['wsf_input_padding'] ? absint( $input['wsf_input_padding'] ) : '';
        $sanitized['wsf_result_size']         = isset( $input['wsf_result_size'] ) && '' !== $input['wsf_result_size'] ? absint( $input['wsf_result_size'] ) : '';
        $sanitized['wsf_button_radius']       = isset( $input['wsf_button_radius'] ) && '' !== $input['wsf_button_radius'] ? absint( $input['wsf_button_radius'] ) : '';
        $sanitized['wsf_redirect']            = isset( $input['wsf_redirect'] ) ? sanitize_text_field( $input['wsf_redirect'] ) : '';
        $sanitized['wsf_per_page']            = isset( $input['wsf_per_page'] ) ? absint( $input['wsf_per_page'] ) : 12;

        return $sanitized;
    }

    private function sanitize_color( $input, $key ) {
        if ( ! isset( $input[ $key ] ) ) {
            return '';
        }

        return sanitize_hex_color( $input[ $key ] );
    }

    private function sanitize_css_classes( $value ) {
        $classes = preg_split( '/\s+/', $value );

        $clean = array();
        foreach ( $classes as $class ) {
            $class = preg_replace( '/[^a-zA-Z0-9_-]/', '', $class );
            if ( ! empty( $class ) ) {
                $clean[] = $class;
            }
        }

        return implode( ' ', $clean );
    }

    public function enqueue_admin_assets( $hook ) {
        if ( 'toplevel_page_wheels-size-finder' !== $hook ) {
            return;
        }
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style(
            'wheels-size-finder',
            WSF_PLUGIN_URL . 'assets/css/wheels-finder.css',
            array(),
            WSF_VERSION
        );
        wp_enqueue_script(
            'wsf-admin',
            WSF_PLUGIN_URL . 'assets/js/admin.js',
            array( 'wp-color-picker' ),
            WSF_VERSION,
            true
        );
    }

    public function handle_license_activation() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'No tienes permisos suficientes.', 'wheels-size-finder' ) );
        }

        check_admin_referer( 'wsf_license_nonce', 'wsf_nonce' );

        $key = isset( $_POST['wsf_license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['wsf_license_key'] ) ) : '';

        $result = $this->license->validate( $key, $this->api );

        if ( is_wp_error( $result ) ) {
            set_transient( 'wsf_admin_notice', $result->get_error_message(), 60 );
        } else {
            set_transient( 'wsf_admin_notice', __( 'Licencia activada correctamente.', 'wheels-size-finder' ), 60 );
            $this->license->schedule_check();
        }

        wp_safe_redirect( admin_url( 'admin.php?page=wheels-size-finder' ) );
        exit;
    }

    public function handle_license_deactivation() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'No tienes permisos suficientes.', 'wheels-size-finder' ) );
        }

        check_admin_referer( 'wsf_license_nonce', 'wsf_nonce' );

        $this->license->set_status( 'inactive' );
        set_transient( 'wsf_admin_notice', __( 'Licencia desactivada.', 'wheels-size-finder' ), 60 );

        wp_safe_redirect( admin_url( 'admin.php?page=wheels-size-finder' ) );
        exit;
    }

    public function render_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'No tienes permisos suficientes.', 'wheels-size-finder' ) );
        }

        $settings = get_option( WSF_SETTINGS_OPTION, array() );
        $license_key    = $this->license->get_key();
        $license_status = $this->license->get_status_label();

        $preview_vars = array();
        foreach ( $this->assets->get_style_vars( $settings ) as $var => $value ) {
            $preview_vars[] = $var . ':' . $value;
        }
        $preview_style = implode( ';', $preview_vars );

        $notice = get_transient( 'wsf_admin_notice' );
        if ( $notice ) {
            delete_transient( 'wsf_admin_notice' );
        }

        ?>
        <div class="wrap wsf-admin-wrap">
            <h1><?php echo esc_html__( 'Wheels Size Finder', 'wheels-size-finder' ); ?></h1>

            <?php if ( $notice ) : ?>
                <div class="notice notice-success is-dismissible"><p><?php echo esc_html( $notice ); ?></p></div>
            <?php endif; ?>

            <div class="wsf-admin-grid">
                <div class="wsf-admin-main">
                    <form method="post" action="options.php">
                        <?php settings_fields( 'wsf_settings_group' ); ?>
                        <div class="wsf-card wsf-preview-card">
                            <h2><?php esc_html_e( 'Vista previa en vivo', 'wheels-size-finder' ); ?></h2>
                            <p class="description"><?php esc_html_e( 'Edita los estilos en la barra y mira el resultado al instante. Guarda los cambios al terminar.', 'wheels-size-finder' ); ?></p>

                            <div class="wsf-preview-toolbar">
                                <?php
                                $toolbar_colors = array(
                                    'wsf_bg_color'      => array( 'Fondo', '#0f1117', 'Fondo general del buscador (detras de todo)' ),
                                    'wsf_card_bg'       => array( 'Tarjeta', '#161b22', 'Fondo de las tarjetas de producto en los resultados' ),
                                    'wsf_input_bg'      => array( 'Selects', '#0d1117', 'Fondo de los campos desplegables (Marca, Modelo, Ancho...)' ),
                                    'wsf_text_color'    => array( 'Texto', '#e1e4e8', 'Color del texto dentro de los campos desplegables' ),
                                    'wsf_option_bg'     => array( 'Opc. fondo', '#0d1117', 'Fondo de la lista de opciones al abrir un desplegable' ),
                                    'wsf_option_text'   => array( 'Opc. texto', '#e1e4e8', 'Color de las opciones al abrir un desplegable' ),
                                    'wsf_arrow_color'   => array( 'Flechitas', '#e1e4e8', 'Color de la flecha de los campos desplegables' ),
                                    'wsf_label_color'   => array( 'Etiquetas', '#e1e4e8', 'Color de los textos encima de cada campo (Marca, Modelo, Ancho...)' ),
                                    'wsf_border_color'  => array( 'Bordes', '#30363d', 'Color de los bordes de los campos y separadores' ),
                                    'wsf_button_bg'     => array( 'Btn fondo', '#238636', 'Fondo del boton "Buscar productos"' ),
                                    'wsf_button_text'   => array( 'Btn texto', '#ffffff', 'Color del texto del boton "Buscar productos"' ),
                                    'wsf_button_hover'  => array( 'Btn hover', '#1f6f2f', 'Fondo del boton "Buscar productos" al pasar el mouse' ),
                                    'wsf_button_border' => array( 'Btn borde', '#1f6f2f', 'Color del borde del boton "Buscar productos"' ),
                                    'wsf_result_color'  => array( 'Resultado', '#3fb950', 'Color de la medida encontrada (ej: 205/65R15)' ),
                                    'wsf_accent_color'  => array( 'Acento', '#58a6ff', 'Pestanas activas, bordes al enfocar y paginacion' ),
                                    'wsf_primary_color' => array( 'Primario', '#3fb950', 'Color principal: precios de productos y otros detalles' ),
                                );
                                foreach ( $toolbar_colors as $field => $field_data ) :
                                    list( $label, $default_color, $desc ) = $field_data;
                                    $value = isset( $settings[ $field ] ) ? $settings[ $field ] : '';
                                    ?>
                                <span class="wsf-tool-group" title="<?php echo esc_attr( $desc ); ?>">
                                    <label for="<?php echo esc_attr( $field ); ?>"><?php echo esc_html( $label ); ?></label>
                                    <span class="wsf-tool-color">
                                        <input type="text" id="<?php echo esc_attr( $field ); ?>"
                                               name="wsf_settings[<?php echo esc_attr( $field ); ?>]"
                                               value="<?php echo esc_attr( $value ); ?>"
                                               class="wsf-color-picker" data-default-color="<?php echo esc_attr( $default_color ); ?>">
                                        <button type="button" class="wsf-color-clear" data-target="<?php echo esc_attr( $field ); ?>"
                                                title="<?php esc_attr_e( 'Heredar del tema', 'wheels-size-finder' ); ?>">&times;</button>
                                    </span>
                                    <span class="wsf-tool-desc"><?php echo esc_html( $desc ); ?></span>
                                </span>
                                <?php endforeach; ?>

                                <span class="wsf-tool-group">
                                    <label for="wsf_font_family"><?php esc_html_e( 'Tipografia', 'wheels-size-finder' ); ?></label>
                                    <input type="text" id="wsf_font_family" name="wsf_settings[wsf_font_family]"
                                           value="<?php echo esc_attr( isset( $settings['wsf_font_family'] ) ? $settings['wsf_font_family'] : '' ); ?>"
                                           placeholder="<?php esc_attr_e( 'Heredar o ej: Roboto', 'wheels-size-finder' ); ?>">
                                </span>

                                <?php
                                $toolbar_sizes = array(
                                    'wsf_input_font_size'     => array( 'Tam. letra', array( 12, 13, 14, 15, 16, 17, 18, 20 ), 'Tamano de la letra dentro de los campos desplegables' ),
                                    'wsf_input_border_radius' => array( 'Esquinas', array( 0, 2, 4, 6, 8, 12, 16, 24 ), 'Redondeo de las esquinas de los campos desplegables' ),
                                    'wsf_input_padding'       => array( 'Relleno', array( 6, 8, 10, 12, 14, 16, 20 ), 'Relleno interior (alto) de los campos desplegables' ),
                                    'wsf_result_size'         => array( 'Resultado tam.', array( 22, 26, 30, 34, 36, 40, 44, 48, 54 ), 'Tamano de la letra de la medida encontrada (ej: 205/65R15)' ),
                                    'wsf_button_radius'       => array( 'Btn esquinas', array( 0, 2, 4, 6, 8, 12, 16, 24 ), 'Redondeo de las esquinas del boton "Buscar productos"' ),
                                );
                                foreach ( $toolbar_sizes as $field => $field_data ) :
                                    list( $label, $values, $desc ) = $field_data;
                                    ?>
                                <span class="wsf-tool-group" title="<?php echo esc_attr( $desc ); ?>">
                                    <label for="<?php echo esc_attr( $field ); ?>"><?php echo esc_html( $label ); ?></label>
                                    <select id="<?php echo esc_attr( $field ); ?>" name="wsf_settings[<?php echo esc_attr( $field ); ?>]">
                                        <option value=""><?php esc_html_e( 'Heredar', 'wheels-size-finder' ); ?></option>
                                        <?php foreach ( $values as $size ) : ?>
                                            <option value="<?php echo esc_attr( $size ); ?>" <?php selected( isset( $settings[ $field ] ) ? $settings[ $field ] : '', (string) $size ); ?>><?php echo esc_html( $size ); ?> px</option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="wsf-tool-desc"><?php echo esc_html( $desc ); ?></span>
                                </span>
                                <?php endforeach; ?>

                                <span class="wsf-tool-group">
                                    <label for="wsf_title_tag"><?php esc_html_e( 'Etiqueta titulo', 'wheels-size-finder' ); ?></label>
                                    <select id="wsf_title_tag" name="wsf_settings[wsf_title_tag]">
                                        <?php foreach ( array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ) as $tag ) : ?>
                                            <option value="<?php echo esc_attr( $tag ); ?>" <?php selected( isset( $settings['wsf_title_tag'] ) ? $settings['wsf_title_tag'] : 'h2', $tag ); ?>><?php echo esc_html( strtoupper( $tag ) ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </span>

                                <button type="button" class="button wsf-toolbar-reset" id="wsf-reset-styles">
                                    <?php esc_html_e( 'Restablecer estilos', 'wheels-size-finder' ); ?>
                                </button>
                            </div>

                            <div class="wsf-preview" id="wsf-preview"<?php echo $preview_style ? ' style="' . esc_attr( $preview_style ) . '"' : ''; ?>>
                                <?php echo $this->shortcode->render_preview( $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML built with escaping functions. ?>
                            </div>
                        </div>

                        <div class="wsf-card">
                            <h2><?php esc_html_e( 'Configuracion de la API', 'wheels-size-finder' ); ?></h2>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        <label for="wsf_api_url"><?php esc_html_e( 'URL del servidor Wheels', 'wheels-size-finder' ); ?></label>
                                    </th>
                                    <td>
                                        <input type="url" id="wsf_api_url" name="wsf_settings[wsf_api_url]"
                                               value="<?php echo esc_attr( isset( $settings['wsf_api_url'] ) ? $settings['wsf_api_url'] : '' ); ?>"
                                               class="regular-text" placeholder="https://tuservidor.com">
                                        <p class="description"><?php esc_html_e( 'URL de tu servidor Node.js con la API de Wheels.', 'wheels-size-finder' ); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="wsf_search_mode"><?php esc_html_e( 'Modo de busqueda', 'wheels-size-finder' ); ?></label>
                                    </th>
                                    <td>
                                        <select id="wsf_search_mode" name="wsf_settings[wsf_search_mode]">
                                            <option value="tire" <?php selected( isset( $settings['wsf_search_mode'] ) ? $settings['wsf_search_mode'] : 'tire', 'tire' ); ?>><?php esc_html_e( 'Por medidas del neumatico', 'wheels-size-finder' ); ?></option>
                                            <option value="vehicle" <?php selected( isset( $settings['wsf_search_mode'] ) ? $settings['wsf_search_mode'] : 'tire', 'vehicle' ); ?>><?php esc_html_e( 'Por vehiculo', 'wheels-size-finder' ); ?></option>
                                            <option value="both" <?php selected( isset( $settings['wsf_search_mode'] ) ? $settings['wsf_search_mode'] : 'tire', 'both' ); ?>><?php esc_html_e( 'Ambos (tabs)', 'wheels-size-finder' ); ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="wsf_per_page"><?php esc_html_e( 'Productos por pagina', 'wheels-size-finder' ); ?></label>
                                    </th>
                                    <td>
                                        <input type="number" id="wsf_per_page" name="wsf_settings[wsf_per_page]"
                                               value="<?php echo esc_attr( isset( $settings['wsf_per_page'] ) ? $settings['wsf_per_page'] : '12' ); ?>"
                                               min="1" max="100" class="small-text">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="wsf_redirect"><?php esc_html_e( 'Pagina de resultados (slug)', 'wheels-size-finder' ); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" id="wsf_redirect" name="wsf_settings[wsf_redirect]"
                                               value="<?php echo esc_attr( isset( $settings['wsf_redirect'] ) ? $settings['wsf_redirect'] : '' ); ?>"
                                               class="regular-text" placeholder="<?php esc_attr_e( 'Dejar vacio para mostrar en el mismo lugar', 'wheels-size-finder' ); ?>">
                                        <p class="description"><?php esc_html_e( 'Opcional: slug de una pagina donde redirigir los resultados.', 'wheels-size-finder' ); ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="wsf-card">
                            <h2><?php esc_html_e( 'Titulo del buscador', 'wheels-size-finder' ); ?></h2>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        <label for="wsf_title"><?php esc_html_e( 'Titulo', 'wheels-size-finder' ); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" id="wsf_title" name="wsf_settings[wsf_title]"
                                               value="<?php echo esc_attr( isset( $settings['wsf_title'] ) ? $settings['wsf_title'] : '' ); ?>"
                                               class="regular-text" placeholder="<?php esc_attr_e( 'Ej: Buscar neumaticos', 'wheels-size-finder' ); ?>">
                                        <p class="description"><?php esc_html_e( 'Dejar vacio para no mostrar titulo.', 'wheels-size-finder' ); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <label for="wsf_title_classes"><?php esc_html_e( 'Clases CSS del titulo', 'wheels-size-finder' ); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" id="wsf_title_classes" name="wsf_settings[wsf_title_classes]"
                                               value="<?php echo esc_attr( isset( $settings['wsf_title_classes'] ) ? $settings['wsf_title_classes'] : '' ); ?>"
                                               class="regular-text" placeholder="<?php esc_attr_e( 'Ej: vc_custom_heading vc_do_custom_heading vc_custom_1470913347701', 'wheels-size-finder' ); ?>">
                                        <p class="description"><?php esc_html_e( 'Clases extra aplicadas al titulo para integrarlo con estilos del tema (ej. encabezados de WPBakery).', 'wheels-size-finder' ); ?></p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <?php submit_button(); ?>
                    </form>

                    <div class="wsf-card wsf-shortcode-info">
                        <h2><?php esc_html_e( 'Shortcode', 'wheels-size-finder' ); ?></h2>
                        <p><?php esc_html_e( 'Usa el siguiente shortcode en cualquier pagina o post:', 'wheels-size-finder' ); ?></p>
                        <code>[wheels_finder]</code>
                        <p class="description"><?php esc_html_e( 'Atributos opcionales: mode="tire|vehicle|both"', 'wheels-size-finder' ); ?></p>
                    </div>
                </div>

                <div class="wsf-admin-sidebar">
                    <div class="wsf-card">
                        <h2><?php esc_html_e( 'Licencia Premium', 'wheels-size-finder' ); ?></h2>
                        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                            <input type="hidden" name="action" value="wsf_activate_license">
                            <?php wp_nonce_field( 'wsf_license_nonce', 'wsf_nonce' ); ?>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        <label for="wsf_license_key"><?php esc_html_e( 'Clave de licencia', 'wheels-size-finder' ); ?></label>
                                    </th>
                                    <td>
                                        <input type="text" id="wsf_license_key" name="wsf_license_key"
                                               value="<?php echo esc_attr( $license_key ); ?>"
                                               class="regular-text" placeholder="WSF-XXXX-XXXX-XXXX">
                                        <p class="description">
                                            <?php esc_html_e( 'Estado:', 'wheels-size-finder' ); ?>
                                            <strong class="wsf-license-status wsf-status-<?php echo esc_attr( $this->license->get_status() ); ?>">
                                                <?php echo esc_html( $license_status ); ?>
                                            </strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <p class="submit">
                                <button type="submit" class="button button-primary">
                                    <?php esc_html_e( 'Activar licencia', 'wheels-size-finder' ); ?>
                                </button>
                                <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=wsf_deactivate_license' ), 'wsf_license_nonce', 'wsf_nonce' ) ); ?>" class="button">
                                    <?php esc_html_e( 'Desactivar', 'wheels-size-finder' ); ?>
                                </a>
                            </p>
                        </form>
                    </div>

                    <div class="wsf-card">
                        <h2><?php esc_html_e( 'Informacion', 'wheels-size-finder' ); ?></h2>
                        <p><?php esc_html_e( 'Para obtener una clave de licencia, contacta con el soporte de Wheels.', 'wheels-size-finder' ); ?></p>
                        <p>
                            <?php
                            printf(
                                esc_html__( 'Version del plugin: %s', 'wheels-size-finder' ),
                                esc_html( WSF_VERSION )
                            );
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .wsf-admin-wrap { max-width: 1200px; }
            .wsf-admin-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; margin-top: 20px; }
            .wsf-card { background: #fff; border: 1px solid #c3c4c7; border-radius: 4px; padding: 20px; margin-bottom: 20px; }
            .wsf-card h2 { margin-top: 0; padding-bottom: 10px; border-bottom: 1px solid #ddd; }
            .wsf-preview-card { position: static; max-height: none; }
            .wsf-preview-toolbar {
                display: flex;
                flex-wrap: wrap;
                align-items: flex-end;
                gap: 10px 14px;
                margin: 0 0 16px;
                padding: 12px;
                background: #f6f7f7;
                border: 1px solid #dcdcde;
                border-radius: 6px;
            }
            .wsf-tool-group { display: flex; flex-direction: column; gap: 4px; max-width: 220px; }
            .wsf-tool-group > label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; color: #50575e; }
            .wsf-tool-desc { font-size: 10px; line-height: 1.35; color: #8c8f94; }
            .wsf-tool-color { display: flex; align-items: center; gap: 4px; }
            .wsf-preview-toolbar select,
            .wsf-preview-toolbar input[type="text"] {
                min-height: 28px;
                border-radius: 4px;
                border: 1px solid #c3c4c7;
                font-size: 12px;
                padding: 3px 6px;
            }
            .wsf-preview-toolbar input[type="text"] { width: 130px; }
            .wsf-preview-toolbar .wp-picker-input-wrap .wp-color-picker { width: 64px !important; font-size: 12px; padding: 3px 6px; min-height: 26px; border-radius: 4px; }
            .wsf-preview-toolbar .wp-picker-clear { display: none !important; }
            .wsf-color-clear {
                width: 24px;
                height: 28px;
                line-height: 1;
                border: 1px solid #c3c4c7;
                border-radius: 4px;
                background: #fff;
                cursor: pointer;
                font-size: 14px;
                color: #50575e;
            }
            .wsf-color-clear:hover { background: #f0f0f1; }
            .wsf-toolbar-reset { align-self: center; margin-left: auto; }
            .wsf-preview { border: 1px dashed #c3c4c7; border-radius: 6px; padding: 24px; background: #f6f7f7; }
            .wsf-preview .wsf-title { margin-bottom: 16px; }
            .wsf-license-status { font-weight: 700; }
            .wsf-status-active { color: #008a20; }
            .wsf-status-inactive, .wsf-status-invalid { color: #d63638; }
            .wsf-status-expired { color: #bd8600; }
            .wsf-shortcode-info code { display: inline-block; background: #f0f0f1; padding: 6px 12px; border-radius: 3px; font-size: 14px; margin: 8px 0; }
            @media (max-width: 782px) {
                .wsf-admin-grid { grid-template-columns: 1fr; }
                .wsf-preview-card { position: static; max-height: none; }
            }
        </style>
        <?php
    }
}
