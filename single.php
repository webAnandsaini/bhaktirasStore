<?php
/**
 * Single Blog Post Template - Pixel-Perfect Figma 1:1
 * Matching Figma ID: 418:4389 (1920x5787px)
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();

$post_id    = get_the_ID();
$author_id  = get_post_field('post_author', $post_id);
$author_name = get_the_author_meta('display_name', $author_id);

// ACF Fields for CTA Banner & Bottom Sections
$post_cta_image       = get_field('post_cta_image', $post_id);
$post_cta_button_text = get_field('post_cta_button_text', $post_id) ?: __('Buy it now', 'dharmgyan');
$post_cta_button_url  = get_field('post_cta_button_url', $post_id) ?: (function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'));

$show_discount_sale     = get_field('show_discount_sale', $post_id);
$show_trending_products = get_field('show_trending_products', $post_id);
$show_testimonials      = get_field('show_testimonials', $post_id);
$show_trust_badges      = get_field('show_trust_badges', $post_id);

// Default to showing pre-footer sections unless explicitly disabled
$show_discount_sale     = $show_discount_sale !== false && $show_discount_sale !== '0';
$show_trending_products = $show_trending_products !== false && $show_trending_products !== '0';
$show_testimonials      = $show_testimonials !== false && $show_testimonials !== '0';
$show_trust_badges      = $show_trust_badges !== false && $show_trust_badges !== '0';

// Hero Featured Image
$hero_thumb_id  = get_post_thumbnail_id($post_id);
$hero_thumb_url = $hero_thumb_id ? wp_get_attachment_image_url($hero_thumb_id, 'full') : get_template_directory_uri() . '/assets/images/blog/blog_hero.png';

// In-Article CTA Banner Image
$cta_banner_url = '';
if (is_array($post_cta_image) && !empty($post_cta_image['url'])) {
    $cta_banner_url = $post_cta_image['url'];
} elseif (is_numeric($post_cta_image)) {
    $cta_banner_url = wp_get_attachment_image_url($post_cta_image, 'full');
} elseif (is_string($post_cta_image) && !empty($post_cta_image)) {
    $cta_banner_url = $post_cta_image;
} else {
    $cta_banner_url = get_template_directory_uri() . '/assets/images/blog/blog_cta_banner.png';
}

$blog_listing_url = get_permalink(get_option('page_for_posts')) ?: home_url('/blog/');
?>

<main id="primary" class="site-main single-post-page bg-white min-h-screen">

    <!-- ─── 1. Breadcrumb Bar (Matching Figma 1920x68px #FFF9F4) ─── -->
    <div class="page-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors">
                <?php esc_html_e('Home', 'dharmgyan'); ?>
            </a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <a href="<?php echo esc_url($blog_listing_url); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors">
                <?php esc_html_e('Our Blog', 'dharmgyan'); ?>
            </a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444] font-medium truncate max-w-[280px] sm:max-w-[450px] md:max-w-none">
                <?php echo esc_html(get_the_title()); ?>
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

            <!-- Right Content: Single Blog Article (8 Cols / 1040px in Figma) -->
            <div class="lg:col-span-8 xl:col-span-8 w-full">

                <article id="post-<?php the_ID(); ?>" <?php post_class('single-article-content'); ?>>

                    <!-- 1. Hero Featured Image (1034x644px Aspect Ratio) with Saffron Author & Date Badges -->
                    <div class="blog-hero-container relative w-full aspect-[1034/644] max-h-[644px] rounded-2xl md:rounded-[20px] overflow-hidden bg-[#F9F5EB] border border-[#EAE3DC] shadow-sm">
                        <img 
                            src="<?php echo esc_url($hero_thumb_url); ?>" 
                            alt="<?php the_title_attribute(); ?>" 
                            class="w-full h-full object-cover" 
                            loading="eager" 
                        />
                        
                        <!-- Dark Gradient Overlay for Badges Readability -->
                        <div class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black/75 via-black/35 to-transparent flex items-end p-5 sm:p-7 md:p-8">
                            <div class="flex flex-wrap items-center gap-3">
                                <!-- Author Badge -->
                                <span class="inline-flex items-center gap-2 bg-[#CC5600] text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-full shadow-md font-body">
                                    <svg class="w-4 h-4 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span><?php printf(esc_html__('By %s', 'dharmgyan'), esc_html($author_name)); ?></span>
                                </span>

                                <!-- Date Badge -->
                                <span class="inline-flex items-center gap-2 bg-[#CC5600] text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-full shadow-md font-body">
                                    <svg class="w-4 h-4 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span><?php echo esc_html(get_the_date('d M Y')); ?></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Centered Saffron CTA Button ("Buy it now" matching Figma 306x52px) -->
                    <div class="blog-cta-wrapper flex justify-center my-7 sm:my-9">
                        <a 
                            href="<?php echo esc_url($post_cta_button_url); ?>" 
                            class="inline-flex items-center justify-center w-full max-w-[306px] h-[52px] bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-base rounded-md transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none font-body"
                        >
                            <?php echo esc_html($post_cta_button_text); ?>
                        </a>
                    </div>

                    <!-- 3. Post Title (28-34px Bold Serif) -->
                    <header class="entry-header mb-6">
                        <h1 class="text-2xl sm:text-3xl md:text-[32px] lg:text-[34px] font-bold text-[#111111] leading-snug tracking-tight font-serif">
                            <?php the_title(); ?>
                        </h1>
                    </header>

                    <!-- 4. Post Prose Content -->
                    <div class="entry-content blog-post-prose text-[16px] sm:text-[18px] text-[#444444] leading-[1.8] font-body">
                        <?php while (have_posts()) : the_post(); ?>
                            <?php the_content(); ?>
                        <?php endwhile; ?>
                    </div>

                    <!-- 5. In-Article CTA Product Banner Matching Figma 1:1 -->
                    <?php if (!empty($cta_banner_url)) : ?>
                        <section class="in-article-cta-banner my-12 pt-4">
                            <div class="relative w-full aspect-[1034/644] max-h-[644px] rounded-2xl md:rounded-[20px] overflow-hidden bg-[#F9F5EB] border border-[#EAE3DC] shadow-sm mb-7 sm:mb-9">
                                <img 
                                    src="<?php echo esc_url($cta_banner_url); ?>" 
                                    alt="<?php esc_attr_e('Featured Devotional Product', 'dharmgyan'); ?>" 
                                    class="w-full h-full object-cover" 
                                    loading="lazy" 
                                />
                            </div>

                            <!-- Centered "Buy it now" Button -->
                            <div class="flex justify-center">
                                <a 
                                    href="<?php echo esc_url($post_cta_button_url); ?>" 
                                    class="inline-flex items-center justify-center w-full max-w-[306px] h-[52px] bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-base rounded-md transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none font-body"
                                >
                                    <?php echo esc_html($post_cta_button_text); ?>
                                </a>
                            </div>
                        </section>
                    <?php endif; ?>

                    <!-- 6. Post Tags & Navigation -->
                    <?php
                    $post_tags = get_the_tags();
                    if ($post_tags) :
                    ?>
                        <div class="post-tags-section mt-12 pt-6 border-t border-[#F2EAE3] flex flex-wrap items-center gap-2">
                            <span class="text-sm font-semibold text-[#666666] mr-2"><?php esc_html_e('Tags:', 'dharmgyan'); ?></span>
                            <?php foreach ($post_tags as $ptag) : ?>
                                <a href="<?php echo esc_url(get_tag_link($ptag->term_id)); ?>" class="text-xs font-semibold text-[#CC5600] bg-[#FFF8F2] border border-[#F2DECF] hover:bg-[#CC5600] hover:text-white rounded-[4px] px-3 py-1.5 transition-colors">
                                    #<?php echo esc_html($ptag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- 7. Previous / Next Post Navigation (Square Boxes Matching Figma Theme) -->
                    <nav class="post-navigation-cards mt-10 pt-8 border-t border-[#F2EAE3] flex items-center justify-between gap-4">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>

                        <?php if ($prev_post) : ?>
                            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="flex items-center gap-3 p-3 sm:p-4 rounded-xl border border-[#EAE3DC] hover:border-[#CC5600] bg-white hover:bg-[#FFF9F4] transition-all group max-w-[48%]">
                                <span class="w-10 h-10 rounded-lg bg-[#FFF8F2] text-[#CC5600] flex items-center justify-center shrink-0 group-hover:bg-[#CC5600] group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </span>
                                <div class="min-w-0 hidden sm:block text-left">
                                    <span class="text-xs text-[#888888] uppercase tracking-wider font-semibold block"><?php esc_html_e('Previous', 'dharmgyan'); ?></span>
                                    <span class="text-sm font-semibold text-[#111111] group-hover:text-[#CC5600] truncate block"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                </div>
                            </a>
                        <?php else : ?>
                            <div></div>
                        <?php endif; ?>

                        <?php if ($next_post) : ?>
                            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="flex items-center justify-end gap-3 p-3 sm:p-4 rounded-xl border border-[#EAE3DC] hover:border-[#CC5600] bg-white hover:bg-[#FFF9F4] transition-all group max-w-[48%] ml-auto text-right">
                                <div class="min-w-0 hidden sm:block">
                                    <span class="text-xs text-[#888888] uppercase tracking-wider font-semibold block"><?php esc_html_e('Next', 'dharmgyan'); ?></span>
                                    <span class="text-sm font-semibold text-[#111111] group-hover:text-[#CC5600] truncate block"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                </div>
                                <span class="w-10 h-10 rounded-lg bg-[#FFF8F2] text-[#CC5600] flex items-center justify-center shrink-0 group-hover:bg-[#CC5600] group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </a>
                        <?php endif; ?>
                    </nav>

                    <!-- 8. Comments Template -->
                    <?php if (comments_open() || get_comments_number()) : ?>
                        <div class="post-comments-wrapper mt-12 pt-8 border-t border-[#F2EAE3]">
                            <?php comments_template(); ?>
                        </div>
                    <?php endif; ?>

                </article>

            </div>

        </div>

    </div>

    <!-- ─── 3. Pre-Footer Sections Matching Figma PDP 1:1 ─── -->
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
