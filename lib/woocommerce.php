<?php
/**
 * WooCommerce Customizations & Hooks
 * Pixel-Perfect Single Product Page & Catalog Support matching Figma 1:3218.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

add_filter('woocommerce_enqueue_styles', '__return_false');

/**
 * Remove default WooCommerce wrappers and default unwanted single product elements
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// Remove default WooCommerce sale flash badge on single product
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

// Remove default short description excerpt, rating, and meta to avoid messy duplicate layout
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

/**
 * 1. Enhanced Single Product Price Display with 'SAVE XX%' Badge
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
function dharmgyan_single_product_price_with_discount()
{
    global $product;
    if (!$product) {
        return;
    }

    $is_on_sale = $product->is_on_sale();
    $discount_pct = 20; // Default Figma percentage

    if ($product->is_type('variable')) {
        $min_regular = (float) $product->get_variation_regular_price('min', true);
        $min_sale    = (float) $product->get_variation_sale_price('min', true);
        if ($min_regular > 0 && $min_sale > 0 && $min_sale < $min_regular) {
            $discount_pct = round((($min_regular - $min_sale) / $min_regular) * 100);
        }
        ?>
        <div class="single-product-price-row flex items-baseline gap-3 my-1.5">
            <span class="single-price text-[#CC5600] font-medium text-2xl md:text-[25px] font-body leading-none">
                <?php echo wc_price($product->get_price()); ?>
            </span>
            <?php if ($is_on_sale && $min_regular > $min_sale): ?>
                <span class="single-regular-price text-[#717171] font-normal text-sm md:text-[15px] line-through font-body leading-none">
                    <?php echo wc_price($min_regular); ?>
                </span>
                <span class="save-discount-badge bg-[#242424] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    <?php echo esc_html(sprintf(__('SAVE %d%%', 'dharmgyan'), $discount_pct)); ?>
                </span>
            <?php else: ?>
                <span class="save-discount-badge bg-[#242424] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    SAVE 20%
                </span>
            <?php endif; ?>
        </div>
        <?php
    } else {
        $regular_price = (float) $product->get_regular_price();
        $sale_price    = (float) $product->get_sale_price();

        if ($regular_price > 0 && $sale_price > 0 && $is_on_sale) {
            $discount_pct = round((($regular_price - $sale_price) / $regular_price) * 100);
        }
        ?>
        <div class="single-product-price-row flex items-baseline gap-3 my-1.5">
            <span class="single-price text-[#CC5600] font-medium text-2xl md:text-[25px] font-body leading-none">
                <?php echo wc_price($product->get_price()); ?>
            </span>
            <?php if ($is_on_sale && $regular_price > $sale_price): ?>
                <span class="single-regular-price text-[#717171] font-normal text-sm md:text-[15px] line-through font-body leading-none">
                    <?php echo wc_price($regular_price); ?>
                </span>
                <span class="save-discount-badge bg-[#242424] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    <?php echo esc_html(sprintf(__('SAVE %d%%', 'dharmgyan'), $discount_pct)); ?>
                </span>
            <?php else: ?>
                <span class="save-discount-badge bg-[#242424] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    SAVE 20%
                </span>
            <?php endif; ?>
        </div>
        <?php
    }
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_price_with_discount', 10);

/**
 * 2. Single Product Prepaid Offer Pill (Right below price in Figma)
 */
