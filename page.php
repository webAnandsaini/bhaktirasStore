<?php
/**
 * Master Page Template for Static & Content Pages
 * Pixel-Perfect Typography matching Figma Design System.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();

// Determine if this is a specialized WooCommerce or Wishlist page
$is_special_wc_page = (function_exists('is_cart') && is_cart()) || 
                      (function_exists('is_checkout') && is_checkout()) || 
                      (function_exists('is_account_page') && is_account_page());
?>

<main id="main" class="site-main site-page-container bg-white min-h-screen font-body">

    <?php while (have_posts()): the_post(); ?>

        <?php if ($is_special_wc_page): ?>
            
            <!-- Direct WooCommerce Special Flow (Cart / Checkout / My Account) -->
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php the_content(); ?>
            </article>

        <?php else: ?>

            <!-- Full-Width Centered Breadcrumb Bar matching Figma (1920x68px #FFF9F4) -->
            <div class="page-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
                <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
                    <span class="text-[#444444] select-none mx-0.5">›</span>
                    <span class="text-[#444444]"><?php the_title(); ?></span>
                </div>
            </div>

            <!-- Main Page Content Container -->
            <div class="max-w-[1100px] mx-auto px-4 pb-16 md:pb-24">
                <article id="post-<?php the_ID(); ?>" <?php post_class('prose-container'); ?>>
                    
                    <header class="page-header mb-8 text-center">
                        <h1 class="page-title font-body text-2xl md:text-4xl text-[#111111] font-semibold leading-tight mb-3">
                            <?php the_title(); ?>
                        </h1>
                        <div class="w-16 h-0.5 bg-[#CC5600] mx-auto rounded-full"></div>
                    </header>

                    <div class="page-content prose prose-stone max-w-none text-[#444444] text-[15px] md:text-[16px] leading-relaxed">
                        <?php the_content(); ?>
                    </div>

                </article>
            </div>

        <?php endif; ?>

    <?php endwhile; ?>

</main>

<?php
get_footer();
