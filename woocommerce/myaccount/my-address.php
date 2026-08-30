<?php
/**
 * My Addresses - Pixel-Perfect Spiritual Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

$customer_id = get_current_user_id();

if (!wc_ship_to_billing_address_only() && wc_shipping_enabled()) {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing'  => __('Billing Address', 'dharmgyan'),
            'shipping' => __('Shipping Address', 'dharmgyan'),
        ),
        $customer_id
    );
} else {
    $get_addresses = apply_filters(
        'woocommerce_my_account_get_addresses',
        array(
            'billing' => __('Billing Address', 'dharmgyan'),
        ),
        $customer_id
    );
}
?>

<div class="my-addresses-wrapper font-body">
    
    <!-- Section Header -->
    <div class="mb-6">
        <h2 class="font-serif text-2xl md:text-[26px] text-[#111111] font-normal leading-tight mb-1.5">
            <?php esc_html_e('My Addresses', 'dharmgyan'); ?>
        </h2>
        <p class="text-xs md:text-sm text-[#666666]">
            <?php echo apply_filters('woocommerce_my_account_my_address_description', esc_html__('The following addresses will be used on the checkout page by default.', 'dharmgyan')); ?>
        </p>
    </div>

    <!-- 2-Column Address Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach ($get_addresses as $name => $address_title): ?>
            <?php
            $address = wc_get_account_formatted_address($name);
            $edit_url = wc_get_endpoint_url('edit-address', $name);
            $is_billing = ($name === 'billing');
            ?>
            <div class="address-card bg-white border border-[#EAE3DC] rounded-[8px] overflow-hidden shadow-2xs flex flex-col justify-between">
                
                <!-- Card Header -->
                <div class="bg-[#FCFAF7] border-b border-[#EAE3DC] px-5 py-3.5 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-[#FFF1E5] text-[#CC5600] flex items-center justify-center shrink-0">
                            <?php if ($is_billing): ?>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            <?php else: ?>
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-sm md:text-[15px] font-bold text-[#242424] font-body">
                            <?php echo esc_html($address_title); ?>
                        </h3>
                    </div>

                    <a href="<?php echo esc_url($edit_url); ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#CC5600] hover:text-white bg-[#FFF1E5] hover:bg-[#CC5600] px-3 py-1.5 rounded-[4px] transition-colors">
                        <?php if ($address): ?>
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            <span><?php esc_html_e('Edit', 'dharmgyan'); ?></span>
                        <?php else: ?>
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span><?php esc_html_e('Add', 'dharmgyan'); ?></span>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Card Body -->
                <div class="p-5 flex-1 text-xs md:text-sm text-[#444444] leading-relaxed">
                    <?php if ($address): ?>
                        <address class="not-italic">
                            <?php echo wp_kses_post($address); ?>
                        </address>
                    <?php else: ?>
                        <div class="text-[#888888] italic py-2">
                            <?php esc_html_e('You have not set up this type of address yet.', 'dharmgyan'); ?>
                        </div>
                    <?php endif; ?>

                    <?php do_action('woocommerce_my_account_after_my_address', $name); ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>
