<?php
/**
 * Template Name: My Wishlist
 * 
 * Pixel-Perfect My Wishlist page matching Figma (401:2423).
 * Integrated with YITH WooCommerce Wishlist with zero hardcoded default values.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();

// Fetch ACF pre-footer toggles
$show_discount_sale     = get_field('show_discount_sale');
$show_trending_products = get_field('show_trending_products');
$show_testimonials      = get_field('show_testimonials');
$show_trust_badges      = get_field('show_trust_badges');

// Retrieve YITH Wishlist items safely
$wishlist_items = array();
if (class_exists('YITH_WCWL_Wishlist_Factory')) {
    $current_wishlist = YITH_WCWL_Wishlist_Factory::get_current_wishlist();
    if ($current_wishlist && method_exists($current_wishlist, 'get_items')) {
        $wishlist_items = $current_wishlist->get_items();
    }
}
$item_count = count($wishlist_items);
?>

<main id="primary" class="site-main wishlist-page bg-white min-h-screen font-body">

    <!-- Breadcrumb Bar matching Figma Section -->
    <div class="page-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]"><?php esc_html_e('My wishlist', 'dharmgyan'); ?></span>
        </div>
    </div>

    <div class="max-w-[1580px] mx-auto px-4 sm:px-6 lg:px-8 pb-16 md:pb-24">

        <!-- Header & Wishlist Toolbar matching Figma -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-[#F0EAE4]">
            
            <h1 class="text-3xl sm:text-4xl font-serif text-[#111111] font-medium tracking-tight">
                <?php esc_html_e('My wishlist', 'dharmgyan'); ?>
            </h1>

            <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                
                <!-- Search Products Input -->
                <div class="relative min-w-[240px] sm:min-w-[280px]">
                    <label for="wishlist-search-input" class="sr-only"><?php esc_html_e('Search products in wishlist', 'dharmgyan'); ?></label>
                    <input type="text" id="wishlist-search-input" placeholder="<?php esc_attr_e('Search Products', 'dharmgyan'); ?>" class="w-full pl-4 pr-10 py-2.5 rounded-lg border border-[#D5D5D5] focus:border-[#CC5600] focus:ring-1 focus:ring-[#CC5600] outline-none text-sm text-[#333333] transition-colors">
                    <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#717171] pointer-events-none" aria-hidden="true">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                </div>

                <!-- Share Wishlist Button -->
                <button type="button" id="share-wishlist-btn" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-[#D5D5D5] hover:border-[#CC5600] hover:text-[#CC5600] text-sm font-medium text-[#333333] transition-colors cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]" aria-label="<?php esc_attr_e('Share your wishlist link', 'dharmgyan'); ?>">
                    <svg class="w-4 h-4" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                    <span class="uppercase text-xs tracking-wider"><?php esc_html_e('SHARE WISHLIST', 'dharmgyan'); ?></span>
                </button>

                <!-- Grid View Indicator Buttons -->
                <div class="hidden sm:flex items-center gap-1.5 p-1 bg-[#F5EBE1]/50 rounded-lg border border-[#EADBC8]" role="group" aria-label="<?php esc_attr_e('Grid View Options', 'dharmgyan'); ?>">
                    <button type="button" id="grid-view-compact" class="p-1.5 rounded text-[#717171] hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]" aria-label="<?php esc_attr_e('Compact 5 Columns View', 'dharmgyan'); ?>" title="<?php esc_attr_e('Compact 5 Columns', 'dharmgyan'); ?>">
                        <svg class="w-4 h-4" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                        </svg>
                    </button>
                    <button type="button" id="grid-view-standard" class="p-1.5 rounded bg-[#CC5600] text-white shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]" aria-label="<?php esc_attr_e('Standard Grid View', 'dharmgyan'); ?>" title="<?php esc_attr_e('Default Grid', 'dharmgyan'); ?>">
                        <svg class="w-4 h-4" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                        </svg>
                    </button>
                </div>

            </div>

        </div>

        <?php if (!empty($wishlist_items)): ?>
            
            <!-- Bulk Action Strip matching Figma -->
            <div class="flex items-center justify-between py-4 text-sm border-b border-[#F0EAE4] mb-8">
                <label class="inline-flex items-center gap-2 cursor-pointer select-none font-medium text-[#444444]">
                    <input type="checkbox" id="wishlist-select-all" class="w-4 h-4 rounded border-gray-300 text-[#CC5600] focus:ring-[#CC5600] cursor-pointer">
                    <span><?php esc_html_e('Select All', 'dharmgyan'); ?></span>
                </label>

                <div class="flex items-center gap-4 text-sm font-medium">
                    <button type="button" id="bulk-move-to-cart" class="text-[#2E7D32] hover:underline cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2E7D32]">
                        <?php esc_html_e('Move to cart', 'dharmgyan'); ?>
                    </button>
                    <span class="text-gray-300" aria-hidden="true">|</span>
                    <button type="button" id="bulk-delete" class="text-[#D32F2F] hover:underline cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus-visible:ring-2 focus-visible:ring-[#D32F2F]">
                        <?php esc_html_e('Delete', 'dharmgyan'); ?>
                    </button>
                </div>
            </div>

            <!-- 5-Column Responsive Product Grid matching Figma (401:2423) -->
            <div id="wishlist-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
                
                <?php foreach ($wishlist_items as $item): 
                    $product = $item->get_product();
                    if (!$product) continue;

                    $product_id   = $product->get_id();
                    $product_name = $product->get_name();
                    $product_url  = $product->get_permalink();
                    $regular_prc  = $product->get_regular_price();
                    $sale_prc     = $product->get_sale_price();
                    $current_prc  = $product->get_price();
                    $img_html     = $product->get_image('woocommerce_thumbnail', array(
                        'class' => 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-105',
                        'alt'   => esc_attr($product_name),
                    ));
                    $item_id      = $item->get_id();
                    $remove_url   = $item->get_remove_url();
                ?>
                    <article class="wishlist-product-card group relative bg-white border border-[#EAE3DC] rounded-xl overflow-hidden flex flex-col justify-between transition-shadow hover:shadow-md" data-product-title="<?php echo esc_attr(strtolower($product_name)); ?>" data-item-id="<?php echo esc_attr($item_id); ?>" data-product-id="<?php echo esc_attr($product_id); ?>" aria-label="<?php echo esc_attr($product_name); ?>">
                        
                        <div>
                            <!-- Top Card Image & Select Checkbox -->
                            <div class="relative aspect-square overflow-hidden bg-[#FFF9F4]">
                                
                                <label class="absolute top-2.5 left-2.5 z-10 p-1 bg-white/90 backdrop-blur-xs rounded-md shadow-xs cursor-pointer">
                                    <input type="checkbox" name="wishlist_item[]" value="<?php echo esc_attr($item_id); ?>" class="wishlist-item-checkbox w-4 h-4 rounded border-gray-300 text-[#CC5600] focus:ring-[#CC5600] cursor-pointer" aria-label="<?php echo esc_attr(sprintf(__('Select %s', 'dharmgyan'), $product_name)); ?>">
                                </label>

                                <!-- Individual Remove Icon (Hover) -->
                                <a href="<?php echo esc_url($remove_url); ?>" class="absolute top-2.5 right-2.5 z-10 w-7 h-7 bg-white/90 hover:bg-[#D32F2F] text-gray-500 hover:text-white rounded-full flex items-center justify-center transition-colors shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-[#D32F2F]" aria-label="<?php echo esc_attr(sprintf(__('Remove %s from wishlist', 'dharmgyan'), $product_name)); ?>" title="<?php esc_attr_e('Remove', 'dharmgyan'); ?>">
                                    <svg class="w-3.5 h-3.5" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"></path></svg>
                                </a>

                                <a href="<?php echo esc_url($product_url); ?>" class="block w-full h-full" tabindex="-1">
                                    <?php echo $img_html; ?>
                                </a>
                            </div>

                            <!-- Product Details Block -->
                            <div class="p-3.5 sm:p-4">
                                <h2 class="text-sm sm:text-[15px] font-medium text-[#111111] line-clamp-2 leading-snug mb-2 group-hover:text-[#CC5600] transition-colors">
                                    <a href="<?php echo esc_url($product_url); ?>">
                                        <?php echo esc_html($product_name); ?>
                                    </a>
                                </h2>

                                <!-- Price Block matching Figma -->
                                <div class="flex items-baseline gap-2 mb-3" aria-label="<?php esc_attr_e('Price', 'dharmgyan'); ?>">
                                    <span class="text-base sm:text-lg font-bold text-[#CC5600]">
                                        <?php echo wc_price($current_prc); ?>
                                    </span>
                                    <?php if (!empty($sale_prc) && !empty($regular_prc) && $regular_prc > $sale_prc): ?>
                                        <span class="text-xs sm:text-sm text-[#717171] line-through">
                                            <?php echo wc_price($regular_prc); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Move to Cart Button -->
                        <div class="px-3.5 pb-3.5 sm:px-4 sm:pb-4">
                            <?php if ($product->is_in_stock()): ?>
                                <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" data-quantity="1" data-product_id="<?php echo esc_attr($product_id); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" class="add_to_cart_button ajax_add_to_cart w-full block py-2.5 px-4 bg-[#CC5600] hover:bg-[#B34B00] text-white text-center font-medium text-xs sm:text-sm uppercase tracking-wider rounded-lg shadow-xs transition duration-200 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]" aria-label="<?php echo esc_attr(sprintf(__('Move %s to cart', 'dharmgyan'), $product_name)); ?>">
                                    <?php esc_html_e('MOVE TO CART', 'dharmgyan'); ?>
                                </a>
                            <?php else: ?>
                                <span class="w-full block py-2.5 px-4 bg-gray-200 text-gray-500 text-center font-medium text-xs sm:text-sm uppercase tracking-wider rounded-lg cursor-not-allowed">
                                    <?php esc_html_e('Out of stock', 'dharmgyan'); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                    </article>
                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <!-- Empty Wishlist State -->
            <div class="text-center py-16 sm:py-24 bg-[#FFF9F4] border border-[#F5EBE1] rounded-2xl max-w-[800px] mx-auto px-6 my-8">
                <div class="w-20 h-20 mx-auto rounded-full bg-white border border-[#EADBC8] flex items-center justify-center text-[#CC5600] mb-6 shadow-xs">
                    <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </div>

                <h2 class="text-2xl sm:text-3xl font-serif font-medium text-[#111111] mb-3">
                    <?php esc_html_e('Your Wishlist is Empty', 'dharmgyan'); ?>
                </h2>

                <p class="text-[#666666] text-sm sm:text-base max-w-md mx-auto mb-8 leading-relaxed">
                    <?php esc_html_e('Explore our sacred idols, spiritual wall art, and divine collections to add your beloved items to your wishlist.', 'dharmgyan'); ?>
                </p>

                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="inline-block py-3.5 px-8 bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-sm sm:text-base uppercase tracking-wider rounded-lg shadow-sm transition-colors">
                    <?php esc_html_e('Explore Collections', 'dharmgyan'); ?>
                </a>
            </div>

        <?php endif; ?>

    </div>

    <!-- Conditional Pre-Footer Sections (Only render if enabled via ACF) -->
    <?php if ($show_discount_sale): ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/discount-sale'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_trending_products): ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/trending-products'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_testimonials): ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/testimonials'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_trust_badges): ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/trust-badges'); ?>
        </div>
    <?php endif; ?>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Live Instant Product Filter
    const searchInput = document.getElementById('wishlist-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.wishlist-product-card');
            cards.forEach(card => {
                const title = card.getAttribute('data-product-title') || '';
                if (title.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // 2. Select All Checkbox Logic
    const selectAllCheckbox = document.getElementById('wishlist-select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function(e) {
            const itemCheckboxes = document.querySelectorAll('.wishlist-item-checkbox');
            itemCheckboxes.forEach(cb => {
                cb.checked = e.target.checked;
            });
        });
    }

    // 3. Share Wishlist Button (Copy URL to Clipboard with Feedback)
    const shareBtn = document.getElementById('share-wishlist-btn');
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const originalHtml = shareBtn.innerHTML;
                shareBtn.innerHTML = '<span class="text-xs text-[#2E7D32] font-semibold uppercase"><?php echo esc_js(__('Link Copied!', 'dharmgyan')); ?></span>';
                setTimeout(() => {
                    shareBtn.innerHTML = originalHtml;
                }, 2000);
            }).catch(err => {
                alert('<?php echo esc_js(__('Share link: ', 'dharmgyan')); ?>' + window.location.href);
            });
        });
    }

    // 4. Batch Move to Cart
    const moveBtn = document.getElementById('bulk-move-to-cart');
        if (moveBtn) {
            moveBtn.addEventListener('click', function() {
                const checkedItems = document.querySelectorAll('.wishlist-item-checkbox:checked');
                if (checkedItems.length === 0) {
                    alert('<?php echo esc_js(__('Please select at least one item.', 'dharmgyan')); ?>');
                    return;
                }
                checkedItems.forEach(cb => {
                    const card = cb.closest('.wishlist-product-card');
                    const addBtn = card ? card.querySelector('.add_to_cart_button') : null;
                    if (addBtn) addBtn.click();
                });
            });
        }

        // 5. Batch Delete Items
        const deleteBtn = document.getElementById('bulk-delete');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                const checkedItems = document.querySelectorAll('.wishlist-item-checkbox:checked');
                if (checkedItems.length === 0) {
                    alert('<?php echo esc_js(__('Please select at least one item to delete.', 'dharmgyan')); ?>');
                    return;
                }
                if (confirm('<?php echo esc_js(__('Are you sure you want to remove selected items from your wishlist?', 'dharmgyan')); ?>')) {
                    checkedItems.forEach(cb => {
                        const card = cb.closest('.wishlist-product-card');
                        const removeLink = card ? card.querySelector('a[href*="remove_from_wishlist"]') : null;
                        if (removeLink) {
                            removeLink.click();
                        } else if (card) {
                            card.remove();
                        }
                    });
                }
            });
        }

        // 6. Grid View Toggle (5-Column vs 4-Column)
        const viewCompact = document.getElementById('grid-view-compact');
        const viewStandard = document.getElementById('grid-view-standard');
        const grid = document.getElementById('wishlist-grid');
        if (viewCompact && viewStandard && grid) {
            viewCompact.addEventListener('click', function() {
                grid.className = 'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6';
                viewCompact.className = 'p-1.5 rounded bg-[#CC5600] text-white shadow-xs';
                viewStandard.className = 'p-1.5 rounded text-[#717171] hover:text-[#CC5600] transition-colors';
            });
            viewStandard.addEventListener('click', function() {
                grid.className = 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6';
                viewStandard.className = 'p-1.5 rounded bg-[#CC5600] text-white shadow-xs';
                viewCompact.className = 'p-1.5 rounded text-[#717171] hover:text-[#CC5600] transition-colors';
            });
        }
});
</script>

<?php
get_footer();
