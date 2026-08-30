<?php
/**
 * Homepage 'Sacred Darshan & Video Reels' Showcase Template Part
 * Sourced purely from ACF Homepage Settings (Tab: Video Reels).
 *
 * @package Dharmgyan
 */

$title = dharmgyan_get_field('video_reels_title') ?: __('Sacred Darshan & Video Reels', 'dharmgyan');
$reels = dharmgyan_get_field('video_reels_items');

if (empty($reels) || !is_array($reels)) {
    return;
}
?>

<section class="home-video-reels-section w-full bg-white py-10 md:py-16" aria-label="<?php echo esc_attr($title); ?>">
    <div class="max-w-[1580px] mx-auto px-4">

        <!-- Section Header -->
        <div class="text-center mb-6 md:mb-10">
            <h2 class="font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-tight">
                <?php echo esc_html($title); ?>
            </h2>
        </div>

        <!-- Video Swiper Carousel -->
        <div class="swiper videoSwiper relative">
            <div class="swiper-wrapper">
                <?php foreach ($reels as $reel): ?>
                    <?php
                    $poster_url = '';
                    if (is_array($reel['reel_thumbnail']) && !empty($reel['reel_thumbnail']['url'])) {
                        $poster_url = $reel['reel_thumbnail']['url'];
                    } elseif (is_numeric($reel['reel_thumbnail'])) {
                        $poster_url = wp_get_attachment_image_url($reel['reel_thumbnail'], 'large');
                    } elseif (is_string($reel['reel_thumbnail'])) {
                        $poster_url = $reel['reel_thumbnail'];
                    }

                    if (empty($poster_url)) continue;

                    $video_url     = !empty($reel['reel_video_url']) ? $reel['reel_video_url'] : '';
                    $views         = !empty($reel['reel_views']) ? $reel['reel_views'] : '5.1k';
                    $product_title = !empty($reel['reel_product_title']) ? $reel['reel_product_title'] : '';
                    $product_link  = !empty($reel['reel_product_link']) ? $reel['reel_product_link'] : home_url('/shop/');
                    ?>

                    <div class="swiper-slide">
                        <div class="relative aspect-[9/16] w-full rounded-[6px] overflow-hidden bg-black shadow-md group">

                            <!-- Poster Image -->
                            <img
                                src="<?php echo esc_url($poster_url); ?>"
                                alt="<?php echo esc_attr($product_title); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                loading="lazy"
                            />

                            <!-- Dark Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/30"></div>

                            <!-- View Count Badge (Top Left) -->
                            <div class="absolute top-3 left-3 bg-black/50 backdrop-blur-sm text-white text-xs px-2.5 py-1 rounded-full flex items-center gap-1.5 z-10">
                                <svg class="w-3.5 h-3.5 text-[#FFB23D]" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                                <span><?php echo esc_html($views); ?></span>
                            </div>

                            <!-- Play Icon (Center) -->
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">
                                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center group-hover:scale-110 group-hover:bg-[#CC5600] transition-all duration-300 shadow-lg">
                                    <svg class="w-5 h-5 translate-x-0.5" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                    </svg>
                                </div>
                            </div>

                            <!-- Bottom Product Link Badge -->
                            <?php if ($product_title): ?>
                                <div class="absolute bottom-0 left-0 right-0 p-3.5 z-10">
                                    <a href="<?php echo esc_url($product_link); ?>" class="block bg-white/95 backdrop-blur-sm text-[#111111] hover:text-[#CC5600] p-2.5 rounded-[4px] shadow-sm transition-colors text-xs md:text-sm font-medium line-clamp-1">
                                        <?php echo esc_html($product_title); ?> →
                                    </a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Navigation Arrows -->
            <div class="swiper-button-next !w-10 !h-10 !rounded-full !bg-white !shadow-lg !text-[#242424] after:!text-sm hover:!bg-[#CC5600] hover:!text-white transition-all"></div>
            <div class="swiper-button-prev !w-10 !h-10 !rounded-full !bg-white !shadow-lg !text-[#242424] after:!text-sm hover:!bg-[#CC5600] hover:!text-white transition-all"></div>
        </div>

    </div>
</section>
