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
        'hide_empty' => true,
        'parent'     => 0,
        'number'     => 12,
    ));
}

// Social Media Links (Repeater) - matching Footer
$social_links = dharmgyan_get_field('social_links');
if (empty($social_links) || !is_array($social_links)) {
    $social_links = array(
        array('platform' => 'facebook',  'url' => 'https://facebook.com'),
        array('platform' => 'instagram', 'url' => 'https://instagram.com'),
        array('platform' => 'youtube',   'url' => 'https://youtube.com'),
        array('platform' => 'pinterest', 'url' => 'https://pinterest.com'),
    );
}
?>

<div class="site-navigation-bar hidden lg:block w-full bg-white">
    <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-between min-h-20">

        <div class="flex items-center gap-7 xl:gap-10">
            <!-- Categories Dropdown Button (161x46 px matching Figma) -->
            <div class="categories-dropdown-wrapper relative group py-1.5">
                <button type="button" id="categories-dropdown-btn" class="categories-btn bg-[#CC5600] hover:bg-[#B34B00] text-white w-[161px] h-[46px] rounded-[4px] flex items-center justify-between px-3.5 text-[16px] font-medium font-body transition-colors shadow-none focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]" aria-expanded="false" aria-haspopup="true" aria-controls="categories-dropdown-menu">
                    <div class="flex items-center gap-2">
                        <!-- Category 4-box Grid Icon matching Figma -->
                        <svg class="w-4 h-4" aria-hidden="true" focusable="false" viewBox="0 0 18 18" fill="currentColor">
                            <rect x="0" y="0" width="8" height="8" rx="1.5"></rect>
                            <rect x="10" y="0" width="8" height="8" rx="1.5"></rect>
                            <rect x="0" y="10" width="8" height="8" rx="1.5"></rect>
                            <rect x="10" y="10" width="8" height="8" rx="1.5"></rect>
                        </svg>
                        <span class="tracking-tight"><?php esc_html_e('Categories', 'dharmgyan'); ?></span>
                    </div>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:rotate-180" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <?php if (!empty($categories) && !is_wp_error($categories)): ?>
                    <div id="categories-dropdown-menu" role="menu" aria-labelledby="categories-dropdown-btn" class="categories-dropdown-menu absolute top-full left-0 w-[320px] bg-white border border-[#EAE3DC] rounded-[8px] shadow-xl p-2.5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform group-hover:translate-y-0 translate-y-1">
                        <div class="max-h-[420px] overflow-y-auto scrollbar-thin pr-1 space-y-1">
                            <?php foreach ($categories as $cat): ?>
                                <?php
                                if ($cat->slug === 'uncategorized') continue;
                                $cat_link = get_term_link($cat);
                                $cat_count = $cat->count;

                                // Fetch child categories for this parent category
                                $sub_categories = get_terms(array(
                                    'taxonomy'   => 'product_cat',
                                    'hide_empty' => true,
                                    'parent'     => $cat->term_id,
                                ));
                                ?>
                                <div class="category-dropdown-group">
                                    <!-- Parent Category -->
                                    <a href="<?php echo esc_url($cat_link); ?>" role="menuitem" class="flex items-center justify-between px-3 py-2 text-[14px] text-[#111111] font-semibold hover:text-[#CC5600] hover:bg-[#FFF8F3] rounded-[5px] transition-colors focus:outline-none">
                                        <span><?php echo esc_html($cat->name); ?></span>
                                        <span class="text-[11px] font-medium text-[#666666] bg-[#F2ECE6] px-2 py-0.5 rounded-full" aria-label="<?php echo esc_attr(sprintf(__('%d products', 'dharmgyan'), $cat_count)); ?>"><?php echo esc_html($cat_count); ?></span>
                                    </a>

                                    <!-- Sub Categories List -->
                                    <?php if (!empty($sub_categories) && !is_wp_error($sub_categories)): ?>
                                        <div class="ml-3 pl-3 border-l-2 border-[#F3ECE4] my-1 space-y-0.5">
                                            <?php foreach ($sub_categories as $sub_cat): ?>
                                                <?php
                                                $sub_link = get_term_link($sub_cat);
                                                $sub_count = $sub_cat->count;
                                                ?>
                                                <a href="<?php echo esc_url($sub_link); ?>" role="menuitem" class="group flex items-center justify-between px-2.5 py-1.5 text-[13px] text-[#555555] hover:text-[#CC5600] hover:bg-[#FFF5ED] rounded-[4px] transition-all focus:outline-none">
                                                    <span class="font-normal flex items-center gap-2">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-[#D4C8BC] group-hover:bg-[#CC5600] transition-colors"></span>
                                                        <?php echo esc_html($sub_cat->name); ?>
                                                    </span>
                                                    <span class="text-[11px] text-[#777777] bg-[#F7F3EE] group-hover:bg-white px-2 py-0.5 rounded-full transition-colors"><?php echo esc_html($sub_count); ?></span>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="border-t border-[#F0ECE7] mt-2 pt-2 px-1">
                            <a href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>" role="menuitem" class="flex items-center justify-between px-3 py-1.5 text-xs font-semibold text-[#CC5600] hover:text-[#B34B00] hover:bg-[#FFF8F3] rounded-[4px] transition-colors focus:outline-none">
                                <span><?php esc_html_e('View All Collections', 'dharmgyan'); ?></span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Primary Navigation Menu matching Figma -->
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Navigation', 'dharmgyan'); ?>">
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
                            <a href="<?php echo esc_url(home_url('/shop/')); ?>" class="flex items-center gap-2 hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm">
                                <svg class="w-4 h-4 text-[#444444]" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                <span><?php esc_html_e('All Collections', 'dharmgyan'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('/product-category/aarti-diya/')); ?>" class="flex items-center gap-2 hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm">
                                <svg class="w-4 h-4 text-[#444444]" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span><?php esc_html_e('Aarti & Diyas', 'dharmgyan'); ?></span>
                            </a>
                        </li>
                        <li class="relative group">
                            <a href="<?php echo esc_url(home_url('/product-category/home-decor/')); ?>" class="flex items-center gap-2 hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm">
                                <svg class="w-4 h-4 text-[#444444]" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span><?php esc_html_e('Home Decor', 'dharmgyan'); ?></span>
                                <svg class="w-3 h-3 text-[#717171] transition-transform group-hover:rotate-180" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </a>
                        </li>
                        <li class="relative group">
                            <a href="<?php echo esc_url(home_url('/product-category/wall-art/')); ?>" class="flex items-center gap-2 hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm">
                                <svg class="w-4 h-4 text-[#444444]" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <span><?php esc_html_e('Wall Art', 'dharmgyan'); ?></span>
                                <svg class="w-3 h-3 text-[#717171] transition-transform group-hover:rotate-180" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </a>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </nav>
        </div>

        <!-- Social Media Links (Right) - Matching Footer -->
        <?php if (!empty($social_links)) : ?>
        <div class="header-social-links flex items-center gap-3.5 text-[#444444]">
            <?php
            foreach ($social_links as $item) :
                $platform = strtolower(trim($item['platform'] ?? ''));
                $url = trim($item['url'] ?? '');
                if (empty($url)) continue;

                $label = sprintf(__('Follow us on %s (opens in new tab)', 'dharmgyan'), ucfirst($platform));
                $icon_svg = '';

                switch ($platform) {
                    case 'facebook':
                        $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.6 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>';
                        break;
                    case 'instagram':
                        $icon_svg = '<svg class="w-4 h-4" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>';
                        break;
                    case 'twitter':
                    case 'x':
                        $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';
                        break;
                    case 'youtube':
                        $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';
                        break;
                    case 'pinterest':
                        $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>';
                        break;
                    case 'linkedin':
                        $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>';
                        break;
                    case 'whatsapp':
                        $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>';
                        break;
                    default:
                        $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>';
                        break;
                }
            ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm" aria-label="<?php echo esc_attr($label); ?>">
                    <?php echo $icon_svg; ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
