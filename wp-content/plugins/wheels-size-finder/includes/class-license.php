<?php
/**
 * License key validation.
 *
 * @package WheelsSizeFinder
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Wheels_Size_Finder_License {

    const TRANSIENT_KEY    = 'wsf_license_valid';
    const TRANSIENT_EXPIRY = DAY_IN_SECONDS;

    public function is_valid() {
        if ( defined( 'WSF_DEV_MODE' ) && WSF_DEV_MODE ) {
            return true;
        }

        $cached = get_transient( self::TRANSIENT_KEY );
        if ( false !== $cached ) {
            return (bool) $cached;
        }

        $status = get_option( WSF_LICENSE_STATUS, 'inactive' );
        return 'active' === $status;
    }

    public function get_key() {
        return get_option( WSF_LICENSE_OPTION, '' );
    }

    public function get_status() {
        return get_option( WSF_LICENSE_STATUS, 'inactive' );
    }

    public function get_status_label() {
        $status = $this->get_status();
        $labels = array(
            'active'   => __( 'Activa', 'wheels-size-finder' ),
            'inactive' => __( 'Inactiva', 'wheels-size-finder' ),
            'expired'  => __( 'Expirada', 'wheels-size-finder' ),
            'invalid'  => __( 'Invalida', 'wheels-size-finder' ),
        );
        return isset( $labels[ $status ] ) ? $labels[ $status ] : ucfirst( $status );
    }

    public function validate( $key, Wheels_Size_Finder_API $api ) {
        if ( empty( $key ) ) {
            return new WP_Error( 'wsf_empty_key', __( 'La clave de licencia no puede estar vacia.', 'wheels-size-finder' ) );
        }

        $key = sanitize_text_field( $key );

        $domain = wp_parse_url( home_url(), PHP_URL_HOST );

        $response = $api->validate_license( $key, $domain );

        if ( is_wp_error( $response ) ) {
            $this->set_status( 'inactive' );
            return $response;
        }

        if ( ! empty( $response['valid'] ) ) {
            update_option( WSF_LICENSE_OPTION, $key );
            $this->set_status( 'active' );
            return true;
        }

        $this->set_status( 'invalid' );
        return new WP_Error( 'wsf_invalid_key', __( 'Clave de licencia invalida.', 'wheels-size-finder' ) );
    }

    public function set_status( $status ) {
        $allowed = array( 'active', 'inactive', 'expired', 'invalid' );
        if ( ! in_array( $status, $allowed, true ) ) {
            $status = 'inactive';
        }

        update_option( WSF_LICENSE_STATUS, $status );

        if ( 'active' === $status ) {
            set_transient( self::TRANSIENT_KEY, true, self::TRANSIENT_EXPIRY );
        } else {
            delete_transient( self::TRANSIENT_KEY );
        }
    }

    public function schedule_check() {
        if ( ! wp_next_scheduled( 'wsf_license_check' ) ) {
            wp_schedule_event( time(), 'daily', 'wsf_license_check' );
        }
    }
}
