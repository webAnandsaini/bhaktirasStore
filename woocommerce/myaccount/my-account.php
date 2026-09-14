<?php
/**
 * My Account page layout - Pixel-Perfect Spiritual Luxury Design
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;
?>

<div class="myaccount-page-wrapper bg-[#FAF8F5] min-h-screen">
    
    <!-- Full-Width Centered Breadcrumb Bar matching Figma -->
    <div class="myaccount-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-10">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#717171] select-none mx-0.5">›</span>
            <span class="text-[#CC5600] font-medium"><?php esc_html_e('My Account', 'dharmgyan'); ?></span>
        </div>
    </div>

    <div class="max-w-[1480px] mx-auto px-4 pb-20">
        
        <!-- Page Title & Sacred Header -->
        <div class="mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#FFF0E2] text-[#CC5600] text-xs font-semibold mb-2">
                <span>🕉️</span>
                <span><?php esc_html_e('Sacred Member Portal', 'dharmgyan'); ?></span>
            </div>
            <h1 class="font-serif text-2xl md:text-4xl text-[#111111] font-bold leading-tight">
                <?php esc_html_e('My Account', 'dharmgyan'); ?>
            </h1>
            <p class="text-sm md:text-[15px] text-[#717171] mt-1 font-body">
                <?php esc_html_e('Manage your sacred orders, saved delivery addresses, and personal profile.', 'dharmgyan'); ?>
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 xl:gap-10 items-start font-body">
            
            <?php
            /**
             * My Account navigation.
             * @hooked woocommerce_account_navigation - 10
             */
            do_action('woocommerce_account_navigation');
            ?>

            <div class="woocommerce-MyAccount-content flex-1 w-full min-w-0 myaccount-content-card">
                <?php
                /**
                 * My Account content.
                 * @hooked woocommerce_account_content - 10
                 */
                do_action('woocommerce_account_content');
                ?>
            </div>

        </div>

    </div>

</div>
