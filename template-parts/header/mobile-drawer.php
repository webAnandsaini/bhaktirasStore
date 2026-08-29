<?php
/**
 * Mobile Navigation Drawer Template Part
 * 
 * @package Dharmgyan
 */

$categories = array();
if (taxonomy_exists('product_cat')) {
    $categories = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
        'number'     => 15,
    ));
}

$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/');
$wishlist_url = function_exists('YITH_WCWL') ? YITH_WCWL()->get_wishlist_url() : home_url('/wishlist/');
$is_logged_in = is_user_logged_in();
?>

<!-- Mobile Drawer Overlay -->
<div id="mobile-drawer-backdrop" class="fixed inset-0 bg-black/50 z-[999] opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Mobile Drawer Off-Canvas Menu -->
<div id="mobile-drawer" class="fixed top-0 left-0 bottom-0 w-[300px] max-w-[85vw] bg-white z-[1000] transform -translate-x-full transition-transform duration-300 flex flex-col shadow-2xl overflow-y-auto">
    <!-- Drawer Header -->
    <div class="flex items-center justify-between p-4 border-b border-[#E5E5E5] bg-[#F9F5EB]">
        <div class="font-serif font-bold text-lg text-[#111111] flex items-center gap-1.5">
            <span class="text-[#CC5600]">🕉️</span>
            <span><?php bloginfo('name'); ?></span>
        </div>
        <button id="mobile-drawer-close" class="p-1 text-[#444444] hover:text-[#CC5600] transition-colors" aria-label="<?php esc_attr_e('Close Menu', 'dharmgyan'); ?>">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <!-- Drawer Navigation Content -->
    <div class="flex-1 p-4 space-y-6">
        <!-- Categories Section -->
        <div>
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#717171] mb-3"><?php esc_html_e('Product Categories', 'dharmgyan'); ?></h3>
            <?php if (!empty($categories) && !is_wp_error($categories)): ?>
                <ul class="space-y-1">
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="flex items-center justify-between py-2 text-sm font-medium text-[#444444] hover:text-[#CC5600] transition-colors">
                                <span><?php echo esc_html($cat->name); ?></span>
                                <span class="text-xs text-[#717171] bg-gray-100 px-2 py-0.5 rounded-full"><?php echo esc_html($cat->count); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Quick Links -->
        <div class="border-t border-[#E5E5E5] pt-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#717171] mb-3"><?php esc_html_e('Quick Links', 'dharmgyan'); ?></h3>
            <ul class="space-y-2 text-sm font-medium text-[#444444]">
                <li><a href="<?php echo esc_url(home_url('/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Home', 'dharmgyan'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/shop/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Shop All', 'dharmgyan'); ?></a></li>
                <li><a href="<?php echo esc_url($wishlist_url); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('My Wishlist', 'dharmgyan'); ?></a></li>
                <li><a href="<?php echo esc_url($account_url); ?>" class="block py-1 hover:text-[#CC5600]"><?php echo $is_logged_in ? esc_html__('My Account', 'dharmgyan') : esc_html__('Login / Register', 'dharmgyan'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Contact Us', 'dharmgyan'); ?></a></li>
            </ul>
        </div>
    </div>

    <!-- Drawer Footer -->
    <div class="p-4 border-t border-[#E5E5E5] bg-gray-50">
        <a href="<?php echo esc_url($account_url); ?>" class="w-full inline-flex items-center justify-center gap-2 bg-[#CC5600] text-white text-sm font-medium py-2.5 px-4 rounded-md hover:bg-[#B34B00] transition-colors shadow-sm">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span><?php echo $is_logged_in ? esc_html__('My Account', 'dharmgyan') : esc_html__('Sign In / Register', 'dharmgyan'); ?></span>
        </a>
    </div>
</div>
