<?php
/**
 * HTTP API client for Wheels Node.js backend.
 *
 * @package WheelsSizeFinder
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Wheels_Size_Finder_API {

    private $base_url;
    private $timeout = 15;

    public function __construct() {
        $settings     = get_option( WSF_SETTINGS_OPTION, array() );
        $this->base_url = isset( $settings['wsf_api_url'] ) ? untrailingslashit( $settings['wsf_api_url'] ) : '';
    }

    private function request( $endpoint, $method = 'GET', $body = null ) {
        if ( empty( $this->base_url ) ) {
            return new WP_Error( 'wsf_no_api_url', __( 'URL de la API no configurada.', 'wheels-size-finder' ) );
        }

        $url  = $this->base_url . $endpoint;
        $args = array(
            'method'  => $method,
            'timeout' => $this->timeout,
            'headers' => array(
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ),
        );

        if ( null !== $body ) {
            $args['body'] = wp_json_encode( $body );
        }

        $response = wp_remote_request( esc_url_raw( $url ), $args );

        if ( is_wp_error( $response ) ) {
            return $response;
        }

        $code = wp_remote_retrieve_response_code( $response );
        $data = wp_remote_retrieve_body( $response );
        $json = json_decode( $data, true );

        if ( $code < 200 || $code >= 300 ) {
            $message = isset( $json['error'] ) ? $json['error'] : __( 'Error desconocido del servidor.', 'wheels-size-finder' );
            return new WP_Error( 'wsf_api_error', $message, array( 'status' => $code ) );
        }

        return $json;
    }

    public function validate_license( $key, $domain ) {
        return $this->request( '/api/license/validate', 'POST', array(
            'license_key' => $key,
            'domain'      => $domain,
        ) );
    }

    public function get_widths() {
        $result = $this->request( '/api/tire-widths' );
        if ( is_wp_error( $result ) ) {
            return array();
        }
        return is_array( $result ) ? $result : array();
    }

    public function get_profiles( $width ) {
        $result = $this->request( '/api/tire-profiles?width=' . urlencode( $width ) );
        if ( is_wp_error( $result ) ) {
            return array();
        }
        return is_array( $result ) ? $result : array();
    }

    public function get_rims( $width, $profile ) {
        $result = $this->request( '/api/tire-rims?width=' . urlencode( $width ) . '&profile=' . urlencode( $profile ) );
        if ( is_wp_error( $result ) ) {
            return array();
        }
        return is_array( $result ) ? $result : array();
    }

    public function get_brands( $vehicle_type = 1 ) {
        $result = $this->request( '/api/vehicle-brands?type=' . intval( $vehicle_type ) );
        if ( is_wp_error( $result ) ) {
            return array();
        }
        return is_array( $result ) ? $result : array();
    }

    public function get_models( $brand, $vehicle_type = 1 ) {
        $result = $this->request( '/api/vehicle-models?brand=' . urlencode( $brand ) . '&type=' . intval( $vehicle_type ) );
        if ( is_wp_error( $result ) ) {
            return array();
        }
        return is_array( $result ) ? $result : array();
    }

    public function get_years( $brand, $model, $vehicle_type = 1 ) {
        $result = $this->request(
            '/api/vehicle-years?brand=' . urlencode( $brand ) . '&model=' . urlencode( $model ) . '&type=' . intval( $vehicle_type )
        );
        if ( is_wp_error( $result ) ) {
            return array();
        }
        return is_array( $result ) ? $result : array();
    }

    public function get_versions( $brand, $model, $year, $vehicle_type = 1 ) {
        $result = $this->request(
            '/api/vehicle-versions?brand=' . urlencode( $brand ) . '&model=' . urlencode( $model ) . '&year=' . urlencode( $year ) . '&type=' . intval( $vehicle_type )
        );
        if ( is_wp_error( $result ) ) {
            return array();
        }
        return is_array( $result ) ? $result : array();
    }

    public function get_vehicle_tire( $brand, $model, $year, $version, $vehicle_type = 1 ) {
        $result = $this->request(
            '/api/vehicle-tire?brand=' . urlencode( $brand )
            . '&model=' . urlencode( $model )
            . '&year=' . urlencode( $year )
            . '&version=' . urlencode( $version )
            . '&type=' . intval( $vehicle_type )
        );
        if ( is_wp_error( $result ) ) {
            return null;
        }
        return $result;
    }
}
