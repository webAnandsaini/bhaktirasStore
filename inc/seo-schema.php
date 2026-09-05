<?php
/**
 * SEO & Accessibility Enhancement Module
 * Generates Schema.org JSON-LD Structured Data, Breadcrumbs, and ARIA attributes.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

/**
 * Output Schema.org JSON-LD Structured Data in wp_head
 */
function dharmgyan_output_schema_jsonld()
{
    $site_name = get_bloginfo('name') ?: 'Bhaktirastore';
    $site_url  = home_url('/');
    $logo_url  = '';

    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_data = wp_get_attachment_image_src($custom_logo_id, 'full');
        if ($logo_data) {
            $logo_url = $logo_data[0];
        }
    }

    $social_links = array_filter(array(
        dharmgyan_get_field('social_facebook', 'option') ?: 'https://facebook.com',
        dharmgyan_get_field('social_instagram', 'option') ?: 'https://instagram.com',
        dharmgyan_get_field('social_twitter', 'option') ?: 'https://twitter.com',
        'https://youtube.com',
        'https://pinterest.com',
    ));

    $schemas = array();

    // 1. WebSite Schema with Sitelinks SearchBox
    $schemas[] = array(
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        '@id'             => esc_url($site_url) . '#website',
        'url'             => esc_url($site_url),
        'name'            => esc_html($site_name),
        'description'     => esc_html(get_bloginfo('description') ?: 'Sacred & Auspicious Devotional Accents for Your Sacred Space'),
        'inLanguage'      => get_locale(),
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => esc_url($site_url) . '?s={search_term_string}&post_type=product',
            'query-input' => 'required name=search_term_string',
        ),
    );

    // 2. Organization / OnlineStore Schema
    $org_schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'OnlineStore',
        '@id'         => esc_url($site_url) . '#organization',
        'name'        => esc_html($site_name),
        'url'         => esc_url($site_url),
        'description' => esc_html__('Handcrafted Hindu God Idols, Aarti Diyas, Brass Essentials, and Spiritual Home Decor.', 'dharmgyan'),
        'sameAs'      => array_values($social_links),
        'contactPoint' => array(
            '@type'       => 'ContactPoint',
            'telephone'   => '+91-9999999999',
            'contactType' => 'customer service',
            'areaServed'  => 'IN',
            'availableLanguage' => array('Hindi', 'English'),
        ),
    );

    if ($logo_url) {
        $org_schema['logo'] = esc_url($logo_url);
        $org_schema['image'] = esc_url($logo_url);
    }
    $schemas[] = $org_schema;

    // 3. BreadcrumbList Schema (Dynamic for all pages)
    $breadcrumb_items = array();
    $breadcrumb_items[] = array(
        '@type'    => 'ListItem',
        'position' => 1,
        'name'     => esc_html__('Home', 'dharmgyan'),
        'item'     => esc_url($site_url),
    );

    if (function_exists('is_product') && is_product()) {
        $product = wc_get_product(get_the_ID());
        if ($product) {
            $terms = get_the_terms(get_the_ID(), 'product_cat');
            $pos = 2;
            if (!empty($terms) && !is_wp_error($terms)) {
                $main_term = $terms[0];
                $breadcrumb_items[] = array(
                    '@type'    => 'ListItem',
                    'position' => $pos++,
                    'name'     => esc_html($main_term->name),
                    'item'     => esc_url(get_term_link($main_term)),
                );
            }
            $breadcrumb_items[] = array(
                '@type'    => 'ListItem',
                'position' => $pos,
                'name'     => esc_html($product->get_name()),
                'item'     => esc_url(get_permalink()),
            );
        }
    } elseif (function_exists('is_product_category') && is_product_category()) {
        $current_term = get_queried_object();
        $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
        $breadcrumb_items[] = array(
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => esc_html__('Collections', 'dharmgyan'),
            'item'     => esc_url($shop_url),
        );
        if ($current_term) {
            $breadcrumb_items[] = array(
                '@type'    => 'ListItem',
                'position' => 3,
                'name'     => esc_html($current_term->name),
                'item'     => esc_url(get_term_link($current_term)),
            );
        }
    } elseif (function_exists('is_shop') && is_shop()) {
        $breadcrumb_items[] = array(
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => esc_html__('Collections', 'dharmgyan'),
            'item'     => esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')),
        );
    } elseif (is_page()) {
        $breadcrumb_items[] = array(
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => esc_html(get_the_title()),
            'item'     => esc_url(get_permalink()),
        );
    }

    if (count($breadcrumb_items) > 1) {
        $schemas[] = array(
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $breadcrumb_items,
        );
    }

    // Output valid JSON-LD
    echo "\n<!-- Dharmgyan SEO Schema.org JSON-LD -->\n";
    foreach ($schemas as $schema) {
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
    }
}
add_action('wp_head', 'dharmgyan_output_schema_jsonld', 5);

/**
 * Filter WordPress Navigation Menus to add aria-current="page" to active links
 */
function dharmgyan_nav_menu_aria_current($atts, $item, $args)
{
    if (in_array('current-menu-item', (array) $item->classes, true) || in_array('current_page_item', (array) $item->classes, true)) {
        $atts['aria-current'] = 'page';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'dharmgyan_nav_menu_aria_current', 10, 3);

/**
 * Ensure image tags output decoding="async" for Core Web Vitals
 */
function dharmgyan_optimize_attachment_image_attributes($attr, $attachment, $size)
{
    if (empty($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'dharmgyan_optimize_attachment_image_attributes', 10, 3);
