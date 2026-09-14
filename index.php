<?php
/**
 * Master Index Fallback Template
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main index-fallback-page bg-white min-h-screen font-body" role="main">

    <!-- ─── 1. Full-Width Breadcrumb Bar matching Figma (1920x68px #FFF9F4) ─── -->
    <div class="page-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors">
                <?php esc_html_e('Home', 'dharmgyan'); ?>
            </a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]">
                <?php esc_html_e('Articles & Collections', 'dharmgyan'); ?>
            </span>
        </div>
    </div>

    <!-- ─── 2. Main Content Container ─── -->
    <div class="max-w-[1580px] mx-auto px-4 sm:px-6 lg:px-8 pb-16 md:pb-24">

        <?php if (have_posts()) : ?>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 xl:gap-8 items-stretch">
                <?php while (have_posts()) : the_post(); ?>
                    <?php if (get_post_type() === 'product' && function_exists('wc_get_template_part')): ?>
                        <div class="index-card-product flex flex-col">
                            <?php get_template_part('template-parts/shop/product-card'); ?>
                        </div>
                    <?php elseif (get_post_type() === 'post'): ?>
                        <div class="index-card-post flex flex-col">
                            <?php get_template_part('template-parts/blog/card'); ?>
                        </div>
                    <?php else: ?>
                        <article class="index-card-generic bg-white border border-[#EAE3DC] rounded-[10px] p-6 hover:shadow-md transition-shadow flex flex-col justify-between">
                            <div>
                                <h2 class="font-serif text-lg font-medium text-[#111111] mb-2 leading-snug">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-[#CC5600] transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                <div class="text-[#666666] text-xs sm:text-sm line-clamp-3 leading-relaxed mb-4">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-[#F2EAE3]">
                                <a href="<?php the_permalink(); ?>" class="text-xs font-semibold text-[#CC5600] hover:text-[#B34700] inline-flex items-center gap-1">
                                    <span><?php esc_html_e('Read More', 'dharmgyan'); ?></span>
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>

            <div class="index-pagination mt-12 md:mt-16 flex justify-center">
                <?php
                echo paginate_links(array(
                    'prev_text' => '<span class="sr-only">' . __('Previous', 'dharmgyan') . '</span>&larr;',
                    'next_text' => '<span class="sr-only">' . __('Next', 'dharmgyan') . '</span>&rarr;',
                    'type'      => 'list',
                ));
                ?>
            </div>

        <?php else : ?>

            <div class="max-w-md mx-auto text-center py-16">
                <h2 class="font-serif text-2xl text-[#111111] mb-3">
                    <?php esc_html_e('No content found', 'dharmgyan'); ?>
                </h2>
                <p class="text-[#717171] text-sm mb-6">
                    <?php esc_html_e('Please return to our homepage or explore our collections.', 'dharmgyan'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-[#CC5600] hover:bg-[#B34700] text-white px-6 py-2.5 rounded-[4px] text-sm font-medium transition-colors">
                    <?php esc_html_e('Return to Home', 'dharmgyan'); ?>
                </a>
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