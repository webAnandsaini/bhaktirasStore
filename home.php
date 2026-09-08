<?php
/**
 * Blog Listing Template - Pixel-Perfect Figma 1:1
 * Matching Figma ID: 414:3383 (1920x5867px)
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();

// Fetch ACF fields for Blog settings (with graceful defaults)
$blog_page_id           = get_option('page_for_posts') ?: get_queried_object_id();
$header_title           = get_field('blog_header_title', $blog_page_id) ?: __('Our Blogs', 'dharmgyan');
$show_discount_sale     = get_field('show_discount_sale', $blog_page_id);
$show_trending_products = get_field('show_trending_products', $blog_page_id);
$show_testimonials      = get_field('show_testimonials', $blog_page_id);
$show_trust_badges      = get_field('show_trust_badges', $blog_page_id);

// Default to showing pre-footer sections if field is not explicitly 0/false
$show_discount_sale     = $show_discount_sale !== false && $show_discount_sale !== '0';
$show_trending_products = $show_trending_products !== false && $show_trending_products !== '0';
$show_testimonials      = $show_testimonials !== false && $show_testimonials !== '0';
$show_trust_badges      = $show_trust_badges !== false && $show_trust_badges !== '0';
?>

<main id="primary" class="site-main blog-archive-page bg-white min-h-screen">

    <!-- ─── 1. Breadcrumb Bar (Matching Figma 1920x68px #FFF9F4) ─── -->
    <div class="page-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors">
                <?php esc_html_e('Home', 'dharmgyan'); ?>
            </a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444] font-medium">
                <?php echo esc_html($header_title); ?>
            </span>
        </div>
    </div>

    <!-- ─── 2. Main 2-Column Content Container ─── -->
    <div class="max-w-[1580px] mx-auto px-4 sm:px-6 lg:px-8 pb-16 md:pb-24">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 xl:gap-12 items-start">

            <!-- Left Sidebar (4 Cols / 498px in Figma) -->
            <div class="lg:col-span-4 xl:col-span-4 w-full">
                <?php get_template_part('template-parts/blog/sidebar'); ?>
            </div>

            <!-- Right Content: Blog Post Cards Grid (8 Cols / 1040px in Figma) -->
            <div class="lg:col-span-8 xl:col-span-8 w-full">

                <?php if (have_posts()) : ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-12">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/blog/card');
                        endwhile;
                        ?>
                    </div>

                    <!-- ─── 3. Square Figma Pagination (59x59px) ─── -->
                    <div class="blog-pagination flex items-center justify-center gap-3 mt-14 pt-8 border-t border-[#F2EAE3]">
                        <?php
                        global $wp_query;
                        $big = 999999999;
                        $pages = paginate_links(array(
                            'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format'    => '?paged=%#%',
                            'current'   => max(1, get_query_var('paged')),
                            'total'     => $wp_query->max_num_pages,
                            'type'      => 'array',
                            'prev_text' => '<svg class="w-5 h-5 text-current" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>',
                            'next_text' => '<svg class="w-5 h-5 text-current" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>',
                        ));

                        if (is_array($pages)) {
                            foreach ($pages as $page) {
                                // Add square styling to pagination links
                                $page = str_replace(
                                    array('page-numbers current', 'page-numbers'),
                                    array('w-[52px] h-[52px] sm:w-[59px] sm:h-[59px] rounded-lg bg-[#CC5600] text-white font-bold text-base flex items-center justify-center shadow-sm border border-[#CC5600]', 'w-[52px] h-[52px] sm:w-[59px] sm:h-[59px] rounded-lg bg-white border border-[#D5D5D5] text-[#222222] hover:border-[#CC5600] hover:text-[#CC5600] font-semibold text-base flex items-center justify-center transition-colors'),
                                    $page
                                );
                                echo $page; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            }
                        }
                        ?>
                    </div>

                <?php else : ?>

                    <div class="text-center py-16 bg-white border border-[#EAE3DC] rounded-2xl p-8">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#FFF8F2] text-[#CC5600] flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-serif text-[#111111] mb-2"><?php esc_html_e('No Articles Found', 'dharmgyan'); ?></h2>
                        <p class="text-sm text-[#666666] max-w-md mx-auto mb-6"><?php esc_html_e('We are currently preparing inspiring devotional stories and articles. Please check back soon.', 'dharmgyan'); ?></p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2 bg-[#CC5600] text-white text-sm font-semibold px-6 py-3 rounded-lg hover:bg-[#B34B00] transition-colors">
                            <?php esc_html_e('Return to Home', 'dharmgyan'); ?>
                        </a>
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <!-- ─── 4. Pre-Footer Sections Matching Figma PDP 1:1 ─── -->
    <?php if ($show_discount_sale) : ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/discount-sale'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_trending_products) : ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/trending-products'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_testimonials) : ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/testimonials'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_trust_badges) : ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/trust-badges'); ?>
        </div>
    <?php endif; ?>

</main>

<?php
get_footer();
