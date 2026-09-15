<?php
/**
 * Check if the environment is local
 */
function stadig_env_is_local() {
    return defined( 'WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'local';
}

/**
 * Convert Vite manifest to an array
 */
function stadig_vite_manifest() {

    static $manifest = null;

    if ( $manifest !== null ) {
        return $manifest;
    }

    $manifest_path = get_theme_file_path( 'assets/build/.vite/manifest.json' );

    if ( ! file_exists( $manifest_path ) ) {
        return array();
    }

    $manifest = json_decode(
        file_get_contents( $manifest_path ),
        true
    );

    return $manifest ?: array();
}