<?php
/**
 * Custom WooCommerce Cart Template
 * Pixel-Perfect layout matching Figma Design System.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<div class="cart-page-wrapper bg-white min-h-screen">
    
    <!-- Full-Width Centered Breadcrumb Bar -->
    <div class="cart-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]"><?php esc_html_e('Shopping Bag', 'dharmgyan'); ?></span>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 pb-16">

        <h1 class="font-body text-2xl md:text-3xl text-[#111111] font-semibold mb-8">
            <?php esc_html_e('Your Shopping Bag', 'dharmgyan'); ?> 
            <span class="cart-header-count text-sm md:text-base font-normal text-[#717171] ml-2">(<?php echo esc_html(WC()->cart->get_cart_contents_count()); ?> <?php esc_html_e('items', 'dharmgyan'); ?>)</span>
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 xl:gap-12 items-start">
            
            <!-- Left: Cart Items Table -->
            <div class="lg:col-span-8 w-full">
                <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                    <?php do_action('woocommerce_before_cart_table'); ?>

                    <div class="woocommerce-cart-form__contents border border-[#EAE3DC] rounded-[6px] overflow-hidden bg-white shadow-2xs">
                        
                        <!-- Table Header (Desktop) -->
                        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-4 bg-[#F9F5EB] border-b border-[#EAE3DC] text-xs font-semibold text-[#111111] uppercase tracking-wider font-body">
                            <div class="col-span-6"><?php esc_html_e('Product', 'dharmgyan'); ?></div>
                            <div class="col-span-2 text-center"><?php esc_html_e('Price', 'dharmgyan'); ?></div>
                            <div class="col-span-2 text-center"><?php esc_html_e('Quantity', 'dharmgyan'); ?></div>
                            <div class="col-span-2 text-right"><?php esc_html_e('Subtotal', 'dharmgyan'); ?></div>
                        </div>

                        <div class="divide-y divide-[#EAE3DC]">
                            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item): 
                                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)):
                                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                            ?>
                                <div class="woocommerce-cart-form__cart-item cart_item p-4 md:p-6 flex flex-col md:grid md:grid-cols-12 md:gap-4 md:items-center relative group">
                                    
                                    <!-- Product Info & Thumbnail -->
                                    <div class="md:col-span-6 flex items-center gap-4">
                                        <div class="w-20 h-20 md:w-24 md:h-24 shrink-0 rounded-[4px] overflow-hidden border border-[#EAE3DC] bg-[#F9F9F9]">
                                            <?php
                                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail', array('class' => 'w-full h-full object-cover')), $cart_item, $cart_item_key);
                                            if (!$product_permalink) {
                                                echo $thumbnail; // PHPCS: XSS ok.
                                            } else {
                                                printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                                            }
                                            ?>
                                        </div>
                                        <div class="min-w-0 pr-6 md:pr-0">
                                            <h3 class="font-body text-sm md:text-base font-medium text-[#111111] hover:text-[#CC5600] transition-colors leading-snug line-clamp-2">
                                                <?php
                                                if (!$product_permalink) {
                                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                                } else {
                                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                                }
                                                ?>
                                            </h3>
                                            <?php
                                            // Backorder notification
                                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification text-xs text-[#CC5600] mt-1">' . esc_html__('Available on backorder', 'dharmgyan') . '</p>', $product_id));
                                            }
                                            // Meta data
                                            echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="md:col-span-2 md:text-center mt-2 md:mt-0 font-body text-sm text-[#444444]">
                                        <span class="md:hidden text-xs text-[#717171] mr-1"><?php esc_html_e('Price:', 'dharmgyan'); ?></span>
                                        <?php echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                                    </div>

                                    <!-- Quantity Stepper -->
                                    <div class="md:col-span-2 flex items-center md:justify-center mt-2 md:mt-0">
                                        <div class="cart-quantity-stepper border border-[#CCCCCC] rounded-[4px] h-[38px] w-[104px] flex items-center justify-between px-1 bg-white">
                                            <?php
                                            if ($_product->is_sold_individually()) {
                                                $min_quantity = 1;
                                                $max_quantity = 1;
                                            } else {
                                                $min_quantity = 1;
                                                $max_quantity = $_product->get_max_purchase_quantity();
                                            }

                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $max_quantity,
                                                    'min_value'    => $min_quantity,
                                                    'product_name' => $_product->get_name(),
                                                    'classes'      => array('input-text', 'qty', 'text', 'w-10', 'text-center', 'border-none', 'text-xs', 'font-medium', 'text-[#111111]', 'focus:outline-none', 'p-0'),
                                                ),
                                                $_product,
                                                false
                                            );

                                            echo $product_quantity; // PHPCS: XSS ok.
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="md:col-span-2 md:text-right mt-2 md:mt-0 font-body text-sm md:text-base font-semibold text-[#CC5600]">
                                        <span class="md:hidden text-xs text-[#717171] font-normal mr-1"><?php esc_html_e('Subtotal:', 'dharmgyan'); ?></span>
                                        <?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                                    </div>

                                    <!-- Remove Button -->
                                    <div class="product-remove absolute top-4 right-4 md:static md:col-span-12 md:hidden">
                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="text-[#717171] hover:text-red-600 p-1.5 inline-flex items-center justify-center transition-colors" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg class="w-4 h-4" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></a>',
                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                /* translators: %s is the product name */
                                                esc_attr(sprintf(__('Remove %s from cart', 'dharmgyan'), wp_strip_all_tags($_product->get_name()))),
                                                esc_attr($product_id),
                                                esc_attr($_product->get_sku())
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </div>

                                </div>
                            <?php endif; endforeach; ?>
                        </div>

                        <!-- Cart Actions (Coupon & Update Cart) -->
                        <div class="p-4 md:p-6 bg-[#FCFAF7] border-t border-[#EAE3DC] flex flex-col sm:flex-row items-center justify-between gap-4">
                            
                            <?php if (wc_coupons_enabled()): ?>
                                <div class="flex items-center gap-2 w-full sm:w-auto">
                                    <label for="coupon_code" class="sr-only"><?php esc_html_e('Coupon code', 'dharmgyan'); ?></label>
                                    <input 
                                        type="text" 
                                        name="coupon_code" 
                                        class="input-text px-3.5 py-2.5 text-xs text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none w-full sm:w-48 placeholder:text-gray-400" 
                                        id="coupon_code" 
                                        value="" 
                                        placeholder="<?php esc_attr_e('Coupon code', 'dharmgyan'); ?>" 
                                    />
                                    <button 
                                        type="submit" 
                                        class="button shrink-0 bg-[#242424] hover:bg-black text-white text-xs font-semibold px-4 py-2.5 rounded-[4px] transition-colors cursor-pointer" 
                                        name="apply_coupon" 
                                        value="<?php esc_attr_e('Apply coupon', 'dharmgyan'); ?>"
                                    >
                                        <?php esc_html_e('Apply', 'dharmgyan'); ?>
                                    </button>
                                    <?php do_action('woocommerce_cart_coupon'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="text-xs text-[#717171] hover:text-[#CC5600] font-medium transition-colors">
                                    ← <?php esc_html_e('Continue Shopping', 'dharmgyan'); ?>
                                </a>
                                <button 
                                    type="submit" 
                                    class="button bg-white hover:bg-gray-50 text-[#111111] border border-[#CCCCCC] hover:border-[#CC5600] text-xs font-medium px-4 py-2.5 rounded-[4px] transition-colors cursor-pointer" 
                                    name="update_cart" 
                                    value="<?php esc_attr_e('Update cart', 'dharmgyan'); ?>"
                                >
                                    <?php esc_html_e('Update Cart', 'dharmgyan'); ?>
                                </button>
                                <?php do_action('woocommerce_cart_actions'); ?>
                                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                            </div>

                        </div>

                    </div>

                    <?php do_action('woocommerce_after_cart_table'); ?>
                </form>
            </div>

            <!-- Right: Sticky Cart Totals Card -->
            <div class="lg:col-span-4 w-full sticky top-28">
                <div class="cart_totals border border-[#EAE3DC] rounded-[6px] p-6 bg-[#FCFAF7] shadow-xs font-body">
                    
                    <h2 class="font-body text-lg font-bold text-[#111111] pb-3 border-b border-[#EAE3DC] mb-4">
                        <?php esc_html_e('Order Summary', 'dharmgyan'); ?>
                    </h2>

                    <!-- Free Shipping Milestone Indicator -->
                    <div class="p-3 bg-[#EAFFEA] border border-[#D1F2E8] rounded-[5px] mb-4 text-xs text-[#166534] flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#166534] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong><?php esc_html_e('Free Delivery', 'dharmgyan'); ?></strong> <?php esc_html_e('applied on your sacred order!', 'dharmgyan'); ?></span>
                    </div>

                    <!-- Totals Breakdown -->
                    <div class="space-y-3 text-sm text-[#444444] pb-4 border-b border-[#EAE3DC]">
                        <div class="flex items-center justify-between">
                            <span><?php esc_html_e('Bag Subtotal', 'dharmgyan'); ?></span>
                            <span class="font-medium text-[#111111]"><?php wc_cart_totals_subtotal_html(); ?></span>
                        </div>

                        <?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
                            <div class="flex items-center justify-between text-green-700">
                                <span><?php wc_cart_totals_coupon_label($coupon); ?></span>
                                <span><?php wc_cart_totals_coupon_html($coupon); ?></span>
                            </div>
                        <?php endforeach; ?>

                        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()): ?>
                            <div class="flex items-center justify-between">
                                <span><?php esc_html_e('Shipping', 'dharmgyan'); ?></span>
                                <span class="text-green-700 font-semibold"><?php esc_html_e('FREE', 'dharmgyan'); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Final Total -->
                    <div class="flex items-baseline justify-between py-4 text-[#111111]">
                        <span class="text-base font-bold"><?php esc_html_e('Total Amount', 'dharmgyan'); ?></span>
                        <span class="text-2xl font-bold text-[#CC5600] font-body"><?php wc_cart_totals_order_total_html(); ?></span>
                    </div>

                    <!-- Checkout CTA Button -->
                    <div class="pt-2">
                        <a 
                            href="<?php echo esc_url(wc_get_checkout_url()); ?>" 
                            class="checkout-button button alt w-full h-[52px] bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-base rounded-[4px] shadow-sm transition-all flex items-center justify-center gap-2 group text-center"
                        >
                            <span><?php esc_html_e('Proceed to Checkout', 'dharmgyan'); ?></span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <!-- Trust Strip -->
                    <div class="pt-4 mt-4 border-t border-[#EAE3DC] flex items-center justify-center gap-4 text-[11px] text-[#717171] text-center">
                        <span class="flex items-center gap-1">🔒 <?php esc_html_e('100% Secure Checkout', 'dharmgyan'); ?></span>
                        <span>•</span>
                        <span class="flex items-center gap-1">⚡ <?php esc_html_e('Razorpay Powered', 'dharmgyan'); ?></span>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

<?php do_action('woocommerce_after_cart'); ?>
