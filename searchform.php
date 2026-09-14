<?php
/**
 * Global Search Form Template
 * Pixel-Perfect Dharmgyan Design with Saffron Accents (#CC5600)
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

$unique_id = wp_unique_id('search-form-');
$search_placeholder = isset($args['placeholder']) && !empty($args['placeholder']) 
    ? $args['placeholder'] 
    : __('Search products, pooja samagri, articles...', 'dharmgyan');
?>

<form role="search" method="get" class="search-form relative flex items-center w-full max-w-2xl mx-auto" action="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Site Search', 'dharmgyan'); ?>">
    <label for="<?php echo esc_attr($unique_id); ?>" class="sr-only">
        <?php esc_html_e('Search', 'dharmgyan'); ?>
    </label>
    
    <div class="relative w-full flex items-center">
        <!-- Search Icon on Left -->
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#737373] pointer-events-none" aria-hidden="true">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </span>

        <!-- Search Input -->
        <input 
            type="search" 
            id="<?php echo esc_attr($unique_id); ?>" 
            class="w-full h-[50px] pl-11 pr-28 text-[15px] bg-white text-[#111111] border border-[#D4D4D4] rounded-[6px] focus:outline-none focus:border-[#CC5600] focus:ring-1 focus:ring-[#CC5600] transition-all placeholder-[#888888] font-body shadow-xs" 
            placeholder="<?php echo esc_attr($search_placeholder); ?>" 
            value="<?php echo get_search_query(); ?>" 
            name="s" 
            required
            autocomplete="off"
        />

        <!-- Default to searching products if WooCommerce is installed -->
        <?php if (class_exists('WooCommerce')): ?>
            <input type="hidden" name="post_type" value="product" />
        <?php endif; ?>

        <!-- Saffron Submit Button -->
        <button 
            type="submit" 
            class="absolute right-1.5 top-1.5 bottom-1.5 px-5 bg-[#CC5600] hover:bg-[#B34700] text-white text-sm font-medium rounded-[4px] transition-colors flex items-center justify-center gap-1.5 shadow-xs cursor-pointer font-body"
        >
            <span><?php esc_html_e('Search', 'dharmgyan'); ?></span>
        </button>
    </div>
</form>
