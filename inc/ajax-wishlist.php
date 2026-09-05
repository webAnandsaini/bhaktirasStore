<?php
/**
 * AJAX 2-Way Wishlist Toggle (Add / Remove) with YITH Sync & Header Badge Count.
 * Fully supports Guest (session-based) and Logged-In users.
 * 
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

function dharmgyan_ajax_toggle_wishlist() {
    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;

    if (!$product_id || !wc_get_product($product_id)) {
        wp_send_json_error(array('message' => __('Invalid product ID', 'dharmgyan')));
    }

    $in_wishlist = false;
    $action_done = 'added';
    $message     = '';

    // Check if product is currently in wishlist for current user / session
    $is_currently_in_wishlist = false;
    if (function_exists('yith_wcwl_is_product_in_wishlist')) {
        $is_currently_in_wishlist = yith_wcwl_is_product_in_wishlist($product_id);
    } elseif (class_exists('YITH_WCWL_Wishlist_Factory')) {
        try {
            $default_wl = YITH_WCWL_Wishlist_Factory::get_default_wishlist(false, 'read');
            if ($default_wl && method_exists($default_wl, 'has_product')) {
                $is_currently_in_wishlist = $default_wl->has_product($product_id);
            }
        } catch (\Exception $e) {}
    }

    // 1. Primary Method: yith_wcwl_wishlists API (handles guest cookie sessions and user accounts)
    $handled = false;
    if (function_exists('yith_wcwl_wishlists')) {
        try {
            if ($is_currently_in_wishlist) {
                yith_wcwl_wishlists()->remove_item(array('product_id' => $product_id));
                $in_wishlist = false;
                $action_done = 'removed';
                $message     = __('Removed from Wishlist', 'dharmgyan');
            } else {
                yith_wcwl_wishlists()->add_item(array('product_id' => $product_id));
                $in_wishlist = true;
                $action_done = 'added';
                $message     = __('Added to Wishlist', 'dharmgyan');
            }
            $handled = true;
        } catch (\Exception $e) {
            $handled = false;
        }
    }

    // 2. Fallback Method: YITH Wishlist Factory with 'edit' context (creates guest default wishlist if none exists)
    if (!$handled && class_exists('YITH_WCWL_Wishlist_Factory')) {
        try {
            $wishlist = YITH_WCWL_Wishlist_Factory::get_default_wishlist(false, 'edit');
            if ($wishlist) {
                if ($wishlist->has_product($product_id)) {
                    $wishlist->remove_product($product_id);
                    $in_wishlist = false;
                    $action_done = 'removed';
                    $message     = __('Removed from Wishlist', 'dharmgyan');
                } else {
                    $wishlist->add_product($product_id);
                    $in_wishlist = true;
                    $action_done = 'added';
                    $message     = __('Added to Wishlist', 'dharmgyan');
                }
                $wishlist->save();
                $handled = true;
            }
        } catch (\Exception $e) {
            $handled = false;
        }
    }

    // 3. Calculate updated count across all products in wishlist
    $count = 0;
    if (function_exists('yith_wcwl_count_all_products')) {
        $count = yith_wcwl_count_all_products();
    } elseif (function_exists('yith_wcwl_count_products')) {
        $count = yith_wcwl_count_products();
    }

    wp_send_json_success(array(
        'product_id'  => $product_id,
        'in_wishlist' => $in_wishlist,
        'action'      => $action_done,
        'count'       => $count,
        'message'     => $message,
    ));
}
add_action('wp_ajax_dharmgyan_toggle_wishlist', 'dharmgyan_ajax_toggle_wishlist');
add_action('wp_ajax_nopriv_dharmgyan_toggle_wishlist', 'dharmgyan_ajax_toggle_wishlist');

