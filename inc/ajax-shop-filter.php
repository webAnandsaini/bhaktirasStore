<?php
/**
 * AJAX Handler for Real-Time Shop & Category Filtering
 *
 * @package Dharmgyan
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_ajax_dharmgyan_filter_products', 'dharmgyan_ajax_filter_products');
add_action('wp_ajax_nopriv_dharmgyan_filter_products', 'dharmgyan_ajax_filter_products');

function dharmgyan_ajax_filter_products() {
    // Nonce verification
    $nonce = '';
    if (isset($_POST['nonce'])) {
        $nonce = sanitize_text_field(wp_unslash($_POST['nonce']));
    } elseif (isset($_POST['security'])) {
        $nonce = sanitize_text_field(wp_unslash($_POST['security']));
    }

    if (!wp_verify_nonce($nonce, 'dharmgyan_shop_nonce')) {
        wp_send_json_error(array('message' => __('Invalid security token. Please refresh the page and try again.', 'dharmgyan')));
        wp_die();
    }

    $categories  = isset($_POST['categories']) && is_array($_POST['categories']) ? array_map('sanitize_text_field', wp_unslash($_POST['categories'])) : array();
    $shapes      = isset($_POST['shapes']) && is_array($_POST['shapes']) ? array_map('sanitize_text_field', wp_unslash($_POST['shapes'])) : array();
    $min_price   = isset($_POST['min_price']) && $_POST['min_price'] !== '' ? floatval($_POST['min_price']) : null;
    $max_price   = isset($_POST['max_price']) && $_POST['max_price'] !== '' ? floatval($_POST['max_price']) : null;
    $in_stock    = isset($_POST['in_stock']) && $_POST['in_stock'] === '1';
    $on_sale     = isset($_POST['on_sale']) && $_POST['on_sale'] === '1';
    $orderby     = isset($_POST['orderby']) ? sanitize_text_field(wp_unslash($_POST['orderby'])) : 'menu_order';
    $paged       = isset($_POST['paged']) ? max(1, intval($_POST['paged'])) : 1;
    $search      = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])) : '';

    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 12,
        'paged'          => $paged,
        'tax_query'      => array('relation' => 'AND'),
        'meta_query'     => array('relation' => 'AND'),
    );

    // Search query
    if (!empty($search)) {
        $args['s'] = $search;
    }

    // Category filter
    if (!empty($categories)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $categories,
            'operator' => 'IN',
        );
    }

    // Shape / Custom attribute filter if pa_shape taxonomy exists
    if (!empty($shapes)) {
        if (taxonomy_exists('pa_shape')) {
            $args['tax_query'][] = array(
                'taxonomy' => 'pa_shape',
                'field'    => 'slug',
                'terms'    => $shapes,
                'operator' => 'IN',
            );
        }
    }

    // Price filter
    if ($min_price !== null || $max_price !== null) {
        $args['meta_query'][] = array(
            'key'     => '_price',
            'type'    => 'NUMERIC',
            'compare' => 'BETWEEN',
            'value'   => array(
                $min_price !== null ? $min_price : 0,
                $max_price !== null ? $max_price : 9999999,
            ),
        );
    }

    // In stock filter
    if ($in_stock) {
        $args['meta_query'][] = array(
            'key'     => '_stock_status',
            'value'   => 'instock',
            'compare' => '=',
        );
    }

    // On sale filter
    if ($on_sale) {
        $product_ids_on_sale  = wc_get_product_ids_on_sale();
        $args['post__in']     = !empty($product_ids_on_sale) ? $product_ids_on_sale : array(0);
    }

    // Ordering
    switch ($orderby) {
        case 'popularity':
            $args['meta_key'] = 'total_sales';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
            break;
        case 'rating':
            $args['meta_key'] = '_wc_average_rating';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
            break;
        case 'date':
        case 'latest':
            $args['orderby']  = 'date';
            $args['order']    = 'DESC';
            break;
        case 'price':
        case 'price-asc':
            $args['meta_key'] = '_price';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'ASC';
            break;
        case 'price-desc':
            $args['meta_key'] = '_price';
            $args['orderby']  = 'meta_value_num';
            $args['order']    = 'DESC';
            break;
        default:
            $args['orderby']  = 'menu_order title';
            $args['order']    = 'ASC';
            break;
    }

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            include(locate_template('template-parts/shop/product-card.php'));
        }
    } else {
        include(locate_template('template-parts/shop/no-results.php'));
    }
    $products_html = ob_get_clean();

    // Pagination HTML
    ob_start();
    if ($query->max_num_pages > 1) {
        $current_page = $paged;
        $total_pages  = $query->max_num_pages;
        include(locate_template('template-parts/shop/shop-pagination.php'));
    }
    $pagination_html = ob_get_clean();

    // Count text
    $total_count = $query->found_posts;
    $start_index = ($paged - 1) * 12 + 1;
    $end_index   = min($paged * 12, $total_count);

    if ($total_count > 0) {
        $count_text = sprintf(__('Showing %1$d–%2$d of %3$d results', 'dharmgyan'), $start_index, $end_index, $total_count);
    } else {
        $count_text = __('Showing 0 results', 'dharmgyan');
    }

    wp_reset_postdata();

    wp_send_json_success(array(
        'html'            => $products_html,
        'pagination_html' => $pagination_html,
        'count_text'      => $count_text,
        'total_products'  => $total_count,
        'max_pages'       => $query->max_num_pages,
        'current_page'    => $paged,
    ));
}
