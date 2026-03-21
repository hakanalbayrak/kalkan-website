<?php
/**
 * Kalkan Child Theme functions.
 *
 * Extend this file conservatively and keep logic simple.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue child stylesheet.
 *
 * We load after parent styles and keep dependency handling minimal.
 */
function kalkan_child_enqueue_styles() {
    $dependencies = array();

    // If Blocksy registered its main stylesheet, load child CSS after it.
    if (wp_style_is('blocksy-style', 'registered') || wp_style_is('blocksy-style', 'enqueued')) {
        $dependencies[] = 'blocksy-style';
    }

    wp_enqueue_style(
        'kalkan-child-style',
        get_stylesheet_uri(),
        $dependencies,
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'kalkan_child_enqueue_styles', 20);

/**
 * Register lightweight theme settings used by code-rendered homepage.
 */
function kalkan_child_customize_register($wp_customize) {
    $wp_customize->add_setting(
        'kalkan_app_store_url',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'kalkan_app_store_url',
        array(
            'type'        => 'url',
            'section'     => 'title_tagline',
            'label'       => __('Kalkan App Store URL', 'kalkan-child'),
            'description' => __('Used for homepage App Store CTA buttons.', 'kalkan-child'),
        )
    );
}
add_action('customize_register', 'kalkan_child_customize_register');

/**
 * App Store URL override for homepage template.
 */
function kalkan_child_filter_app_store_url($url) {
    $customizer_value = get_theme_mod('kalkan_app_store_url', '');

    if (!empty($customizer_value)) {
        return $customizer_value;
    }

    return $url;
}
add_filter('kalkan_app_store_url', 'kalkan_child_filter_app_store_url');
