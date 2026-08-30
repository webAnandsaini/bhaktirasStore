<?php
/**
 * Single Product Image Gallery Component - Pixel-Perfect Figma 1:3218
 * Swiper Slider for Main Viewport, Synchronized Thumbnails & Fullscreen Lightbox Slider.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

global $product;

if (!is_a($product, 'WC_Product')) {
    return;
}

$post_thumbnail_id = $product->get_image_id();
$attachment_ids    = $product->get_gallery_image_ids();
$product_title     = get_the_title();
$is_on_sale        = $product->is_on_sale();

// Gather all gallery images into a single indexed list
$gallery_items = array();
if ($post_thumbnail_id) {
    $gallery_items[] = array(
        'id'        => $post_thumbnail_id,
        'full_url'  => wp_get_attachment_image_url($post_thumbnail_id, 'full'),
        'large_url' => wp_get_attachment_image_url($post_thumbnail_id, 'woocommerce_single') ?: wp_get_attachment_image_url($post_thumbnail_id, 'large'),
        'thumb_url' => wp_get_attachment_image_url($post_thumbnail_id, 'thumbnail'),
        'alt'       => get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true) ?: $product_title,
    );
}

if (!empty($attachment_ids)) {
    foreach ($attachment_ids as $attachment_id) {
        $gallery_items[] = array(
            'id'        => $attachment_id,
            'full_url'  => wp_get_attachment_image_url($attachment_id, 'full'),
            'large_url' => wp_get_attachment_image_url($attachment_id, 'woocommerce_single') ?: wp_get_attachment_image_url($attachment_id, 'large'),
            'thumb_url' => wp_get_attachment_image_url($attachment_id, 'thumbnail'),
            'alt'       => get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ?: $product_title,
        );
    }
}

if (empty($gallery_items)) {
    $placeholder = wc_placeholder_img_src('woocommerce_single');
    $gallery_items[] = array(
        'id'        => 0,
        'full_url'  => $placeholder,
        'large_url' => $placeholder,
        'thumb_url' => $placeholder,
        'alt'       => $product_title,
    );
}
?>

<div class="dharmgyan-product-gallery w-full relative select-none" id="dharmgyan-product-gallery">
    
    <!-- Main Feature Image Viewport (Square with Swiper Slider) -->
    <div class="main-gallery-viewport relative w-full aspect-square rounded-[6px] overflow-hidden bg-[#F9F9F9] border border-[#EAE3DC] shadow-xs group">
        
        <div class="swiper productMainSwiper w-full h-full">
            <div class="swiper-wrapper w-full h-full">
                <?php foreach ($gallery_items as $index => $item): ?>
                    <div class="swiper-slide w-full h-full flex items-center justify-center overflow-hidden bg-[#F9F9F9]">
                        <img
                            src="<?php echo esc_url($item['large_url']); ?>"
                            data-full-src="<?php echo esc_url($item['full_url']); ?>"
                            alt="<?php echo esc_attr($item['alt']); ?>"
                            class="gallery-slide-img w-full h-full object-cover object-center cursor-pointer"
                            width="769"
                            height="769"
                            loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                        />
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sale Badge -->
        <?php if ($is_on_sale): ?>
            <span class="absolute top-3.5 left-3.5 bg-[#CC5600] text-white text-xs font-bold px-3 py-1 rounded-[3px] shadow-sm z-20 pointer-events-none font-body">
                <?php esc_html_e('SALE', 'dharmgyan'); ?>
            </span>
        <?php endif; ?>

        <!-- Fullscreen / Zoom Trigger Button -->
        <button
            type="button"
            id="gallery-zoom-trigger"
            class="absolute bottom-3.5 right-3.5 w-10 h-10 rounded-full bg-white/95 hover:bg-[#CC5600] text-[#111111] hover:text-white flex items-center justify-center shadow-md transition-all duration-200 z-20 cursor-pointer focus:outline-none"
            aria-label="<?php esc_attr_e('View fullscreen gallery', 'dharmgyan'); ?>"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 3 21 3 21 9"></polyline>
                <polyline points="9 21 3 21 3 15"></polyline>
                <line x1="21" y1="3" x2="14" y2="10"></line>
                <line x1="3" y1="21" x2="10" y2="14"></line>
            </svg>
        </button>

        <!-- Slider Arrows on Main Gallery -->
        <?php if (count($gallery_items) > 1): ?>
            <button type="button" class="product-main-prev swiper-button-prev !w-10 !h-10 !rounded-full !bg-white/90 hover:!bg-[#CC5600] !text-[#242424] hover:!text-white after:!hidden transition-all duration-300 flex items-center justify-center !left-3 z-20 focus:outline-none shadow-md cursor-pointer opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <button type="button" class="product-main-next swiper-button-next !w-10 !h-10 !rounded-full !bg-white/90 hover:!bg-[#CC5600] !text-[#242424] hover:!text-white after:!hidden transition-all duration-300 flex items-center justify-center !right-3 z-20 focus:outline-none shadow-md cursor-pointer opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        <?php endif; ?>
    </div>

    <!-- Gallery Thumbnails Strip (Padding added to prevent border clipping) -->
    <?php if (count($gallery_items) > 1): ?>
        <div class="gallery-thumbnails-strip flex items-center gap-3 mt-3 overflow-x-auto pt-2 pb-3 px-1.5 scrollbar-thin">
            <?php foreach ($gallery_items as $index => $item): ?>
                <button
                    type="button"
                    class="gallery-thumb-item shrink-0 w-20 h-20 sm:w-24 sm:h-24 md:w-[100px] md:h-[100px] aspect-square rounded-[6px] p-0.5 bg-white border-2 <?php echo $index === 0 ? 'border-[#CC5600] active-thumb shadow-xs' : 'border-[#EAE3DC] hover:border-[#CC5600] opacity-80 hover:opacity-100'; ?> transition-all duration-200 focus:outline-none cursor-pointer"
                    data-slide-index="<?php echo $index; ?>"
                    aria-label="<?php echo esc_attr(sprintf(__('View image %d', 'dharmgyan'), $index + 1)); ?>"
                >
                    <img
                        src="<?php echo esc_url($item['thumb_url']); ?>"
                        alt="<?php echo esc_attr($item['alt']); ?>"
                        class="w-full h-full object-cover object-center rounded-[4px] pointer-events-none"
                        loading="lazy"
                    />
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Fullscreen Lightbox Modal Slider (30% Dark Overlay + Blur + Perfectly Centered Image) -->
    <div id="product-gallery-lightbox" class="product-gallery-lightbox fixed inset-0 z-50 bg-black/30 backdrop-blur-md hidden flex items-center justify-center p-4 sm:p-8">
        <!-- Close Button (Dark semi-transparent circle for high contrast against 30% overlay) -->
        <button type="button" id="lightbox-close-btn" class="absolute top-4 right-4 sm:top-6 sm:right-6 w-11 h-11 rounded-full bg-[#111111]/80 hover:bg-[#CC5600] text-white flex items-center justify-center transition-all z-50 cursor-pointer focus:outline-none shadow-xl border border-white/20">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <!-- Lightbox Swiper Container (Centered) -->
        <div class="swiper productLightboxSwiper w-full max-w-5xl h-[85vh] flex items-center justify-center relative">
            <div class="swiper-wrapper w-full h-full items-center">
                <?php foreach ($gallery_items as $item): ?>
                    <div class="swiper-slide w-full h-full !flex items-center justify-center select-none text-center">
                        <img
                            src="<?php echo esc_url($item['full_url']); ?>"
                            alt="<?php echo esc_attr($item['alt']); ?>"
                            class="max-h-[80vh] max-w-[80vw] object-contain rounded-[6px] shadow-2xl mx-auto block"
                        />
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Nav Arrows -->
            <button type="button" class="lightbox-prev swiper-button-prev !w-12 !h-12 !rounded-full !bg-[#111111]/80 hover:!bg-[#CC5600] !text-white after:!hidden transition-all duration-300 flex items-center justify-center cursor-pointer !left-2 focus:outline-none shadow-xl border border-white/20">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <button type="button" class="lightbox-next swiper-button-next !w-12 !h-12 !rounded-full !bg-[#111111]/80 hover:!bg-[#CC5600] !text-white after:!hidden transition-all duration-300 flex items-center justify-center cursor-pointer !right-2 focus:outline-none shadow-xl border border-white/20">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </div>
</div>
