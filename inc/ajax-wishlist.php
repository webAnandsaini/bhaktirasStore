<?php
/**
 * AJAX 2-Way Wishlist Toggle (Add / Remove) with YITH Sync & Header Badge Count.
 * 
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

function dharmgyan_ajax_toggle_wishlist() {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if (!$product_id) {
        wp_send_json_error(array('message' => 'Invalid product ID'));
    }

    $in_wishlist = false;
    $action_done = 'added';

    // 1. Try YITH Wishlist Factory (YITH 4.x / 5.x)
    if (class_exists('YITH_WCWL_Wishlist_Factory')) {
        try {
            $wishlist = YITH_WCWL_Wishlist_Factory::get_default_wishlist();
            if ($wishlist) {
                if ($wishlist->has_product($product_id)) {
                    $wishlist->remove_product($product_id);
                    $in_wishlist = false;
                    $action_done = 'removed';
                } else {
                    $wishlist->add_product($product_id);
                    $in_wishlist = true;
                    $action_done = 'added';
                }
                $wishlist->save();
            }
        } catch (\Exception $e) {
            // Fallback gracefully
        }
    } 
    
    // 2. Legacy YITH_WCWL fallback
    if (!$action_done && function_exists('YITH_WCWL')) {
        try {
            if (YITH_WCWL()->is_product_in_wishlist($product_id)) {
                YITH_WCWL()->details['remove_from_wishlist'] = $product_id;
                $in_wishlist = false;
                $action_done = 'removed';
            } else {
                YITH_WCWL()->details['add_to_wishlist'] = $product_id;
                $in_wishlist = true;
                $action_done = 'added';
            }
        } catch (\Exception $e) {}
    }

    // 3. Calculate updated count
    $count = 0;
    if (function_exists('yith_wcwl_count_products')) {
        $count = yith_wcwl_count_products();
    } elseif (function_exists('yith_wcwl_count_all_products')) {
        $count = yith_wcwl_count_all_products();
    }

    wp_send_json_success(array(
        'product_id'  => $product_id,
        'in_wishlist' => $in_wishlist,
        'action'      => $action_done,
        'count'       => $count,
    ));
}
add_action('wp_ajax_dharmgyan_toggle_wishlist', 'dharmgyan_ajax_toggle_wishlist');
add_action('wp_ajax_nopriv_dharmgyan_toggle_wishlist', 'dharmgyan_ajax_toggle_wishlist');
