<?php
/**
 * Theme setup.
 */
function xepress_setup() {
	load_theme_textdomain( 'dharmgyan', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary menu', 'dharmgyan' ),
			'topmenu' => esc_html__( 'Top menu', 'dharmgyan' ),
			'footer'  => __( 'Secondary menu', 'dharmgyan' ),
			'footerlist'  => __( 'footer list menu', 'dharmgyan' ),
			'toprightmenu' => esc_html__( 'Top Right menu', 'dharmgyan' ),
		)
	);

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

    add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/style.css' );

	// WooCommerce support
	add_theme_support( 'woocommerce' );
	
	// Product gallery features
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Set image dimensions
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 300,
			'single_image_width'    => 744,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 2,
				'max_rows'        => 8,
				'default_columns' => 4,
				'min_columns'     => 2,
				'max_columns'     => 5,
			),
		)
	);
}

add_action( 'after_setup_theme', 'xepress_setup' );


add_image_size( '1920x600', 1920, 600, true );
add_image_size( 'dharmgyan-product-thumb', 300, 300, true );
add_image_size( 'dharmgyan-product-single', 600, 600, true );

/**
 * Clean & Optimize Search Query:
 * Focus searches on Products and Blog Articles, preventing utility system pages
 * (Cart, Checkout, Account, Privacy Policy) from appearing as search results.
 */
function dharmgyan_filter_search_query($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $post_type = $query->get('post_type');
        if (empty($post_type)) {
            if (class_exists('WooCommerce')) {
                $query->set('post_type', array('product', 'post'));
            } else {
                $query->set('post_type', array('post'));
            }
        }
    }
}
add_action('pre_get_posts', 'dharmgyan_filter_search_query');

