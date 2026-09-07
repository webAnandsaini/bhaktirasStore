<?php
/**
 * Lost password form
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_lost_password_form');
?>

<div class="lost-password-wrapper bg-white min-h-screen py-10 md:py-16 font-body">
    <div class="max-w-md mx-auto px-4">
        
        <div class="border border-[#EAE3DC] rounded-[6px] p-6 md:p-8 bg-[#FCFAF7] shadow-2xs">
            
            <h1 class="font-body text-xl font-bold text-[#111111] pb-3 border-b border-[#EAE3DC] mb-4 text-center">
                <?php esc_html_e('Reset Your Password', 'dharmgyan'); ?>
            </h1>

            <p class="text-xs md:text-sm text-[#717171] leading-relaxed mb-6">
                <?php echo apply_filters('woocommerce_lost_password_message', esc_html__('Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'dharmgyan')); ?>
            </p>

            <form method="post" class="woocommerce-ResetPassword lost_reset_password space-y-4">

                <div>
                    <label for="user_login" class="block text-xs font-semibold text-[#111111] mb-1.5"><?php esc_html_e('Username or email', 'dharmgyan'); ?> <span class="text-red-500">*</span></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" type="text" name="user_login" id="user_login" autocomplete="username" required />
                </div>

                <?php do_action('woocommerce_lostpassword_form'); ?>

                <div class="pt-2">
                    <input type="hidden" name="wc_reset_password" value="true" />
                    <button type="submit" class="woocommerce-Button button w-full h-[48px] bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-sm rounded-[4px] shadow-sm transition-colors cursor-pointer flex items-center justify-center" value="<?php esc_attr_e('Reset password', 'dharmgyan'); ?>">
                        <?php esc_html_e('Reset password', 'dharmgyan'); ?>
                    </button>
                </div>

                <div class="text-center pt-2">
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="text-xs text-[#717171] hover:text-[#CC5600] transition-colors">
                        ← <?php esc_html_e('Back to Login', 'dharmgyan'); ?>
                    </a>
                </div>

                <?php wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>

            </form>

        </div>

    </div>
</div>

<?php do_action('woocommerce_after_lost_password_form'); ?>
