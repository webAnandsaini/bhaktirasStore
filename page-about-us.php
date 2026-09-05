<?php
/**
 * Template Name: About Us
 * 
 * Pixel-Perfect About Us page matching Figma (378:1011).
 * Fully dynamic via ACF with zero hardcoded default values.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();

// Fetch ACF fields strictly (render ONLY if populated)
$story_subtitle   = get_field('story_subtitle');
$story_title      = get_field('story_title');
$story_content    = get_field('story_content');
$story_image      = get_field('story_image');
$story_quote      = get_field('story_quote_badge');

$craft_subtitle   = get_field('craft_subtitle');
$craft_title      = get_field('craft_title');
$craft_content    = get_field('craft_content');
$craft_gallery    = get_field('craft_gallery');
$craft_stats      = get_field('craft_stats');

$vision_title     = get_field('vision_title');
$vision_desc      = get_field('vision_description');
$mission_title    = get_field('mission_title');
$mission_desc     = get_field('mission_description');

$show_discount_sale     = get_field('show_discount_sale');
$show_trending_products = get_field('show_trending_products');
$show_testimonials      = get_field('show_testimonials');
$show_trust_badges      = get_field('show_trust_badges');

$has_story_section = !empty($story_subtitle) || !empty($story_title) || !empty($story_content) || !empty($story_image);
$has_craft_section = !empty($craft_subtitle) || !empty($craft_title) || !empty($craft_content) || !empty($craft_gallery) || !empty($craft_stats);
$has_vm_section    = !empty($vision_title) || !empty($vision_desc) || !empty($mission_title) || !empty($mission_desc);
?>

<main id="primary" class="site-main about-us-page bg-white min-h-screen">

    <!-- Breadcrumb Bar matching Figma Section -->
    <div class="page-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-14">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]"><?php echo esc_html(get_the_title()); ?></span>
        </div>
    </div>

    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 space-y-16 md:space-y-24 pb-16 md:pb-24">

        <?php if ($has_story_section): ?>
            <!-- Section 1: Who We Are / Story Block -->
            <section class="story-block grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                
                <!-- Left Narrative Column (7 cols) -->
                <div class="lg:col-span-7 space-y-4">
                    <?php if (!empty($story_subtitle)): ?>
                        <span class="inline-block text-[#CC5600] text-sm md:text-base font-semibold tracking-wider uppercase font-body">
                            <?php echo esc_html($story_subtitle); ?>
                        </span>
                    <?php endif; ?>

                    <?php if (!empty($story_title)): ?>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-serif text-[#111111] font-medium leading-[1.15]">
                            <?php echo esc_html($story_title); ?>
                        </h1>
                    <?php else: ?>
                        <h1 class="sr-only"><?php echo esc_html(get_the_title()); ?></h1>
                    <?php endif; ?>

                    <?php if (!empty($story_content)): ?>
                        <div class="prose prose-stone max-w-none text-[#444444] text-[15px] md:text-[16px] leading-[1.8] space-y-4 pt-2">
                            <?php echo wp_kses_post(wpautop($story_content)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right Visual Column (5 cols) with Saffron Quote Overlay -->
                <?php if (!empty($story_image)): ?>
                    <div class="lg:col-span-5 relative">
                        <div class="relative rounded-2xl overflow-hidden shadow-md group">
                            <?php 
                            $img_url = is_array($story_image) ? $story_image['url'] : $story_image;
                            $img_alt = is_array($story_image) ? ($story_image['alt'] ?: $story_title) : '';
                            ?>
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt); ?>" class="w-full h-[450px] sm:h-[520px] object-cover transition-transform duration-500 group-hover:scale-105">
                            
                            <?php if (!empty($story_quote)): ?>
                                <!-- Saffron Quote Overlay Card matching Figma exactly -->
                                <div class="absolute bottom-0 left-0 right-0 bg-[#CC5600] text-white p-5 md:p-6 shadow-xl">
                                    <p class="text-base md:text-lg font-medium leading-snug">
                                        <?php echo nl2br(esc_html($story_quote)); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </section>
        <?php endif; ?>


        <?php if ($has_craft_section): ?>
            <!-- Section 2: The Craft Block -->
            <section class="craft-block grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">
                
                <!-- Left: 2x2 Image Mosaic (5 cols) -->
                <?php if (!empty($craft_gallery) && is_array($craft_gallery)): ?>
                    <div class="lg:col-span-5 grid grid-cols-2 gap-3 sm:gap-4">
                        <?php foreach (array_slice($craft_gallery, 0, 4) as $item): 
                            $g_url = is_array($item) ? $item['url'] : $item;
                            $g_alt = is_array($item) ? ($item['alt'] ?: $craft_title) : '';
                        ?>
                            <div class="aspect-square rounded-xl overflow-hidden shadow-sm">
                                <img src="<?php echo esc_url($g_url); ?>" alt="<?php echo esc_attr($g_alt); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Right: Narrative & Milestone Counters (7 cols) -->
                <div class="<?php echo (!empty($craft_gallery)) ? 'lg:col-span-7' : 'lg:col-span-12'; ?> space-y-5">
                    <?php if (!empty($craft_subtitle)): ?>
                        <span class="inline-block text-[#CC5600] text-sm md:text-base font-semibold tracking-wider uppercase font-body">
                            <?php echo esc_html($craft_subtitle); ?>
                        </span>
                    <?php endif; ?>

                    <?php if (!empty($craft_title)): ?>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-serif text-[#111111] font-medium leading-[1.15]">
                            <?php echo esc_html($craft_title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if (!empty($craft_content)): ?>
                        <div class="prose prose-stone max-w-none text-[#444444] text-[15px] md:text-[16px] leading-[1.8] space-y-4">
                            <?php echo wp_kses_post(wpautop($craft_content)); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Milestone Stats Row matching Figma (500+ Happy Clients) -->
                    <?php if (!empty($craft_stats) && is_array($craft_stats)): ?>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-[#F0EAE4]">
                            <?php foreach ($craft_stats as $stat): 
                                $s_num = $stat['stat_number'] ?? '';
                                $s_lbl = $stat['stat_label'] ?? '';
                                if (empty($s_num) && empty($s_lbl)) continue;
                            ?>
                                <div>
                                    <?php if (!empty($s_num)): ?>
                                        <div class="text-3xl md:text-4xl font-serif font-bold text-[#CC5600]">
                                            <?php echo esc_html($s_num); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($s_lbl)): ?>
                                        <div class="text-sm font-medium text-[#CC5600] mt-1 font-body">
                                            <?php echo esc_html($s_lbl); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </section>
        <?php endif; ?>


        <?php if ($has_vm_section): ?>
            <!-- Section 3: Vision & Mission Cards -->
            <section class="vision-mission-block grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                
                <?php if (!empty($vision_title) || !empty($vision_desc)): ?>
                    <div class="bg-[#FFF9F4] border border-[#F5EBE1] rounded-2xl p-8 sm:p-10 transition-shadow hover:shadow-sm flex flex-col justify-between">
                        <div>
                            <!-- Eye / Vision SVG Icon -->
                            <div class="w-14 h-14 rounded-full bg-white border border-[#EADBC8] flex items-center justify-center text-[#CC5600] mb-6">
                                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>

                            <?php if (!empty($vision_title)): ?>
                                <h3 class="text-2xl sm:text-3xl font-serif text-[#111111] font-medium mb-4">
                                    <?php echo esc_html($vision_title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if (!empty($vision_desc)): ?>
                                <p class="text-[#555555] text-[15px] md:text-[16px] leading-relaxed">
                                    <?php echo nl2br(esc_html($vision_desc)); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($mission_title) || !empty($mission_desc)): ?>
                    <div class="bg-[#FFF9F4] border border-[#F5EBE1] rounded-2xl p-8 sm:p-10 transition-shadow hover:shadow-sm flex flex-col justify-between">
                        <div>
                            <!-- Target / Mission SVG Icon -->
                            <div class="w-14 h-14 rounded-full bg-white border border-[#EADBC8] flex items-center justify-center text-[#CC5600] mb-6">
                                <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <circle cx="12" cy="12" r="6"></circle>
                                    <circle cx="12" cy="12" r="2"></circle>
                                </svg>
                            </div>

                            <?php if (!empty($mission_title)): ?>
                                <h3 class="text-2xl sm:text-3xl font-serif text-[#111111] font-medium mb-4">
                                    <?php echo esc_html($mission_title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if (!empty($mission_desc)): ?>
                                <p class="text-[#555555] text-[15px] md:text-[16px] leading-relaxed">
                                    <?php echo nl2br(esc_html($mission_desc)); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </section>
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

<?php
get_footer();
