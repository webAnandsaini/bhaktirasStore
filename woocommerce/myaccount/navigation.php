<?php
/**
 * My Account navigation - Pixel-Perfect Spiritual Luxury Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

$current_user = wp_get_current_user();
$first_letter = strtoupper(substr($current_user->display_name, 0, 1));
$order_count = 0;
if (function_exists('wc_get_customer_order_count')) {
    $order_count = wc_get_customer_order_count($current_user->ID);
}

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation w-full lg:w-80 shrink-0 font-body mb-8 lg:mb-0" aria-label="<?php esc_attr_e('Account Navigation', 'dharmgyan'); ?>">
    
    <div class="myaccount-nav-card">
        
        <!-- User Profile Header Card -->
        <div class="myaccount-profile-header flex items-center gap-3.5">
            <div class="relative shrink-0">
                <div class="w-13 h-13 w-[52px] h-[52px] rounded-full bg-gradient-to-br from-[#FFF0E2] to-[#FFE0C2] border-2 border-[#CC5600] text-[#CC5600] flex items-center justify-center font-bold text-lg shadow-sm">
                    <?php echo esc_html($first_letter); ?>
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full" title="<?php esc_attr_e('Active Account', 'dharmgyan'); ?>"></span>
            </div>
            
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-1.5 flex-wrap">
                    <h2 class="text-[15px] font-bold text-[#111111] truncate leading-tight">
                        <?php echo esc_html($current_user->display_name); ?>
                    </h2>
                </div>
                <p class="text-xs text-[#717171] truncate mt-0.5" title="<?php echo esc_attr($current_user->user_email); ?>">
                    <?php echo esc_html($current_user->user_email); ?>
                </p>
                <div class="mt-1.5">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-[#CC5600] bg-[#FFF0E2] px-2 py-0.5 rounded-full">
                        <span>🕉️</span>
                        <span><?php esc_html_e('Devotee Member', 'dharmgyan'); ?></span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu List -->
        <div class="p-3">
            <ul class="space-y-1">
                <?php foreach (wc_get_account_menu_items() as $endpoint => $label): 
                    $is_current = is_account_page() && is_wc_endpoint_url($endpoint);
                    if ($endpoint === 'dashboard' && !is_wc_endpoint_url()) {
                        $is_current = true;
                    }
                ?>
                    <li class="myaccount-nav-item <?php echo $is_current ? 'is-active' : ''; ?> <?php echo esc_attr(wc_get_account_menu_item_classes($endpoint)); ?>">
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"
                           class="group">
                            
                            <div class="flex items-center gap-3">
                                <!-- Endpoint SVG Icons -->
                                <span class="nav-icon shrink-0 transition-transform group-hover:scale-110">
                                    <?php if ($endpoint === 'dashboard'): ?>
                                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                                            <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                                            <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                                            <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                                        </svg>
                                    <?php elseif ($endpoint === 'orders'): ?>
                                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                                            <line x1="12" y1="22.08" x2="12" y2="12"/>
                                        </svg>
                                    <?php elseif ($endpoint === 'downloads'): ?>
                                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="7 10 12 15 17 10"/>
                                            <line x1="12" y1="15" x2="12" y2="3"/>
                                        </svg>
                                    <?php elseif ($endpoint === 'edit-address'): ?>
                                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                    <?php elseif ($endpoint === 'edit-account'): ?>
                                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    <?php elseif ($endpoint === 'customer-logout'): ?>
                                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                            <polyline points="16 17 21 12 16 7"/>
                                            <line x1="21" y1="12" x2="9" y2="12"/>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="12" y1="8" x2="12" y2="12"/>
                                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                                        </svg>
                                    <?php endif; ?>
                                </span>

                                <span class="nav-label"><?php echo esc_html($label); ?></span>
                            </div>

                            <div class="flex items-center gap-2">
                                <?php if ($endpoint === 'orders' && $order_count > 0 && !$is_current): ?>
                                    <span class="text-[11px] font-bold bg-[#FFF0E2] text-[#CC5600] px-2 py-0.5 rounded-full">
                                        <?php echo esc_html($order_count); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="nav-chevron font-bold text-sm <?php echo $is_current ? 'text-white' : 'text-[#CCCCCC] group-hover:text-[#CC5600] group-hover:translate-x-0.5 transition-all'; ?>">›</span>
                            </div>

                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Customer Care Mini Banner in Sidebar -->
        <div class="p-3 pt-0">
            <div class="myaccount-support-card p-3.5 text-center">
                <div class="w-8 h-8 rounded-full bg-white text-[#CC5600] flex items-center justify-center mx-auto mb-2 shadow-2xs">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                        <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                    </svg>
                </div>
                <h3 class="text-xs font-bold text-[#111111] mb-1">
                    <?php esc_html_e('Need Assistance?', 'dharmgyan'); ?>
                </h3>
                <p class="text-[11px] text-[#717171] leading-relaxed mb-2.5">
                    <?php esc_html_e('Our support team is here to help with your sacred orders.', 'dharmgyan'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="inline-block text-[11px] font-bold text-[#CC5600] hover:text-[#B34B00] hover:underline">
                    <?php esc_html_e('Contact Support →', 'dharmgyan'); ?>
                </a>
            </div>
        </div>

    </div>

</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
