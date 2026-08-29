<?php
/**
 * Empty cart page template
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;
?>

<div class="cart-empty-wrapper bg-white py-16 md:py-24 text-center font-body min-h-[60vh] flex flex-col items-center justify-center">
    <div class="max-w-md mx-auto px-4">
        
        <!-- Sacred Bag Empty Illustration -->
        <div class="w-20 h-20 mx-auto rounded-full bg-[#FFF9F4] border border-[#F5EBE1] flex items-center justify-center text-[#CC5600] mb-6 shadow-xs">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        </div>

        <h2 class="font-body text-2xl md:text-3xl font-semibold text-[#111111] mb-2">
            <?php esc_html_e('Your shopping bag is empty', 'dharmgyan'); ?>
        </h2>
        
        <p class="text-sm md:text-base text-[#717171] leading-relaxed mb-8">
            <?php esc_html_e('Bring divine grace, peace, and prosperity into your home. Explore our authentic sacred idols, puja essentials, and wall art.', 'dharmgyan'); ?>
        </p>

        <a 
            href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" 
            class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-sm md:text-base rounded-[4px] shadow-sm transition-colors"
        >
            <span><?php esc_html_e('Explore Collections', 'dharmgyan'); ?></span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>

    </div>
</div>
