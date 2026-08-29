<?php
/**
 * Homepage 'Product Videos' Showcase Template Part - Full-Width Playable Video Slider
 * Sourced purely from ACF Homepage Settings (Tab: Product Videos) with fallback.
 * 
 * @package Dharmgyan
 */

$title = dharmgyan_get_field('product_videos_title') ?: __('Product Videos', 'dharmgyan');
$items = dharmgyan_get_field('product_videos_items');

$default_demo_video = get_theme_file_uri('/assets/videos/demo-reel-1.mp4');

if (empty($items) || !is_array($items)) {
    $items = array(
        array(
            'video_poster'  => get_theme_file_uri('/assets/images/reels/reel-1.png'),
            'video_views'   => '7L',
            'video_url'     => $default_demo_video,
            'product_image' => get_theme_file_uri('/assets/images/products/prod-1.png'),
            'product_title' => 'Lord Venkateswara Swamy Acrylic Wall Art',
            'product_price' => '₹1,466.00',
            'product_link'  => home_url('/product-category/wall-art/'),
        ),
        array(
            'video_poster'  => get_theme_file_uri('/assets/images/reels/reel-2.png'),
            'video_views'   => '65k',
            'video_url'     => $default_demo_video,
            'product_image' => get_theme_file_uri('/assets/images/products/prod-2.png'),
            'product_title' => 'Premium Brass Aarti Diya with Handle',
            'product_price' => '₹3,706.00',
            'product_link'  => home_url('/product-category/aarti-diya/'),
        ),
        array(
            'video_poster'  => get_theme_file_uri('/assets/images/reels/reel-3.png'),
            'video_views'   => '2L',
            'video_url'     => $default_demo_video,
            'product_image' => get_theme_file_uri('/assets/images/products/prod-3.png'),
            'product_title' => 'Handcrafted Ganesha Temple Idol',
            'product_price' => '₹3,706.00',
            'product_link'  => home_url('/product-category/collections/'),
        ),
        array(
            'video_poster'  => get_theme_file_uri('/assets/images/reels/reel-4.png'),
            'video_views'   => '96k',
            'video_url'     => $default_demo_video,
            'product_image' => get_theme_file_uri('/assets/images/products/prod-4.png'),
            'product_title' => 'Divine Krishna Illumination Wall Decor',
            'product_price' => '₹3,706.00',
            'product_link'  => home_url('/product-category/home-decor/'),
        ),
        array(
            'video_poster'  => get_theme_file_uri('/assets/images/reels/reel-5.png'),
            'video_views'   => '3L',
            'video_url'     => $default_demo_video,
            'product_image' => get_theme_file_uri('/assets/images/products/prod-5.png'),
            'product_title' => 'Seven Running White Horses Wall Art',
            'product_price' => '₹3,706.00',
            'product_link'  => home_url('/product-category/wall-art/'),
        ),
    );
}
?>

