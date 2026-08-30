<?php
/**
 * Homepage 4 Circular Saffron Badges Template Part - Matching Figma 1:1
 * (Made In India, Best Quality, Secured Payment, Free Shipping)
 * 
 * @package Dharmgyan
 */

$icon_base = get_theme_file_uri('/assets/images/icons');
?>

<section class="home-trust-badges-section w-full bg-white my-12 md:my-16" aria-label="<?php esc_attr_e('Store Highlights & Badges', 'dharmgyan'); ?>">
    <div class="max-w-[1580px] mx-auto px-4">
        
        <!-- 4-Column Responsive Grid matching Figma (Y: 8865 to 9080) -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 text-center">
            
            <!-- Badge 1: Made In India -->
            <div class="flex flex-col items-center group">
                <div class="w-[110px] h-[110px] md:w-[136px] md:h-[136px] rounded-full bg-[#CC5600] text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300 mb-4 p-5">
                    <img src="<?php echo esc_url($icon_base . '/badge-made-in-india.svg'); ?>" alt="<?php esc_attr_e('Made In India', 'dharmgyan'); ?>" class="w-16 h-16 object-contain" />
                </div>
                <h3 class="font-serif text-lg md:text-[22px] text-[#242424] font-normal leading-tight">
                    <?php esc_html_e('Made In India', 'dharmgyan'); ?>
                </h3>
            </div>

            <!-- Badge 2: Best Quality -->
            <div class="flex flex-col items-center group">
                <div class="w-[110px] h-[110px] md:w-[136px] md:h-[136px] rounded-full bg-[#CC5600] text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300 mb-4 p-5">
                    <img src="<?php echo esc_url($icon_base . '/badge-best-quality.svg'); ?>" alt="<?php esc_attr_e('Best Quality', 'dharmgyan'); ?>" class="w-14 h-14 object-contain" />
                </div>
                <h3 class="font-serif text-lg md:text-[22px] text-[#242424] font-normal leading-tight">
                    <?php esc_html_e('Best Quality', 'dharmgyan'); ?>
                </h3>
            </div>

            <!-- Badge 3: Secured Payment -->
            <div class="flex flex-col items-center group">
                <div class="w-[110px] h-[110px] md:w-[136px] md:h-[136px] rounded-full bg-[#CC5600] text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300 mb-4 p-5">
                    <img src="<?php echo esc_url($icon_base . '/badge-secured-payment.svg'); ?>" alt="<?php esc_attr_e('Secured Payment', 'dharmgyan'); ?>" class="w-14 h-14 object-contain" />
                </div>
                <h3 class="font-serif text-lg md:text-[22px] text-[#242424] font-normal leading-tight">
                    <?php esc_html_e('Secured Payment', 'dharmgyan'); ?>
                </h3>
            </div>

            <!-- Badge 4: Free Shipping -->
            <div class="flex flex-col items-center group">
                <div class="w-[110px] h-[110px] md:w-[136px] md:h-[136px] rounded-full bg-[#CC5600] text-white flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300 mb-4 p-5">
                    <img src="<?php echo esc_url($icon_base . '/badge-free-shipping.svg'); ?>" alt="<?php esc_attr_e('Free Shipping', 'dharmgyan'); ?>" class="w-16 h-12 object-contain" />
                </div>
                <h3 class="font-serif text-lg md:text-[22px] text-[#242424] font-normal leading-tight">
                    <?php esc_html_e('Free Shipping', 'dharmgyan'); ?>
                </h3>
            </div>

        </div>

    </div>
</section>
