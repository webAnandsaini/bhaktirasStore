<?php
/**
 * Site Search Bar Template Part - Pixel Perfect Figma
 * 
 * @package Dharmgyan
 */
?>
<div class="site-search-form flex-1 max-w-[735px] mx-auto px-2 lg:px-6">
    <form role="search" method="get" class="relative flex items-center w-full" action="<?php echo esc_url(home_url('/')); ?>">
        <label for="header-search-input" class="sr-only"><?php esc_html_e('Search products', 'dharmgyan'); ?></label>
        <input 
            id="header-search-input"
            type="search" 
            name="s" 
            value="<?php echo get_search_query(); ?>" 
            placeholder="<?php esc_attr_e('Search here', 'dharmgyan'); ?>" 
            class="w-full h-[43px] pl-4 pr-11 text-[14px] font-sub bg-white text-[#111111] border border-[#D4D4D4] rounded-[4px] focus:outline-none focus:ring-1 focus:ring-[#CC5600] focus:border-[#CC5600] transition-all placeholder-[#9E9E9E]"
            autocomplete="off"
        />
        <input type="hidden" name="post_type" value="product" />
        <button 
            type="submit" 
            class="absolute right-0 top-0 bottom-0 px-3.5 flex items-center justify-center text-[#737373] hover:text-[#CC5600] transition-colors"
            aria-label="<?php esc_attr_e('Submit Search', 'dharmgyan'); ?>"
        >
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </button>
    </form>
</div>
