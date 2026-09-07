<?php
/**
 * My Account dashboard
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

$allowed_html = array(
    'a' => array(
        'href' => array(),
    ),
);
?>

<div class="myaccount-dashboard font-body">
    
    <!-- Welcome Card -->
    <div class="p-6 bg-[#FCFAF7] border border-[#EAE3DC] rounded-[6px] mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center font-bold text-lg">
                <?php echo esc_html(strtoupper(substr($current_user->display_name, 0, 1))); ?>
            </div>
            <div>
                <h2 class="font-body text-xl font-bold text-[#111111]">
                    <?php printf(esc_html__('Hello, %s!', 'dharmgyan'), esc_html($current_user->display_name)); ?>
                </h2>
                <p class="text-xs text-[#717171] mt-0.5">
                    <?php printf(
                        /* translators: 1: user display name 2: logout url */
                        wp_kses(__('Not %1$s? <a href="%2$s" class="text-[#CC5600] hover:underline font-medium">Log out</a>', 'dharmgyan'), $allowed_html),
                        '<strong>' . esc_html($current_user->display_name) . '</strong>',
                        esc_url(wc_logout_url())
                    ); ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        
        <a href="<?php echo esc_url(wc_get_endpoint_url('orders')); ?>" class="p-5 border border-[#EAE3DC] rounded-[6px] hover:border-[#CC5600] transition-colors group bg-white">
            <div class="w-10 h-10 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <h3 class="font-bold text-sm text-[#111111] group-hover:text-[#CC5600] transition-colors"><?php esc_html_e('Orders', 'dharmgyan'); ?></h3>
            <p class="text-xs text-[#717171] mt-1"><?php esc_html_e('Track and view past sacred orders', 'dharmgyan'); ?></p>
        </a>

        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="p-5 border border-[#EAE3DC] rounded-[6px] hover:border-[#CC5600] transition-colors group bg-white">
            <div class="w-10 h-10 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h3 class="font-bold text-sm text-[#111111] group-hover:text-[#CC5600] transition-colors"><?php esc_html_e('Addresses', 'dharmgyan'); ?></h3>
            <p class="text-xs text-[#717171] mt-1"><?php esc_html_e('Manage delivery & billing addresses', 'dharmgyan'); ?></p>
        </a>

        <a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="p-5 border border-[#EAE3DC] rounded-[6px] hover:border-[#CC5600] transition-colors group bg-white">
            <div class="w-10 h-10 rounded-full bg-[#FFF0E2] text-[#CC5600] flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h3 class="font-bold text-sm text-[#111111] group-hover:text-[#CC5600] transition-colors"><?php esc_html_e('Account Details', 'dharmgyan'); ?></h3>
            <p class="text-xs text-[#717171] mt-1"><?php esc_html_e('Update password and personal details', 'dharmgyan'); ?></p>
        </a>

    </div>

    <?php
    do_action('woocommerce_account_dashboard');
    ?>

</div>
