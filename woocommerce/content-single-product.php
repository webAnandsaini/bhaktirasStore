<?php
/**
 * The template for displaying product content in the single-product.php template
 * 100% Pixel-Perfect Figma 1:3218 layout.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

global $product;

if (post_password_required()) {
    echo get_the_password_form();
    return;
}

$product_id = get_the_ID();
$terms = wc_get_product_terms($product_id, 'product_cat', array('orderby' => 'parent', 'order' => 'DESC'));
$cat_name = !empty($terms) && !is_wp_error($terms) ? $terms[0]->name : __('Collections', 'dharmgyan');
$cat_link = !empty($terms) && !is_wp_error($terms) ? get_term_link($terms[0]) : home_url('/shop/');

// Price calculations
$is_on_sale = $product->is_on_sale();
$regular_price = (float) $product->get_regular_price();
$sale_price    = (float) $product->get_sale_price();
$current_price = (float) $product->get_price();

$discount_pct = 20;
if ($regular_price > 0 && $sale_price > 0 && $is_on_sale) {
    $discount_pct = round((($regular_price - $sale_price) / $regular_price) * 100);
}
?>
<div class="single-product-page-wrapper bg-white">

    <!-- Full-Width Centered Breadcrumb Bar matching Figma (1920x68px #FFF9F4) -->
    <div class="single-product-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-10">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <a href="<?php echo esc_url($cat_link); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php echo esc_html($cat_name); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]"><?php echo esc_html(get_the_title()); ?></span>
        </div>
    </div>

    <div class="max-w-[1580px] mx-auto px-4">

        <div id="product-<?php the_ID(); ?>" <?php wc_product_class('single-product-entry', $product); ?>>

            <!-- 2-Column Main Buy Section (Left: Gallery, Right: Summary/Buy Box) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 xl:gap-14 items-start mb-12 md:mb-16">

                <!-- Left: 769px Gallery Viewer (Sticky on Desktop) -->
                <div id="product-images-wrapper" class="product-image-column w-full lg:sticky lg:top-24 z-10">
                    <?php
                    /**
                     * Hook: woocommerce_before_single_product_summary.
                     * @hooked woocommerce_show_product_images - 20
                     */
                    do_action('woocommerce_before_single_product_summary');
                    ?>
                </div>

                <!-- Right: 769px Summary & Buy Box (100% Pixel-Perfect Figma 1:1) -->
                <div id="product-summary-wrapper" class="product-summary-column w-full font-body">

                    <!-- 1. Product Title -->
                    <h1 class="product_title text-[#212121] text-xl md:text-[24px] font-medium font-body leading-snug mb-2">
                        <?php echo esc_html(get_the_title()); ?>
                    </h1>

                    <!-- 2. Price Row with SAVE XX% Badge (Rendered cleanly exactly 1 time) -->
                    <div class="single-product-price-row flex items-baseline gap-2.5 my-1.5 font-body">
                        <?php if ($is_on_sale && $regular_price > $current_price): ?>
                            <span class="single-price text-[#CC5600] font-medium text-2xl md:text-[25px] font-body leading-none">
                                <?php echo wc_price($current_price); ?>
                            </span>
                            <span class="single-regular-price text-[#717171] font-normal text-sm md:text-[15px] line-through font-body leading-none">
                                <?php echo wc_price($regular_price); ?>
                            </span>
                            <span class="save-discount-badge bg-[#242424] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                <?php echo esc_html(sprintf(__('SAVE %d%%', 'dharmgyan'), $discount_pct)); ?>
                            </span>
                        <?php else: ?>
                            <span class="single-price text-[#CC5600] font-medium text-2xl md:text-[25px] font-body leading-none">
                                <?php echo wc_price($current_price); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- 3. Prepaid Offer Pill matching Figma -->
                    <div class="my-2">
                        <div class="inline-flex items-center gap-1.5 bg-[#EFEFEF] text-[#444444] text-xs px-2.5 py-1 rounded-[4px]">
                            <svg class="w-3.5 h-3.5 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                            <span class="font-medium"><?php esc_html_e('Get 7% Additional Discount on Prepaid order', 'dharmgyan'); ?></span>
                        </div>
                    </div>

                    <!-- 4. Razorpay Money Back Promise Card -->
                    <!-- <div class="money-back-promise-box border border-[#CBD5E1] rounded-[6px] p-3 bg-white my-3.5 shadow-2xs">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-[#1E1B4B] text-white flex items-center justify-center font-bold text-sm shrink-0">
                                    ₹
                                </div>
                                <div>
                                    <span class="block text-[11px] text-[#64748B] font-body leading-none">Razorpay</span>
                                    <h5 class="text-sm md:text-[15px] font-bold text-[#0F172A] font-body leading-tight mt-0.5">Money Back Promise</h5>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="bg-[#1E1B4B] text-white text-[10px] font-semibold px-2.5 py-1 rounded-[4px]">
                                    On Prepaid Orders
                                </span>
                                <span class="text-[#64748B] text-xs">›</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 mt-2 pt-2 border-t border-[#EDF2F7] text-xs text-[#4F46E5] font-medium font-body">
                            <svg class="w-4 h-4 text-[#4F46E5] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>Get 100% refund on non-delivery or defects</span>
                        </div>
                    </div> -->

                    <!-- 5. Dotted Top/Bottom Free Gift Box -->
                    <div class="free-gift-offer-box border-t border-b border-dotted border-[#CCCCCC] py-3 my-3">
                        <div class="flex items-center gap-3">
                            <div class="text-[#242424] shrink-0">
                                <svg class="w-6 h-6 text-[#CC5600]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V6a2 2 0 10-2 2h2zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-xs md:text-sm font-bold text-[#CC5600] font-body leading-tight">Get free Wire art worth ₹999</h5>
                                <p class="text-[11px] text-[#717171] font-body mt-0.5">on every prepaid purchase worth ₹3,999</p>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Stock Urgency Indicator -->
                    <div class="stock-urgency-wrap my-3.5">
                        <div class="text-xs md:text-[13px] text-[#444444] font-body mb-1.5">
                            <span>Hurry Up! Only 41 items left in stock!</span>
                        </div>
                        <div class="w-full h-[5px] bg-[#E3E3E3] rounded-full overflow-hidden">
                            <div class="h-full bg-[#111111] rounded-full" style="width: 25%;"></div>
                        </div>
                    </div>

                    <!-- 7. Buy Form with Variations, Quantity & Dual Buttons -->
                    <form class="cart single-product-cart-form my-4 space-y-3.5" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>

                        <!-- Size Row -->
                        <div class="flex items-center">
                            <span class="w-24 text-xs md:text-sm font-semibold text-[#111111] font-body shrink-0">Size</span>
                            <div class="flex items-center gap-2 flex-wrap">
                                <button type="button" class="variant-pill border-1.5 border-[#CC5600] text-[#CC5600] bg-white rounded-[8px] px-4 py-2 text-xs font-medium focus:outline-none cursor-pointer">18X12 Inches</button>
                                <button type="button" class="variant-pill border border-[#CCCCCC] text-[#717171] hover:border-[#CC5600] bg-white rounded-[8px] px-4 py-2 text-xs focus:outline-none transition-colors cursor-pointer">24X16 Inches</button>
                                <button type="button" class="variant-pill border border-[#CCCCCC] text-[#717171] hover:border-[#CC5600] bg-white rounded-[8px] px-4 py-2 text-xs focus:outline-none transition-colors cursor-pointer">30X20 Inches</button>
                            </div>
                        </div>

                        <!-- Thickness Row -->
                        <div class="flex items-center">
                            <span class="w-24 text-xs md:text-sm font-semibold text-[#111111] font-body shrink-0">Thickness</span>
                            <div class="flex items-center gap-2 flex-wrap">
                                <button type="button" class="variant-pill border-1.5 border-[#CC5600] text-[#CC5600] bg-white rounded-[8px] px-4 py-2 text-xs font-medium focus:outline-none cursor-pointer">3MM</button>
                            </div>
                        </div>

                        <!-- Quantity Row -->
                        <div class="flex items-center">
                            <span class="w-24 text-xs md:text-sm font-semibold text-[#111111] font-body shrink-0">Quantity:</span>
                            <div class="quantity border border-[#444444] rounded-[4px] h-[46px] w-[140px] flex items-center justify-between px-2 bg-white">
                                <button type="button" class="minus text-lg font-medium text-[#111111] hover:text-[#CC5600] w-8 h-full flex items-center justify-center select-none cursor-pointer">−</button>
                                <input type="number" id="quantity_input" class="qty w-10 text-center border-none text-sm font-medium text-[#111111] focus:outline-none p-0" step="1" min="1" max="999" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off" />
                                <button type="button" class="plus text-lg font-medium text-[#111111] hover:text-[#CC5600] w-8 h-full flex items-center justify-center select-none cursor-pointer">+</button>
                            </div>
                        </div>

                        <!-- Dual CTA Buttons (Side-by-Side in 1 row matching Figma 1:1) -->
                        <div class="grid grid-cols-2 gap-3.5 pt-1">
                            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt h-[50px] border-1.5 border-[#CC5600] text-[#CC5600] bg-white hover:bg-[#CC5600] hover:text-white rounded-[4px] font-medium text-sm md:text-base transition-colors flex items-center justify-center cursor-pointer shadow-none">
                                Add to cart
                            </button>
                            <button type="submit" name="dharmgyan_buy_now" value="1" class="buy_now_button button h-[50px] bg-[#CC5600] hover:bg-[#B34B00] text-white rounded-[4px] font-medium text-sm md:text-base transition-colors shadow-sm flex items-center justify-center cursor-pointer">
                                Buy it now
                            </button>
                        </div>

                    </form>

                    <!-- 8. EMI & Offers Card -->
                    <!-- <div class="emi-offers-card border border-[#CBD5E1] rounded-[6px] p-2.5 bg-white my-3 shadow-2xs">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div class="border border-[#CBD5E1] rounded-[4px] p-2.5 flex items-center justify-between">
                                <div>
                                    <span class="block text-xs font-bold text-[#1E293B]">EMI from ₹141/month</span>
                                    <span class="block text-[10px] text-[#64748B]">Snapmint & more</span>
                                </div>
                                <a href="#emi" class="text-xs text-[#2563EB] font-semibold hover:underline">View plans</a>
                            </div>
                            <div class="border border-[#CBD5E1] rounded-[4px] p-2.5 flex items-center justify-between">
                                <div>
                                    <span class="block text-xs font-bold text-[#1E293B]">Save up to ₹280</span>
                                    <span class="block text-[10px] text-[#64748B]">GPay & more</span>
                                </div>
                                <a href="#offers" class="text-xs text-[#2563EB] font-semibold hover:underline">View offers</a>
                            </div>
                        </div>
                        <div class="pt-1.5 mt-1.5 border-t border-[#F1F5F9] text-[10px] text-[#64748B] flex items-center justify-between">
                            <span>Secured by <strong class="text-[#0F172A]">Razorpay</strong></span>
                        </div>
                    </div> -->

                    <!-- 9. Gradient Banner ("ELEGANT HANDMADE WALLART") -->
                    <!-- <div class="elegant-wallart-banner bg-gradient-to-r from-[#EAFFEA] to-[#E2FBF5] border border-[#D1F2E8] rounded-[6px] p-3 flex items-center gap-3 my-3">
                        <div class="w-9 h-9 rounded-full bg-white text-[#242424] flex items-center justify-center shrink-0 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold uppercase tracking-wider text-[#111111] font-body leading-tight">ELEGANT HANDMADE WALLART</h5>
                            <p class="text-xs text-[#444444] font-body mt-0.5">Crafted with care, designed for timeless beauty.</p>
                        </div>
                    </div> -->

                    <!-- 10. Guarantee Safe Checkout -->
                    <div class="product-guarantee-box border border-[#E2E8F0] rounded-[6px] p-3.5 bg-white my-3.5">
                        <div class="relative flex py-2 items-center mb-2">
                            <div class="flex-grow border-t border-[#E5E5E5]"></div>
                            <span class="flex-shrink mx-3 text-[11px] font-bold text-[#111111] uppercase tracking-wider">GUARANTEE SAFE CHECKOUT</span>
                            <div class="flex-grow border-t border-[#E5E5E5]"></div>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                                    <span class="text-[9px] font-bold text-[#333333] uppercase leading-none">SATISFACTION<br/>100%</span>
                                </div>
                                <span class="text-[10px] font-semibold text-[#111111] uppercase">GUARANTEED</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                                    <span class="text-[9px] font-bold text-[#333333] uppercase leading-none">FREE<br/>SHIPPING</span>
                                </div>
                                <span class="text-[10px] font-semibold text-[#111111] uppercase">FREE DELIVERY</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                                    <span class="text-[9px] font-bold text-[#333333] uppercase leading-none">EASY<br/>RETURN</span>
                                </div>
                                <span class="text-[10px] font-semibold text-[#111111] uppercase">7 DAYS RETURN</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                                    <span class="text-[9px] font-bold text-[#333333] uppercase leading-none">CASH ON<br/>DELIVERY</span>
                                </div>
                                <span class="text-[10px] font-semibold text-[#111111] uppercase">COD AVAILABLE</span>
                            </div>
                        </div>
                    </div>

                    <!-- 11. Size Customisation Available Banner -->
                    <!-- <div class="size-customisation-banner bg-[#F1F5F9] border border-[#E2E8F0] rounded-[6px] p-3 flex items-center justify-between my-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded bg-white text-[#CC5600] flex items-center justify-center shrink-0 border border-[#CBD5E1]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-[#111111] font-body leading-tight">Size customisation available</h5>
                                <p class="text-[10px] text-[#64748B] font-body mt-0.5">To enquire for a custom size, please reach out to us.</p>
                            </div>
                        </div>
                        <div class="text-[#CC5600] font-bold text-xs md:text-sm font-body shrink-0">
                            (+91) 9999999999
                        </div>
                    </div> -->

                    <!-- 12. Designed By XYZ (Made In India) + 7 Bullet Highlights -->
                    <div class="product-features-checklist my-3.5 pt-2">
                        <h4 class="font-body text-xs md:text-sm font-bold text-[#111111] mb-2.5">Designed By XYZ (Made In India)</h4>
                        <ul class="space-y-2 text-xs md:text-[13px] text-[#444444] font-body">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Made with High Quality 3 MM acrylic sheet</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Unidirectional pixel perfect direct printing on Acrylic</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Acrylic Chemical treatment before printing</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Super HD print output 1200*2400 DPI</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Peel-off resistant, compatible with moist and humid environment</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Unidirectional mode</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Scratch Free & Unbreakable</span>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

        </div><!-- #product-<?php the_ID(); ?> -->

    </div>

    <!-- Tabbed Specifications & Policies Module (Section @ y=2409 in Figma) -->
    <div class="single-product-tabs-section max-w-[1580px] mx-auto px-4 my-12 md:my-16 border-t border-[#E5E5E5] pt-10">
        <?php
        /**
         * Hook: woocommerce_after_single_product_summary.
         * @hooked woocommerce_output_product_data_tabs - 10
         */
        woocommerce_output_product_data_tabs();
        ?>
    </div>

    <!-- Product Video Reels Section (Positioned Below Description/Tabs as requested) -->
    <?php get_template_part('template-parts/home/product-videos'); ?>

    <!-- Bottom Sections Matching Figma PDP 1:3218 -->
    <div class="single-product-bottom-sections border-t border-[#E5E5E5] bg-white">
        <!-- 1. Our Most Discount Sale (5 products row) -->
        <?php get_template_part('template-parts/home/discount-sale'); ?>

        <!-- 2. Trending Products (5 products row) -->
        <?php get_template_part('template-parts/home/trending-products'); ?>

        <!-- 3. Customer Testimonials & Reviews (5 review cards) -->
        <?php get_template_part('template-parts/home/testimonials'); ?>

        <!-- 4. 4 Circular Saffron Badges -->
        <?php get_template_part('template-parts/home/trust-badges'); ?>
    </div>
</div>
