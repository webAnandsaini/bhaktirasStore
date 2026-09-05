<?php
/**
 * Master Site Header Template Part - Pixel Perfect Figma
 * 
 * @package Dharmgyan
 */

get_template_part('template-parts/header/site-topbar');
?>

<header class="site-header bg-white relative z-40" role="banner">
    <!-- Middle Main Header Row (Full Width Border Bottom only here!) -->
    <div class="site-header-middle-bar w-full border-b border-[#E5E5E5]">
        <div class="max-w-[1580px] mx-auto px-4">
            <div class="site-header-main flex items-center justify-between py-4 md:py-5 gap-4 md:gap-8">
                
                <!-- Mobile Menu Toggle Button -->
                <button id="mobile-menu-toggle" class="lg:hidden p-2 text-[#444444] hover:text-[#CC5600] transition-colors rounded-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]" aria-label="<?php esc_attr_e('Open Navigation Menu', 'dharmgyan'); ?>" aria-expanded="false" aria-controls="mobile-drawer">
                    <svg class="w-6 h-6" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>

                <!-- Brand Logo -->
                <?php get_template_part('template-parts/header/site-branding'); ?>

                <!-- Desktop Search Form -->
                <div class="hidden md:flex flex-1">
                    <?php get_template_part('template-parts/header/site-search', null, array('context' => 'desktop')); ?>
                </div>

                <!-- Header Actions (Help, Wishlist, Cart, Login) -->
                <?php get_template_part('template-parts/header/site-right'); ?>
            </div>

            <!-- Mobile Search Form -->
            <div class="md:hidden pb-3 pt-1 border-t border-gray-100">
                <?php get_template_part('template-parts/header/site-search', null, array('context' => 'mobile')); ?>
            </div>
        </div>
    </div>

    <!-- Category & Navigation Bar (NO BOTTOM BORDER!) -->
    <?php get_template_part('template-parts/header/site-nav'); ?>
</header>

<!-- Mobile Off-Canvas Drawer -->
<?php get_template_part('template-parts/header/mobile-drawer'); ?>
