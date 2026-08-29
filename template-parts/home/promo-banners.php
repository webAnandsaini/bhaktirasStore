<?php
/**
 * Homepage Dual Middle Promo Banners Template Part
 * Sourced purely from ACF fields on Homepage (Post ID: 109).
 * 
 * @package Dharmgyan
 */

$b1_img   = dharmgyan_get_field('promo_banner_1_image');
$b1_title = dharmgyan_get_field('promo_banner_1_title');
$b1_link  = dharmgyan_get_field('promo_banner_1_link');

$b2_img   = dharmgyan_get_field('promo_banner_2_image');
$b2_title = dharmgyan_get_field('promo_banner_2_title');
$b2_link  = dharmgyan_get_field('promo_banner_2_link');

$b1_url = is_array($b1_img) && !empty($b1_img['url']) ? $b1_img['url'] : (is_numeric($b1_img) ? wp_get_attachment_image_url($b1_img, 'full') : (is_string($b1_img) ? $b1_img : ''));
$b2_url = is_array($b2_img) && !empty($b2_img['url']) ? $b2_img['url'] : (is_numeric($b2_img) ? wp_get_attachment_image_url($b2_img, 'full') : (is_string($b2_img) ? $b2_img : ''));

if (empty($b1_url) && empty($b2_url)) {
    return;
}
?>

<section class="home-promo-banners-section w-full bg-white py-6 md:py-8" aria-label="<?php esc_attr_e('Promotional Banners', 'dharmgyan'); ?>">
    <div class="max-w-[1580px] mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-7">
            
            <!-- Banner 1 (Left) -->
            <?php if ($b1_url): ?>
                <div class="w-full h-[180px] sm:h-[220px] md:h-[260px] lg:h-[289px]">
                    <<?php echo $b1_link ? 'a href="' . esc_url($b1_link) . '"' : 'div'; ?> class="group block w-full h-full relative rounded-[5px] overflow-hidden shadow-sm focus:outline-none">
                        <img 
                            src="<?php echo esc_url($b1_url); ?>" 
                            alt="<?php echo esc_attr($b1_title ?: __('Promotional Banner', 'dharmgyan')); ?>" 
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
                            loading="lazy"
                        />
                        <?php if ($b1_title): ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent group-hover:from-black/70 transition-colors duration-300"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-5 md:p-6 z-10">
                                <span class="inline-block bg-white/95 text-[#111111] text-xs md:text-sm font-semibold px-4 py-2 rounded-[3px] shadow-sm group-hover:bg-[#CC5600] group-hover:text-white transition-colors duration-200">
                                    <?php echo esc_html($b1_title); ?> →
                                </span>
                            </div>
                        <?php else: ?>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition-colors duration-300"></div>
                        <?php endif; ?>
                    </<?php echo $b1_link ? 'a' : 'div'; ?>>
                </div>
            <?php endif; ?>

            <!-- Banner 2 (Right) -->
            <?php if ($b2_url): ?>
                <div class="w-full h-[180px] sm:h-[220px] md:h-[260px] lg:h-[289px]">
                    <<?php echo $b2_link ? 'a href="' . esc_url($b2_link) . '"' : 'div'; ?> class="group block w-full h-full relative rounded-[5px] overflow-hidden shadow-sm focus:outline-none">
                        <img 
                            src="<?php echo esc_url($b2_url); ?>" 
                            alt="<?php echo esc_attr($b2_title ?: __('Promotional Banner', 'dharmgyan')); ?>" 
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
                            loading="lazy"
                        />
                        <?php if ($b2_title): ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent group-hover:from-black/70 transition-colors duration-300"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-5 md:p-6 z-10">
                                <span class="inline-block bg-white/95 text-[#111111] text-xs md:text-sm font-semibold px-4 py-2 rounded-[3px] shadow-sm group-hover:bg-[#CC5600] group-hover:text-white transition-colors duration-200">
                                    <?php echo esc_html($b2_title); ?> →
                                </span>
                            </div>
                        <?php else: ?>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition-colors duration-300"></div>
                        <?php endif; ?>
                    </<?php echo $b2_link ? 'a' : 'div'; ?>>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
