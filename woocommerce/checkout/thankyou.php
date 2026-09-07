<?php
/**
 * Thank You / Order Received Template
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;
?>

<div class="thankyou-page-wrapper bg-white min-h-screen py-10 md:py-16 font-body">
    <div class="max-w-[800px] mx-auto px-4">

        <?php if ($order): ?>

            <?php if ($order->has_status('failed')): ?>
                
                <div class="text-center p-8 bg-red-50 border border-red-200 rounded-[6px] mb-8">
                    <div class="w-16 h-16 mx-auto rounded-full bg-red-100 text-red-600 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    </div>
                    <h1 class="text-2xl font-bold text-red-800 mb-2"><?php esc_html_e('Payment Failed', 'dharmgyan'); ?></h1>
                    <p class="text-sm text-red-700 leading-relaxed mb-6">
                        <?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'dharmgyan'); ?>
                    </p>
                    <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="inline-block px-6 py-3 bg-[#CC5600] text-white font-medium text-sm rounded-[4px] shadow-sm">
                        <?php esc_html_e('Pay Now', 'dharmgyan'); ?>
                    </a>
                </div>

            <?php else: ?>

                <!-- Auspicious Success Banner -->
                <div class="text-center mb-10">
                    <div class="w-20 h-20 mx-auto rounded-full bg-[#EAFFEA] border border-[#D1F2E8] text-[#166534] flex items-center justify-center mb-5 shadow-xs">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="inline-block px-3 py-1 bg-[#FFF8F3] text-[#CC5600] text-xs font-bold rounded-full mb-3 tracking-wider uppercase">
                        <?php esc_html_e('Order Placed Auspiciously', 'dharmgyan'); ?>
                    </span>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#111111] mb-2">
                        <?php esc_html_e('Thank you for your sacred order!', 'dharmgyan'); ?>
                    </h1>
                    <p class="text-sm md:text-base text-[#717171] max-w-md mx-auto leading-relaxed">
                        <?php esc_html_e('A confirmation email and SMS with tracking details have been sent to your contact.', 'dharmgyan'); ?>
                    </p>
                </div>

                <!-- Order Summary Key Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-[#FCFAF7] border border-[#EAE3DC] rounded-[6px] p-4 md:p-6 mb-8 text-center">
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

            <?php endif; ?>

            <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
            <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

            <!-- Action Return to Shop -->
            <div class="pt-8 text-center">
                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="inline-flex items-center gap-2 px-8 py-3.5 bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-sm md:text-base rounded-[4px] shadow-sm transition-colors">
                    <span><?php esc_html_e('Continue Shopping', 'dharmgyan'); ?></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

        <?php else: ?>

            <div class="text-center py-12">
                <p class="text-base text-[#717171]"><?php esc_html_e('Thank you. Your order has been received.', 'dharmgyan'); ?></p>
            </div>

        <?php endif; ?>

    </div>
</div>
