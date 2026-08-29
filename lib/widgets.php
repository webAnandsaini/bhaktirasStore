<?php

/**
 * Register widget areas.
 */
function dharmgyan_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'dharmgyan'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'dharmgyan'),
            'before_widget' => '<section id="%1$s" class="widget %2$s mb-8">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title text-xl font-bold mb-4">',
            'after_title'   => '</h2>',
        )
    );
    register_sidebar(array(
        'name'          => esc_html__('Shop Page Widget Area', 'dharmgyan'),
        'id'            => 'shop-page',
        'description'   => esc_html__('Add widgets here to appear in shop page sidebar.', 'dharmgyan'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Single Product Widget Area', 'dharmgyan'),
        'id'            => 'single-product',
        'description'   => esc_html__('Add widgets here to appear in single product page sidebar.', 'dharmgyan'),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(
        array(
            'name'          => esc_html__('Footer Widget Area', 'dharmgyan'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Add widgets here.', 'dharmgyan'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title text-lg font-semibold mb-3">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'dharmgyan_widgets_init');