<section class="home-product-videos-section w-full bg-white py-10 md:py-16 overflow-hidden" aria-label="<?php echo esc_attr($title); ?>">
    
    <!-- Section Header (Centered in Container) -->
    <div class="max-w-[1580px] mx-auto px-4 text-center mb-8 md:mb-12">
        <h2 class="font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-tight">
            <?php echo esc_html($title); ?>
        </h2>
    </div>

    <!-- Full-Width Product Videos Swiper Slider -->
    <div class="w-full px-3 sm:px-6 lg:px-8">
        <div class="swiper productVideosSwiper relative w-full overflow-hidden">
            <div class="swiper-wrapper">
                <?php foreach ($items as $item): ?>
                    <?php
                    $poster_url = '';
                    if (is_array($item['video_poster']) && !empty($item['video_poster']['url'])) {
                        $poster_url = $item['video_poster']['url'];
                    } elseif (is_numeric($item['video_poster'])) {
                        $poster_url = wp_get_attachment_image_url($item['video_poster'], 'large');
                    } elseif (is_string($item['video_poster'])) {
                        $poster_url = $item['video_poster'];
                    }

                    if (empty($poster_url)) continue;

                    $views       = !empty($item['video_views']) ? $item['video_views'] : '65k';
                    $prod_title  = !empty($item['product_title']) ? $item['product_title'] : '';
                    $prod_price  = !empty($item['product_price']) ? $item['product_price'] : '';
                    $prod_link   = !empty($item['product_link']) ? $item['product_link'] : home_url('/shop/');
                    $video_url   = !empty($item['video_url']) ? $item['video_url'] : $default_demo_video;
                    
                    $prod_img_url = '';
                    if (!empty($item['product_image'])) {
                        if (is_array($item['product_image']) && !empty($item['product_image']['url'])) {
                            $prod_img_url = $item['product_image']['url'];
                        } elseif (is_numeric($item['product_image'])) {
                            $prod_img_url = wp_get_attachment_image_url($item['product_image'], 'thumbnail');
                        } elseif (is_string($item['product_image'])) {
                            $prod_img_url = $item['product_image'];
                        }
                    }
                    ?>
                    
                    <div class="swiper-slide">
                        <div class="product-reel-card relative aspect-[9/16] w-full rounded-[6px] overflow-hidden bg-black shadow-md group cursor-pointer select-none" data-video-url="<?php echo esc_url($video_url); ?>">
                            
                            <!-- Video Element (Hidden until clicked) -->
                            <video 
                                class="reel-video absolute inset-0 w-full h-full object-cover z-0 hidden" 
                                src="<?php echo esc_url($video_url); ?>" 
                                playsinline 
                                loop 
                                preload="metadata"
                            ></video>

                            <!-- Video Poster Image -->
                            <img 
                                src="<?php echo esc_url($poster_url); ?>" 
                                alt="<?php echo esc_attr($prod_title ?: __('Product Video', 'dharmgyan')); ?>" 
                                class="reel-poster w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                                loading="lazy"
                            />
                            
                            <!-- Gradient Overlay -->
                            <div class="reel-overlay absolute inset-0 bg-gradient-to-t from-black/85 via-transparent to-black/35 pointer-events-none transition-opacity duration-300"></div>
                            
                            <!-- Top View Count Badge -->
                            <div class="absolute top-3.5 left-3.5 bg-black/50 backdrop-blur-sm text-white text-xs px-2.5 py-1 rounded-full flex items-center gap-1.5 z-10 font-body pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-[#FFB23D]" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                </svg>
                                <span><?php echo esc_html($views); ?></span>
                            </div>

                            <!-- Mute/Unmute Sound Button (shown when playing) -->
                            <button type="button" class="reel-mute-btn absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-black/60 text-white flex items-center justify-center z-20 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto hover:bg-[#CC5600] transition-all cursor-pointer" aria-label="Toggle Mute" onclick="event.stopPropagation();">
                                <svg class="icon-muted w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                    <line x1="23" y1="9" x2="17" y2="15"></line>
                                    <line x1="17" y1="9" x2="23" y2="15"></line>
                                </svg>
                                <svg class="icon-unmuted w-4 h-4 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                                </svg>
                            </button>

                            <!-- Center Play / Pause Icon Button -->
                            <div class="reel-play-indicator absolute inset-0 flex items-center justify-center pointer-events-none z-10">
                                <div class="w-12 h-12 rounded-full bg-white/30 backdrop-blur-sm text-white flex items-center justify-center group-hover:scale-110 group-hover:bg-[#CC5600] transition-all duration-300 shadow-lg">
                                    <svg class="icon-play w-5 h-5 translate-x-0.5" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                    </svg>
                                    <svg class="icon-pause w-5 h-5 hidden" viewBox="0 0 24 24" fill="currentColor">
                                        <rect x="6" y="4" width="4" height="16"></rect>
                                        <rect x="14" y="4" width="4" height="16"></rect>
                                    </svg>
                                </div>
                            </div>

                            <!-- Floating Bottom Product Card matching Figma -->
                            <?php if ($prod_title): ?>
                                <div class="absolute bottom-3 left-3 right-3 z-20" onclick="event.stopPropagation();">
                                    <a href="<?php echo esc_url($prod_link); ?>" class="flex items-center gap-2.5 bg-white/95 backdrop-blur-sm hover:bg-white p-2 rounded-[5px] shadow-lg transition-colors group/card">
                                        <?php if ($prod_img_url): ?>
                                            <div class="w-11 h-11 rounded-[3px] overflow-hidden bg-gray-100 flex-shrink-0">
                                                <img src="<?php echo esc_url($prod_img_url); ?>" alt="<?php echo esc_attr($prod_title); ?>" class="w-full h-full object-cover" />
                                            </div>
                                        <?php endif; ?>
                                        <div class="overflow-hidden flex-1 text-left">
                                            <h4 class="font-body text-[#111111] group-hover/card:text-[#CC5600] text-xs font-medium line-clamp-1 leading-tight transition-colors">
                                                <?php echo esc_html($prod_title); ?>
                                            </h4>
                                            <?php if ($prod_price): ?>
                                                <p class="text-[#CC5600] text-[11px] font-semibold font-body mt-0.5">
                                                    <?php echo esc_html($prod_price); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Navigation Buttons -->
            <div class="swiper-button-next !w-10 !h-10 !rounded-full !bg-white !shadow-lg !text-[#242424] after:!text-sm hover:!bg-[#CC5600] hover:!text-white transition-all"></div>
            <div class="swiper-button-prev !w-10 !h-10 !rounded-full !bg-white !shadow-lg !text-[#242424] after:!text-sm hover:!bg-[#CC5600] hover:!text-white transition-all"></div>
        </div>
    </div>

</section>
