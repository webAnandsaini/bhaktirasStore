<?php
/**
 * My Account dashboard - Pixel-Perfect Spiritual Luxury Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

$current_user = wp_get_current_user();
$order_count = 0;
$customer_orders = array();

if (function_exists('wc_get_orders')) {
    $customer_orders = wc_get_orders(array(
        'customer' => $current_user->ID,
        'limit'    => 3,
        'orderby'  => 'date',
        'order'    => 'DESC',
    ));
    if (function_exists('wc_get_customer_order_count')) {
        $order_count = wc_get_customer_order_count($current_user->ID);
    }
}
?>

<div class="myaccount-dashboard font-body space-y-8">
    
    <!-- Welcome Banner -->
    <div class="myaccount-welcome-banner p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#FFF0E2] to-[#FFE0C2] border-2 border-[#CC5600] text-[#CC5600] flex items-center justify-center font-bold text-xl shadow-xs shrink-0">
                <?php echo esc_html(strtoupper(substr($current_user->display_name, 0, 1))); ?>
            </div>
            <div>
                <h2 class="font-serif text-xl md:text-2xl font-bold text-[#111111] leading-tight">
                    <?php printf(esc_html__('Namaste, %s!', 'dharmgyan'), esc_html($current_user->display_name)); ?>
                </h2>
                <p class="text-xs md:text-sm text-[#717171] mt-1">
                    <?php printf(
                        /* translators: 1: user display name 2: logout url */
                        wp_kses(__('Logged in as <strong>%1$s</strong>. Not you? <a href="%2$s" class="text-[#CC5600] hover:underline font-semibold">Sign out</a>', 'dharmgyan'), array('strong' => array(), 'a' => array('href' => array(), 'class' => array()))),
                        esc_html($current_user->display_name),
                        esc_url(wc_logout_url())
                    ); ?>
                </p>
            </div>
        </div>

        <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="inline-flex items-center gap-2 bg-[#CC5600] hover:bg-[#B34B00] text-white px-5 py-2.5 rounded-[6px] text-xs md:text-sm font-semibold transition-all shadow-sm shrink-0">
            <span><?php esc_html_e('Explore Collections', 'dharmgyan'); ?></span>
            <span>→</span>
        </a>
    </div>

    <!-- Quick Navigation Cards Grid (3 Columns) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        
        <!-- Card 1: Orders -->
        <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="myaccount-action-card group">
            <div>
                <div class="w-11 h-11 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center mb-4 group-hover:bg-[#CC5600] group-hover:text-white transition-all shadow-2xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                        <line x1="12" y1="22.08" x2="12" y2="12"/>
                    </svg>
                </div>
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-[15px] text-[#111111] group-hover:text-[#CC5600] transition-colors">
                        <?php esc_html_e('Sacred Orders', 'dharmgyan'); ?>
                    </h3>
                    <?php if ($order_count > 0): ?>
                        <span class="text-xs font-bold bg-[#FFF0E2] text-[#CC5600] px-2 py-0.5 rounded-full">
                            <?php echo esc_html($order_count); ?>
                        </span>
                    <?php endif; ?>
                </div>
                <p class="text-xs text-[#717171] mt-1.5 leading-relaxed">
                    <?php esc_html_e('Track active shipments, view invoices and sacred items order history.', 'dharmgyan'); ?>
                </p>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-bold text-[#CC5600] mt-4 group-hover:translate-x-1 transition-transform">
                <span><?php esc_html_e('View Orders', 'dharmgyan'); ?></span>
                <span>→</span>
            </span>
        </a>

        <!-- Card 2: Addresses -->
        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="myaccount-action-card group">
            <div>
                <div class="w-11 h-11 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center mb-4 group-hover:bg-[#CC5600] group-hover:text-white transition-all shadow-2xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[15px] text-[#111111] group-hover:text-[#CC5600] transition-colors">
                    <?php esc_html_e('Delivery Addresses', 'dharmgyan'); ?>
                </h3>
                <p class="text-xs text-[#717171] mt-1.5 leading-relaxed">
                    <?php esc_html_e('Manage your billing details and primary shipping destinations.', 'dharmgyan'); ?>
                </p>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-bold text-[#CC5600] mt-4 group-hover:translate-x-1 transition-transform">
                <span><?php esc_html_e('Manage Addresses', 'dharmgyan'); ?></span>
                <span>→</span>
            </span>
        </a>

        <!-- Card 3: Account Details -->
        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="myaccount-action-card group">
            <div>
                <div class="w-11 h-11 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center mb-4 group-hover:bg-[#CC5600] group-hover:text-white transition-all shadow-2xs">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <h3 class="font-bold text-[15px] text-[#111111] group-hover:text-[#CC5600] transition-colors">
                    <?php esc_html_e('Account & Security', 'dharmgyan'); ?>
                </h3>
                <p class="text-xs text-[#717171] mt-1.5 leading-relaxed">
                    <?php esc_html_e('Update your personal details, email address and account password.', 'dharmgyan'); ?>
                </p>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-bold text-[#CC5600] mt-4 group-hover:translate-x-1 transition-transform">
                <span><?php esc_html_e('Edit Details', 'dharmgyan'); ?></span>
                <span>→</span>
            </span>
        </a>

    </div>

    <!-- Recent Orders Section -->
    <div class="pt-4 border-t border-[#EAE3DC]">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="text-[#CC5600]">📦</span>
                <h3 class="font-serif text-lg md:text-xl font-bold text-[#111111]">
                    <?php esc_html_e('Recent Orders', 'dharmgyan'); ?>
                </h3>
            </div>
            <?php if (!empty($customer_orders)): ?>
                <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="text-xs font-bold text-[#CC5600] hover:text-[#B34B00] hover:underline">
                    <?php esc_html_e('View All Orders →', 'dharmgyan'); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($customer_orders)): ?>
            <!-- Recent Orders Table -->
            <div class="overflow-x-auto">
                <table class="woocommerce-orders-table">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Order', 'dharmgyan'); ?></th>
                            <th><?php esc_html_e('Date', 'dharmgyan'); ?></th>
                            <th><?php esc_html_e('Status', 'dharmgyan'); ?></th>
                            <th><?php esc_html_e('Total', 'dharmgyan'); ?></th>
                            <th class="text-right"><?php esc_html_e('Action', 'dharmgyan'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customer_orders as $order): 
                            $order_id   = $order->get_id();
                            $status     = $order->get_status();
                            $status_obj = wc_get_order_status_name($status);
                            $item_count = $order->get_item_count();
                        ?>
                            <tr>
                                <td class="font-bold text-[#111111]">
                                    <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="text-[#CC5600] hover:underline">
                                        #<?php echo esc_html($order->get_order_number()); ?>
                                    </a>
                                </td>
                                <td>
                                    <time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>">
                                        <?php echo esc_html(wc_format_datetime($order->get_date_created())); ?>
                                    </time>
                                </td>
                                <td>
                                    <span class="order-status-badge order-status-<?php echo esc_attr($status); ?>">
                                        <?php echo esc_html($status_obj); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo wp_kses_post(sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'dharmgyan'), $order->get_formatted_order_total(), $item_count)); ?>
                                </td>
                                <td class="text-right">
                                    <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="inline-flex items-center gap-1 text-xs font-semibold text-[#CC5600] hover:text-white bg-[#FFF0E2] hover:bg-[#CC5600] px-3 py-1.5 rounded-[4px] transition-colors">
                                        <span><?php esc_html_e('View', 'dharmgyan'); ?></span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <!-- Devotional Empty State -->
            <div class="p-8 md:p-12 text-center bg-[#FCFAF7] border border-[#EAE3DC] rounded-xl">
                <div class="w-14 h-14 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center mx-auto mb-3 text-2xl shadow-2xs">
                    🕉️
                </div>
                <h4 class="font-serif text-lg md:text-xl font-bold text-[#111111] mb-1.5">
                    <?php esc_html_e('No Sacred Orders Yet', 'dharmgyan'); ?>
                </h4>
                <p class="text-xs md:text-sm text-[#717171] max-w-md mx-auto mb-5 leading-relaxed">
                    <?php esc_html_e('You haven\'t placed any devotional orders yet. Bring sacred auspicious energy to your home with our handcrafted murtis, pure brass diyas, and authentic tulsi malas.', 'dharmgyan'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="inline-flex items-center gap-2 bg-[#CC5600] hover:bg-[#B34B00] text-white px-6 py-2.5 rounded-[6px] text-xs md:text-sm font-semibold transition-all shadow-sm">
                    <span><?php esc_html_e('Start Sacred Shopping', 'dharmgyan'); ?></span>
                    <span>→</span>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php do_action('woocommerce_account_dashboard'); ?>

</div>
