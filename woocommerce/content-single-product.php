<?php
/**
 * The template for displaying product content in the single-product.php template
 * Pixel-Perfect Figma 1:3218 layout.
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

                <!-- Right: 769px Summary & Buy Box (Pixel-Perfect Figma 1:1) -->
                <div id="product-summary-wrapper" class="product-summary-column w-full lg:sticky lg:top-28 font-body">
                    
                    <!-- 1. Product Title -->
                    <h1 class="product_title text-[#212121] text-xl md:text-[22px] font-medium font-body leading-snug mb-1">
                        <?php echo esc_html(get_the_title()); ?>
                    </h1>

                    <!-- 2. Price Row with SAVE XX% Badge (Rendered cleanly exactly 1 time) -->
                    <div class="single-product-price-row flex items-baseline gap-2.5 my-1.5 font-body">
                        <?php if ($is_on_sale && $regular_price > $current_price): ?>
                            <span class="single-price text-[#CC5600] font-medium text-2xl md:text-[24px] font-body leading-none">
                                <?php echo wc_price($current_price); ?>
                            </span>
                            <span class="single-regular-price text-[#717171] font-normal text-sm md:text-[15px] line-through font-body leading-none">
                                <?php echo wc_price($regular_price); ?>
                            </span>
                            <span class="save-discount-badge bg-[#242424] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                <?php echo esc_html(sprintf(__('SAVE %d%%', 'dharmgyan'), $discount_pct)); ?>
                            </span>
                        <?php else: ?>
                            <span class="single-price text-[#CC5600] font-medium text-2xl md:text-[24px] font-body leading-none">
                                <?php echo wc_price($current_price); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- 3. Prepaid Offer Pill matching Figma -->
                    <div class="my-1.5">
                        <div class="inline-flex items-center gap-1.5 bg-[#EFEFEF] text-[#444444] text-xs px-2.5 py-1 rounded-[4px]">
                            <svg class="w-3.5 h-3.5 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                            <span class="font-medium"><?php esc_html_e('7% Extra Off On All Prepaid Orders', 'dharmgyan'); ?></span>
                        </div>
                    </div>

                    <!-- 4. Money Back Promise Alert Box (100% Money Back) -->
                    <div class="money-back-promise-box bg-[#F8FAFC] border border-[#E2E8F0] rounded-[6px] p-3 my-2.5 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-[#E2E8F0] text-[#1E293B] flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-[#1E293B] font-body leading-tight">100% Money Back Guarantee</h5>
                                <p class="text-[11px] text-[#64748B] font-body mt-0.5">Free replacement or full refund if damaged in transit.</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-[#CC5600] font-body">Assured</span>
                    </div>

                    <!-- 5. Free Divine Gift Box (Golden Ganesh Coin) -->
                    <div class="free-gift-offer-box bg-[#FFFDF9] border-y border-dashed border-[#CC5600]/40 py-2.5 px-3 my-2 flex items-center gap-2.5">
                        <span class="text-base select-none">🎁</span>
                        <p class="text-xs text-[#242424] font-body">
                            <strong class="text-[#CC5600]">FREE Gift:</strong> Holy Gangajal & Energized Rudraksha included with this order today!
                        </p>
                    </div>

                    <!-- 6. Stock Urgency Indicator -->
                    <div class="stock-urgency-wrap flex items-center gap-2 my-2 text-xs text-[#DC2626] font-medium font-body">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                        </span>
                        <span>Only 4 items left in stock – order soon.</span>
                    </div>

                    <!-- 7. Dynamic Variations & Standard Add to Cart Form -->
                    <div class="single-product-add-to-cart-wrapper my-3">
                        <?php
                        /**
                         * Hook: woocommerce_single_product_summary.
                         * @hooked woocommerce_template_single_add_to_cart - 30
                         */
                        woocommerce_template_single_add_to_cart();
                        ?>
                    </div>

                    <!-- 8. Pincode Delivery Checker Box -->
                    <div class="pincode-delivery-checker bg-[#FCFAF7] border border-[#EAE3DC] rounded-[6px] p-3 my-3">
                        <label for="delivery-pincode-input" class="block text-xs font-bold text-[#111111] mb-1.5 font-body">
                            Check estimated delivery date
                        </label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="text" 
                                id="delivery-pincode-input"
                                placeholder="Enter 6-digit Pincode" 
                                maxlength="6"
                                class="w-full h-9 bg-white border border-[#D1D5DB] rounded-[4px] px-3 text-xs text-[#242424] focus:outline-none focus:border-[#CC5600] font-body"
                            />
                            <button 
                                type="button" 
                                id="check-pincode-btn"
                                class="h-9 px-4 bg-[#242424] hover:bg-[#CC5600] text-white text-xs font-semibold rounded-[4px] transition-colors shrink-0 font-body cursor-pointer"
                            >
                                CHECK
                            </button>
                        </div>
                        <p id="pincode-result-msg" class="text-[11px] text-[#059669] font-medium font-body mt-1.5 hidden">
                            ✓ Delivery in 3-5 business days. COD Available.
                        </p>
                    </div>

                    <!-- 9. Buy In Pairs & Save More 10% Extra -->
                    <div class="buy-in-pairs-banner bg-[#FFF8F3] border border-[#F5D5BE] rounded-[6px] p-2.5 my-2 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs font-body text-[#111111]">
                            <span class="text-sm">⚡</span>
                            <span><strong>Buy 2 items:</strong> Get Extra 10% Off automatically at checkout!</span>
                        </div>
                    </div>

                    <!-- 10. 4 Trust Icons (Satisfaction, Free Delivery, 7 Days Return, COD) -->
                    <div class="trust-assurance-grid border border-[#E5E5E5] rounded-[6px] p-3.5 my-3 bg-[#FCFAF7]">
                        <div class="grid grid-cols-4 gap-2 text-center">
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

                    <!-- 12. Designed By XYZ (Made In India) + 7 Bullet Highlights -->
                    <div class="product-features-checklist my-3 pt-2">
                        <h4 class="font-body text-xs font-bold text-[#111111] mb-2.5">Designed By XYZ (Made In India)</h4>
                        <ul class="space-y-1.5 text-xs md:text-[13px] text-[#444444] font-body">
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Made with High Quality 3 MM acrylic sheet</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Unidirectional pixel perfect direct printing on Acrylic</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Acrylic Chemical treatment before printing</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Super HD print output 1200*2400 DPI</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Peel-off resistant, compatible with moist and humid environment</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                <span>Unidirectional mode</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-[#555555] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
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
