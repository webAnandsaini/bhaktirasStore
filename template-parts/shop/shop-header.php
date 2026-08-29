<?php
/**
 * Shop Archive Header & Sorting Bar Component - Pixel-Perfect Figma
 *
 * @package Dharmgyan
 */

$archive_title = woocommerce_page_title(false);
?>

<div class="shop-archive-header mb-6">

    <!-- Main Title & Controls Row -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-[#E5E5E5]">
        <div>
            <h1 class="font-body text-2xl md:text-[26px] text-[#111111] font-medium leading-tight">
                <?php echo esc_html($archive_title ?: __('Modern Wall Art', 'dharmgyan')); ?>
            </h1>
            <p id="shop-products-count" class="text-xs md:text-sm text-[#717171] font-body mt-1">
                <?php
                global $wp_query;
                $total_count = $wp_query->found_posts;
                $paged       = max(1, get_query_var('paged'));
                $per_page    = (int) get_option('posts_per_page', 12);
                $start_index = ($paged - 1) * $per_page + 1;
                $end_index   = min($paged * $per_page, $total_count);
                if ($total_count > 0) {
                    printf(esc_html__('Showing %1$d–%2$d of %3$d results', 'dharmgyan'), $start_index, $end_index, $total_count);
                } else {
                    esc_html_e('Showing 0 results', 'dharmgyan');
                }
                ?>
            </p>
        </div>

        <!-- Controls: Mobile Filter Toggle + Sort Select -->
        <div class="flex items-center gap-3 shrink-0">

            <!-- Mobile Filter Toggle Button -->
            <button
                type="button"
                id="mobile-filter-drawer-toggle"
                class="lg:hidden inline-flex items-center gap-2 px-4 py-2.5 bg-[#FFF8F3] border border-[#EAE3DC] text-[#CC5600] rounded-[4px] text-xs font-semibold hover:bg-[#CC5600] hover:text-white hover:border-[#CC5600] transition-colors"
                aria-expanded="false"
                aria-controls="mobile-filter-drawer"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <line x1="4" y1="21" x2="4" y2="14"></line>
                    <line x1="4" y1="10" x2="4" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12" y2="3"></line>
                    <line x1="20" y1="21" x2="20" y2="16"></line>
                    <line x1="20" y1="12" x2="20" y2="3"></line>
                    <line x1="1" y1="14" x2="7" y2="14"></line>
                    <line x1="9" y1="8" x2="15" y2="8"></line>
                    <line x1="17" y1="16" x2="23" y2="16"></line>
                </svg>
                <span><?php esc_html_e('Filters', 'dharmgyan'); ?></span>
                <span id="mobile-filter-count" class="hidden items-center justify-center w-4 h-4 bg-[#CC5600] text-white text-[10px] font-bold rounded-full"></span>
            </button>

            <!-- Sort By Select -->
            <div class="flex items-center gap-2">
                <label for="shop-orderby-select" class="hidden sm:inline-block text-xs text-[#717171] font-body whitespace-nowrap"><?php esc_html_e('Sort by:', 'dharmgyan'); ?></label>
                <div class="relative">
                    <select
                        id="shop-orderby-select"
                        class="appearance-none bg-white border border-[#CCCCCC] text-[#444444] text-xs font-medium py-2 pl-3 pr-8 rounded-[4px] focus:border-[#CC5600] focus:outline-none cursor-pointer"
                        aria-label="<?php esc_attr_e('Sort products', 'dharmgyan'); ?>"
                    >
                        <option value="menu_order"><?php esc_html_e('Featured', 'dharmgyan'); ?></option>
                        <option value="popularity"><?php esc_html_e('Best Selling', 'dharmgyan'); ?></option>
                        <option value="rating"><?php esc_html_e('Average rating', 'dharmgyan'); ?></option>
                        <option value="latest"><?php esc_html_e('Latest', 'dharmgyan'); ?></option>
                        <option value="price-asc"><?php esc_html_e('Price: low to high', 'dharmgyan'); ?></option>
                        <option value="price-desc"><?php esc_html_e('Price: high to low', 'dharmgyan'); ?></option>
                    </select>
                    <svg class="w-3.5 h-3.5 text-[#717171] absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>

        </div>
    </div>

    <!-- Active Filter Chips Container (populated by JS) -->
    <div id="active-filter-chips" class="hidden flex-wrap items-center gap-2 pt-3">
        <!-- Dynamically injected via shop-filter.js -->
    </div>

</div>
