<?php
/**
 * Custom Taxonomies for Products: Product Types and Shapes
 *
 * Configured as hierarchical taxonomies so they appear in the right sidebar
 * of the WooCommerce Product Edit page below Categories with checkboxes and "+ Add New".
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

/**
 * Register Product Types and Shapes Taxonomies
 */
function dharmgyan_register_product_taxonomies() {
    // 1. Product Type Taxonomy
    if (!taxonomy_exists('product_item_type')) {
        $type_labels = array(
            'name'              => _x('Product Types', 'taxonomy general name', 'dharmgyan'),
            'singular_name'     => _x('Product Type', 'taxonomy singular name', 'dharmgyan'),
            'search_items'      => __('Search Product Types', 'dharmgyan'),
            'all_items'         => __('All Product Types', 'dharmgyan'),
            'parent_item'       => __('Parent Product Type', 'dharmgyan'),
            'parent_item_colon' => __('Parent Product Type:', 'dharmgyan'),
            'edit_item'         => __('Edit Product Type', 'dharmgyan'),
            'update_item'       => __('Update Product Type', 'dharmgyan'),
            'add_new_item'      => __('Add New Product Type', 'dharmgyan'),
            'new_item_name'     => __('New Product Type Name', 'dharmgyan'),
            'menu_name'         => __('Product Types', 'dharmgyan'),
        );

        register_taxonomy('product_item_type', array('product'), array(
            'hierarchical'          => true, // Checkbox checklist in sidebar like categories
            'labels'                => $type_labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'show_in_nav_menus'     => true,
            'show_in_rest'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'product-type', 'with_front' => false),
        ));
    }

    // 2. Shape Taxonomy
    if (!taxonomy_exists('product_shape')) {
        $shape_labels = array(
            'name'              => _x('Shapes', 'taxonomy general name', 'dharmgyan'),
            'singular_name'     => _x('Shape', 'taxonomy singular name', 'dharmgyan'),
            'search_items'      => __('Search Shapes', 'dharmgyan'),
            'all_items'         => __('All Shapes', 'dharmgyan'),
            'parent_item'       => __('Parent Shape', 'dharmgyan'),
            'parent_item_colon' => __('Parent Shape:', 'dharmgyan'),
            'edit_item'         => __('Edit Shape', 'dharmgyan'),
            'update_item'       => __('Update Shape', 'dharmgyan'),
            'add_new_item'      => __('Add New Shape', 'dharmgyan'),
            'new_item_name'     => __('New Shape Name', 'dharmgyan'),
            'menu_name'         => __('Shapes', 'dharmgyan'),
        );

        register_taxonomy('product_shape', array('product'), array(
            'hierarchical'          => true, // Checkbox checklist in sidebar like categories
            'labels'                => $shape_labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'show_in_nav_menus'     => true,
            'show_in_rest'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'shape', 'with_front' => false),
        ));
    }
}
add_action('init', 'dharmgyan_register_product_taxonomies', 5);

/**
 * Seed initial terms if empty so the filter displays immediately
 */
function dharmgyan_seed_default_taxonomies() {
    // Only run in admin or when initializing
    if (!get_option('dharmgyan_taxonomies_seeded')) {
        $default_types = array(
            'Wall Art'         => 'wall-art',
            'Home Decor'       => 'home-decor',
            'Bracelets'        => 'bracelets',
            'Statues'          => 'statues',
            'Spiritual Items'  => 'spiritual-items',
        );

        foreach ($default_types as $name => $slug) {
            if (!term_exists($slug, 'product_item_type')) {
                wp_insert_term($name, 'product_item_type', array('slug' => $slug));
            }
        }

        $default_shapes = array(
            'Horizontal Wall Hanging' => 'horizontal',
            'Round'                   => 'round',
            'Set of 2 Wall Art'       => 'set-of-2',
            'Set of 3 Wall Art'       => 'set-of-3',
            'Set of 4 Wall Art'       => 'set-of-4',
            'Square Wall Decor'       => 'square',
            'Vertical Wall Art'       => 'vertical',
        );

        foreach ($default_shapes as $name => $slug) {
            if (!term_exists($slug, 'product_shape')) {
                wp_insert_term($name, 'product_shape', array('slug' => $slug));
            }
        }

        update_option('dharmgyan_taxonomies_seeded', '1');
    }
}
add_action('init', 'dharmgyan_seed_default_taxonomies', 10);
