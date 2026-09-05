<?php
/**
 * Universal Product Card Component - Pixel-Perfect Figma Design
 * Used across Shop, Archives, Related Products, and Homepage Curated Sections.
 *
 * @package Dharmgyan
 */

global $product;

if (empty($product) || !is_a($product, 'WC_Product')) {
    $product_id = get_the_ID();
    $product    = wc_get_product($product_id);
} else {
    $product_id = $product->get_id();
}

if (!$product) {
    return;
}

$product_link  = get_permalink($product_id);
$product_title = get_the_title($product_id);
$img_url       = get_the_post_thumbnail_url($product_id, 'medium_large') ?: wc_placeholder_img_src();
$is_on_sale    = $product->is_on_sale();

// Build price HTML
$price_html = '';
if ($product->is_type('variable')) {
    $min_sale_price    = $product->get_variation_sale_price('min', true);
    $min_regular_price = $product->get_variation_regular_price('min', true);

    if ($min_sale_price && $min_sale_price < $min_regular_price) {
        $price_html .= '<span class="text-[#CC5600] font-semibold text-[17px] md:text-[20px] font-body leading-none">' . wc_price($min_sale_price) . '</span>';
        $price_html .= '<span class="text-[#717171] font-normal text-[12px] md:text-[13px] line-through font-body leading-none ml-2">' . wc_price($min_regular_price) . '</span>';
    } else {
        $price_html .= '<span class="text-[#CC5600] font-semibold text-[17px] md:text-[20px] font-body leading-none">' . wc_price($product->get_price()) . '</span>';
    }
} else {
    $regular_price = $product->get_regular_price();
    $sale_price    = $product->get_sale_price();

    if ($is_on_sale && $sale_price) {
        $price_html .= '<span class="text-[#CC5600] font-semibold text-[17px] md:text-[20px] font-body leading-none">' . wc_price($sale_price) . '</span>';
        $price_html .= '<span class="text-[#717171] font-normal text-[12px] md:text-[13px] line-through font-body leading-none ml-2">' . wc_price($regular_price) . '</span>';
    } else {
        $price_html .= '<span class="text-[#CC5600] font-semibold text-[17px] md:text-[20px] font-body leading-none">' . wc_price($product->get_price()) . '</span>';
    }
}

// Star rating data
$rating_count = $product->get_rating_count();
$average      = (float) $product->get_average_rating();

// Check if in wishlist
$is_in_wishlist = false;
if (function_exists('yith_wcwl_is_product_in_wishlist')) {
    $is_in_wishlist = yith_wcwl_is_product_in_wishlist($product_id);
} elseif (class_exists('YITH_WCWL_Wishlist_Factory')) {
    try {
        $default_wl = YITH_WCWL_Wishlist_Factory::get_default_wishlist();
        if ($default_wl && $default_wl->has_product($product_id)) {
            $is_in_wishlist = true;
        }
    } catch (\Exception $e) {}
}
?>

