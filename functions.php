<?php
/**
 * Theme functions and definitions.
 */

function theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'theme_setup');

register_nav_menus(array(
    'primary' => __('Primary Menu', 'text_domain'),
    'footer'  => __('Footer Menu', 'text_domain'),
));

add_filter('should_load_separate_core_block_assets', '__return_false');
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');

require_once get_template_directory() . '/inc/enqueue-scripts.php';
require_once get_template_directory() . '/inc/autoloader.php';
require_once get_template_directory() . '/inc/acf-value-options.php';
require_once get_template_directory() . '/inc/property_filter/rest-update-properties.php';
require_once get_template_directory() . '/inc/breadcrumbs.php';
require_once get_template_directory() . '/inc/weather-time.php';
require_once get_template_directory() . '/inc/property_filter/pagination-helper.php';

add_theme_support('custom-logo', array(
    'flex-height' => true,
    'flex-width'  => true,
));

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}

//Disabling jQuery on frontend
add_action('wp_enqueue_scripts', function() {
    if (!is_admin() && !defined('QM_VERSION')) {
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-core');
        wp_deregister_script('jquery-migrate');
        wp_dequeue_script('jquery');
        wp_dequeue_script('jquery-core');
        wp_dequeue_script('jquery-migrate');
    }
}, 100);