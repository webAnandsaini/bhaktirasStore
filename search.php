<?php
/**
 * Standalone Search Results Template
 * Clean Full-Width Layout without Filter Sidebar matching User Request.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();

$search_query  = get_search_query();
$total_results = $wp_query->found_posts;
$paged         = max(1, get_query_var('paged'));
$posts_per_page= (int) get_query_var('posts_per_page') ?: 12;
$start_index   = ($paged - 1) * $posts_per_page + 1;
$end_index     = min($paged * $posts_per_page, $total_results);
?>

<main id="primary" class="site-main search-results-page bg-white min-h-screen font-body" role="main">

    <!-- ─── 1. Full-Width Breadcrumb Bar matching Figma (1920x68px #FFF9F4) ─── -->
    <div class="page-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-6 md:mb-10">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors">
                <?php esc_html_e('Home', 'dharmgyan'); ?>
            </a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]">
                <?php printf(esc_html__('Search results: "%s"', 'dharmgyan'), esc_html($search_query)); ?>
            </span>
        </div>
    </div>

    <!-- ─── 2. Main Full-Width Content Container (NO FILTER SIDEBAR) ─── -->
    <div class="max-w-[1580px] mx-auto px-4 sm:px-6 lg:px-8 pb-16 md:pb-24">

        <!-- Search Results Header Row -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-[#E5E5E5] mb-8">
            <div>
                <h1 class="font-serif text-2xl md:text-[28px] text-[#111111] font-normal leading-tight">
                    <?php printf(esc_html__('Search results: "%s"', 'dharmgyan'), esc_html($search_query)); ?>
                </h1>
                <p class="text-xs md:text-sm text-[#717171] font-body mt-1">
                    <?php
                    if ($total_results > 0) {
                        printf(esc_html__('Showing %1$d–%2$d of %3$d results', 'dharmgyan'), $start_index, $end_index, $total_results);
                    } else {
                        esc_html_e('Showing 0 results', 'dharmgyan');
                    }
                    ?>
                </p>
            </div>

            <!-- Optional Sort By Ordering if WooCommerce is active -->
            <?php if (have_posts() && class_exists('WooCommerce')): ?>
                <div class="search-sort-wrapper shrink-0">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (have_posts()) : ?>

            <!-- ─── Full-Width 4-Column Responsive Grid (No Sidebar) ─── -->
            <div id="search-results-grid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-x-3 sm:gap-x-4 md:gap-x-6 gap-y-8 md:gap-y-10">
                <?php while (have_posts()) : the_post(); ?>

                    <?php if (get_post_type() === 'product' && function_exists('wc_get_template_part')): ?>
                        <!-- Product Item -->
                        <div class="search-product-item flex flex-col">
                            <?php get_template_part('template-parts/shop/product-card'); ?>
                        </div>
                    <?php elseif (get_post_type() === 'post'): ?>
                        <!-- Blog Article Item -->
                        <div class="search-blog-item flex flex-col">
                            <?php get_template_part('template-parts/blog/card'); ?>
                        </div>
                    <?php else: ?>
                        <!-- Generic Content Item -->
                        <article class="search-generic-item bg-white border border-[#EAE3DC] rounded-[10px] p-6 hover:shadow-md transition-shadow flex flex-col justify-between">
                            <div>
                                <span class="inline-block text-[11px] font-semibold text-[#CC5600] uppercase tracking-wider mb-2">
                                    <?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name ?? 'Page'); ?>
                                </span>
                                <h3 class="font-serif text-lg font-medium text-[#111111] mb-2 leading-snug">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-[#CC5600] transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <div class="text-[#666666] text-xs sm:text-sm line-clamp-3 leading-relaxed mb-4">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-[#F2EAE3]">
                                <a href="<?php the_permalink(); ?>" class="text-xs font-semibold text-[#CC5600] hover:text-[#B34700] inline-flex items-center gap-1">
                                    <span><?php esc_html_e('View Details', 'dharmgyan'); ?></span>
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </article>
                    <?php endif; ?>

                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="search-pagination mt-12 md:mt-16 flex justify-center">
                <?php
                echo paginate_links(array(
                    'prev_text' => '<span class="sr-only">' . __('Previous', 'dharmgyan') . '</span>&larr;',
                    'next_text' => '<span class="sr-only">' . __('Next', 'dharmgyan') . '</span>&rarr;',
                    'type'      => 'list',
                ));
                ?>
            </div>

        <?php else : ?>

            <!-- ─── Empty State (When no items match search) ─── -->
            <div class="search-empty-state max-w-2xl mx-auto py-12 md:py-16 text-center bg-white border border-[#F2EAE3] rounded-2xl p-6 sm:p-10 shadow-xs">
                
                <div class="w-18 h-18 mx-auto mb-5 rounded-full bg-[#FFF8F3] text-[#CC5600] flex items-center justify-center border border-[#F5EBE1]">
                    <svg class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        <path d="M8 11h6" stroke-linecap="round"></path>
                    </svg>
                </div>

                <h2 class="font-serif text-2xl sm:text-3xl text-[#111111] font-normal mb-3">
                    <?php esc_html_e('No Matching Products or Content Found', 'dharmgyan'); ?>
                </h2>

                <p class="text-[#717171] text-sm sm:text-[15px] mb-8 max-w-md mx-auto leading-relaxed">
                    <?php if (!empty($search_query)): ?>
                        <?php printf(esc_html__('We could not find any items matching "%s". Please try checking for typos or searching with general keywords.', 'dharmgyan'), esc_html($search_query)); ?>
                    <?php else: ?>
                        <?php esc_html_e('Please enter a keyword to search through our divine collections and sacred articles.', 'dharmgyan'); ?>
                    <?php endif; ?>
                </p>

                <!-- Search Form -->
                <div class="mb-8 w-full max-w-lg mx-auto">
                    <?php get_search_form(); ?>
                </div>

                <!-- Popular Suggestions -->
                <div class="pt-6 border-t border-[#F2EAE3]">
                    <p class="text-xs uppercase tracking-wider text-[#8C827A] font-semibold mb-3">
                        <?php esc_html_e('Popular Searches:', 'dharmgyan'); ?>
                    </p>
                    <div class="flex items-center justify-center flex-wrap gap-2">
                        <a href="<?php echo esc_url(home_url('/?s=Brass+Diya&post_type=product')); ?>" class="px-3.5 py-1.5 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs text-[#555555] font-medium transition-all shadow-2xs">
                            <?php esc_html_e('Brass Diya', 'dharmgyan'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/?s=Ganesha&post_type=product')); ?>" class="px-3.5 py-1.5 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs text-[#555555] font-medium transition-all shadow-2xs">
                            <?php esc_html_e('Ganesha Idols', 'dharmgyan'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/?s=Jap+Mala&post_type=product')); ?>" class="px-3.5 py-1.5 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs text-[#555555] font-medium transition-all shadow-2xs">
                            <?php esc_html_e('Jap Mala', 'dharmgyan'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/?s=Rudraksha&post_type=product')); ?>" class="px-3.5 py-1.5 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs text-[#555555] font-medium transition-all shadow-2xs">
                            <?php esc_html_e('Rudraksha', 'dharmgyan'); ?>
                        </a>
                        <a href="<?php echo esc_url(home_url('/?s=Pooja+Samagri&post_type=product')); ?>" class="px-3.5 py-1.5 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs text-[#555555] font-medium transition-all shadow-2xs">
                            <?php esc_html_e('Pooja Samagri', 'dharmgyan'); ?>
                        </a>
                    </div>
                </div>

            </div>

        <?php endif; ?>

    </div>

    <!-- ─── 3. Pre-Footer Curated Sections ─── -->
    <div class="border-t border-[#F2EAE3] bg-white">
        <?php get_template_part('template-parts/home/trending-products'); ?>
        <?php get_template_part('template-parts/home/trust-badges'); ?>
    </div>

</main>

<?php
get_footer();
