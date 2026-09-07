<?php
/**
 * Shop Archive — No Results Empty State Template Part
 *
 * Displayed both on initial page load (archive-product.php) and
 * injected via AJAX (ajax-shop-filter.php) when no products match filters.
 *
 * @package Dharmgyan
 */
?>

<div class="col-span-full py-16 text-center">
    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#FFF8F3] text-[#CC5600] flex items-center justify-center">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
    </div>
    <h3 class="font-serif text-2xl text-[#111111] font-normal">
        <?php esc_html_e('No products found', 'dharmgyan'); ?>
    </h3>
    <p class="text-[#717171] text-sm mt-2 max-w-xs mx-auto leading-relaxed">
        <?php esc_html_e('Try changing or clearing your selected filters to discover our sacred collection.', 'dharmgyan'); ?>
    </p>
    <button
        type="button"
        id="reset-all-filters-btn"
        class="mt-6 inline-flex items-center gap-2 bg-[#CC5600] text-white text-xs font-semibold px-6 py-2.5 rounded-[4px] hover:bg-[#B34B00] transition-colors shadow-sm"
    >
        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="1 4 1 10 7 10"></polyline>
            <path d="M3.51 15a9 9 0 1 0 .49-3.26"></path>
        </svg>
        <?php esc_html_e('Clear All Filters', 'dharmgyan'); ?>
    </button>
    <div class="mt-6">
        <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="text-sm text-[#CC5600] hover:text-[#B34B00] font-medium underline underline-offset-2 transition-colors">
            <?php esc_html_e('Browse All Products', 'dharmgyan'); ?>
        </a>
    </div>
</div>
