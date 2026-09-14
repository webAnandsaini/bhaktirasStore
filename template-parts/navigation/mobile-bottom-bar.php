<?php
/**
 * Mobile App-Style Bottom Control Bar (Fixed Bottom Navigation)
 *
 * @package Dharmgyan
 */

$enable_bottom_bar = dharmgyan_get_field('enable_mobile_bottom_bar', 'option');
if ($enable_bottom_bar === null || $enable_bottom_bar === '') {
    $enable_bottom_bar = true;
}

if (!$enable_bottom_bar) {
    return;
}

// Navigation URLs & Active states
$home_url    = home_url('/');
$is_home     = is_front_page() || (is_home() && !is_front_page());

$cart_url    = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/');
$is_cart     = function_exists('is_cart') && is_cart();
$cart_count  = (function_exists('WC') && WC()->cart) ? WC()->cart->get_cart_contents_count() : 0;

$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/');
$is_account  = function_exists('is_account_page') && is_account_page();
?>

<!-- Mobile App-Style Fixed Bottom Control Bar (Max Width <= 640px, Scroll > 300px) -->
<nav class="mobile-bottom-control-bar fixed bottom-0 left-0 right-0 z-50 sm:hidden bg-[#211C27] border-t border-[#2F293E] shadow-[0_-4px_25px_rgba(0,0,0,0.3)]" 
     role="navigation" 
     aria-label="<?php esc_attr_e('Mobile Navigation Bar', 'dharmgyan'); ?>">
    
    <div class="mobile-bottom-nav-grid grid grid-cols-4 h-[60px] max-w-md mx-auto items-center px-2">
        
        <!-- Tab 1: Home -->
        <a href="<?php echo esc_url($home_url); ?>" 
           class="mobile-bottom-nav-item group relative flex flex-col items-center justify-center h-full text-[#B5B0C2] hover:text-[#E5B869] <?php echo $is_home ? 'is-active text-[#E5B869]' : ''; ?> transition-colors"
           aria-label="<?php esc_attr_e('Home', 'dharmgyan'); ?>"
           <?php echo $is_home ? 'aria-current="page"' : ''; ?>>
            <div class="relative flex items-center justify-center p-1.5 rounded-xl transition-all group-active:scale-95">
                <!-- Home Outline Icon (Exact Match: Rounded House Outline) -->
                <svg class="w-[26px] h-[26px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M3 10.5L12 3.5l9 7V19.5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V10.5z" />
                    <circle cx="12" cy="14" r="1.5" fill="currentColor" stroke="none" />
                </svg>
            </div>
            <?php if ($is_home) : ?>
            <span class="mobile-nav-dot w-1 h-1 rounded-full bg-[#E5B869] -mt-0.5"></span>
            <?php endif; ?>
        </a>

        <!-- Tab 2: Categories / Drawer Toggle (Exact Match: 4-Quadrant Window Grid) -->
        <button type="button" 
                id="mobile-bottom-nav-categories" 
                class="mobile-bottom-nav-item mobile-drawer-open-trigger group relative flex flex-col items-center justify-center h-full text-[#B5B0C2] hover:text-[#E5B869] transition-colors focus:outline-none"
                aria-label="<?php esc_attr_e('Open Categories Menu', 'dharmgyan'); ?>"
                aria-controls="mobile-drawer"
                aria-expanded="false">
            <div class="relative flex items-center justify-center p-1.5 rounded-xl transition-all group-active:scale-95">
                <!-- 4-Quadrant Rounded Grid Icon -->
                <svg class="w-[26px] h-[26px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <rect x="3" y="3" width="18" height="18" rx="5" ry="5" />
                    <line x1="12" y1="3" x2="12" y2="21" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                </svg>
            </div>
        </button>

        <!-- Tab 3: Cart / Bag (Exact Match: Cart with Live Count Badge) -->
        <a href="<?php echo esc_url($cart_url); ?>" 
           class="mobile-bottom-nav-item group relative flex flex-col items-center justify-center h-full text-[#B5B0C2] hover:text-[#E5B869] <?php echo $is_cart ? 'is-active text-[#E5B869]' : ''; ?> transition-colors"
           aria-label="<?php echo esc_attr(sprintf(__('Shopping Cart, %d items', 'dharmgyan'), $cart_count)); ?>"
           <?php echo $is_cart ? 'aria-current="page"' : ''; ?>>
            <div class="relative flex items-center justify-center p-1.5 rounded-xl transition-all group-active:scale-95">
                <!-- Shopping Cart Icon -->
                <svg class="w-[26px] h-[26px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <circle cx="9" cy="20" r="1.5" />
                    <circle cx="18" cy="20" r="1.5" />
                    <path d="M1 2.5h3.5l2.6 11.5a2 2 0 0 0 2 1.5h9.8a2 2 0 0 0 2-1.5l1.6-7.5H6" />
                </svg>
                
                <!-- Live Cart Badge Counter (Shows real-time count, synced via AJAX) -->
                <span class="mini-cart-count absolute -top-1.5 -right-1.5 bg-[#CC5600] text-white text-[11px] font-bold min-w-[18px] h-[18px] px-1 rounded-full flex items-center justify-center shadow-sm border-2 border-[#211C27] leading-none" aria-hidden="true">
                    <?php echo esc_html($cart_count); ?>
                </span>
            </div>
            <?php if ($is_cart) : ?>
            <span class="mobile-nav-dot w-1 h-1 rounded-full bg-[#E5B869] -mt-0.5"></span>
            <?php endif; ?>
        </a>

        <!-- Tab 4: Profile / My Account (Exact Match: User with Lightning/Star Accent) -->
        <a href="<?php echo esc_url($account_url); ?>" 
           class="mobile-bottom-nav-item group relative flex flex-col items-center justify-center h-full text-[#B5B0C2] hover:text-[#E5B869] <?php echo $is_account ? 'is-active text-[#E5B869]' : ''; ?> transition-colors"
           aria-label="<?php esc_attr_e('My Account', 'dharmgyan'); ?>"
           <?php echo $is_account ? 'aria-current="page"' : ''; ?>>
            <div class="relative flex items-center justify-center p-1.5 rounded-xl transition-all group-active:scale-95">
                <!-- User Outline with Shoulder Lightning Accent -->
                <svg class="w-[26px] h-[26px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <circle cx="12" cy="7" r="4" />
                    <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
                </svg>
                
                <!-- Lightning Bolt Accent Badge on Profile (as in screenshot) -->
                <span class="absolute -top-0.5 -right-0.5 text-[#F59E0B] drop-shadow-[0_1px_2px_rgba(0,0,0,0.5)]" aria-hidden="true">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                    </svg>
                </span>
            </div>
            <?php if ($is_account) : ?>
            <span class="mobile-nav-dot w-1 h-1 rounded-full bg-[#E5B869] -mt-0.5"></span>
            <?php endif; ?>
        </a>

    </div>
</nav>
