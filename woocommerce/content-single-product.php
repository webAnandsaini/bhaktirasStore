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

// Price & Product Type calculations
$is_variable           = $product->is_type('variable');
$initial_display_price = 0;
$initial_regular_price = 0;
$initial_is_on_sale    = false;
$discount_pct          = 0;

if ($is_variable) {
    $default_attrs = $product->get_default_attributes();
    $var_id = 0;
    if (!empty($default_attrs)) {
        $data_store = WC_Data_Store::load('product');
        $var_id = $data_store->find_matching_product_variation($product, $default_attrs);
    }
    if (!$var_id) {
        $children = $product->get_children();
        if (!empty($children)) {
            $var_id = $children[0];
        }
    }
    if ($var_id) {
        $matched_var = wc_get_product($var_id);
        if ($matched_var) {
            $initial_display_price = (float) $matched_var->get_price();
            $initial_regular_price = (float) $matched_var->get_regular_price();
            $initial_is_on_sale    = $matched_var->is_on_sale();
            if ($initial_regular_price > 0 && $initial_is_on_sale && $initial_regular_price > $initial_display_price) {
                $discount_pct = round((($initial_regular_price - $initial_display_price) / $initial_regular_price) * 100);
            }
        }
    }
} else {
    $initial_display_price = (float) $product->get_price();
    $initial_regular_price = (float) $product->get_regular_price();
    $initial_is_on_sale    = $product->is_on_sale();
    if ($initial_regular_price > 0 && $initial_is_on_sale && $initial_regular_price > $initial_display_price) {
        $discount_pct = round((($initial_regular_price - $initial_display_price) / $initial_regular_price) * 100);
    }
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

                    <!-- 2. Price Row with SAVE XX% Badge (Always shows clean final price & updates dynamically) -->
                    <div id="single-product-price-row" class="single-product-price-row flex items-baseline flex-wrap gap-2.5 my-1.5 font-body" data-default-html="">
                        <span class="single-price text-[#CC5600] font-medium text-2xl md:text-[25px] font-body leading-none">
                            <?php echo wc_price($initial_display_price); ?>
                        </span>
                        <?php if ($initial_is_on_sale && $initial_regular_price > $initial_display_price): ?>
                            <span class="single-regular-price text-[#717171] font-normal text-sm md:text-[15px] line-through font-body leading-none">
                                <?php echo wc_price($initial_regular_price); ?>
                            </span>
                            <span class="save-discount-badge bg-[#242424] text-white text-[11px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                <?php echo esc_html(sprintf(__('SAVE %d%%', 'dharmgyan'), $discount_pct)); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- 3. Prepaid Offer Pill (Dynamic from Theme Settings) -->
                    <?php
                    $enable_prepaid = dharmgyan_get_field('enable_prepaid_discount', 'option');
                    if ($enable_prepaid !== false && $enable_prepaid !== '0'):
                        $prepaid_text = dharmgyan_get_field('prepaid_discount_text', 'option') ?: __('Get 7% Additional Discount on Prepaid order', 'dharmgyan');
                    ?>
                        <div class="my-2">
                            <div class="inline-flex items-center gap-1.5 bg-[#EFEFEF] text-[#444444] text-xs px-2.5 py-1 rounded-[4px]">
                                <svg class="w-3.5 h-3.5 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                <span class="font-medium"><?php echo esc_html($prepaid_text); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>


                    <!-- 5. Dotted Top/Bottom Free Gift Box (Dynamic from Theme Settings) -->
                    <?php
                    $enable_gift = dharmgyan_get_field('enable_free_gift_offer', 'option');
                    if ($enable_gift !== false && $enable_gift !== '0'):
                        $gift_title = dharmgyan_get_field('free_gift_title', 'option') ?: __('Get free Wire art worth ₹999', 'dharmgyan');
                        $gift_sub   = dharmgyan_get_field('free_gift_subtitle', 'option') ?: __('on every prepaid purchase worth ₹3,999', 'dharmgyan');
                    ?>
                        <div class="free-gift-offer-box border-t border-b border-dotted border-[#CCCCCC] py-3 my-3">
                            <div class="flex items-center gap-3">
                                <div class="text-[#242424] shrink-0">
                                    <svg class="w-6 h-6 text-[#CC5600]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V6a2 2 0 10-2 2h2zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm font-bold text-[#CC5600] font-body leading-tight"><?php echo esc_html($gift_title); ?></p>
                                    <p class="text-[11px] text-[#717171] font-body mt-0.5"><?php echo esc_html($gift_sub); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 6. Stock Urgency Indicator (Updated Figma Pill Design 1:1) -->
                    <?php
                    $stock_qty = $product->get_stock_quantity();
                    if ($stock_qty && $stock_qty > 0) {
                        $stock_count = $stock_qty;
                        $bar_pct     = min(100, max(15, round(($stock_qty / 30) * 100)));
                    } else {
                        $stock_count = 41;
                        $bar_pct     = 68;
                    }
                    ?>
                    <div class="stock-urgency-wrap my-3.5">
                        <div class="stock-urgency-card relative flex items-center justify-between gap-3 sm:gap-4 px-3.5 sm:px-5 py-2 sm:py-2.5 bg-gradient-to-b from-[#FFFDF9] to-[#FFF8F1] border border-[#F6C692] rounded-full shadow-[0_2px_8px_rgba(246,198,146,0.15)] overflow-visible">

                            <!-- 1. Alarm Clock Icon with Ringing Rays -->
                            <div class="stock-alarm-icon shrink-0 text-[#E03E1A] flex items-center justify-center" aria-hidden="true">
                                <svg class="w-8 h-8 sm:w-9 sm:h-9" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Soft circular glow behind clock -->
                                    <circle cx="20" cy="22" r="14" fill="#FDF3E7" />
                                    <!-- Left ringing rays -->
                                    <path d="M4 16L7.5 17.5" stroke="#E03E1A" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M4 25L7.5 23.5" stroke="#E03E1A" stroke-width="2" stroke-linecap="round"/>
                                    <!-- Right ringing rays -->
                                    <path d="M36 16L32.5 17.5" stroke="#E03E1A" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M36 25L32.5 23.5" stroke="#E03E1A" stroke-width="2" stroke-linecap="round"/>
                                    <!-- Bells & stems -->
                                    <path d="M11 9C9.8 9 8.8 10 8.8 11.2C8.8 12.1 9.3 12.8 10 13.2C10.8 12.1 11.8 11.1 13 10.4C12.7 9.6 11.9 9 11 9Z" fill="#E03E1A"/>
                                    <path d="M29 9C28.1 9 27.3 9.6 27 10.4C28.2 11.1 29.2 12.1 30 13.2C30.7 12.8 31.2 12.1 31.2 11.2C31.2 10 30.2 9 29 9Z" fill="#E03E1A"/>
                                    <path d="M12 8L13.8 10.2" stroke="#E03E1A" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M28 8L26.2 10.2" stroke="#E03E1A" stroke-width="2" stroke-linecap="round"/>
                                    <!-- Top hammer -->
                                    <path d="M18.5 7.5H21.5" stroke="#E03E1A" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M20 7.5V9.5" stroke="#E03E1A" stroke-width="2" stroke-linecap="round"/>
                                    <!-- Clock Face Dial -->
                                    <circle cx="20" cy="22" r="11" fill="#FFFFFF" stroke="#E03E1A" stroke-width="2.2"/>
                                    <!-- Clock Hands -->
                                    <path d="M20 16.5V22L23.5 25" stroke="#E03E1A" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="20" cy="22" r="1.3" fill="#E03E1A"/>
                                    <!-- Clock Legs -->
                                    <path d="M12.5 31.5L10.5 34.5" stroke="#E03E1A" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M27.5 31.5L29.5 34.5" stroke="#E03E1A" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>

                            <!-- 2. Text + Progress Bar Column -->
                            <div class="stock-urgency-content flex-1 min-w-0 flex flex-col justify-center">
                                <div class="stock-urgency-text-row text-xs sm:text-[13.5px] md:text-[14px] font-body leading-tight mb-1 sm:mb-1.5 flex flex-wrap items-baseline gap-1">
                                    <span class="stock-hurry-label font-bold text-[#E03E1A]"><?php esc_html_e('Hurry Up!', 'dharmgyan'); ?></span>
                                    <span class="stock-middle-text text-[#222222] font-normal">
                                        <?php esc_html_e('Only', 'dharmgyan'); ?>
                                        <strong class="stock-qty-num font-bold text-[#E03E1A] mx-0.5"><?php echo esc_html($stock_count); ?></strong>
                                        <?php esc_html_e('items left in stock!', 'dharmgyan'); ?>
                                    </span>
                                </div>
                                <div class="stock-urgency-track w-full h-[7px] sm:h-[8px] bg-[#FCE6CF] rounded-full overflow-hidden p-0">
                                    <div class="stock-urgency-bar h-full rounded-full transition-all duration-500 ease-out"
                                         style="width: <?php echo esc_attr($bar_pct); ?>%;">
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Right Pill Badge + 3 Urgency Rays -->
                            <div class="stock-badge-container relative shrink-0 flex items-center">
                                <div class="stock-left-badge bg-gradient-to-r from-[#E64016] to-[#CB2807] text-white font-bold text-xs sm:text-[13px] px-3 sm:px-3.5 py-1 sm:py-1.5 rounded-full shadow-[0_2px_6px_rgba(203,40,7,0.3)] whitespace-nowrap leading-none flex items-center justify-center font-body">
                                    <span class="stock-badge-qty"><?php echo esc_html($stock_count); ?></span>&nbsp;<span><?php esc_html_e('left', 'dharmgyan'); ?></span>
                                </div>
                                <div class="stock-sparks ml-1 sm:ml-1.5 flex items-center shrink-0 select-none" aria-hidden="true">
                                    <svg class="w-3 sm:w-3.5 h-6 text-[#E03E1A]" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 4.5L11 2.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                        <path d="M1.5 12H12.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                        <path d="M2 19.5L11 21.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- 7. Buy Form with Variations, Quantity & Dual Buttons (Simple & Variable Supported) -->
                    <?php woocommerce_template_single_add_to_cart(); ?>

                    <!-- 10. Guarantee Safe Checkout (Dynamic Toggle from Theme Settings) -->
                    <?php
                    $enable_guarantee = dharmgyan_get_field('enable_guarantee_box', 'option');
                    if ($enable_guarantee !== false && $enable_guarantee !== '0'):
                    ?>
                        <div class="product-guarantee-box border border-[#E2E8F0] rounded-[6px] p-3.5 bg-white my-3.5">
                            <div class="relative flex py-2 items-center mb-2">
                                <div class="flex-grow border-t border-[#E5E5E5]"></div>
                                <span class="flex-shrink mx-3 text-[11px] font-bold text-[#111111] uppercase tracking-wider">GUARANTEE SAFE CHECKOUT</span>
                                <div class="flex-grow border-t border-[#E5E5E5]"></div>
                            </div>
                            <div class="grid grid-cols-4 gap-2.5 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="size-[50px] md:size-[70px] rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/satisfaction.svg'); ?>" alt="<?php esc_attr_e('Satisfaction Guarantee', 'dharmgyan'); ?>" class="size-[50px] md:size-[70px]" />
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="size-[50px] md:size-[70px] rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/free-shipping.svg'); ?>" alt="<?php esc_attr_e('FREE SHIPPING', 'dharmgyan'); ?>" class="size-[50px] md:size-[70px]" />
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="size-[50px] md:size-[70px] rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                                     <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/easy-return.svg'); ?>" alt="<?php esc_attr_e('Easy Return', 'dharmgyan'); ?>" class="size-[50px] md:size-[70px]" />
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <div class="size-[50px] md:size-[70px] rounded-full border-2 border-dashed border-[#D2691E] p-1 flex items-center justify-center mb-1">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/cash-delivery.svg'); ?>" alt="<?php esc_attr_e('COD AVAILABLE', 'dharmgyan'); ?>" class="size-[50px] md:size-[70px]" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                    <!-- 12. SEO-Optimized Dynamic Product Highlights (WooCommerce Short Description / ACF / Attributes) -->
                    <?php
                    $product_highlights = dharmgyan_get_product_highlights($product);
                    if (!empty($product_highlights)):
                    ?>
                        <div class="product-features-checklist my-3.5 pt-2">
                            <p class="font-body text-xs md:text-sm font-bold text-[#111111] mb-2.5"><?php esc_html_e('Key Highlights & Specifications', 'dharmgyan'); ?></p>
                            <ul class="space-y-2 text-xs md:text-[13px] text-[#444444] font-body">
                                <?php foreach ($product_highlights as $highlight): ?>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-[#CC5600] shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5 5-5"/></svg>
                                        <span class="leading-relaxed"><?php echo esc_html($highlight); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- Google Schema.org Product Microdata for Rich Search Results -->
                    <script type="application/ld+json">
                    {
                        "@context": "https://schema.org/",
                        "@type": "Product",
                        "name": <?php echo json_encode($product->get_name()); ?>,
                        "image": <?php echo json_encode(wp_get_attachment_url($product->get_image_id()) ?: ''); ?>,
                        "description": <?php echo json_encode(wp_strip_all_tags($product->get_short_description() ?: $product->get_description())); ?>,
                        "sku": <?php echo json_encode($product->get_sku() ?: (string)$product->get_id()); ?>,
                        "brand": {
                            "@type": "Brand",
                            "name": "Bhakti Ras"
                        },
                        "offers": {
                            "@type": "Offer",
                            "url": <?php echo json_encode(get_permalink($product->get_id())); ?>,
                            "priceCurrency": <?php echo json_encode(get_woocommerce_currency()); ?>,
                            "price": <?php echo json_encode((string)$initial_display_price); ?>,
                            "availability": <?php echo json_encode($product->is_in_stock() ? "https://schema.org/InStock" : "https://schema.org/OutOfStock"); ?>,
                            "seller": {
                                "@type": "Organization",
                                "name": "Bhakti Ras Store"
                            }
                        }
                    }
                    </script>

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
