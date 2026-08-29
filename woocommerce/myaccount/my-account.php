<?php
/**
 * My Account page layout
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;
?>

<div class="myaccount-page-wrapper bg-white min-h-screen">
    
    <!-- Full-Width Centered Breadcrumb Bar -->
    <div class="myaccount-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]"><?php esc_html_e('My Account', 'dharmgyan'); ?></span>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 pb-16">
        
        <div class="flex flex-col lg:flex-row gap-8 xl:gap-12 items-start font-body">
            
            <?php
            /**
             * My Account navigation.
             * @hooked woocommerce_account_navigation - 10
             */
            do_action('woocommerce_account_navigation');
            ?>

            <div class="woocommerce-MyAccount-content flex-1 w-full min-w-0 bg-white border border-[#EAE3DC] rounded-[6px] p-6 md:p-8 shadow-2xs">
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
