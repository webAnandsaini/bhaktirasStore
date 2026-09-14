<?php
/**
 * Edit account form - Pixel-Perfect Spiritual Luxury Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_edit_account_form');
?>

<div class="edit-account-wrapper max-w-3xl font-body">
    
    <!-- Header -->
    <div class="mb-6 pb-4 border-b border-[#EAE3DC]">
        <h2 class="font-serif text-2xl md:text-[26px] text-[#111111] font-normal leading-tight mb-1">
            <?php esc_html_e('Account & Security Details', 'dharmgyan'); ?>
        </h2>
        <p class="text-xs md:text-sm text-[#717171]">
            <?php esc_html_e('Update your personal details, email address, and security password.', 'dharmgyan'); ?>
        </p>
    </div>

    <form class="woocommerce-EditAccountForm edit-account space-y-5" action="" method="post" <?php do_action('woocommerce_edit_account_form_tag'); ?>>
        
        <?php do_action('woocommerce_edit_account_form_start'); ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="account_first_name" class="block text-xs font-semibold text-[#111111] mb-1.5">
                    <?php esc_html_e('First name', 'dharmgyan'); ?> <span class="text-red-500">*</span>
                </label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr($user->first_name); ?>" required />
            </div>

            <div>
                <label for="account_last_name" class="block text-xs font-semibold text-[#111111] mb-1.5">
                    <?php esc_html_e('Last name', 'dharmgyan'); ?> <span class="text-red-500">*</span>
                </label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr($user->last_name); ?>" required />
            </div>
        </div>

        <div>
            <label for="account_display_name" class="block text-xs font-semibold text-[#111111] mb-1.5">
                <?php esc_html_e('Display name', 'dharmgyan'); ?> <span class="text-red-500">*</span>
            </label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" required />
            <span class="text-[11px] text-[#888888] mt-1 block">
                <?php esc_html_e('This is how your name will appear in the account header and sacred product reviews.', 'dharmgyan'); ?>
            </span>
        </div>

        <div>
            <label for="account_email" class="block text-xs font-semibold text-[#111111] mb-1.5">
                <?php esc_html_e('Email address', 'dharmgyan'); ?> <span class="text-red-500">*</span>
            </label>
            <input type="email" class="woocommerce-Input woocommerce-Input--email input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr($user->user_email); ?>" required />
        </div>

        <?php do_action('woocommerce_edit_account_form_fields'); ?>

        <!-- Password Change Card -->
        <fieldset class="p-5 bg-[#FCFAF7] border border-[#EAE3DC] rounded-[8px] space-y-4">
            <legend class="text-sm font-bold text-[#111111] px-2">
                🔒 <?php esc_html_e('Change Password', 'dharmgyan'); ?>
            </legend>

            <div>
                <label for="password_current" class="block text-xs font-semibold text-[#111111] mb-1.5">
                    <?php esc_html_e('Current password (leave blank to leave unchanged)', 'dharmgyan'); ?>
                </label>
                <input type="password" class="woocommerce-Input woocommerce-Input--password input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="password_current" id="password_current" autocomplete="current-password" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password_1" class="block text-xs font-semibold text-[#111111] mb-1.5">
                        <?php esc_html_e('New password', 'dharmgyan'); ?>
                    </label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="password_1" id="password_1" autocomplete="new-password" />
                </div>

                <div>
                    <label for="password_2" class="block text-xs font-semibold text-[#111111] mb-1.5">
                        <?php esc_html_e('Confirm new password', 'dharmgyan'); ?>
                    </label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="password_2" id="password_2" autocomplete="new-password" />
                </div>
            </div>
        </fieldset>

        <?php do_action('woocommerce_edit_account_form'); ?>

        <div class="pt-4 border-t border-[#EAE3DC] flex items-center gap-4">
            <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
            <button type="submit" class="bg-[#CC5600] hover:bg-[#B34B00] text-white font-semibold text-sm px-6 py-2.5 rounded-[4px] transition-colors shadow-sm cursor-pointer" name="save_account_details" value="<?php esc_attr_e('Save changes', 'dharmgyan'); ?>">
                <?php esc_html_e('Save Changes', 'dharmgyan'); ?>
            </button>
            <input type="hidden" name="action" value="save_account_details" />
        </div>

        <?php do_action('woocommerce_edit_account_form_end'); ?>

    </form>

</div>

<?php do_action('woocommerce_after_edit_account_form'); ?>
