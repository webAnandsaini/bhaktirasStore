<?php

/**
 * Enqueue theme assets.
 */
function dharmgyan_enqueue_scripts()
{
    // $theme_version = wp_get_theme()->get('Version');
    $theme_version = '1.0.0';

    // Google Fonts: Noto Sans, Rosarivo, Karla, Germania One
    wp_enqueue_style(
        'dharmgyan-google-fonts',
        'https://fonts.googleapis.com/css2?family=Germania+One&family=Karla:ital,wght@0,400..700;1,400..700&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Rosarivo:ital@0;1&display=swap',
        array(),
        null
    );

    wp_enqueue_style('dharmgyan-style', get_stylesheet_uri(), array(), $theme_version);
    wp_style_add_data('dharmgyan-style', 'rtl', 'replace');
    wp_enqueue_style('dharmgyan-fontawesome', get_theme_file_uri('/assets/css/font-awesome.min.css'), array(), $theme_version);
    wp_enqueue_style('dharmgyan', get_theme_file_uri('/assets/css/style.css'), array(), $theme_version);

    // Global Modern App Bundle (Vite + Swiper + Header Drawer + AJAX Filters)
    wp_enqueue_script('dharmgyan-app', get_theme_file_uri('/assets/js/app.js'), array('jquery'), $theme_version, true);

    // Localize Script for AJAX Filter & Cart operations
    wp_localize_script('dharmgyan-app', 'dharmgyan_vars', array(
        'ajax_url'   => admin_url('admin-ajax.php'),
        'shop_nonce' => wp_create_nonce('dharmgyan_shop_nonce'),
        'home_url'   => home_url('/'),
        'shop_url'   => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
    ));
}

add_action('wp_enqueue_scripts', 'dharmgyan_enqueue_scripts');
