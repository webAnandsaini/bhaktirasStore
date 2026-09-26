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
        'hide_empty' => true,
        'parent'     => 0,
        'number'     => 15,
    ));
}

$account_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : home_url('/my-account/');
$wishlist_url = function_exists('YITH_WCWL') ? YITH_WCWL()->get_wishlist_url() : home_url('/wishlist/');
$is_logged_in = is_user_logged_in();
?>

<!-- Mobile Drawer Overlay -->
<div id="mobile-drawer-backdrop" class="fixed inset-0 bg-black/50 z-[999] opacity-0 pointer-events-none transition-opacity duration-300" aria-hidden="true"></div>

<!-- Mobile Drawer Off-Canvas Menu -->
<div id="mobile-drawer" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Mobile Navigation Menu', 'dharmgyan'); ?>" aria-hidden="true" tabindex="-1" class="fixed top-0 left-0 bottom-0 w-[300px] max-w-[85vw] bg-white z-[1000] transform -translate-x-full transition-transform duration-300 flex flex-col shadow-2xl overflow-y-auto">
    <!-- Drawer Header -->
    <div class="flex items-center justify-between p-4 border-b border-[#E5E5E5] bg-[#F9F5EB]">
        <div class="font-serif font-bold text-lg text-[#111111] flex items-center gap-1.5">
            <span class="text-[#CC5600]" aria-hidden="true">🕉️</span>
            <span><?php bloginfo('name'); ?></span>
        </div>
        <button id="mobile-drawer-close" class="p-1 text-[#444444] hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm" aria-label="<?php esc_attr_e('Close Navigation Menu', 'dharmgyan'); ?>">
            <svg class="w-6 h-6" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <!-- Drawer Navigation Content -->
    <div class="flex-1 p-4 space-y-6">
        <!-- Categories Section -->
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-[#717171] mb-3"><?php esc_html_e('Product Categories', 'dharmgyan'); ?></p>
            <?php if (!empty($categories) && !is_wp_error($categories)): ?>
                <ul class="space-y-1">
                    <?php foreach ($categories as $cat): ?>
                        <?php
                        $sub_categories = get_terms(array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,
                            'parent'     => $cat->term_id,
                        ));
                        ?>
                        <li>
                            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="flex items-center justify-between py-2 text-sm font-semibold text-[#111111] hover:text-[#CC5600] transition-colors">
                                <span><?php echo esc_html($cat->name); ?></span>
                                <span class="text-xs text-[#717171] bg-gray-100 px-2 py-0.5 rounded-full"><?php echo esc_html($cat->count); ?></span>
                            </a>

                            <?php if (!empty($sub_categories) && !is_wp_error($sub_categories)): ?>
                                <ul class="pl-4 ml-2 border-l border-[#EAE3DC] space-y-1 my-1">
                                    <?php foreach ($sub_categories as $sub_cat): ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_term_link($sub_cat)); ?>" class="flex items-center justify-between py-1 text-xs text-[#444444] hover:text-[#CC5600] transition-colors">
                                                <span class="flex items-center gap-1.5">
                                                    <span class="text-[#CC5600]">↳</span>
                                                    <?php echo esc_html($sub_cat->name); ?>
                                                </span>
                                                <span class="text-[11px] text-[#777777] bg-gray-50 px-1.5 py-0.2 rounded-full"><?php echo esc_html($sub_cat->count); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <!-- Main Navigation Section -->
        <div class="border-t border-[#E5E5E5] pt-4">
            <p class="text-xs font-bold uppercase tracking-wider text-[#717171] mb-3"><?php esc_html_e('Main Menu', 'dharmgyan'); ?></p>
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'space-y-2 text-sm font-medium text-[#444444] [&_a]:block [&_a]:py-1 [&_a]:hover:text-[#CC5600] [&_a]:transition-colors [&_ul.sub-menu]:pl-4 [&_ul.sub-menu]:space-y-1 [&_ul.sub-menu]:my-1',
                    'fallback_cb'    => false,
                    'depth'          => 2,
                ));
            } else {
                ?>
                <ul class="space-y-2 text-sm font-medium text-[#444444]">
                    <li><a href="<?php echo esc_url(home_url('/shop/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('All Collections', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/aarti-diya/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Pooja Samagri', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/collections/god-statue/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('God Statue', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/collections/rudraksha/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Rudraksha', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/collections/bracelets/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Bracelets', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/collections/jap-mala/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Jap Mala', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/home-decor/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Home Decor', 'dharmgyan'); ?></a></li>
                </ul>
                <?php
            }
            ?>
        </div>

        <!-- Quick Links -->
        <div class="border-t border-[#E5E5E5] pt-4">
            <p class="text-xs font-bold uppercase tracking-wider text-[#717171] mb-3"><?php esc_html_e('Quick Links', 'dharmgyan'); ?></p>
            <ul class="space-y-2 text-sm font-medium text-[#444444]">
                <li><a href="<?php echo esc_url(home_url('/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Home', 'dharmgyan'); ?></a></li>
                <li><a href="<?php echo esc_url($wishlist_url); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('My Wishlist', 'dharmgyan'); ?></a></li>
                <li><a href="<?php echo esc_url($account_url); ?>" class="block py-1 hover:text-[#CC5600]"><?php echo $is_logged_in ? esc_html__('My Account', 'dharmgyan') : esc_html__('Login / Register', 'dharmgyan'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="block py-1 hover:text-[#CC5600]"><?php esc_html_e('Contact Us', 'dharmgyan'); ?></a></li>
            </ul>
        </div>
    </div>

    <!-- Drawer Footer -->
    <div class="p-4 border-t border-[#E5E5E5] bg-gray-50">
        <a href="<?php echo esc_url($account_url); ?>" class="w-full inline-flex items-center justify-center gap-2 bg-[#CC5600] text-white text-sm font-medium py-2.5 px-4 rounded-md hover:bg-[#B34B00] transition-colors shadow-sm">
            <svg class="w-4 h-4" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span><?php echo $is_logged_in ? esc_html__('My Account', 'dharmgyan') : esc_html__('Sign In / Register', 'dharmgyan'); ?></span>
        </a>
    </div>
</div>
