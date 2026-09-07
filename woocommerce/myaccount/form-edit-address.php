<?php
/**
 * Edit address form - Pixel-Perfect Spiritual Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

$page_title = ('billing' === $load_address) ? esc_html__('Billing Address', 'dharmgyan') : esc_html__('Shipping Address', 'dharmgyan');

do_action('woocommerce_before_edit_account_address_form');
?>

<?php if (!$load_address): ?>
    <?php wc_get_template('myaccount/my-address.php'); ?>
<?php else: ?>

    <div class="edit-address-form-wrapper max-w-3xl font-body">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-[#EAE3DC]">
            <div>
                <h2 class="font-serif text-2xl text-[#111111] font-normal leading-tight">
                    <?php echo apply_filters('woocommerce_my_account_edit_address_title', $page_title, $load_address); ?>
                </h2>
                <p class="text-xs text-[#666666] mt-1">
                    <?php esc_html_e('Please update your delivery and contact details below.', 'dharmgyan'); ?>
                </p>
            </div>
            <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="text-xs text-[#717171] hover:text-[#CC5600] flex items-center gap-1 font-medium transition-colors">
                ← <?php esc_html_e('Back to Addresses', 'dharmgyan'); ?>
            </a>
        </div>

        <form method="post" novalidate class="woocommerce-EditAddressForm space-y-4">
            
            <div class="woocommerce-address-fields">
                <?php do_action("woocommerce_before_edit_address_form_{$load_address}"); ?>

                <div class="woocommerce-address-fields__field-wrapper space-y-3">
                    <?php
                    foreach ($address as $key => $field) {
                        woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
                    }
                    ?>
                </div>

                <?php do_action("woocommerce_after_edit_address_form_{$load_address}"); ?>

                <div class="pt-4 mt-4 border-t border-[#EAE3DC] flex items-center gap-3">
                    <button type="submit" class="button bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-sm px-6 py-2.5 rounded-[4px] transition-colors cursor-pointer shadow-sm" name="save_address" value="<?php esc_attr_e('Save Address', 'dharmgyan'); ?>">
                        <?php esc_html_e('Save Address', 'dharmgyan'); ?>
                    </button>
                    <a href="<?php echo esc_url(wc_get_endpoint_url('edit-address')); ?>" class="text-xs text-[#666666] hover:text-[#242424] px-3 py-2">
                        <?php esc_html_e('Cancel', 'dharmgyan'); ?>
                    </a>
                    <?php wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
                    <input type="hidden" name="action" value="edit_address" />
                </div>
            </div>

        </form>

    </div>

<?php endif; ?>

<?php do_action('woocommerce_after_edit_account_address_form'); ?>
