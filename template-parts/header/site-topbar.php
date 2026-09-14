<?php
/**
 * Top Notice Bar Template Part - Continuous Infinite Right-to-Left Sliding Strip
 * Sourced dynamically from ACF Theme Settings (topbar_items repeater).
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

$enable_topbar = dharmgyan_get_field('enable_topbar', 'option');
if ($enable_topbar === null) {
    $enable_topbar = true;
}

if (!$enable_topbar) {
    return;
}

$raw_items = dharmgyan_get_field('topbar_items', 'option');

// Default fallback items matching user reference if empty in backend
if (empty($raw_items) || !is_array($raw_items)) {
    $raw_items = array(
        array(
            'icon_text'  => '🎁',
            'text'       => __('Shop ₹2,999+ & Get a Free Tulsi Mala', 'dharmgyan'),
            'link'       => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
        ),
        array(
            'icon_text'  => '🚚',
            'text'       => __('Free Shipping on Eligible Orders', 'dharmgyan'),
            'link'       => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
        ),
        array(
            'icon_text'  => '🔒',
            'text'       => __('Secure Payments', 'dharmgyan'),
            'link'       => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : home_url('/checkout/'),
        ),
        array(
            'icon_text'  => '🎁',
            'text'       => __('Perfect for Gifting', 'dharmgyan'),
            'link'       => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
        ),
        array(
            'icon_text'  => '✨',
            'text'       => __('Carefully Selected Products', 'dharmgyan'),
            'link'       => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
        ),
    );
}

// Ensure Set 1 has sufficient items to span ultrawide monitors smoothly
$items_set = $raw_items;
while (count($items_set) < 6) {
    $items_set = array_merge($items_set, $raw_items);
}
?>

<div class="site-topbar relative w-full bg-[#FFF8F3] border-b border-[#EAE3DC] py-1.5 sm:py-2 overflow-hidden select-none z-30 font-body" role="region" aria-label="<?php esc_attr_e('Announcements', 'dharmgyan'); ?>">
    <div class="topbar-marquee-wrapper relative flex overflow-hidden w-full">
        <div class="topbar-marquee-track flex items-center whitespace-nowrap">
            
            <!-- Set 1 (Original track) -->
            <div class="topbar-marquee-set flex items-center shrink-0">
                <?php foreach ($items_set as $item): 
                    $icon_img = !empty($item['icon_image']) ? $item['icon_image'] : null;
                    $icon_url = '';
                    if ($icon_img) {
                        $icon_url = is_array($icon_img) ? ($icon_img['url'] ?? '') : (is_numeric($icon_img) ? wp_get_attachment_image_url($icon_img, 'thumbnail') : $icon_img);
                    }
                    $icon_text = !empty($item['icon_text']) ? trim($item['icon_text']) : '';
                    $text      = !empty($item['text']) ? trim($item['text']) : '';
                    $link      = !empty($item['link']) ? trim($item['link']) : '';
                    if (empty($text)) continue;
                ?>
                    <?php if ($link): ?>
                        <a href="<?php echo esc_url($link); ?>" class="topbar-item group inline-flex items-center gap-1.5 text-[12.5px] sm:text-[13px] font-bold text-[#222222] hover:text-[#CC5600] tracking-wide transition-colors py-0.5">
                            <?php if ($icon_url): ?>
                                <img src="<?php echo esc_url($icon_url); ?>" alt="" class="w-4 h-4 object-contain shrink-0 group-hover:scale-110 transition-transform" />
                            <?php elseif ($icon_text): ?>
                                <span class="text-[14px] leading-none shrink-0 group-hover:scale-110 transition-transform" aria-hidden="true"><?php echo esc_html($icon_text); ?></span>
                            <?php endif; ?>
                            <span class="whitespace-nowrap"><?php echo esc_html($text); ?></span>
                        </a>
                    <?php else: ?>
                        <div class="topbar-item inline-flex items-center gap-1.5 text-[12.5px] sm:text-[13px] font-bold text-[#222222] tracking-wide py-0.5">
                            <?php if ($icon_url): ?>
                                <img src="<?php echo esc_url($icon_url); ?>" alt="" class="w-4 h-4 object-contain shrink-0" />
                            <?php elseif ($icon_text): ?>
                                <span class="text-[14px] leading-none shrink-0" aria-hidden="true"><?php echo esc_html($icon_text); ?></span>
                            <?php endif; ?>
                            <span class="whitespace-nowrap"><?php echo esc_html($text); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Separator -->
                    <span class="topbar-separator mx-4 sm:mx-6 text-[#D4C8BC] font-normal select-none" aria-hidden="true">|</span>
                <?php endforeach; ?>
            </div>

            <!-- Set 2 (Identical duplicate for seamless continuous right-to-left loop) -->
            <div class="topbar-marquee-set flex items-center shrink-0" aria-hidden="true">
                <?php foreach ($items_set as $item): 
                    $icon_img = !empty($item['icon_image']) ? $item['icon_image'] : null;
                    $icon_url = '';
                    if ($icon_img) {
                        $icon_url = is_array($icon_img) ? ($icon_img['url'] ?? '') : (is_numeric($icon_img) ? wp_get_attachment_image_url($icon_img, 'thumbnail') : $icon_img);
                    }
                    $icon_text = !empty($item['icon_text']) ? trim($item['icon_text']) : '';
                    $text      = !empty($item['text']) ? trim($item['text']) : '';
                    $link      = !empty($item['link']) ? trim($item['link']) : '';
                    if (empty($text)) continue;
                ?>
                    <?php if ($link): ?>
                        <a href="<?php echo esc_url($link); ?>" tabindex="-1" class="topbar-item group inline-flex items-center gap-1.5 text-[12.5px] sm:text-[13px] font-bold text-[#222222] hover:text-[#CC5600] tracking-wide transition-colors py-0.5">
                            <?php if ($icon_url): ?>
                                <img src="<?php echo esc_url($icon_url); ?>" alt="" class="w-4 h-4 object-contain shrink-0 group-hover:scale-110 transition-transform" />
                            <?php elseif ($icon_text): ?>
                                <span class="text-[14px] leading-none shrink-0 group-hover:scale-110 transition-transform"><?php echo esc_html($icon_text); ?></span>
                            <?php endif; ?>
                            <span class="whitespace-nowrap"><?php echo esc_html($text); ?></span>
                        </a>
                    <?php else: ?>
                        <div class="topbar-item inline-flex items-center gap-1.5 text-[12.5px] sm:text-[13px] font-bold text-[#222222] tracking-wide py-0.5">
                            <?php if ($icon_url): ?>
                                <img src="<?php echo esc_url($icon_url); ?>" alt="" class="w-4 h-4 object-contain shrink-0" />
                            <?php elseif ($icon_text): ?>
                                <span class="text-[14px] leading-none shrink-0"><?php echo esc_html($icon_text); ?></span>
                            <?php endif; ?>
                            <span class="whitespace-nowrap"><?php echo esc_html($text); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Separator -->
                    <span class="topbar-separator mx-4 sm:mx-6 text-[#D4C8BC] font-normal select-none">|</span>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>
