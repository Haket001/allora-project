<?php

function theme_enqueue()
{
    wp_enqueue_style('fonts', get_stylesheet_directory_uri() . '/assets/styles/fonts.css');
    wp_enqueue_style('global', get_stylesheet_directory_uri() . '/assets/styles/global.css');
    wp_enqueue_style('header.styles', get_stylesheet_directory_uri() . '/assets/styles/header.css');
    wp_enqueue_style('footer.styles', get_stylesheet_directory_uri() . '/assets/styles/footer.css');
    wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/scripts/scripts.js', array(), date('Ymd'), true);
    if (is_front_page()) {
        wp_enqueue_style('custom-template-styles', get_stylesheet_directory_uri() . '/assets/styles/home.css');
        wp_enqueue_script('home-scripts', get_template_directory_uri() . '/assets/scripts/home.js', array(), date('Ymd'), true);
    }
    if (is_singular('area')) {
        wp_enqueue_style('single-style', get_stylesheet_directory_uri() . '/assets/styles/single.css');
    }
    if (is_singular('guides')) {
        wp_enqueue_style('single-guides', get_stylesheet_directory_uri() . '/assets/styles/single-guides.css');
    }
    if ( is_post_type_archive( 'guides' ) ) {
        wp_enqueue_style( 'guides-style', get_stylesheet_directory_uri() . '/assets/styles/guides.css' );
    }
    if (is_front_page() || is_post_type_archive('property')) {
        wp_enqueue_style('archive', get_stylesheet_directory_uri() . '/assets/styles/archive.css');
        wp_enqueue_style('nouislider', get_template_directory_uri() . '/assets/noUiSlider/nouislider.min.css', array(), '15.5.0');
        wp_enqueue_script('nouislider', get_template_directory_uri() . '/assets/noUiSlider/nouislider.min.js', array(), '15.5.0', true);
    }
    if (is_post_type_archive('property')) {
        wp_enqueue_script('property-filter', get_template_directory_uri() . '/assets/scripts/property.js', array(), date('Ymd'), true);
        wp_localize_script('property-filter', 'ajaxParams', array(
            'ajaxurl' => admin_url('admin-ajax.php')
        ));
    }
    if (is_singular('property')) {
        wp_enqueue_style('single-property', get_stylesheet_directory_uri() . '/assets/styles/single-property.css');
        wp_enqueue_script('single-property', get_template_directory_uri() . '/assets/scripts/single-property.js', array(), date('Ymd'), true);
        wp_enqueue_style('fancybox', get_stylesheet_directory_uri() . '/assets/scripts/fancybox/fancybox.css');
        wp_enqueue_script('lightbox', get_template_directory_uri() . '/assets/scripts/fancybox/fancybox.js', array(), '5.0', true);
        wp_enqueue_style('archive', get_stylesheet_directory_uri() . '/assets/styles/archive.css');
    }
    wp_enqueue_script('weather-time', get_template_directory_uri() . '/assets/scripts/weather-time.js', array(), date('Ymd'), true);
    wp_localize_script('weather-time', 'weatherTimeSettings', array(
        'locale' => get_locale(),
    ));
    wp_enqueue_script('newsletter-subscribe', get_template_directory_uri() . '/assets/scripts/newsletter-subscribe.js', [], null, true);

    wp_localize_script('newsletter-subscribe', 'SubscribeFormData', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
}


add_action('wp_enqueue_scripts', 'theme_enqueue');