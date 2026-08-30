<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

// Theme setup
include_once(get_template_directory() . '/lib/setup.php');

// Enqueue scripts and styles
include_once(get_template_directory() . '/lib/enqueue.php');

// Initialize theme default settings.
include_once(get_template_directory() . '/lib/config.php');

// Register widget area
include_once(get_template_directory() . '/lib/widgets.php');

// WooCommerce customizations
if (class_exists('WooCommerce')) {
    include_once(get_template_directory() . '/lib/woocommerce.php');
}

/**
 * Register the ACF options page after ACF has initialized.
 */
function dharmgyan_register_acf_options_page()
{
    if (! function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'manage_options',
        'redirect'   => false,
    ));

    if (function_exists('acf_add_options_sub_page')) {
        acf_add_options_sub_page(array(
            'page_title'  => 'Curated Product Sections (Most Viewed, Discount, Trending)',
            'menu_title'  => 'Product Sections',
            'parent_slug' => 'theme-general-settings',
            'menu_slug'   => 'global-curated-products',
        ));

        acf_add_options_sub_page(array(
            'page_title'  => 'Global Product Videos & Reels',
            'menu_title'  => 'Product Videos',
            'parent_slug' => 'theme-general-settings',
            'menu_slug'   => 'global-product-videos',
        ));

        acf_add_options_sub_page(array(
            'page_title'  => 'Global Testimonials & Reviews',
            'menu_title'  => 'Testimonials',
            'parent_slug' => 'theme-general-settings',
            'menu_slug'   => 'global-testimonials',
        ));

        acf_add_options_sub_page(array(
            'page_title'  => 'Global Instagram Gallery',
            'menu_title'  => 'Instagram Gallery',
            'parent_slug' => 'theme-general-settings',
            'menu_slug'   => 'global-instagram-gallery',
        ));
    }
}
add_action('acf/init', 'dharmgyan_register_acf_options_page');

/**
 * Add the theme's local ACF JSON directory.
 *
 * @param array $paths Existing ACF JSON load paths.
 * @return array
 */
function dharmgyan_acf_json_load_point($paths)
{
    $paths[] = get_stylesheet_directory() . '/acf-json';

    return $paths;
}
add_filter('acf/settings/load_json', 'dharmgyan_acf_json_load_point');

/**
 * Safely read an ACF field when ACF is available.
 *
 * @param string         $selector Field name or key.
 * @param int|string|bool $post_id Optional post or options identifier.
 * @return mixed|null
 */
function dharmgyan_get_field($selector, $post_id = false)
{
    if (! function_exists('get_field')) {
        return null;
    }

    $val = get_field($selector, $post_id);
    if (empty($val) && $post_id === false) {
        $val = get_field($selector, 'option');
    }

    return $val;
}

// AJAX Shop and Category Filtering
require_once(get_template_directory() . '/inc/ajax-shop-filter.php');

// AJAX 2-Way Wishlist Toggle
require_once(get_template_directory() . '/inc/ajax-wishlist.php');
