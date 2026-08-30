<?php
/**
 * Dynamic Product Videos Slider (Reels with Floating Attached Product Cards)
 * Full-width continuous slider with real video playback & sound toggle.
 *
 * @package Dharmgyan
 */

$title = dharmgyan_get_field('product_videos_title') ?: dharmgyan_get_field('product_videos_title', 'option');
$items = dharmgyan_get_field('product_videos_items');

if (empty($items)) {
    $items = dharmgyan_get_field('product_videos_items', 'option');
}

$default_demo_video = get_theme_file_uri('/assets/videos/demo-reel-1.mp4');

// Default fallback items matching Figma 1:1 if ACF is empty
if (empty($items) || !is_array($items)) {
    $items = array(
        array(
            'poster_image'  => get_theme_file_uri('/assets/images/reels/reel-1.png'),
            'video_url'     => $default_demo_video,
            'view_count'    => '2L',
            'product_title' => 'Handcrafted Ganesha Idol',
            'product_price' => '₹ 3,706.00',
            'product_link'  => home_url('/shop/'),
            'product_image' => get_theme_file_uri('/assets/images/products/prod-1.png'),
        ),
        array(
            'poster_image'  => get_theme_file_uri('/assets/images/reels/reel-2.png'),
            'video_url'     => $default_demo_video,
            'view_count'    => '96k',
            'product_title' => 'Divine Krishna Murti',
            'product_price' => '₹ 3,706.00',
            'product_link'  => home_url('/shop/'),
            'product_image' => get_theme_file_uri('/assets/images/products/prod-2.png'),
        ),
        array(
            'poster_image'  => get_theme_file_uri('/assets/images/reels/reel-3.png'),
            'video_url'     => $default_demo_video,
            'view_count'    => '3L',
            'product_title' => 'Seven Running Horses Vastu',
            'product_price' => '₹ 3,706.00',
            'product_link'  => home_url('/shop/'),
            'product_image' => get_theme_file_uri('/assets/images/products/prod-3.png'),
        ),
        array(
            'poster_image'  => get_theme_file_uri('/assets/images/reels/reel-4.png'),
            'video_url'     => $default_demo_video,
            'view_count'    => '1.5L',
            'product_title' => 'Brass Pooja Thali Set',
            'product_price' => '₹ 2,499.00',
            'product_link'  => home_url('/shop/'),
            'product_image' => get_theme_file_uri('/assets/images/products/prod-4.png'),
        ),
        array(
            'poster_image'  => get_theme_file_uri('/assets/images/reels/reel-5.png'),
            'video_url'     => $default_demo_video,
            'view_count'    => '50k',
            'product_title' => 'Marble Shivling with Trishul',
            'product_price' => '₹ 4,199.00',
            'product_link'  => home_url('/shop/'),
            'product_image' => get_theme_file_uri('/assets/images/products/prod-5.png'),
        ),
        array(
            'poster_image'  => get_theme_file_uri('/assets/images/reels/reel-1.png'),
            'video_url'     => $default_demo_video,
            'view_count'    => '80k',
            'product_title' => 'Sacred Brass Aarti Lamp',
            'product_price' => '₹ 1,899.00',
            'product_link'  => home_url('/shop/'),
            'product_image' => get_theme_file_uri('/assets/images/products/prod-1.png'),
        ),
    );
}
?>

<section class="home-product-videos-section w-full bg-white my-10 md:my-16 overflow-hidden" aria-label="<?php echo esc_attr($title ?: __('Product Videos', 'dharmgyan')); ?>">
    
    <!-- Section Header (Only rendered if title exists in backend) -->
    <?php if ($title): ?>
        <div class="max-w-[1580px] mx-auto px-4 mb-6 md:mb-10">
            <h2 class="font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-tight text-center">
                <?php echo esc_html($title); ?>
            </h2>
        </div>
    <?php endif; ?>

    <!-- Full-Width Edge-to-Edge Swiper Reel Slider -->
    <div class="w-full px-3 sm:px-6 lg:px-8">
        <div class="swiper productVideosSwiper relative w-full overflow-visible py-2">
            <div class="swiper-wrapper items-center">
                <?php foreach ($items as $item): ?>
                    <?php
                    $poster_url = '';
                    if (!empty($item['poster_image'])) {
                        if (is_array($item['poster_image']) && !empty($item['poster_image']['url'])) {
                            $poster_url = $item['poster_image']['url'];
                        } elseif (is_numeric($item['poster_image'])) {
                            $poster_url = wp_get_attachment_image_url($item['poster_image'], 'large');
                        } elseif (is_string($item['poster_image'])) {
                            $poster_url = $item['poster_image'];
                        }
                    }

                    if (empty($poster_url)) {
                        $poster_url = get_theme_file_uri('/assets/images/reels/reel-1.png');
                    }

                    $views       = !empty($item['view_count']) ? $item['view_count'] : '';
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
                        <div class="product-reel-card relative aspect-[9/16] w-full rounded-[8px] overflow-hidden bg-black shadow-md group cursor-pointer select-none" data-video-url="<?php echo esc_url($video_url); ?>">

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
                            <?php if ($views): ?>
                                <div class="absolute top-3.5 left-3.5 bg-black/50 backdrop-blur-sm text-white text-xs px-2.5 py-1 rounded-full flex items-center gap-1.5 z-10 font-body pointer-events-none">
                                    <svg class="w-3.5 h-3.5 text-[#FFB23D]" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                    </svg>
                                    <span><?php echo esc_html($views); ?></span>
                                </div>
                            <?php endif; ?>

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

            <!-- Custom Styled Slider Navigation Arrows (Spiritual Luxury Aesthetic) -->
            <button type="button" class="swiper-button-prev !w-11 !h-11 md:!w-12 md:!h-12 !rounded-full !bg-white/95 backdrop-blur-md !border !border-[#EAE3DC] hover:!border-[#CC5600] !shadow-lg hover:!shadow-xl !text-[#242424] hover:!text-white hover:!bg-[#CC5600] transition-all duration-300 flex items-center justify-center after:!hidden group !left-2 md:!left-4 z-30 focus:outline-none cursor-pointer" aria-label="<?php esc_attr_e('Previous Video', 'dharmgyan'); ?>">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <button type="button" class="swiper-button-next !w-11 !h-11 md:!w-12 md:!h-12 !rounded-full !bg-white/95 backdrop-blur-md !border !border-[#EAE3DC] hover:!border-[#CC5600] !shadow-lg hover:!shadow-xl !text-[#242424] hover:!text-white hover:!bg-[#CC5600] transition-all duration-300 flex items-center justify-center after:!hidden group !right-2 md:!right-4 z-30 focus:outline-none cursor-pointer" aria-label="<?php esc_attr_e('Next Video', 'dharmgyan'); ?>">
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </div>

</section>
