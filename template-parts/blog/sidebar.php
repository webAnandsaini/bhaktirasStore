<?php
/**
 * Blog Reusable Sidebar - Pixel-Perfect Figma 1:1
 * Matching Figma ID: 414:3383 & 418:4389
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;
?>

<aside class="blog-sidebar w-full flex flex-col gap-8" aria-label="<?php esc_attr_e('Blog Sidebar', 'dharmgyan'); ?>">

    <!-- ─── 1. Search Widget ─── -->
    <div class="blog-widget bg-white border border-[#EAE3DC] rounded-2xl p-6 sm:p-8 shadow-xs">
        <div class="widget-header mb-5">
            <h3 class="widget-title text-xl md:text-2xl font-serif text-[#111111] font-medium pb-3 border-b-2 border-[#CC5600]/20 relative">
                <?php esc_html_e('Search Here', 'dharmgyan'); ?>
                <span class="absolute bottom-[-2px] left-0 w-12 h-[2px] bg-[#CC5600]"></span>
            </h3>
        </div>
        <form role="search" method="get" class="blog-search-form flex items-stretch gap-0 rounded-lg overflow-hidden border border-[#D5D5D5] focus-within:border-[#CC5600] transition-colors" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="hidden" name="post_type" value="post" />
            <input 
                type="search" 
                class="w-full h-12 sm:h-[50px] px-4 bg-white text-[#222222] placeholder-[#9E9E9E] text-sm outline-none border-none font-body" 
                placeholder="<?php esc_attr_e('Search here', 'dharmgyan'); ?>" 
                value="<?php echo get_search_query(); ?>" 
                name="s" 
                aria-label="<?php esc_attr_e('Search blog posts', 'dharmgyan'); ?>" 
                required 
            />
            <button 
                type="submit" 
                class="bg-[#CC5600] hover:bg-[#B34B00] text-white px-6 font-medium text-sm transition-colors flex items-center justify-center shrink-0"
                aria-label="<?php esc_attr_e('Submit Search', 'dharmgyan'); ?>"
            >
                <?php esc_html_e('Search', 'dharmgyan'); ?>
            </button>
        </form>
    </div>

    <!-- ─── 2. Categories Widget ─── -->
    <div class="blog-widget bg-white border border-[#EAE3DC] rounded-2xl p-6 sm:p-8 shadow-xs">
        <div class="widget-header mb-5">
            <h3 class="widget-title text-xl md:text-2xl font-serif text-[#111111] font-medium pb-3 border-b-2 border-[#CC5600]/20 relative">
                <?php esc_html_e('Categories', 'dharmgyan'); ?>
                <span class="absolute bottom-[-2px] left-0 w-12 h-[2px] bg-[#CC5600]"></span>
            </h3>
        </div>
        <ul class="blog-category-list flex flex-col divide-y divide-[#F2EAE3]">
            <?php
            $categories = get_categories(array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'hide_empty' => true,
                'number'     => 10,
            ));

            if (!empty($categories)) :
                foreach ($categories as $cat) :
                    $cat_link = get_category_link($cat->term_id);
            ?>
                    <li class="py-3.5 first:pt-0 last:pb-0">
                        <a href="<?php echo esc_url($cat_link); ?>" class="flex items-center justify-between text-[#333333] hover:text-[#CC5600] font-medium text-[15px] transition-colors group">
                            <span class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-[#CC5600]/40 group-hover:bg-[#CC5600] transition-colors shrink-0"></span>
                                <span class="group-hover:translate-x-1 transition-transform"><?php echo esc_html($cat->name); ?></span>
                            </span>
                            <span class="text-xs font-semibold text-[#888888] bg-[#FFF8F2] border border-[#F0E2D4] px-2 py-0.5 rounded-full group-hover:text-[#CC5600] group-hover:border-[#CC5600]/30 transition-colors">
                                <?php echo esc_html($cat->count); ?>
                            </span>
                        </a>
                    </li>
                <?php
                endforeach;
            else :
                // Graceful fallback categories if none created yet
                $demo_cats = array('Pooja Essentials', 'Spiritual Decor', 'Vastu Shastra', 'Festive Traditions', 'Sacred Idols');
                foreach ($demo_cats as $demo_cat) :
                ?>
                    <li class="py-3.5 first:pt-0 last:pb-0">
                        <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="flex items-center justify-between text-[#333333] hover:text-[#CC5600] font-medium text-[15px] transition-colors group">
                            <span class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-[#CC5600]/40 group-hover:bg-[#CC5600] transition-colors shrink-0"></span>
                                <span class="group-hover:translate-x-1 transition-transform"><?php echo esc_html($demo_cat); ?></span>
                            </span>
                            <span class="text-xs font-semibold text-[#888888] bg-[#FFF8F2] border border-[#F0E2D4] px-2 py-0.5 rounded-full group-hover:text-[#CC5600] transition-colors">1</span>
                        </a>
                    </li>
            <?php
                endforeach;
            endif;
            ?>
        </ul>
    </div>

    <!-- ─── 3. Latest Posts Widget ─── -->
    <div class="blog-widget bg-white border border-[#EAE3DC] rounded-2xl p-6 sm:p-8 shadow-xs">
        <div class="widget-header mb-6">
            <h3 class="widget-title text-xl md:text-2xl font-serif text-[#111111] font-medium pb-3 border-b-2 border-[#CC5600]/20 relative">
                <?php esc_html_e('Latest Posts', 'dharmgyan'); ?>
                <span class="absolute bottom-[-2px] left-0 w-12 h-[2px] bg-[#CC5600]"></span>
            </h3>
        </div>
        <div class="latest-posts-list flex flex-col gap-6">
            <?php
            $recent_posts = new WP_Query(array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'ignore_sticky_posts' => 1,
            ));

            if ($recent_posts->have_posts()) :
                while ($recent_posts->have_posts()) : $recent_posts->the_post();
                    $thumb_id  = get_post_thumbnail_id();
                    $thumb_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'medium') : get_template_directory_uri() . '/assets/images/blog/blog_card_1.png';
            ?>
                    <article class="latest-post-item flex items-center gap-4 group">
                        <a href="<?php the_permalink(); ?>" class="w-24 h-24 sm:w-28 sm:h-28 rounded-xl overflow-hidden shrink-0 bg-[#F9F5EB] border border-[#EAE3DC] relative block focus:outline-none">
                            <img 
                                src="<?php echo esc_url($thumb_url); ?>" 
                                alt="<?php the_title_attribute(); ?>" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                loading="lazy" 
                            />
                        </a>
                        <div class="flex-1 min-w-0">
                            <span class="text-xs font-semibold text-[#CC5600] font-body block mb-1">
                                <?php echo esc_html(get_the_date('d F, Y')); ?>
                            </span>
                            <h4 class="text-sm sm:text-[15px] font-semibold text-[#111111] group-hover:text-[#CC5600] transition-colors line-clamp-2 leading-snug mb-1.5 font-body">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <div class="flex items-center gap-1.5 text-xs text-[#777777] font-body">
                                <span class="text-[#999999]"><?php esc_html_e('by', 'dharmgyan'); ?></span>
                                <span class="font-medium text-[#444444]"><?php the_author(); ?></span>
                            </div>
                        </div>
                    </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>

    <!-- ─── 4. Popular Tags Widget ─── -->
    <div class="blog-widget bg-white border border-[#EAE3DC] rounded-2xl p-6 sm:p-8 shadow-xs">
        <div class="widget-header mb-5">
            <h3 class="widget-title text-xl md:text-2xl font-serif text-[#111111] font-medium pb-3 border-b-2 border-[#CC5600]/20 relative">
                <?php esc_html_e('Popular Tags', 'dharmgyan'); ?>
                <span class="absolute bottom-[-2px] left-0 w-12 h-[2px] bg-[#CC5600]"></span>
            </h3>
        </div>
        <div class="popular-tags-cloud flex flex-wrap gap-2">
            <?php
            $tags = get_tags(array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 12,
            ));

            if (!empty($tags)) :
                foreach ($tags as $tag) :
            ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="inline-block text-xs font-semibold text-[#CC5600] bg-[#FFF8F2] border border-[#F2DECF] hover:bg-[#CC5600] hover:text-white hover:border-[#CC5600] rounded-[4px] px-3.5 py-1.5 transition-all duration-200 focus:outline-none">
                        #<?php echo esc_html($tag->name); ?>
                    </a>
                <?php
                endforeach;
            else :
                // Graceful fallback tags
                $demo_tags = array('Vastu', 'Wall Art', 'Puja Samagri', 'Ganesh Idol', 'Brass Diya', 'Spiritual Energy', 'Home Decor', 'Bhakti');
                foreach ($demo_tags as $dtag) :
                ?>
                    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="inline-block text-xs font-semibold text-[#CC5600] bg-[#FFF8F2] border border-[#F2DECF] hover:bg-[#CC5600] hover:text-white hover:border-[#CC5600] rounded-[4px] px-3.5 py-1.5 transition-all duration-200 focus:outline-none">
                        #<?php echo esc_html($dtag); ?>
                    </a>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>

</aside>
