<?php
/**
 * Simple product add to cart
 * Dharmgyan Figma 1:3218 Pixel-Perfect
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product);

if ($product->is_in_stock()) : ?>

    <?php do_action('woocommerce_before_add_to_cart_form'); ?>

    <form class="cart single-product-cart-form my-4 space-y-3.5" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data' data-product-id="<?php echo esc_attr($product->get_id()); ?>">
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

        <!-- Quantity Row -->
        <div class="product-qty-row flex items-center">
            <span class="w-24 text-xs md:text-sm font-semibold text-[#111111] font-body shrink-0"><?php esc_html_e('Quantity:', 'dharmgyan'); ?></span>
            <div class="quantity border border-[#444444] rounded-[4px] h-[46px] w-[140px] flex items-center justify-between px-2 bg-white">
                <button type="button" class="minus text-lg font-medium text-[#111111] hover:text-[#CC5600] w-8 h-full flex items-center justify-center select-none cursor-pointer" aria-label="<?php esc_attr_e('Decrease quantity', 'dharmgyan'); ?>">−</button>
                <input type="number" id="quantity_<?php echo esc_attr(uniqid()); ?>" class="qty w-10 text-center border-none text-sm font-medium text-[#111111] focus:outline-none p-0" step="1" min="<?php echo esc_attr($product->get_min_purchase_quantity()); ?>" max="<?php echo esc_attr($product->get_max_purchase_quantity() > 0 ? $product->get_max_purchase_quantity() : 999); ?>" name="quantity" value="<?php echo esc_attr(isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity()); ?>" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off" />
                <button type="button" class="plus text-lg font-medium text-[#111111] hover:text-[#CC5600] w-8 h-full flex items-center justify-center select-none cursor-pointer" aria-label="<?php esc_attr_e('Increase quantity', 'dharmgyan'); ?>">+</button>
            </div>
        </div>

        <!-- Dual CTA Buttons (Side-by-Side in 1 row matching Figma 1:1) -->
        <div class="product-cta-buttons grid grid-cols-2 gap-3.5 pt-1">
            <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt h-[48px] !text-[#111111] !border-[2px] !border-[#C0570A] !text-[#C0570A] !bg-white hover:!bg-[#C0570A] hover:text-white rounded-[4px] font-medium text-sm md:text-base transition-colors flex items-center justify-center cursor-pointer shadow-none">
                <?php echo esc_html($product->single_add_to_cart_text()); ?>
            </button>
            <button type="submit" name="dharmgyan_buy_now" value="1" data-product-id="<?php echo esc_attr($product->get_id()); ?>" class="buy_now_button button h-[48px] bg-[#C0570A] hover:bg-[#A84905] text-white rounded-[4px] font-medium text-sm md:text-base transition-colors shadow-none flex items-center justify-center cursor-pointer">
                <?php esc_html_e('Buy it now', 'dharmgyan'); ?>
            </button>
        </div>

        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    </form>

    <?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>
