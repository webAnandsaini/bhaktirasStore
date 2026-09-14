<?php
/**
 * Orders - Pixel-Perfect Spiritual Luxury Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders);
?>

<div class="myaccount-orders-wrapper font-body">
    
    <!-- Section Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-[#EAE3DC]">
        <div>
            <h2 class="font-serif text-2xl md:text-[26px] text-[#111111] font-normal leading-tight mb-1">
                <?php esc_html_e('Your Sacred Orders', 'dharmgyan'); ?>
            </h2>
            <p class="text-xs md:text-sm text-[#717171]">
                <?php esc_html_e('Review order history, check shipment statuses, and download invoice receipts.', 'dharmgyan'); ?>
            </p>
        </div>
        <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#CC5600] hover:text-[#B34B00] self-start sm:self-auto">
            <span><?php esc_html_e('Continue Shopping', 'dharmgyan'); ?></span>
            <span>→</span>
        </a>
    </div>

    <?php if ($has_orders) : ?>
        <div class="overflow-x-auto">
            <table class="woocommerce-orders-table">
                <thead>
                    <tr>
                        <?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) : ?>
                            <th scope="col" class="<?php echo ('order-actions' === $column_id) ? 'text-right' : ''; ?>">
                                <?php echo esc_html($column_name); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($customer_orders->orders as $customer_order) {
                        $order      = wc_get_order($customer_order);
                        $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                        $status     = $order->get_status();
                        ?>
                        <tr class="order-status-row-<?php echo esc_attr($status); ?>">
                            <?php foreach (wc_get_account_orders_columns() as $column_id => $column_name) : ?>
                                <td data-title="<?php echo esc_attr($column_name); ?>" class="<?php echo ('order-actions' === $column_id) ? 'text-right' : ''; ?>">
                                    <?php if (has_action('woocommerce_my_account_my_orders_column_' . $column_id)) : ?>
                                        <?php do_action('woocommerce_my_account_my_orders_column_' . $column_id, $order); ?>

                                    <?php elseif ('order-number' === $column_id) : ?>
                                        <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="font-bold text-[#CC5600] hover:underline">
                                            #<?php echo esc_html($order->get_order_number()); ?>
                                        </a>

                                    <?php elseif ('order-date' === $column_id) : ?>
                                        <time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>" class="text-xs md:text-sm text-[#555555]">
                                            <?php echo esc_html(wc_format_datetime($order->get_date_created())); ?>
                                        </time>

                                    <?php elseif ('order-status' === $column_id) : ?>
                                        <span class="order-status-badge order-status-<?php echo esc_attr($status); ?>">
                                            <?php echo esc_html(wc_get_order_status_name($status)); ?>
                                        </span>

                                    <?php elseif ('order-total' === $column_id) : ?>
                                        <div class="text-sm font-semibold text-[#111111]">
                                            <?php echo wp_kses_post(sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'dharmgyan'), $order->get_formatted_order_total(), $item_count)); ?>
                                        </div>

                                    <?php elseif ('order-actions' === $column_id) : ?>
                                        <?php
                                        $actions = wc_get_account_orders_actions($order);
                                        if (!empty($actions)) {
                                            echo '<div class="inline-flex items-center gap-2 justify-end">';
                                            foreach ($actions as $key => $action) {
                                                echo '<a href="' . esc_url($action['url']) . '" class="inline-flex items-center text-xs font-semibold text-[#CC5600] hover:text-white bg-[#FFF0E2] hover:bg-[#CC5600] px-3.5 py-1.5 rounded-[4px] transition-colors">' . esc_html($action['name']) . '</a>';
                                            }
                                            echo '</div>';
                                        }
                                        ?>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php do_action('woocommerce_before_account_orders_pagination'); ?>

        <?php if (1 < $customer_orders->max_num_pages) : ?>
            <div class="woocommerce-pagination flex items-center justify-center gap-2 mt-8">
                <?php if (1 !== $current_page) : ?>
                    <a class="px-3.5 py-2 border border-[#EAE3DC] rounded-[4px] text-xs font-semibold text-[#444444] hover:bg-[#FFF9F4] hover:text-[#CC5600] transition-colors" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>">
                        ← <?php esc_html_e('Previous', 'dharmgyan'); ?>
                    </a>
                <?php endif; ?>

                <span class="text-xs text-[#717171] font-medium px-3">
                    <?php printf(esc_html__('Page %1$d of %2$d', 'dharmgyan'), $current_page, $customer_orders->max_num_pages); ?>
                </span>

                <?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
                    <a class="px-3.5 py-2 border border-[#EAE3DC] rounded-[4px] text-xs font-semibold text-[#444444] hover:bg-[#FFF9F4] hover:text-[#CC5600] transition-colors" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>">
                        <?php esc_html_e('Next', 'dharmgyan'); ?> →
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <!-- Empty State -->
        <div class="p-8 md:p-12 text-center bg-[#FCFAF7] border border-[#EAE3DC] rounded-xl">
            <div class="w-14 h-14 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center mx-auto mb-3 text-2xl shadow-2xs">
                📦
            </div>
            <h3 class="font-serif text-lg md:text-xl font-bold text-[#111111] mb-1.5">
                <?php esc_html_e('No Orders Placed Yet', 'dharmgyan'); ?>
            </h3>
            <p class="text-xs md:text-sm text-[#717171] max-w-md mx-auto mb-5 leading-relaxed">
                <?php esc_html_e('You have not placed any orders yet. Discover our sacred divine idols, festive brass diyas, and authentic tulsi malas to invite auspicious blessings.', 'dharmgyan'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="inline-flex items-center gap-2 bg-[#CC5600] hover:bg-[#B34B00] text-white px-6 py-2.5 rounded-[6px] text-xs md:text-sm font-semibold transition-all shadow-sm">
                <span><?php esc_html_e('Explore Sacred Store', 'dharmgyan'); ?></span>
                <span>→</span>
            </a>
        </div>
    <?php endif; ?>

</div>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
