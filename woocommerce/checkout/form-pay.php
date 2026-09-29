<?php
/**
 * Pay for order form template
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

$totals = $order->get_order_item_totals();
?>

<div class="order-pay-wrapper bg-white min-h-screen py-10 md:py-16 font-body">
    <div class="max-w-[800px] mx-auto px-4">

        <form id="order_review" method="post" class="bg-white border border-[#EAE3DC] rounded-[8px] p-6 md:p-8 shadow-sm">

            <!-- Order Pay Header -->
            <div class="border-b border-[#EAE3DC] pb-6 mb-6 text-center md:text-left">
                <span class="inline-block px-3 py-1 bg-[#FFF8F3] text-[#CC5600] text-xs font-bold rounded-full mb-3 tracking-wider uppercase">
                    <?php esc_html_e('Complete Payment', 'dharmgyan'); ?>
                </span>
                <h1 class="font-serif text-2xl md:text-3xl text-[#111111] mb-2 font-semibold">
                    <?php esc_html_e('Pay for Order', 'dharmgyan'); ?> #<?php echo esc_html($order->get_order_number()); ?>
                </h1>
                <p class="text-sm text-[#717171]">
                    <?php esc_html_e('Thank you for your order. Please select your payment method below to complete your transaction.', 'dharmgyan'); ?>
                </p>
            </div>

            <!-- Order Summary Banner Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-[#FCFAF7] border border-[#EAE3DC] rounded-[6px] p-4 mb-6 text-center">
                <div class="p-2 border-r border-[#EAE3DC] sm:border-r">
                    <span class="block text-[11px] text-[#717171] uppercase tracking-wider"><?php esc_html_e('Order Number', 'dharmgyan'); ?></span>
                    <strong class="text-sm md:text-base text-[#111111] font-semibold mt-1 block">#<?php echo esc_html($order->get_order_number()); ?></strong>
                </div>
                <div class="p-2 sm:border-r border-[#EAE3DC]">
                    <span class="block text-[11px] text-[#717171] uppercase tracking-wider"><?php esc_html_e('Date', 'dharmgyan'); ?></span>
                    <strong class="text-sm md:text-base text-[#111111] font-semibold mt-1 block"><?php echo wc_format_datetime($order->get_date_created()); ?></strong>
                </div>
                <div class="p-2 border-r border-[#EAE3DC] sm:border-r">
                    <span class="block text-[11px] text-[#717171] uppercase tracking-wider"><?php esc_html_e('Total Amount', 'dharmgyan'); ?></span>
                    <strong class="text-sm md:text-base text-[#CC5600] font-bold mt-1 block"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></strong>
                </div>
                <div class="p-2">
                    <span class="block text-[11px] text-[#717171] uppercase tracking-wider"><?php esc_html_e('Payment Method', 'dharmgyan'); ?></span>
                    <strong class="text-sm md:text-base text-[#111111] font-semibold mt-1 block"><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                </div>
            </div>

            <!-- Order Items & Totals Table -->
            <div class="overflow-x-auto mb-6">
                <table class="shop_table w-full border-collapse border border-[#EAE3DC] rounded-[6px] overflow-hidden">
                    <thead>
                        <tr class="bg-[#FAFAFA] border-b border-[#EAE3DC]">
                            <th class="text-left py-3 px-4 text-xs font-semibold text-[#111111] uppercase tracking-wider"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                            <th class="text-center py-3 px-4 text-xs font-semibold text-[#111111] uppercase tracking-wider"><?php esc_html_e('Qty', 'woocommerce'); ?></th>
                            <th class="text-right py-3 px-4 text-xs font-semibold text-[#111111] uppercase tracking-wider"><?php esc_html_e('Totals', 'woocommerce'); ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EAE3DC]">
                        <?php if (count($order->get_items()) > 0) : ?>
                            <?php foreach ($order->get_items() as $item_id => $item) : ?>
                                <?php
                                if (!apply_filters('woocommerce_order_item_visible', true, $item)) {
                                    continue;
                                }
                                ?>
                                <tr class="<?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'order_item', $item, $order)); ?>">
                                    <td class="py-3.5 px-4 text-sm text-[#111111] font-medium">
                                        <?php
                                        echo wp_kses_post(apply_filters('woocommerce_order_item_name', $item->get_name(), $item, false));
                                        do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, false);
                                        wc_display_item_meta($item);
                                        do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false);
                                        ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-sm text-[#717171] text-center">
                                        <?php echo apply_filters('woocommerce_order_item_quantity_html', '× ' . sprintf('%s', $item->get_quantity()), $item); ?>
                                    </td>
                                    <td class="py-3.5 px-4 text-sm text-[#111111] text-right font-semibold">
                                        <?php echo $order->get_formatted_line_subtotal($item); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <?php if ($totals) : ?>
                            <?php foreach ($totals as $total) : ?>
                                <tr class="border-t border-[#EAE3DC] bg-[#FCFAF7]">
                                    <th scope="row" colspan="2" class="py-3 px-4 text-sm text-[#717171] text-right font-medium"><?php echo $total['label']; ?></th>
                                    <td class="py-3 px-4 text-sm text-right font-bold text-[#111111]"><?php echo $total['value']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tfoot>
                </table>
            </div>

            <!-- Payment Methods Box -->
            <div id="payment" class="bg-[#FCFAF7] border border-[#EAE3DC] rounded-[6px] p-6 mb-6">
                <?php if ($order->needs_payment()) : ?>
                    <ul class="wc_payment_methods payment_methods methods space-y-4 mb-6">
                        <?php
                        if (!empty($available_gateways)) {
                            foreach ($available_gateways as $gateway) {
                                wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
                            }
                        } else {
                            echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info text-sm text-[#717171]">' . apply_filters('woocommerce_no_available_payment_methods_message', esc_html__('Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce')) . '</li>';
                        }
                        ?>
                    </ul>
                <?php endif; ?>

                <div class="form-row flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-[#EAE3DC]">
                    <input type="hidden" name="woocommerce_pay" value="1" />
                    <?php wp_nonce_field('woocommerce-pay', 'woocommerce-pay-nonce'); ?>

                    <a href="<?php echo esc_url($order->get_cancel_order_url()); ?>" class="text-sm font-medium text-[#717171] hover:text-[#CC5600] transition-colors focus:outline-none order-2 sm:order-1">
                        <?php esc_html_e('Cancel Order', 'dharmgyan'); ?>
                    </a>

                    <div class="order-1 sm:order-2 w-full sm:w-auto">
                        <?php echo apply_filters('woocommerce_pay_order_button_html', '<button type="submit" class="button alt w-full sm:w-auto bg-[#CC5600] hover:bg-[#B34B00] text-white text-sm font-semibold px-8 py-3 rounded-[4px] shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-[#CC5600]" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'); ?>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
