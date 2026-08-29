<?php
/**
 * Top Notice Bar Template Part - Pixel Perfect Figma
 * 
 * @package Dharmgyan
 */

$enable_topbar = dharmgyan_get_field('enable_topbar', 'option');
if ($enable_topbar === null) {
    $enable_topbar = true;
}

if (!$enable_topbar) {
    return;
}

$notice_text = dharmgyan_get_field('topbar_notice_text', 'option') ?: __('7% OFF on Prepaid', 'dharmgyan');
$cta_text    = dharmgyan_get_field('topbar_cta_text', 'option') ?: __('Shop now!', 'dharmgyan');
$cta_link    = dharmgyan_get_field('topbar_cta_link', 'option') ?: (function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'));
?>

<div class="site-topbar bg-[#FFF8F3] border-b border-[#EAE3DC] py-2 px-4 w-full">
    <div class="max-w-[1580px] mx-auto flex items-center justify-center gap-3">
        <div class="flex items-center gap-2">
            <!-- Wallet/Offer Icon matching Figma -->
            <svg class="w-4 h-4 text-[#CC5600] flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                <line x1="2" y1="10" x2="22" y2="10"></line>
                <circle cx="17" cy="14" r="1.5" fill="currentColor"></circle>
            </svg>
            <span class="font-bold text-[#CC5600] text-[13px] tracking-wide font-body"><?php echo esc_html($notice_text); ?></span>
        </div>
        
        <?php if ($cta_text && $cta_link): ?>
            <a href="<?php echo esc_url($cta_link); ?>" class="inline-flex items-center justify-center bg-[#CC5600] hover:bg-[#B34B00] text-white text-[11px] font-medium px-4 py-1 rounded-full transition-all shadow-none">
                <?php echo esc_html($cta_text); ?>
            </a>
        <?php endif; ?>
    </div>
</div>
