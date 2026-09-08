<?php
/**
 * Blog Card Component - Pixel-Perfect Figma 1:1
 * Matching Figma ID: 414:3383 (510x307px Card)
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

$post_id    = get_the_ID();
$categories = get_the_category($post_id);
$primary_cat = !empty($categories) ? $categories[0]->name : __('Spiritual Blog', 'dharmgyan');
$cat_link    = !empty($categories) ? get_category_link($categories[0]->term_id) : '#';

$thumb_id  = get_post_thumbnail_id($post_id);
$thumb_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'large') : get_template_directory_uri() . '/assets/images/blog/blog_card_1.png';
?>

<article class="blog-card flex flex-col bg-white group" id="post-<?php echo esc_attr($post_id); ?>">

    <!-- 1. Featured Image (510x307px Aspect Ratio) -->
    <a href="<?php the_permalink(); ?>" class="blog-card-thumbnail block relative w-full aspect-[510/307] rounded-2xl overflow-hidden bg-[#F9F5EB] border border-[#EAE3DC] mb-5 focus:outline-none">
        <img 
            src="<?php echo esc_url($thumb_url); ?>" 
            alt="<?php the_title_attribute(); ?>" 
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" 
            loading="lazy" 
        />
        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </a>

    <!-- 2. Category Label -->
    <div class="blog-card-category mb-2">
        <a href="<?php echo esc_url($cat_link); ?>" class="inline-block text-sm font-semibold text-[#CC5600] tracking-wide uppercase font-body hover:underline underline-offset-2 transition-colors">
            <?php echo esc_html($primary_cat); ?>
        </a>
    </div>

    <!-- 3. Post Title -->
    <h2 class="blog-card-title text-xl sm:text-2xl font-serif text-[#111111] font-medium group-hover:text-[#CC5600] transition-colors leading-snug mb-3 line-clamp-2">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>

    <!-- 4. Post Excerpt -->
    <div class="blog-card-excerpt text-sm text-[#555555] font-body leading-relaxed mb-4 line-clamp-2">
        <?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), 22, '...')); ?>
    </div>

    <!-- 5. Read More Action -->
    <div class="blog-card-action mt-auto pt-1">
        <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-[#111111] group-hover:text-[#CC5600] transition-colors font-body focus:outline-none">
            <span><?php esc_html_e('Read More', 'dharmgyan'); ?></span>
            <svg class="w-4 h-4 transform group-hover:translate-x-1.5 transition-transform duration-200 text-[#CC5600]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>

</article>
