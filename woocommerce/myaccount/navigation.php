<?php
/**
 * My Account navigation
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation w-full lg:w-64 shrink-0 font-body mb-8 lg:mb-0">
    <div class="border border-[#EAE3DC] rounded-[6px] p-4 bg-[#FCFAF7] shadow-2xs">
        <div class="pb-3 mb-3 border-b border-[#EAE3DC] px-2">
            <span class="text-xs text-[#717171] uppercase tracking-wider block font-semibold"><?php esc_html_e('Account Menu', 'dharmgyan'); ?></span>
        </div>
        <ul class="space-y-1">
            <?php foreach (wc_get_account_menu_items() as $endpoint => $label): 
                $is_current = is_account_page() && is_wc_endpoint_url($endpoint);
                if ($endpoint === 'dashboard' && !is_wc_endpoint_url()) {
                    $is_current = true;
                }
            ?>
                <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                    <a 
                        href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>" 
                        class="flex items-center justify-between px-3.5 py-2.5 rounded-[4px] text-xs md:text-sm font-medium transition-all <?php echo $is_current ? 'bg-[#CC5600] text-white shadow-xs' : 'text-[#444444] hover:bg-[#FFF9F4] hover:text-[#CC5600]'; ?>"
                    >
                        <span><?php echo esc_html($label); ?></span>
                        <span class="<?php echo $is_current ? 'text-white' : 'text-[#CCCCCC]'; ?>">›</span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>
