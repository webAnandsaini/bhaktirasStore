<?php
/**
 * Checkout Form Template - Pixel-Perfect Figma Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'dharmgyan')));
    return;
}
?>

<div class="checkout-page-wrapper bg-white min-h-screen overflow-x-clip w-full max-w-full">
    
    <!-- Full-Width Centered Breadcrumb Bar -->
    <div class="checkout-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Shopping Bag', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]"><?php esc_html_e('Checkout', 'dharmgyan'); ?></span>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 pb-16">
        <h1 class="sr-only"><?php esc_html_e('Checkout', 'dharmgyan'); ?></h1>
        
        <div class="checkout-before-form-wrapper mb-6 clear-both">
            <?php do_action('woocommerce_before_checkout_form', $checkout); ?>
        </div>

        <form name="checkout" method="post" class="checkout woocommerce-checkout clear-both block w-full" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 xl:gap-12 items-start">
                
                <!-- Left: Billing & Shipping Address (7 Cols) -->
                <div class="lg:col-span-7 w-full space-y-8 font-body">
                    
                    <?php if ($checkout->get_checkout_fields()): ?>
                        
                        <!-- Customer Details / Billing Fields -->
                        <div class="border border-[#EAE3DC] rounded-[6px] p-6 md:p-8 bg-white shadow-2xs">
                            <h2 class="font-body text-xl font-bold text-[#111111] pb-3 border-b border-[#EAE3DC] mb-6 flex items-center gap-2">
                                <span class="w-7 h-7 rounded-full bg-[#CC5600] text-white text-xs flex items-center justify-center font-bold">1</span>
                                <span><?php esc_html_e('Shipping & Delivery Address', 'dharmgyan'); ?></span>
                            </h2>

                            <?php do_action('woocommerce_checkout_billing'); ?>
                        </div>

                        <!-- Shipping Fields (if applicable) -->
                        <?php do_action('woocommerce_checkout_shipping'); ?>

                    <?php endif; ?>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                </div>

                <!-- Right: Sticky Order Review Card (5 Cols) -->
                <div class="lg:col-span-5 w-full sticky top-28 font-body">
                    <div class="border border-[#EAE3DC] rounded-[6px] p-6 md:p-8 bg-[#FCFAF7] shadow-xs">
                        
                        <h2 id="order_review_heading" class="font-body text-xl font-bold text-[#111111] pb-3 border-b border-[#EAE3DC] mb-6 flex items-center gap-2">
                            <span class="w-7 h-7 rounded-full bg-[#CC5600] text-white text-xs flex items-center justify-center font-bold">2</span>
                            <span><?php esc_html_e('Order Summary', 'dharmgyan'); ?></span>
                        </h2>

                        <?php do_action('woocommerce_checkout_before_order_review'); ?>

                        <div id="order_review" class="woocommerce-checkout-review-order">
                            <?php do_action('woocommerce_checkout_order_review'); ?>
                        </div>

                        <?php do_action('woocommerce_checkout_after_order_review'); ?>

                        <!-- Trust Strip -->
                        <div class="pt-5 mt-5 border-t border-[#EAE3DC] space-y-2 text-xs text-[#64748B]">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#CC5600] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span><?php esc_html_e('100% Money Back Promise on damaged items', 'dharmgyan'); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#CC5600] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                <span><?php esc_html_e('256-bit Encrypted SSL Secure Checkout', 'dharmgyan'); ?></span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </form>

        <?php do_action('woocommerce_after_checkout_form', $checkout); ?>

    </div>

</div>