function dharmgyan_single_product_prepaid_pill()
{
    ?>
    <div class="prepaid-offer-pill inline-flex items-center gap-1.5 bg-[#EFEFEF] text-[#444444] text-xs font-normal px-3 py-1 rounded-[4px] mb-3">
        <span class="font-normal"><?php esc_html_e('Get', 'dharmgyan'); ?> <strong class="text-[#CC5600] font-bold">7%</strong> <?php esc_html_e('Additional Discount on Prepaid order', 'dharmgyan'); ?></span>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_prepaid_pill', 12);

/**
 * 3. Razorpay Money Back Promise Card
 */
function dharmgyan_single_product_money_back_box()
{
    ?>
    <div class="money-back-promise-box border border-[#E2E8F0] bg-[#F8FAFC] rounded-[8px] p-3.5 my-3 shadow-2xs">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-[#1E1B4B] text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                    ₹
                </div>
                <div>
                    <span class="block text-xs text-[#64748B] font-body leading-none">Razorpay</span>
                    <h5 class="text-sm md:text-[15px] font-bold text-[#0F172A] font-body leading-tight mt-0.5"><?php esc_html_e('Money Back Promise', 'dharmgyan'); ?></h5>
                </div>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="bg-[#1E1B4B] text-white text-[10px] font-semibold px-2.5 py-1 rounded-[4px]">
                    <?php esc_html_e('On Prepaid Orders', 'dharmgyan'); ?>
                </span>
                <span class="text-[#64748B] text-xs">›</span>
            </div>
        </div>
        <div class="flex items-center gap-2 mt-2 pt-2 border-t border-[#EDF2F7] text-xs text-[#4F46E5] font-medium font-body">
            <svg class="w-4 h-4 text-[#4F46E5] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            <span><?php esc_html_e('Get 100% refund on non-delivery or defects', 'dharmgyan'); ?></span>
        </div>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_money_back_box', 14);

/**
 * 4. Dotted Divider Free Gift Offer Box
 */
function dharmgyan_single_product_gift_box()
{
    ?>
    <div class="free-gift-offer-box border-t border-b border-dotted border-[#CCCCCC] py-3 my-3">
        <div class="flex items-center gap-3">
            <div class="text-[#242424] shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V6a2 2 0 10-2 2h2zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
            </div>
            <div>
                <h5 class="text-xs md:text-sm font-bold text-[#CC5600] font-body leading-tight"><?php esc_html_e('Get free Wire art worth ₹999', 'dharmgyan'); ?></h5>
                <p class="text-[11px] text-[#717171] font-body mt-0.5"><?php esc_html_e('on every prepaid purchase worth ₹3,999', 'dharmgyan'); ?></p>
            </div>
        </div>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_gift_box', 16);

/**
 * 5. Stock Urgency Progress Indicator
 */
function dharmgyan_single_product_stock_urgency()
{
    global $product;
    if (!$product) {
        return;
    }

    $stock_qty = $product->get_stock_quantity();
    $stock_text = ($stock_qty && $stock_qty > 0) ? $stock_qty : 41;
    ?>
    <div class="stock-urgency-wrap my-3">
        <div class="text-xs md:text-[13px] text-[#444444] font-body mb-1.5">
            <span><?php echo esc_html(sprintf(__('Hurry Up! Only %d items left in stock!', 'dharmgyan'), $stock_text)); ?></span>
        </div>
        <div class="w-full h-[5px] bg-[#E3E3E3] rounded-full overflow-hidden">
            <div class="h-full bg-[#111111] rounded-full" style="width: 25%;"></div>
        </div>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_stock_urgency', 18);

/**
 * Custom Variation Swatch Pill Row Mockup if simple product, or style standard form
 */
function dharmgyan_single_product_variations_custom()
{
    global $product;
    if (!$product) return;

    // Output clean variation pills mockup if standard single product
    if (!$product->is_type('variable')) {
        ?>
        <div class="product-custom-variations space-y-3 my-3">
            <div class="flex items-center">
                <span class="w-[85px] text-xs md:text-sm font-bold text-[#111111] font-body shrink-0"><?php esc_html_e('Size', 'dharmgyan'); ?></span>
                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" class="variant-pill border-1.5 border-[#CC5600] text-[#CC5600] bg-white rounded-[8px] px-3.5 py-1.5 text-xs font-medium focus:outline-none">18X12 Inches</button>
                    <button type="button" class="variant-pill border border-[#CCCCCC] text-[#717171] hover:border-[#CC5600] bg-white rounded-[8px] px-3.5 py-1.5 text-xs focus:outline-none transition-colors">24X16 Inches</button>
                    <button type="button" class="variant-pill border border-[#CCCCCC] text-[#717171] hover:border-[#CC5600] bg-white rounded-[8px] px-3.5 py-1.5 text-xs focus:outline-none transition-colors">30X20 Inches</button>
                </div>
            </div>
            <div class="flex items-center">
                <span class="w-[85px] text-xs md:text-sm font-bold text-[#111111] font-body shrink-0"><?php esc_html_e('Thickness', 'dharmgyan'); ?></span>
                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" class="variant-pill border-1.5 border-[#CC5600] text-[#CC5600] bg-white rounded-[8px] px-3.5 py-1.5 text-xs font-medium focus:outline-none">3MM</button>
                </div>
            </div>
        </div>
        <?php
    }
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_variations_custom', 25);

/**
 * 6. Direct "Buy It Now" Checkout Button Hook inside Add to Cart Form
 */
function dharmgyan_add_buy_now_button()
{
    ?>
    <button type="submit" name="dharmgyan_buy_now" value="1" class="button buy_now_button flex-1 bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-sm md:text-base h-[50px] rounded-[4px] transition-colors shadow-sm inline-flex items-center justify-center gap-2">
        <span><?php esc_html_e('Buy it now', 'dharmgyan'); ?></span>
    </button>
    <?php
}
add_action('woocommerce_after_add_to_cart_button', 'dharmgyan_add_buy_now_button', 10);

/**
 * Handle Direct Checkout on "Buy It Now" submission
 */
function dharmgyan_handle_buy_now_redirect($url)
{
    if (isset($_REQUEST['dharmgyan_buy_now']) && $_REQUEST['dharmgyan_buy_now'] === '1') {
        return wc_get_checkout_url();
    }
    return $url;
}
add_filter('woocommerce_add_to_cart_redirect', 'dharmgyan_handle_buy_now_redirect');

/**
 * 7. EMI & Offers Card (Razorpay)
 */
function dharmgyan_single_product_emi_box()
{
    ?>
    <div class="emi-offers-card border border-[#CBD5E1] rounded-[6px] p-2.5 bg-white my-3 shadow-2xs">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div class="border border-[#CBD5E1] rounded-[4px] p-2.5 flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-[#1E293B]"><?php esc_html_e('EMI from ₹141/month', 'dharmgyan'); ?></span>
                    <span class="block text-[10px] text-[#64748B]"><?php esc_html_e('Snapmint & more', 'dharmgyan'); ?></span>
                </div>
                <a href="#emi" class="text-xs text-[#2563EB] font-semibold hover:underline"><?php esc_html_e('View plans', 'dharmgyan'); ?></a>
            </div>
            <div class="border border-[#CBD5E1] rounded-[4px] p-2.5 flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-[#1E293B]"><?php esc_html_e('Save up to ₹280', 'dharmgyan'); ?></span>
                    <span class="block text-[10px] text-[#64748B]"><?php esc_html_e('GPay & more', 'dharmgyan'); ?></span>
                </div>
                <a href="#offers" class="text-xs text-[#2563EB] font-semibold hover:underline"><?php esc_html_e('View offers', 'dharmgyan'); ?></a>
            </div>
        </div>
        <div class="pt-1.5 mt-1.5 border-t border-[#F1F5F9] text-[10px] text-[#64748B]">
            <span><?php esc_html_e('Secured by', 'dharmgyan'); ?> <strong>Razorpay</strong></span>
        </div>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_emi_box', 31);

/**
 * 8. Gradient Banner ("ELEGANT HANDMADE WALLART")
 */
function dharmgyan_single_product_gradient_banner()
{
    ?>
    <div class="elegant-wallart-banner bg-gradient-to-r from-[#EAFFEA] to-[#E2FBF5] border border-[#D1F2E8] rounded-[6px] p-3 flex items-center gap-3 my-3">
        <div class="w-9 h-9 rounded-full bg-white text-[#242424] flex items-center justify-center shrink-0 shadow-xs">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
        </div>
        <div>
            <h5 class="text-xs font-bold uppercase tracking-wider text-[#111111] font-body leading-tight"><?php esc_html_e('ELEGANT HANDMADE WALLART', 'dharmgyan'); ?></h5>
            <p class="text-xs text-[#444444] font-body mt-0.5"><?php esc_html_e('Crafted with care, designed for timeless beauty.', 'dharmgyan'); ?></p>
        </div>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_gradient_banner', 33);

/**
 * 9. Reassurance & Safe Checkout Box matching Figma 4 Circular Badges
 */
function dharmgyan_single_product_safe_checkout_box()
{
    ?>
    <div class="product-guarantee-box border border-[#E2E8F0] rounded-[6px] p-3.5 bg-white my-3.5" aria-label="<?php esc_attr_e('Guarantee safe checkout', 'dharmgyan'); ?>">
        <div class="relative flex py-2 items-center mb-2">
            <div class="flex-grow border-t border-[#E5E5E5]"></div>
            <span class="flex-shrink mx-3 text-[11px] font-bold text-[#111111] uppercase tracking-wider"><?php esc_html_e('GUARANTEE SAFE CHECKOUT', 'dharmgyan'); ?></span>
            <div class="flex-grow border-t border-[#E5E5E5]"></div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-center">
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                    <span class="text-[9px] font-bold text-[#333333] uppercase leading-none">SATISFACTION<br/>100%</span>
                </div>
                <span class="text-[10px] font-semibold text-[#111111] uppercase"><?php esc_html_e('GUARANTEED', 'dharmgyan'); ?></span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                    <span class="text-[9px] font-bold text-[#333333] uppercase leading-none">FREE<br/>SHIPPING</span>
                </div>
                <span class="text-[10px] font-semibold text-[#111111] uppercase"><?php esc_html_e('FREE DELIVERY', 'dharmgyan'); ?></span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                    <span class="text-[9px] font-bold text-[#333333] uppercase leading-none">EASY<br/>RETURN</span>
                </div>
                <span class="text-[10px] font-semibold text-[#111111] uppercase"><?php esc_html_e('7 DAYS RETURN', 'dharmgyan'); ?></span>
            </div>
            <div class="flex flex-col items-center">
                <div class="w-12 h-12 rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                    <span class="text-[9px] font-bold text-[#333333] uppercase leading-none">CASH ON<br/>DELIVERY</span>
                </div>
                <span class="text-[10px] font-semibold text-[#111111] uppercase"><?php esc_html_e('COD AVAILABLE', 'dharmgyan'); ?></span>
            </div>
        </div>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_safe_checkout_box', 35);

/**
 * 10. Size Customisation Available Strip
 */
function dharmgyan_single_product_custom_size_banner()
{
    ?>
    <div class="size-customisation-banner bg-[#F1F5F9] border border-[#E2E8F0] rounded-[6px] p-3 flex items-center justify-between my-3">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded bg-white text-[#CC5600] flex items-center justify-center shrink-0 border border-[#CBD5E1]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
            </div>
            <div>
                <h5 class="text-xs font-bold text-[#111111] font-body leading-tight"><?php esc_html_e('Size customisation available', 'dharmgyan'); ?></h5>
                <p class="text-[10px] text-[#64748B] font-body mt-0.5"><?php esc_html_e('To enquire for a custom size, please reach out to us.', 'dharmgyan'); ?></p>
            </div>
        </div>
        <div class="text-[#CC5600] font-bold text-xs md:text-sm font-body shrink-0">
            (+91) 9999999999
        </div>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_custom_size_banner', 37);

/**
 * 11. Designed By XYZ (Made In India) + 7 Bullet Features
 */
function dharmgyan_single_product_bullet_features()
{
    ?>
    <div class="product-features-checklist my-3 pt-2">
        <h4 class="font-body text-xs font-bold text-[#111111] mb-2.5"><?php esc_html_e('Designed By XYZ (Made In India)', 'dharmgyan'); ?></h4>
        <ul class="space-y-1.5 text-xs md:text-[13px] text-[#444444] font-body">
            <li class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                <span><?php esc_html_e('Made with High Quality 3 MM acrylic sheet', 'dharmgyan'); ?></span>
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                <span><?php esc_html_e('Unidirectional pixel perfect direct printing on Acrylic', 'dharmgyan'); ?></span>
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                <span><?php esc_html_e('Acrylic Chemical treatment before printing', 'dharmgyan'); ?></span>
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                <span><?php esc_html_e('Super HD print output 1200*2400 DPI', 'dharmgyan'); ?></span>
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                <span><?php esc_html_e('Peel-off resistant, compatible with moist and humid environment', 'dharmgyan'); ?></span>
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                <span><?php esc_html_e('Unidirectional mode', 'dharmgyan'); ?></span>
            </li>
            <li class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                <span><?php esc_html_e('Scratch Free & Unbreakable', 'dharmgyan'); ?></span>
            </li>
        </ul>
    </div>
    <?php
}
add_action('woocommerce_single_product_summary', 'dharmgyan_single_product_bullet_features', 39);

/**
 * Custom WooCommerce Tabs matching Figma
 */
function dharmgyan_custom_product_tabs($tabs)
{
    // 1. Description tab
    if (isset($tabs['description'])) {
        $tabs['description']['title'] = __('Product Description', 'dharmgyan');
        $tabs['description']['priority'] = 10;
        $tabs['description']['callback'] = 'dharmgyan_tab_description_content';
    }

    // 2. Shipping & Delivery Policy tab
    $tabs['shipping_policy'] = array(
        'title'    => __('Shipping & Delivery Policy', 'dharmgyan'),
        'priority' => 20,
        'callback' => 'dharmgyan_tab_shipping_policy_content',
    );

    // 3. Returns & Exchange Policy tab
    $tabs['returns_policy'] = array(
        'title'    => __('Returns & Exchange Policy', 'dharmgyan'),
        'priority' => 30,
        'callback' => 'dharmgyan_tab_returns_policy_content',
    );

    // 4. Product-Specific FAQs tab
    $tabs['product_faqs'] = array(
        'title'    => __('FAQs', 'dharmgyan'),
        'priority' => 40,
        'callback' => 'dharmgyan_tab_faqs_content',
    );

    // 5. Customer Reviews tab
    if (isset($tabs['reviews'])) {
        $tabs['reviews']['title'] = __('Reviews', 'dharmgyan');
        $tabs['reviews']['priority'] = 50;
    }

    return $tabs;
}

/**
 * Tab Content: Product-Specific FAQs (Custom per product via ACF)
 */
function dharmgyan_tab_faqs_content()
{
    global $product;
    $product_id = $product ? $product->get_id() : get_the_ID();
    $faqs = dharmgyan_get_field('product_faqs', $product_id);

    // If no custom FAQs set on this specific product, provide standard devotional FAQs
    if (empty($faqs) || !is_array($faqs)) {
        $faqs = array(
            array(
                'question' => __('Is this sacred idol/item authentic and energized?', 'dharmgyan'),
                'answer'   => __('Yes, all our sacred murtis, spiritual art, and temple items are handcrafted with devotion by experienced traditional artisans using pure materials and undergo auspicious Vedic quality checks before safe dispatch.', 'dharmgyan'),
            ),
            array(
                'question' => __('How should I clean and care for this product?', 'dharmgyan'),
                'answer'   => __('For brass and marble idols, gently wipe with a dry soft microfiber cloth or soft brush to remove dust. Avoid harsh chemical detergents or abrasive scrubbers to preserve the consecrated luster.', 'dharmgyan'),
            ),
            array(
                'question' => __('Is Cash on Delivery (COD) available for my order?', 'dharmgyan'),
                'answer'   => __('Yes, Cash on Delivery is available across most pincodes in India. We also offer an instant extra 7% discount on all Prepaid orders.', 'dharmgyan'),
            ),
            array(
                'question' => __('What if the product gets damaged during transit?', 'dharmgyan'),
                'answer'   => __('We pack all devotional items in reinforced multi-layer protective packaging. In the rare event of transit damage, simply contact our support within 7 days for a 100% hassle-free replacement or refund.', 'dharmgyan'),
            ),
        );
    }
    ?>
    <div class="faq-accordion-container max-w-4xl mx-auto space-y-3 font-body">
        <?php foreach ($faqs as $index => $faq): ?>
            <?php
            $q = !empty($faq['question']) ? $faq['question'] : '';
            $a = !empty($faq['answer']) ? $faq['answer'] : '';
            if (empty($q)) continue;
            ?>
            <details class="faq-accordion-item group border border-[#EAE3DC] rounded-[6px] bg-[#FCFAF7] overflow-hidden transition-all duration-200 open:bg-white open:border-[#CC5600] open:shadow-xs" <?php echo $index === 0 ? 'open' : ''; ?>>
                <summary class="flex items-center justify-between p-4 cursor-pointer list-none select-none font-medium text-[#242424] group-hover:text-[#CC5600] transition-colors">
                    <span class="text-sm md:text-[15px] font-semibold flex items-center gap-2.5 pr-3">
                        <span class="w-6 h-6 rounded-full bg-[#FFF1E5] text-[#CC5600] text-xs font-bold flex items-center justify-center shrink-0">Q</span>
                        <?php echo esc_html($q); ?>
                    </span>
                    <span class="w-7 h-7 rounded-full bg-white border border-[#EAE3DC] flex items-center justify-center shrink-0 text-[#717171] group-open:rotate-180 group-open:text-[#CC5600] group-open:border-[#CC5600] transition-transform duration-300">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </span>
                </summary>
                <div class="px-5 pb-4 pt-1 text-xs md:text-sm text-[#555555] leading-relaxed border-t border-[#F0EAE4]/60">
                    <?php echo wp_kses_post(wpautop($a)); ?>
                </div>
            </details>
        <?php endforeach; ?>
    </div>
    <?php
}
add_filter('woocommerce_product_tabs', 'dharmgyan_custom_product_tabs', 98);

/**
 * Tab Content: Rich Product Description matching Figma
 */
function dharmgyan_tab_description_content()
{
    global $post;
    $content = get_the_content();
    ?>
    <div class="prose max-w-none text-[#444444] font-body text-[15px] leading-relaxed space-y-4">
        <?php if (!empty($content)): ?>
            <?php echo wp_kses_post(wpautop($content)); ?>
        <?php else: ?>
            <p><?php esc_html_e('The Acrylic Wall Art collection by The Next Decor is a lavish display of exuberance. These wall art display extravagant designs and are meticulously detailed. This acrylic wall art is a striking addition to any wall. It features bold colors and rich hues.', 'dharmgyan'); ?></p>
            <p><strong><?php esc_html_e('It is also available in many sizes.', 'dharmgyan'); ?></strong> <?php esc_html_e('Explore the complete collection online and search for prices, discounts, sensibilities, and other details. This can transform plain or white walls into something that is worthy of interior design magazines.', 'dharmgyan'); ?></p>
        <?php endif; ?>

        <h4 class="text-base font-bold text-[#444444] mt-6 mb-2"><?php esc_html_e('About Quality', 'dharmgyan'); ?></h4>
        <p><?php esc_html_e('All the products are designed by The Next Décor. We always check product quality carefully like colors, Bending, and Perfect Fit. We follow strict protocols and only deliver products that pass through our 3 quality checks before packing & shipping.', 'dharmgyan'); ?></p>

        <h4 class="text-base font-bold text-[#444444] mt-6 mb-2"><?php esc_html_e('Sizes Available', 'dharmgyan'); ?></h4>
        <p><?php esc_html_e('We have 3 different sizes for acrylic wall art below:', 'dharmgyan'); ?></p>
        <ul class="size-pills flex flex-wrap gap-2.5 my-2">
            <li class="border border-[#666666] text-[#666666] text-xs font-medium px-3.5 py-1.5 rounded-[5px] bg-white">43X29 CM or 17 X 11.5 Inch - Height x Width</li>
            <li class="border border-[#666666] text-[#666666] text-xs font-medium px-3.5 py-1.5 rounded-[5px] bg-white">59X40 CM or 23.5 X 16 Inch - Height x Width</li>
            <li class="border border-[#666666] text-[#666666] text-xs font-medium px-3.5 py-1.5 rounded-[5px] bg-white">75X50 CM or 29.5 X 20 Inch - Height x Width</li>
        </ul>

        <h4 class="text-base font-bold text-[#444444] mt-6 mb-2"><?php esc_html_e('Thickness Available', 'dharmgyan'); ?></h4>
        <ul class="size-pills flex flex-wrap gap-2.5 my-2">
            <li class="border border-[#666666] text-[#666666] text-xs font-medium px-3.5 py-1.5 rounded-[5px] bg-white">3 MM</li>
        </ul>

        <h4 class="text-base font-bold text-[#444444] mt-6 mb-2"><?php esc_html_e('How to Hang', 'dharmgyan'); ?></h4>
        <p><?php esc_html_e('Our acrylic wall art is easy to hang. The ready-to-mount adhesive is included on the corners of your ordered wall art. You can simply remove the protective sheet and mount it to your wall or use stud mounts.', 'dharmgyan'); ?></p>

        <h4 class="text-base font-bold text-[#444444] mt-6 mb-2"><?php esc_html_e('How to Care', 'dharmgyan'); ?></h4>
        <p><?php esc_html_e('Brush away dust particles with a soft brush. Wipe gently with a soft micro-fiber cloth.', 'dharmgyan'); ?></p>

        <h4 class="text-base font-bold text-[#444444] mt-6 mb-2"><?php esc_html_e('Delivery Time', 'dharmgyan'); ?></h4>
        <p><?php esc_html_e('Delivered in 5–6 business days after order confirmation.', 'dharmgyan'); ?></p>
    </div>
    <?php
}

/**
 * Tab Content: Shipping & Delivery Policy
 */
function dharmgyan_tab_shipping_policy_content()
{
    ?>
    <div class="prose max-w-none text-[#444444] font-body text-[15px] leading-relaxed space-y-4">
        <h4 class="font-serif text-xl text-[#111111] font-medium"><?php esc_html_e('Shipping & Safe Delivery', 'dharmgyan'); ?></h4>
        <p><?php esc_html_e('All orders are carefully packed in multi-layer protective packaging with tamper-proof seal to ensure your sacred items reach you safely and auspiciously.', 'dharmgyan'); ?></p>
        <ul class="list-disc pl-5 space-y-2">
            <li><strong><?php esc_html_e('Standard Delivery:', 'dharmgyan'); ?></strong> <?php esc_html_e('Delivered in 4–7 business days across India.', 'dharmgyan'); ?></li>
            <li><strong><?php esc_html_e('Express Dispatch:', 'dharmgyan'); ?></strong> <?php esc_html_e('Dispatched within 24 hours of order confirmation.', 'dharmgyan'); ?></li>
            <li><strong><?php esc_html_e('Tracking Details:', 'dharmgyan'); ?></strong> <?php esc_html_e('Real-time tracking link sent via SMS and Email once dispatched.', 'dharmgyan'); ?></li>
        </ul>
    </div>
    <?php
}

/**
 * Tab Content: Returns & Exchange Policy
 */
function dharmgyan_tab_returns_policy_content()
{
    ?>
    <div class="prose max-w-none text-[#444444] font-body text-[15px] leading-relaxed space-y-4">
        <h4 class="font-serif text-xl text-[#111111] font-medium"><?php esc_html_e('Hassle-Free Returns & Exchange', 'dharmgyan'); ?></h4>
        <p><?php esc_html_e('We take immense pride in the craftsmanship of our sacred items. If you receive a damaged or defective product, we offer a 100% replacement or refund.', 'dharmgyan'); ?></p>
        <ul class="list-disc pl-5 space-y-2">
            <li><strong><?php esc_html_e('7-Day Replacement Window:', 'dharmgyan'); ?></strong> <?php esc_html_e('Report any defect within 7 days of delivery with an unboxing video.', 'dharmgyan'); ?></li>
            <li><strong><?php esc_html_e('100% Refund Assurance:', 'dharmgyan'); ?></strong> <?php esc_html_e('Instant refund processed upon return pickup verification.', 'dharmgyan'); ?></li>
            <li><strong><?php esc_html_e('Customer Support:', 'dharmgyan'); ?></strong> <?php esc_html_e('Contact our dedicated care team at support@bhaktirastore.com or WhatsApp.', 'dharmgyan'); ?></li>
        </ul>
    </div>
    <?php
}

/**
 * Quantity Buttons
 */
if (!function_exists('dharmgyan_quantity_button_plus')) :
    function dharmgyan_quantity_button_plus()
    { ?>
        <button type="button" class="plus text-lg font-medium text-[#111111] hover:text-[#CC5600] w-9 h-full flex items-center justify-center transition-colors select-none focus:outline-none" aria-label="<?php esc_attr_e('Increase quantity', 'dharmgyan'); ?>">+</button>
    <?php }
endif;

if (!function_exists('dharmgyan_quantity_button_minus')) :
    function dharmgyan_quantity_button_minus()
    { ?>
        <button type="button" class="minus text-lg font-medium text-[#111111] hover:text-[#CC5600] w-9 h-full flex items-center justify-center transition-colors select-none focus:outline-none" aria-label="<?php esc_attr_e('Decrease quantity', 'dharmgyan'); ?>">−</button>
    <?php }
endif;

add_action('woocommerce_before_quantity_input_field', 'dharmgyan_quantity_button_minus', 10);
add_action('woocommerce_after_quantity_input_field', 'dharmgyan_quantity_button_plus', 10);

/**
 * Keep the related-products row concise and balanced.
 */
function dharmgyan_related_products_args($args)
{
    $args['posts_per_page'] = 5;
    $args['columns']        = 5;
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'dharmgyan_related_products_args');

/**
 * Set Products per page limit to 24 on Shop Archive / PLP
 */
add_filter('loop_shop_per_page', function($cols) {
    return 24;
}, 20);
