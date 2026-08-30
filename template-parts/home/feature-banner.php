<?php
/**
 * Full-Width Feature Banner (Lord Ganesha Temple Banner) - Matching Figma 1:1
 * Sourced dynamically from ACF Homepage Settings with fallback.
 * 
 * @package Dharmgyan
 */

$banner_img  = dharmgyan_get_field('feature_banner_image');
$banner_link = dharmgyan_get_field('feature_banner_link') ?: home_url('/product-category/collections/');
$banner_alt  = dharmgyan_get_field('feature_banner_alt') ?: __('Lord Ganesha Temple Collection', 'dharmgyan');

$bg_url = '';
if (is_array($banner_img) && !empty($banner_img['url'])) {
    $bg_url = $banner_img['url'];
} elseif (is_numeric($banner_img)) {
    $bg_url = wp_get_attachment_image_url($banner_img, 'full');
} elseif (is_string($banner_img) && !empty($banner_img)) {
    $bg_url = $banner_img;
} else {
    $bg_url = get_theme_file_uri('/assets/images/banners/ganesha-feature-banner.png');
}

if (empty($bg_url)) {
    return;
}
?>

<section class="home-feature-banner-section w-full bg-white pb-10 md:pb-16" aria-label="<?php echo esc_attr($banner_alt); ?>">
    <div class="max-w-[1580px] mx-auto px-4">
        <a href="<?php echo esc_url($banner_link); ?>" class="block w-full min-h-[220px] md:h-[420px] lg:h-[500px] rounded-[5px] overflow-hidden shadow-sm relative group focus:outline-none">
            <img 
                src="<?php echo esc_url($bg_url); ?>" 
                alt="<?php echo esc_attr($banner_alt); ?>" 
                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out" 
                loading="lazy"
            />
        </a>
    </div>
</section>
