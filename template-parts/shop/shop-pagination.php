<?php
/**
 * Shop Archive AJAX Pagination Component - Pixel-Perfect Figma
 *
 * @package Dharmgyan
 */

if (!isset($current_page) || empty($current_page)) {
    $current_page = max(1, get_query_var('paged'));
}

if (!isset($total_pages) || empty($total_pages)) {
    global $wp_query;
    $total_pages = isset($wp_query->max_num_pages) ? (int) $wp_query->max_num_pages : 1;
}

if ($total_pages <= 1) {
    return;
}
?>

<nav class="shop-ajax-pagination flex items-center justify-center gap-2 pt-8 pb-4" aria-label="<?php esc_attr_e('Products Pagination', 'dharmgyan'); ?>">
    <!-- Previous Page Button -->
    <?php if ($current_page > 1): ?>
        <button 
            type="button" 
            data-page="<?php echo esc_attr($current_page - 1); ?>" 
            class="pagination-btn flex items-center justify-center w-10 h-10 rounded-[4px] border border-[#E5E5E5] text-[#444444] hover:border-[#CC5600] hover:text-[#CC5600] font-medium text-sm transition-colors cursor-pointer"
            aria-label="<?php esc_attr_e('Previous Page', 'dharmgyan'); ?>"
        >
            <svg class="w-4 h-4 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
        </button>
    <?php endif; ?>

    <!-- Page Number Buttons -->
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <?php if ($i == $current_page): ?>
            <span class="flex items-center justify-center w-10 h-10 rounded-[4px] bg-[#CC5600] text-white font-medium text-sm shadow-sm select-none" aria-current="page">
                <?php echo esc_html($i); ?>
            </span>
        <?php elseif ($i == 1 || $i == $total_pages || ($i >= $current_page - 2 && $i <= $current_page + 2)): ?>
            <button 
                type="button" 
                data-page="<?php echo esc_attr($i); ?>" 
                class="pagination-btn flex items-center justify-center w-10 h-10 rounded-[4px] border border-[#E5E5E5] text-[#444444] hover:border-[#CC5600] hover:text-[#CC5600] font-medium text-sm transition-colors cursor-pointer"
            >
                <?php echo esc_html($i); ?>
            </button>
        <?php elseif ($i == $current_page - 3 || $i == $current_page + 3): ?>
            <span class="flex items-center justify-center w-8 h-10 text-[#717171] font-medium text-sm select-none">...</span>
        <?php endif; ?>
    <?php endfor; ?>

    <!-- Next Page Button -->
    <?php if ($current_page < $total_pages): ?>
        <button 
            type="button" 
            data-page="<?php echo esc_attr($current_page + 1); ?>" 
            class="pagination-btn flex items-center justify-center w-10 h-10 rounded-[4px] border border-[#E5E5E5] text-[#444444] hover:border-[#CC5600] hover:text-[#CC5600] transition-colors cursor-pointer"
            aria-label="<?php esc_attr_e('Next Page', 'dharmgyan'); ?>"
        >
            <svg class="w-4 h-4 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </button>
    <?php endif; ?>
</nav>
