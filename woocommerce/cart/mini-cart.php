<?php
/**
 * Mini-cart template - Pixel-Perfect Spiritual Luxury Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart'); ?>

<?php if (WC()->cart && !WC()->cart->is_empty()) : ?>

    <ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr($args['list_class'] ?? ''); ?>">
        <?php
        do_action('woocommerce_before_mini_cart_contents');

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            $visible = apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key);

            if ($_product instanceof WC_Product && $_product->exists() && $cart_item['quantity'] > 0 && $visible) {
                $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                <li class="woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
                    <?php
                    echo apply_filters(
                        'woocommerce_cart_item_remove_link',
                        sprintf(
                            '<a role="button" href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s" data-success_message="%s">&times;</a>',
                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                            esc_attr(sprintf(__('Remove %s from cart', 'dharmgyan'), wp_strip_all_tags($product_name))),
                            esc_attr($product_id),
                            esc_attr($cart_item_key),
                            esc_attr($_product->get_sku()),
                            esc_attr(sprintf(__('%s has been removed from your cart', 'dharmgyan'), wp_strip_all_tags($product_name)))
                        ),
                        $cart_item_key
                    );
                    ?>
                    <?php if (empty($product_permalink)) : ?>
                        <?php echo $thumbnail . wp_kses_post($product_name); ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url($product_permalink); ?>">
                            <?php echo $thumbnail . wp_kses_post($product_name); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php 
                    // Note: wc_get_formatted_cart_item_data (size, color, thickness) is intentionally omitted per user request
                    ?>
                    
                    <?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); ?>
                </li>
                <?php
            }
        }

        do_action('woocommerce_mini_cart_contents');
        ?>
    </ul>

    <p class="woocommerce-mini-cart__total total">
        <?php
        /**
         * Hook: woocommerce_widget_shopping_cart_total.
         *
         * @hooked woocommerce_widget_shopping_cart_subtotal - 10
         */
        do_action('woocommerce_widget_shopping_cart_total');
        ?>
    </p>

    <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

    <p class="woocommerce-mini-cart__buttons buttons"><?php do_action('woocommerce_widget_shopping_cart_buttons'); ?></p>

    <?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>

<?php else : ?>

    <div class="woocommerce-mini-cart__empty-message py-8 text-center">
        <div class="w-12 h-12 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center mx-auto mb-2 text-xl shadow-2xs">
            🛍️
        </div>
        <p class="text-sm font-medium text-[#444444]"><?php esc_html_e('Your cart is empty', 'dharmgyan'); ?></p>
        <p class="text-xs text-[#717171] mt-0.5"><?php esc_html_e('Add sacred items to begin shopping.', 'dharmgyan'); ?></p>
    </div>

<?php endif; ?>

<?php do_action('woocommerce_after_mini_cart'); ?>
