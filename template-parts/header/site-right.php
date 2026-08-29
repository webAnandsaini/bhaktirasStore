<?php
/**
 * Site Header Actions (Help, Wishlist, Bag, Login) - Pixel Perfect Figma
 * 
 * @package Dharmgyan
 */

$help_url = dharmgyan_get_field('help_page_url', 'option') ?: home_url('/contact-us/');

$wishlist_url = function_exists('YITH_WCWL') ? YITH_WCWL()->get_wishlist_url() : home_url('/wishlist/');
$wishlist_count = 0;
if (function_exists('yith_wcwl_count_all_products')) {
    $wishlist_count = yith_wcwl_count_all_products();
}

$cart_count = 0;
$cart_url = home_url('/cart/');
if (function_exists('WC') && WC()->cart) {
    $cart_count = WC()->cart->get_cart_contents_count();
    $cart_url   = wc_get_cart_url();
}

$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/');
$is_logged_in = is_user_logged_in();
?>

<div class="site-header-actions flex items-center gap-6 xl:gap-8 text-[#444444] font-sub">
    <!-- Help Action -->
    <a href="<?php echo esc_url($help_url); ?>" class="header-action-item flex items-center gap-2 hover:text-[#CC5600] transition-colors text-[14px] leading-none">
        <svg class="w-5 h-5 flex-shrink-0 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
        </svg>
        <span class="header-help-text hidden xl:inline"><?php esc_html_e('Help', 'dharmgyan'); ?></span>
    </a>

    <!-- Wishlist Action -->
    <a href="<?php echo esc_url($wishlist_url); ?>" class="header-action-item relative flex items-center gap-2 hover:text-[#CC5600] transition-colors text-[14px] leading-none" aria-label="<?php esc_attr_e('View Wishlist', 'dharmgyan'); ?>">
        <div class="relative flex items-center justify-center">
            <svg class="w-5 h-5 flex-shrink-0 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
            </svg>
            <?php if ($wishlist_count > 0): ?>
                <span class="header-badge-count absolute -top-2.5 -right-2.5 bg-[#CC5600] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                    <?php echo esc_html($wishlist_count); ?>
                </span>
            <?php endif; ?>
        </div>
        <span class="header-wishlist-text hidden xl:inline"><?php esc_html_e('Wishlist', 'dharmgyan'); ?></span>
    </a>

    <!-- Shopping Bag Action -->
    <div class="header-cart-content relative">
        <a href="<?php echo esc_url($cart_url); ?>" class="header-action-item header-cart-trigger flex items-center gap-2 hover:text-[#CC5600] transition-colors text-[14px] leading-none" aria-label="<?php esc_attr_e('View Shopping Bag', 'dharmgyan'); ?>">
            <div class="relative flex items-center justify-center">
                <svg class="w-5 h-5 flex-shrink-0 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <?php if ($cart_count > 0): ?>
                    <span class="mini-cart-count absolute -top-2.5 -right-2.5 bg-[#CC5600] text-white text-[10px] font-bold min-w-4 h-4 px-1 rounded-full flex items-center justify-center">
                        <?php echo esc_html($cart_count); ?>
                    </span>
                <?php endif; ?>
            </div>
            <span class="header-cart-text hidden xl:inline"><?php esc_html_e('Bag', 'dharmgyan'); ?></span>
        </a>

        <!-- Mini Cart Flyout -->
        <div class="header_shopping_cart woocommerce">
            <div class="widget_shopping_cart_content">
                <?php
                if (function_exists('woocommerce_mini_cart')) {
                    woocommerce_mini_cart();
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Login / Account Action -->
    <a href="<?php echo esc_url($account_url); ?>" class="header-action-item flex items-center gap-2 hover:text-[#CC5600] transition-colors text-[14px] leading-none">
        <svg class="w-5 h-5 flex-shrink-0 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        <span class="header-login-text hidden xl:inline">
            <?php echo $is_logged_in ? esc_html__('My Account', 'dharmgyan') : esc_html__('Login / Register', 'dharmgyan'); ?>
        </span>
    </a>
</div>
