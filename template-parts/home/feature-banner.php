<?php
/**
 * Full-Width Feature Banner (Lord Ganesha Temple Banner)
 * Sourced dynamically from ACF Homepage Settings with mobile square banner support.
 * 
 * @package Dharmgyan
 */

$banner_img        = dharmgyan_get_field('feature_banner_image');
$banner_img_mobile = dharmgyan_get_field('feature_banner_image_mobile');
$banner_link       = dharmgyan_get_field('feature_banner_link') ?: home_url('/product-category/collections/');
$banner_alt        = dharmgyan_get_field('feature_banner_alt') ?: __('Lord Ganesha Temple Collection', 'dharmgyan');

// Helper to resolve URL from array/id/string
$resolve_img_url = function ($val) {
    if (is_array($val) && !empty($val['url'])) {
        return $val['url'];
    } elseif (is_numeric($val) && $val > 0) {
        return wp_get_attachment_image_url($val, 'full');
    } elseif (is_string($val) && !empty($val)) {
        return $val;
    }
    return '';
};

$bg_desktop = $resolve_img_url($banner_img) ?: get_theme_file_uri('/assets/images/banners/ganesha-feature-banner.png');
$bg_mobile  = $resolve_img_url($banner_img_mobile) ?: get_theme_file_uri('/assets/images/banners/ganesha-feature-banner-mobile.jpg');

if (empty($bg_desktop)) {
    return;
}
?>

<section class="home-feature-banner-section w-full bg-white my-8 md:my-12" aria-label="<?php echo esc_attr($banner_alt); ?>">
    <div class="max-w-[1580px] mx-auto px-4">
        <a href="<?php echo esc_url($banner_link); ?>" class="block w-full rounded-[6px] overflow-hidden shadow-sm relative group focus:outline-none focus:ring-2 focus:ring-[#CC5600]">
            <picture class="block w-full">
                <?php if (!empty($bg_mobile)) : ?>
                    <source media="(max-width: 767px)" srcset="<?php echo esc_url($bg_mobile); ?>">
                <?php endif; ?>
                <img 
                    src="<?php echo esc_url($bg_desktop); ?>" 
                    alt="<?php echo esc_attr($banner_alt); ?>" 
                    class="w-full h-auto md:h-[420px] lg:h-[500px] object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out" 
                    loading="lazy"
                />
            </picture>
        </a>
    </div>
</section>
