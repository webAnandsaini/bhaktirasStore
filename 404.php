<?php
/**
 * The template for displaying 404 pages (Not Found)
 * Pixel-Perfect Spiritual & Sacred E-Commerce Theme
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main error-404-page bg-white min-h-screen font-body" role="main">

    <!-- ─── 1. Full-Width Breadcrumb Bar matching Figma (1920x68px #FFF9F4) ─── -->
    <div class="page-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-14">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors">
                <?php esc_html_e('Home', 'dharmgyan'); ?>
            </a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#CC5600] font-medium">
                <?php esc_html_e('404 Page Not Found', 'dharmgyan'); ?>
            </span>
        </div>
    </div>

    <!-- ─── 2. Main 404 Hero Section ─── -->
    <div class="max-w-[900px] mx-auto px-4 pb-16 md:pb-24 text-center">

        <!-- Error Badge -->
        <span class="inline-block px-4 py-1.5 bg-[#FFF2E6] border border-[#F5D8C2] text-[#CC5600] text-xs font-semibold uppercase tracking-wider rounded-full mb-3">
            <?php esc_html_e('Error 404', 'dharmgyan'); ?>
        </span>

        <!-- Large Artistic 404 Number -->
        <div class="font-serif text-7xl sm:text-8xl md:text-9xl text-[#CC5600] font-normal tracking-tight leading-none mb-4 select-none drop-shadow-xs">
            404
        </div>

        <!-- Heading -->
        <h1 class="font-serif text-2xl sm:text-3xl md:text-4xl text-[#111111] font-normal leading-tight mb-3">
            <?php esc_html_e('Sacred Path Not Found', 'dharmgyan'); ?>
        </h1>
        <div class="w-16 h-0.5 bg-[#CC5600] mx-auto rounded-full mb-4"></div>

        <!-- Description -->
        <p class="text-[#717171] text-sm sm:text-base max-w-lg mx-auto mb-8 leading-relaxed">
            <?php esc_html_e('The page you are looking for might have been relocated, renamed, or is temporarily resting. Let us guide you back to our divine collection.', 'dharmgyan'); ?>
        </p>

        <!-- Search Bar -->
        <div class="mb-8 w-full max-w-lg mx-auto">
            <?php get_search_form(); ?>
        </div>

        <!-- Action Navigation Buttons -->
        <div class="flex items-center justify-center flex-wrap gap-4 mb-12">
            <a 
                href="<?php echo esc_url(home_url('/')); ?>" 
                class="inline-flex items-center justify-center gap-2 bg-[#CC5600] hover:bg-[#B34700] text-white text-sm font-medium px-7 py-3 rounded-[6px] shadow-sm hover:shadow-md transition-all font-body"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span><?php esc_html_e('Return to Homepage', 'dharmgyan'); ?></span>
            </a>

            <a 
                href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" 
                class="inline-flex items-center justify-center gap-2 bg-white hover:bg-[#FFF9F4] text-[#111111] hover:text-[#CC5600] border border-[#D4D4D4] hover:border-[#CC5600] text-sm font-medium px-7 py-3 rounded-[6px] transition-all font-body"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <span><?php esc_html_e('Explore Collections', 'dharmgyan'); ?></span>
            </a>
        </div>

        <!-- Sacred Popular Categories -->
        <div class="pt-8 border-t border-[#F2EAE3]">
            <p class="text-xs uppercase tracking-wider text-[#8C827A] font-semibold mb-4">
                <?php esc_html_e('Explore Divine Categories:', 'dharmgyan'); ?>
            </p>
            <div class="flex items-center justify-center flex-wrap gap-2.5">
                <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="px-4 py-2 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs sm:text-sm text-[#444444] font-medium transition-all shadow-2xs">
                    <?php esc_html_e('All Collections', 'dharmgyan'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/product-category/pooja-samagri/')); ?>" class="px-4 py-2 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs sm:text-sm text-[#444444] font-medium transition-all shadow-2xs">
                    <?php esc_html_e('Pooja Samagri', 'dharmgyan'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/product-category/god-statue/')); ?>" class="px-4 py-2 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs sm:text-sm text-[#444444] font-medium transition-all shadow-2xs">
                    <?php esc_html_e('God Statues', 'dharmgyan'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/product-category/jap-mala/')); ?>" class="px-4 py-2 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs sm:text-sm text-[#444444] font-medium transition-all shadow-2xs">
                    <?php esc_html_e('Jap Mala', 'dharmgyan'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/product-category/rudraksha/')); ?>" class="px-4 py-2 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs sm:text-sm text-[#444444] font-medium transition-all shadow-2xs">
                    <?php esc_html_e('Rudraksha', 'dharmgyan'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/product-category/home-decor/')); ?>" class="px-4 py-2 bg-[#FFF9F4] hover:bg-[#CC5600] hover:text-white border border-[#EAE3DC] rounded-full text-xs sm:text-sm text-[#444444] font-medium transition-all shadow-2xs">
                    <?php esc_html_e('Home Decor', 'dharmgyan'); ?>
                </a>
            </div>
        </div>

    </div>

    <!-- ─── 3. Pre-Footer Curated Sections ─── -->
    <div class="border-t border-[#F2EAE3] bg-white">
        <?php get_template_part('template-parts/home/trending-products'); ?>
        <?php get_template_part('template-parts/home/trust-badges'); ?>
    </div>

</main>

<?php
get_footer();
