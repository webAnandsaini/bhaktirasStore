<?php
/**
 * Discover Divine Products by Your Rashi (12 Zodiac Signs in 2 Rows of 6) - Matching Figma 1:1
 * 
 * @package Dharmgyan
 */

$title = dharmgyan_get_field('rashi_title') ?: __('Discover Divine Products by Your Rashi', 'dharmgyan');

$rashi_list = array(
    array('name' => 'Aries (मेष)',        'icon' => get_theme_file_uri('/assets/images/rashi/rashi-1.png'),  'link' => '/product-category/collections/?rashi=aries'),
    array('name' => 'Taurus (वृषभ)',      'icon' => get_theme_file_uri('/assets/images/rashi/rashi-2.png'),  'link' => '/product-category/collections/?rashi=taurus'),
    array('name' => 'Gemini (मिथुन)',     'icon' => get_theme_file_uri('/assets/images/rashi/rashi-3.png'),  'link' => '/product-category/collections/?rashi=gemini'),
    array('name' => 'Cancer (कर्क)',      'icon' => get_theme_file_uri('/assets/images/rashi/rashi-4.png'),  'link' => '/product-category/collections/?rashi=cancer'),
    array('name' => 'Leo (सिंह)',         'icon' => get_theme_file_uri('/assets/images/rashi/rashi-5.png'),  'link' => '/product-category/collections/?rashi=leo'),
    array('name' => 'Virgo (कन्या)',      'icon' => get_theme_file_uri('/assets/images/rashi/rashi-6.png'),  'link' => '/product-category/collections/?rashi=virgo'),
    array('name' => 'Libra (तुला)',       'icon' => get_theme_file_uri('/assets/images/rashi/rashi-7.png'),  'link' => '/product-category/collections/?rashi=libra'),
    array('name' => 'Scorpio (वृश्चिक)',   'icon' => get_theme_file_uri('/assets/images/rashi/rashi-8.png'),  'link' => '/product-category/collections/?rashi=scorpio'),
    array('name' => 'Sagittarius (धनु)',  'icon' => get_theme_file_uri('/assets/images/rashi/rashi-9.png'),  'link' => '/product-category/collections/?rashi=sagittarius'),
    array('name' => 'Capricorn (मकर)',    'icon' => get_theme_file_uri('/assets/images/rashi/rashi-10.png'), 'link' => '/product-category/collections/?rashi=capricorn'),
    array('name' => 'Aquarius (कुंभ)',    'icon' => get_theme_file_uri('/assets/images/rashi/rashi-11.png'), 'link' => '/product-category/collections/?rashi=aquarius'),
    array('name' => 'Pisces (मीन)',       'icon' => get_theme_file_uri('/assets/images/rashi/rashi-12.png'), 'link' => '/product-category/collections/?rashi=pisces'),
);
?>

<section class="home-rashi-section w-full bg-white py-10 md:py-16" aria-label="<?php echo esc_attr($title); ?>">
    <div class="max-w-[1580px] mx-auto px-4">
        
        <!-- Section Header matching Figma Rosarivo 36px -->
        <div class="text-center mb-10 md:mb-14">
            <h2 class="font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-tight">
                <?php echo esc_html($title); ?>
            </h2>
        </div>

        <!-- 12 Zodiac Circular Cards in 2 Rows of 6 (Figma 1:1) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-x-4 md:gap-x-8 gap-y-8 md:gap-y-12">
            <?php foreach ($rashi_list as $rashi): ?>
                <div class="rashi-card group flex flex-col items-center text-center">
                    <a href="<?php echo esc_url($rashi['link']); ?>" class="block w-[110px] h-[110px] sm:w-[130px] sm:h-[130px] md:w-[145px] md:h-[145px] rounded-full overflow-hidden p-1 border-2 border-[#EAE3DC] group-hover:border-[#CC5600] group-hover:scale-105 transition-all duration-300 shadow-sm focus:outline-none">
                        <img 
                            src="<?php echo esc_url($rashi['icon']); ?>" 
                            alt="<?php echo esc_attr($rashi['name']); ?>" 
                            class="w-full h-full object-contain object-center" 
                            loading="lazy"
                        />
                    </a>
                    <h3 class="font-serif text-[15px] md:text-[17px] text-[#242424] group-hover:text-[#CC5600] font-normal mt-3 transition-colors">
                        <a href="<?php echo esc_url($rashi['link']); ?>">
                            <?php echo esc_html($rashi['name']); ?>
                        </a>
                    </h3>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
