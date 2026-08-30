<?php
/**
 * Master Product Archive & Category Listing Template
 * Single unified template handling Shop, Categories, Tags, and Search.
 * Sourced with Real-Time AJAX Filtering and Deep URL Parameter Synchronization.
 * Pixel-Perfect Figma 1:4229 layout.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header('shop');

$archive_title = woocommerce_page_title(false);
?>

<main id="primary" class="site-main shop-archive-page bg-white min-h-screen">

    <!-- Full-Width Centered Breadcrumb Bar matching Figma Section (1920x68px #FFF9F4) -->
    <div class="shop-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-6 md:mb-10">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <?php if (is_product_category()): ?>
                <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Collections', 'dharmgyan'); ?></a>
                <span class="text-[#444444] select-none mx-0.5">›</span>
                <span class="text-[#444444]"><?php echo esc_html($archive_title); ?></span>
            <?php elseif (is_search()): ?>
                <span class="text-[#444444]"><?php printf(esc_html__('Search results: "%s"', 'dharmgyan'), esc_html(get_search_query())); ?></span>
            <?php else: ?>
                <span class="text-[#444444]"><?php echo esc_html($archive_title ?: __('Collections', 'dharmgyan')); ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="max-w-[1580px] mx-auto px-4 pb-12 md:pb-16">

        <!-- Shop Header (Title, Active Filter Chips, Sort Controls) -->
        <?php get_template_part('template-parts/shop/shop-header'); ?>

        <!-- Main 2-Column Listing Layout (Left: 314px Sidebar, Right: 4-Column Grid) -->
        <div class="flex flex-col lg:flex-row gap-8 xl:gap-12 items-start mt-6">

            <!-- Left Sticky Filter Sidebar (Desktop: 314px matching Figma) -->
            <aside class="hidden lg:block w-[314px] shrink-0 sticky top-28 self-start">
                <?php get_template_part('template-parts/shop/shop-filters'); ?>
            </aside>

            <!-- Right Product Grid Area -->
            <div class="flex-1 w-full min-w-0">

                <div id="shop-products-grid-wrapper" class="relative min-h-[400px]">

                    <!-- Loading Skeleton Overlay -->
                    <div id="shop-loading-overlay" class="hidden absolute inset-0 bg-white/70 backdrop-blur-xs z-20 flex items-center justify-center">
                        <div class="inline-flex items-center gap-3 px-6 py-3 bg-white border border-[#EAE3DC] rounded-full shadow-lg text-[#CC5600] font-medium text-sm">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-[#CC5600]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span><?php esc_html_e('Updating products...', 'dharmgyan'); ?></span>
                        </div>
                    </div>

                    <!-- Products Grid (4 Columns on Desktop) -->
                    <div id="shop-products-grid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-2 gap-y-8 md:gap-y-10">
                        <?php
                        if (woocommerce_product_loop()) {
                            if (wc_get_loop_prop('total')) {
                                while (have_posts()) {
                                    the_post();
                                    get_template_part('template-parts/shop/product-card');
                                }
                            }
                        } else {
                            get_template_part('template-parts/shop/no-results');
                        }
                        ?>
                    </div>

                    <!-- AJAX Pagination Container -->
                    <div id="shop-pagination-container" class="mt-10 md:mt-14">
                        <?php get_template_part('template-parts/shop/shop-pagination'); ?>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Mobile Off-Canvas Filter Drawer -->
    <div id="mobile-filter-drawer-wrapper" class="fixed inset-0 z-50 lg:hidden pointer-events-none opacity-0 transition-opacity duration-300" aria-hidden="true">
        <!-- Backdrop (Click Outside to Close) -->
        <div id="mobile-filter-backdrop" class="absolute inset-0 bg-black/50 cursor-pointer"></div>

        <!-- Drawer Panel (Slides in from Right) -->
        <div id="mobile-filter-drawer-panel" class="absolute inset-y-0 right-0 w-full max-w-[340px] sm:max-w-[380px] bg-white shadow-2xl flex flex-col h-full transform translate-x-full transition-transform duration-300 ease-out z-10">
            <!-- Drawer Header -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-[#E5E5E5] shrink-0 bg-[#FFF9F4]">
                <h3 class="font-body text-base text-[#111111] font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#CC5600]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                    <span><?php esc_html_e('Filters', 'dharmgyan'); ?></span>
                </h3>
                <button type="button" id="close-mobile-filter-drawer" class="p-1.5 text-gray-500 hover:text-[#CC5600] rounded-full hover:bg-white/80 transition-colors focus:outline-none cursor-pointer" aria-label="<?php esc_attr_e('Close Filter Drawer', 'dharmgyan'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <!-- Drawer Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-4">
                <?php get_template_part('template-parts/shop/shop-filters'); ?>
            </div>
        </div>
    </div>

    <!-- Bottom Reusable Sections Matching Figma 03_product_list.png -->
    <div class="border-t border-[#E5E5E5] bg-white">
        <!-- 1. Trending Products -->
        <?php get_template_part('template-parts/home/trending-products'); ?>

        <!-- 2. Customer Testimonials -->
        <?php get_template_part('template-parts/home/testimonials'); ?>

        <!-- 3. 4 Circular Saffron Badges -->
        <?php get_template_part('template-parts/home/trust-badges'); ?>
    </div>

</main>

<?php
get_footer('shop');
