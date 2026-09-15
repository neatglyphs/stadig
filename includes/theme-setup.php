<?php

/**
 * Set up defaults and register support for WordPress features
 */
function stadig_setup() {
    // Let WordPress handle the <title> tag
    add_theme_support( 'title-tag' );

    // Enable post thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );

    // Swith default core markup to valid HTML5
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )
    );

    // Register nav menus
    register_nav_menus(
        array(
            'nav-primary' => esc_html__( 'Huvudmeny', 'stadig' ),
        )
    );
}
add_action( 'after_setup_theme', 'stadig_setup' );

/**
 * Enqueue scripts and styles
 */
function stadig_theme_assets() {
    // If we're in a local dev environment, enqueue Vite client and assets as modules
    if ( stadig_env_is_local() ) {
        wp_enqueue_script_module( 'stadig-vite-client', 'http://localhost:1337/@vite/client', array(), null );
        wp_enqueue_script_module( 'stadig-main', 'http://localhost:1337/assets/src/main.js', array(), null );
        return;
    }

    // Get manifest
    $manifest = stadig_vite_manifest();

    // Make sure we have an entrypoint defined
    if ( empty( $manifest['assets/src/main.js'] ) ) {
        return;
    }

    $entry = $manifest['assets/src/main.js'];

    // Enqueue CSS
    if ( ! empty( $entry['css'] ) ) {
        foreach ( $entry['css'] as $index => $css_file ) {
            wp_enqueue_style(
                'stadig-main-' . $index,
                get_theme_file_uri( 'assets/build/' . $css_file ),
                array(),
                null
            );
        }
    }

    // Enqueue JavaScript
    wp_enqueue_script_module(
        'stadig-main',
        get_theme_file_uri( 'assets/build/' . $entry['file'] ),
        array(),
        null
    );
}
add_action( 'wp_enqueue_scripts', 'stadig_theme_assets' );