<article class="product-card group flex flex-col justify-between bg-white border border-[#EAE3DC] hover:border-[#CC5600] rounded-[6px] p-2.5 sm:p-3 shadow-2xs hover:shadow-md transition-all duration-300 relative" data-product-id="<?php echo esc_attr($product_id); ?>" aria-label="<?php echo esc_attr($product_title); ?>">
    <div>
        <!-- Product Thumbnail with overlaid actions -->
        <div class="relative aspect-square w-full rounded-[4px] overflow-hidden bg-[#F9F9F9]">
            <a href="<?php echo esc_url($product_link); ?>" class="block w-full h-full" tabindex="-1" aria-hidden="true">
                <img
                    src="<?php echo esc_url($img_url); ?>"
                    alt="<?php echo esc_attr($product_title); ?>"
                    class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                    loading="lazy"
                    decoding="async"
                />
            </a>

            <!-- Sale Badge (top-left) -->
            <?php if ($is_on_sale): ?>
                <span class="absolute top-2.5 left-2.5 bg-[#CC5600] text-white text-[11px] font-bold px-2 py-0.5 rounded-[3px] shadow-sm z-10 select-none" aria-label="<?php esc_attr_e('On Sale', 'dharmgyan'); ?>">
                    <?php esc_html_e('SALE', 'dharmgyan'); ?>
                </span>
            <?php endif; ?>

            <!-- Wishlist Heart Button (top-right) — Pure 2-Way AJAX Toggle, Zero Page Redirect -->
            <div class="product-card-wishlist absolute top-2.5 right-2.5 z-20">
                <button
                    type="button"
                    class="dharmgyan-wishlist-toggle-btn w-8 h-8 flex items-center justify-center bg-white/95 hover:bg-white rounded-full shadow-sm hover:scale-110 transition-all duration-150 cursor-pointer border border-[#EAE3DC] hover:border-[#CC5600] text-[#555555] hover:text-[#CC5600] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] <?php echo $is_in_wishlist ? 'is-in-wishlist' : ''; ?>"
                    aria-label="<?php echo esc_attr(sprintf($is_in_wishlist ? __('Remove %s from Wishlist', 'dharmgyan') : __('Add %s to Wishlist', 'dharmgyan'), $product_title)); ?>"
                    data-product-id="<?php echo esc_attr($product_id); ?>"
                >
                    <svg class="heart-icon w-4 h-4 transition-all duration-200" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="<?php echo $is_in_wishlist ? '#CC5600' : 'none'; ?>" stroke="<?php echo $is_in_wishlist ? '#CC5600' : 'currentColor'; ?>" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </button>
            </div>

            <!-- Slide-up Add to Cart on hover (bottom) with Dynamic Spinner & Feedback -->
            <div class="absolute bottom-0 left-0 right-0 p-2.5 z-10 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out">
                <?php
                $cart_url    = $product->add_to_cart_url();
                $cart_text   = $product->add_to_cart_text();
                $cart_desc   = $product->add_to_cart_description();
                $product_sku = $product->get_sku();
                ?>
                <a
                    href="<?php echo esc_url($cart_url); ?>"
                    data-quantity="1"
                    data-product_id="<?php echo esc_attr($product_id); ?>"
                    data-product_sku="<?php echo esc_attr($product_sku); ?>"
                    class="add_to_cart_button ajax_add_to_cart w-full inline-flex items-center justify-center gap-2 bg-[#CC5600] hover:bg-[#B34B00] text-white text-xs md:text-[13px] font-semibold py-2.5 px-3 rounded-[4px] shadow-md transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                    aria-label="<?php echo esc_attr($cart_desc ?: sprintf(__('Add %s to shopping bag', 'dharmgyan'), $product_title)); ?>"
                >
                    <svg class="cart-icon w-3.5 h-3.5 shrink-0" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="btn-text"><?php echo esc_html($cart_text); ?></span>
                </a>
            </div>
        </div>

        <!-- Product Details (with clean internal padding so text never touches card borders) -->
        <div class="px-1 pt-3 pb-1">
            <h3 class="font-body text-[#333333] group-hover:text-[#CC5600] text-[14px] md:text-[15px] font-medium leading-[20px] line-clamp-2 min-h-[40px] transition-colors">
                <a href="<?php echo esc_url($product_link); ?>" class="focus:outline-none focus-visible:ring-1 focus-visible:ring-[#CC5600] rounded-xs">
                    <?php echo esc_html($product_title); ?>
                </a>
            </h3>

            <!-- Star Rating Row -->
            <?php if ($rating_count > 0): ?>
                <div class="flex items-center gap-1.5 mt-1">
                    <div class="flex items-center gap-0.5" aria-label="<?php echo esc_attr(sprintf(__('Rated %s out of 5', 'dharmgyan'), number_format($average, 1))); ?>" role="img">
                        <?php for ($i = 1; $i <= 5; $i++):
                            if ($i <= floor($average)): ?>
                                <svg class="w-[11px] h-[11px] text-[#FFB23D]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <?php elseif (($i - 0.5) <= $average): ?>
                                <svg class="w-[11px] h-[11px] text-[#FFB23D]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M12 2v15.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <?php else: ?>
                                <svg class="w-[11px] h-[11px] text-[#E5E5E5]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <?php endif;
                        endfor; ?>
                    </div>
                    <span class="text-[#717171] text-[11px] font-body" aria-label="<?php echo esc_attr(sprintf(__('%d customer reviews', 'dharmgyan'), $rating_count)); ?>">(<?php echo esc_html($rating_count); ?>)</span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Price Row (px-1 for proper border spacing) -->
    <div class="px-1 flex items-baseline gap-1 mt-1.5" aria-label="<?php esc_attr_e('Product price', 'dharmgyan'); ?>">
        <?php echo wp_kses_post($price_html); ?>
    </div>
</article>
