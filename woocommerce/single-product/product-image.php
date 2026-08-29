<?php
/**
 * Single Product Image Gallery Component - Pixel-Perfect Figma 1:3218
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
$main_img_url      = $post_thumbnail_id ? wp_get_attachment_image_url($post_thumbnail_id, 'full') : wc_placeholder_img_src('woocommerce_single');
$main_img_thumb    = $post_thumbnail_id ? wp_get_attachment_image_url($post_thumbnail_id, 'woocommerce_single') : wc_placeholder_img_src('woocommerce_single');
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
?>

<div class="dharmgyan-product-gallery w-full" id="dharmgyan-product-gallery">
    <!-- Main Feature Image Viewport (769x769 aspect-square) -->
    <div class="main-gallery-viewport relative aspect-square w-full rounded-[5px] overflow-hidden bg-[#F9F9F9] border border-[#EAE3DC] shadow-xs group">
        <img
            id="gallery-main-image"
            src="<?php echo esc_url($main_img_thumb); ?>"
            data-zoom-src="<?php echo esc_url($main_img_url); ?>"
            alt="<?php echo esc_attr($product_title); ?>"
            class="w-full h-full object-cover object-center transition-all duration-300 cursor-crosshair"
            width="769"
            height="769"
            loading="eager"
            fetchpriority="high"
        />

        <!-- Sale Badge -->
        <?php if ($is_on_sale): ?>
            <span class="absolute top-3.5 left-3.5 bg-[#CC5600] text-white text-xs font-bold px-3 py-1 rounded-[3px] shadow-sm z-10">
                <?php esc_html_e('SALE', 'dharmgyan'); ?>
            </span>
        <?php endif; ?>

        <!-- Fullscreen / Zoom Trigger Button -->
        <a
            id="gallery-zoom-trigger"
            href="<?php echo esc_url($main_img_url); ?>"
            class="absolute bottom-3.5 right-3.5 w-10 h-10 rounded-full bg-white/90 hover:bg-white text-[#111111] hover:text-[#CC5600] flex items-center justify-center shadow-md transition-all duration-200 opacity-80 group-hover:opacity-100 focus:outline-none"
            aria-label="<?php esc_attr_e('View larger image', 'dharmgyan'); ?>"
            target="_blank"
            rel="noopener noreferrer"
        >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 3 21 3 21 9"></polyline>
                <polyline points="9 21 3 21 3 15"></polyline>
                <line x1="21" y1="3" x2="14" y2="10"></line>
                <line x1="3" y1="21" x2="10" y2="14"></line>
            </svg>
        </a>
    </div>

    <!-- Gallery Thumbnails Strip (118x118px matching Figma) -->
    <?php if (count($gallery_items) > 1): ?>
        <div class="gallery-thumbnails-strip flex items-center gap-3 mt-4 overflow-x-auto pb-2 scrollbar-thin">
            <?php foreach ($gallery_items as $index => $item): ?>
                <button
                    type="button"
                    class="gallery-thumb-item shrink-0 w-20 h-20 sm:w-24 sm:h-24 md:w-[110px] md:h-[110px] aspect-square rounded-[4px] overflow-hidden bg-[#F9F9F9] border-2 <?php echo $index === 0 ? 'border-[#111111] active-thumb shadow-xs' : 'border-[#E5E5E5] hover:border-[#CC5600] opacity-75 hover:opacity-100'; ?> transition-all duration-200 focus:outline-none"
                    data-large-src="<?php echo esc_url($item['large_url']); ?>"
                    data-full-src="<?php echo esc_url($item['full_url']); ?>"
                    aria-label="<?php echo esc_attr(sprintf(__('View image %d', 'dharmgyan'), $index + 1)); ?>"
                >
                    <img
                        src="<?php echo esc_url($item['thumb_url']); ?>"
                        alt="<?php echo esc_attr($item['alt']); ?>"
                        class="w-full h-full object-cover object-center pointer-events-none"
                        loading="lazy"
                    />
                </button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
