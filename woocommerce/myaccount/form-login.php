<?php
/**
 * Login / Register Form Template - Pixel-Perfect Figma Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_customer_login_form'); ?>

<div class="myaccount-auth-wrapper bg-white min-h-screen">
    
    <!-- Full-Width Centered Breadcrumb Bar -->
    <div class="myaccount-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]"><?php esc_html_e('My Account', 'dharmgyan'); ?></span>
        </div>
    </div>

    <div class="max-w-[1100px] mx-auto px-4 pb-16 font-body">

        <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')): ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 xl:gap-12" id="customer_login">

            <!-- Login Card -->
            <div class="border border-[#EAE3DC] rounded-[6px] p-6 md:p-8 bg-[#FCFAF7] shadow-2xs">
                
                <h2 class="font-body text-xl font-bold text-[#111111] pb-3 border-b border-[#EAE3DC] mb-6">
                    <?php esc_html_e('Login to Your Account', 'dharmgyan'); ?>
                </h2>

                <form class="woocommerce-form woocommerce-form-login login space-y-4" method="post">
                    <?php do_action('woocommerce_login_form_start'); ?>

                    <div>
                        <label for="username" class="block text-xs font-semibold text-[#111111] mb-1.5"><?php esc_html_e('Username or email address', 'dharmgyan'); ?> <span class="text-red-500">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-semibold text-[#111111]"><?php esc_html_e('Password', 'dharmgyan'); ?> <span class="text-red-500">*</span></label>
                            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text-xs text-[#CC5600] hover:underline font-medium"><?php esc_html_e('Lost password?', 'dharmgyan'); ?></a>
                        </div>
                        <input class="woocommerce-Input woocommerce-Input--text input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" type="password" name="password" id="password" autocomplete="current-password" required />
                    </div>

                    <?php do_action('woocommerce_login_form'); ?>

                    <div class="flex items-center justify-between pt-1">
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline-flex items-center gap-2 cursor-pointer text-xs text-[#444444] select-none">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox rounded text-[#CC5600] focus:ring-[#CC5600]" name="rememberme" type="checkbox" id="rememberme" value="forever" />
                            <span><?php esc_html_e('Remember me', 'dharmgyan'); ?></span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                        <button type="submit" class="woocommerce-button button woocommerce-form-login__submit w-full h-[48px] bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-sm rounded-[4px] shadow-sm transition-colors cursor-pointer flex items-center justify-center" name="login" value="<?php esc_attr_e('Log in', 'dharmgyan'); ?>">
                            <?php esc_html_e('Log in', 'dharmgyan'); ?>
                        </button>
                    </div>

                    <?php do_action('woocommerce_login_form_end'); ?>
                </form>

            </div>

            <!-- Register Card -->
            <div class="border border-[#EAE3DC] rounded-[6px] p-6 md:p-8 bg-white shadow-2xs">
                
                <h2 class="font-body text-xl font-bold text-[#111111] pb-3 border-b border-[#EAE3DC] mb-6">
                    <?php esc_html_e('Create a New Account', 'dharmgyan'); ?>
                </h2>

                <form method="post" class="woocommerce-form woocommerce-form-register register space-y-4" <?php do_action('woocommerce_register_form_tag'); ?>>
                    <?php do_action('woocommerce_register_form_start'); ?>

                    <?php if ('no' === get_option('woocommerce_registration_generate_username')): ?>
                        <div>
                            <label for="reg_username" class="block text-xs font-semibold text-[#111111] mb-1.5"><?php esc_html_e('Username', 'dharmgyan'); ?> <span class="text-red-500">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" required />
                        </div>
                    <?php endif; ?>

                    <div>
                        <label for="reg_email" class="block text-xs font-semibold text-[#111111] mb-1.5"><?php esc_html_e('Email address', 'dharmgyan'); ?> <span class="text-red-500">*</span></label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" required />
                    </div>

                    <?php if ('no' === get_option('woocommerce_registration_generate_password')): ?>
                        <div>
                            <label for="reg_password" class="block text-xs font-semibold text-[#111111] mb-1.5"><?php esc_html_e('Password', 'dharmgyan'); ?> <span class="text-red-500">*</span></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="password" id="reg_password" autocomplete="new-password" required />
                        </div>
                    <?php else: ?>
                        <p class="text-xs text-[#717171] leading-relaxed"><?php esc_html_e('A link to set a new password will be sent to your email address.', 'dharmgyan'); ?></p>
                    <?php endif; ?>

                    <?php do_action('woocommerce_register_form'); ?>

                    <div class="pt-2">
                        <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                        <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit w-full h-[48px] bg-[#242424] hover:bg-black text-white font-medium text-sm rounded-[4px] shadow-sm transition-colors cursor-pointer flex items-center justify-center" name="register" value="<?php esc_attr_e('Register', 'dharmgyan'); ?>">
                            <?php esc_html_e('Register', 'dharmgyan'); ?>
                        </button>
                    </div>

                    <?php do_action('woocommerce_register_form_end'); ?>
                </form>

            </div>

        </div>

        <?php else: ?>

        <!-- Single Centered Login Card if registration is disabled -->
        <div class="max-w-md mx-auto border border-[#EAE3DC] rounded-[6px] p-6 md:p-8 bg-[#FCFAF7] shadow-2xs">
            <h2 class="font-body text-xl font-bold text-[#111111] pb-3 border-b border-[#EAE3DC] mb-6 text-center">
                <?php esc_html_e('Login to Your Account', 'dharmgyan'); ?>
            </h2>
            <form class="woocommerce-form woocommerce-form-login login space-y-4" method="post">
                <?php do_action('woocommerce_login_form_start'); ?>
                <div>
                    <label for="username" class="block text-xs font-semibold text-[#111111] mb-1.5"><?php esc_html_e('Username or email address', 'dharmgyan'); ?> <span class="text-red-500">*</span></label>
                    <input type="text" class="input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" name="username" id="username" required />
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-[#111111]"><?php esc_html_e('Password', 'dharmgyan'); ?> <span class="text-red-500">*</span></label>
                        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="text-xs text-[#CC5600] hover:underline"><?php esc_html_e('Lost password?', 'dharmgyan'); ?></a>
                    </div>
                    <input class="input-text w-full px-3.5 py-2.5 text-sm text-[#111111] border border-[#CCCCCC] rounded-[4px] focus:border-[#CC5600] focus:outline-none bg-white" type="password" name="password" id="password" required />
                </div>
                <div class="pt-2">
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <button type="submit" class="button w-full h-[48px] bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-sm rounded-[4px] shadow-sm transition-colors cursor-pointer" name="login" value="<?php esc_attr_e('Log in', 'dharmgyan'); ?>">
                        <?php esc_html_e('Log in', 'dharmgyan'); ?>
                    </button>
                </div>
                <?php do_action('woocommerce_login_form_end'); ?>
            </form>
        </div>

        <?php endif; ?>

    </div>

</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>
