<?php
/**
 * Site Primary Navigation & Categories Dropdown Bar - Pixel Perfect Figma
 *
 * @package Dharmgyan
 */

$categories = array();
if (taxonomy_exists('product_cat')) {
    $categories = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
        'number'     => 12,
    ));
}

$social_fb  = dharmgyan_get_field('social_facebook', 'option');
$social_ig  = dharmgyan_get_field('social_instagram', 'option');
$social_tw  = dharmgyan_get_field('social_twitter', 'option');
?>

<div class="site-navigation-bar hidden lg:block w-full bg-white">
    <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-between min-h-20">

        <div class="flex items-center gap-7 xl:gap-10">
            <!-- Categories Dropdown Button (161x46 px matching Figma) -->
            <div class="categories-dropdown-wrapper relative group py-1.5">
                <button type="button" class="categories-btn bg-[#CC5600] hover:bg-[#B34B00] text-white w-[161px] h-[46px] rounded-[4px] flex items-center justify-between px-3.5 text-[16px] font-medium font-body transition-colors shadow-none" aria-expanded="false" aria-haspopup="true">
                    <div class="flex items-center gap-2">
                        <!-- Category 4-box Grid Icon matching Figma -->
                        <svg class="w-4 h-4" viewBox="0 0 18 18" fill="currentColor">
                            <rect x="0" y="0" width="8" height="8" rx="1.5"></rect>
                            <rect x="10" y="0" width="8" height="8" rx="1.5"></rect>
                            <rect x="0" y="10" width="8" height="8" rx="1.5"></rect>
                            <rect x="10" y="10" width="8" height="8" rx="1.5"></rect>
                        </svg>
                        <span class="tracking-tight"><?php esc_html_e('Categories', 'dharmgyan'); ?></span>
                    </div>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <?php if (!empty($categories) && !is_wp_error($categories)): ?>
                    <div class="categories-dropdown-menu absolute top-full left-0 w-64 bg-white border border-[#E5E5E5] rounded-[4px] shadow-2xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-150 z-50 transform group-hover:translate-y-0 translate-y-1">
                        <?php foreach ($categories as $cat): ?>
                            <?php
                            $cat_link = get_term_link($cat);
                            $cat_count = $cat->count;
                            ?>
                            <a href="<?php echo esc_url($cat_link); ?>" class="flex items-center justify-between px-4 py-2.5 text-[14px] text-[#444444] hover:text-[#CC5600] hover:bg-[#FFF8F3] transition-colors">
                                <span class="font-medium"><?php echo esc_html($cat->name); ?></span>
                                <span class="text-xs text-[#717171] bg-gray-100 px-2 py-0.5 rounded-full"><?php echo esc_html($cat_count); ?></span>
                            </a>
                        <?php endforeach; ?>

                        <div class="border-t border-[#E5E5E5] mt-1 pt-1">
                            <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" class="block px-4 py-2 text-xs font-semibold text-[#CC5600] hover:underline">
                                <?php esc_html_e('View All Collections →', 'dharmgyan'); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation Menu matching Figma -->
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'dharmgyan'); ?>">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'flex items-center gap-8 xl:gap-11 text-[17px] font-medium text-[#444444] font-body',
                        'fallback_cb'    => false,
                        'depth'          => 2,
                    ));
                } else {
                    ?>
                    <ul class="flex items-center gap-8 xl:gap-11 text-[17px] font-medium text-[#444444] font-body">
                        <li>
                            <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="flex items-center gap-2 hover:text-[#CC5600] transition-colors">
                                <svg class="w-4 h-4 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                <span><?php esc_html_e('All Collections', 'dharmgyan'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/product-category/aarti-diya/')); ?>" class="flex items-center gap-2 hover:text-[#CC5600] transition-colors">
                                <svg class="w-4 h-4 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span><?php esc_html_e('Aarti & Diyas', 'dharmgyan'); ?></span>
                            </a>
                        </li>
                        <li class="relative group">
                            <a href="<?php echo esc_url(home_url('/product-category/home-decor/')); ?>" class="flex items-center gap-2 hover:text-[#CC5600] transition-colors">
                                <svg class="w-4 h-4 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span><?php esc_html_e('Home Decor', 'dharmgyan'); ?></span>
                                <svg class="w-3 h-3 text-[#717171] transition-transform group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </a>
                        </li>
                        <li class="relative group">
                            <a href="<?php echo esc_url(home_url('/product-category/wall-art/')); ?>" class="flex items-center gap-2 hover:text-[#CC5600] transition-colors">
                                <svg class="w-4 h-4 text-[#444444]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <span><?php esc_html_e('Wall Art', 'dharmgyan'); ?></span>
                                <svg class="w-3 h-3 text-[#717171] transition-transform group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </a>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </nav>
        </div>

        <!-- Social Media Icons (Right) -->
        <div class="flex items-center gap-4 text-[#333333]">
            <a href="<?php echo esc_url($social_fb ?: '#'); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#CC5600] transition-colors" aria-label="Facebook">
                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
            </a>
            <a href="<?php echo esc_url($social_ig ?: '#'); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#CC5600] transition-colors" aria-label="Instagram">
                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            <a href="<?php echo esc_url($social_tw ?: '#'); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#CC5600] transition-colors" aria-label="Twitter">
                <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
        </div>
    </div>
</div>
