<?php
/**
 * Discover Divine Products by Your Rashi (12 Zodiac Signs in 2 Rows of 6) - Matching Figma 1:1
 * Sourced dynamically from ACF Homepage fields or Global Theme Settings.
 * 
 * @package Dharmgyan
 */

$title       = dharmgyan_get_field('rashi_title') ?: (dharmgyan_get_field('rashi_title', 'option') ?: __('Discover Divine Products by Your Rashi', 'dharmgyan'));
$rashi_items = dharmgyan_get_field('rashi_items');

if (empty($rashi_items)) {
    $rashi_items = dharmgyan_get_field('rashi_items', 'option');
}

// Fallback to default 12 Zodiac Signs if ACF fields are not populated yet
if (empty($rashi_items) || !is_array($rashi_items)) {
    $rashi_items = array(
        array('rashi_name' => 'Aries (मेष)',        'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-1.png'),  'rashi_link' => '/product-category/collections/?rashi=aries'),
        array('rashi_name' => 'Taurus (वृषभ)',      'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-2.png'),  'rashi_link' => '/product-category/collections/?rashi=taurus'),
        array('rashi_name' => 'Gemini (मिथुन)',     'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-3.png'),  'rashi_link' => '/product-category/collections/?rashi=gemini'),
        array('rashi_name' => 'Cancer (कर्क)',      'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-4.png'),  'rashi_link' => '/product-category/collections/?rashi=cancer'),
        array('rashi_name' => 'Leo (सिंह)',         'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-5.png'),  'rashi_link' => '/product-category/collections/?rashi=leo'),
        array('rashi_name' => 'Virgo (कन्या)',      'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-6.png'),  'rashi_link' => '/product-category/collections/?rashi=virgo'),
        array('rashi_name' => 'Libra (तुला)',       'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-7.png'),  'rashi_link' => '/product-category/collections/?rashi=libra'),
        array('rashi_name' => 'Scorpio (वृश्चिक)',   'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-8.png'),  'rashi_link' => '/product-category/collections/?rashi=scorpio'),
        array('rashi_name' => 'Sagittarius (धनु)',  'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-9.png'),  'rashi_link' => '/product-category/collections/?rashi=sagittarius'),
        array('rashi_name' => 'Capricorn (मकर)',    'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-10.png'), 'rashi_link' => '/product-category/collections/?rashi=capricorn'),
        array('rashi_name' => 'Aquarius (कुंभ)',    'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-11.png'), 'rashi_link' => '/product-category/collections/?rashi=aquarius'),
        array('rashi_name' => 'Pisces (मीन)',       'rashi_icon' => get_theme_file_uri('/assets/images/rashi/rashi-12.png'), 'rashi_link' => '/product-category/collections/?rashi=pisces'),
    );
}
?>

<section class="home-rashi-section w-full bg-white my-10 md:my-16" aria-label="<?php echo esc_attr($title); ?>">
    <div class="max-w-[1580px] mx-auto px-4">
        
        <!-- Section Header matching Figma Rosarivo 36px -->
        <div class="text-center mb-10 md:mb-14">
            <h2 class="font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-tight">
                <?php echo esc_html($title); ?>
            </h2>
        </div>

        <!-- 12 Zodiac Circular Cards in 2 Rows of 6 (Figma 1:1) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-x-4 md:gap-x-8 gap-y-8 md:gap-y-12">
            <?php foreach ($rashi_items as $item): ?>
                <?php
                $rashi_name = !empty($item['rashi_name']) ? $item['rashi_name'] : '';
                $rashi_link = !empty($item['rashi_link']) ? $item['rashi_link'] : '#';
                $rashi_icon = '';

                if (!empty($item['rashi_icon'])) {
                    if (is_array($item['rashi_icon']) && !empty($item['rashi_icon']['url'])) {
                        $rashi_icon = $item['rashi_icon']['url'];
                    } elseif (is_numeric($item['rashi_icon'])) {
                        $rashi_icon = wp_get_attachment_image_url($item['rashi_icon'], 'medium');
                    } elseif (is_string($item['rashi_icon'])) {
                        $rashi_icon = $item['rashi_icon'];
                    }
                }
                ?>
                <div class="rashi-card group flex flex-col items-center text-center">
                    <a href="<?php echo esc_url($rashi_link); ?>" class="block w-[110px] h-[110px] sm:w-[130px] sm:h-[130px] md:w-[145px] md:h-[145px] rounded-full overflow-hidden p-1 border-2 border-[#EAE3DC] group-hover:border-[#CC5600] group-hover:scale-105 transition-all duration-300 shadow-sm focus:outline-none bg-white">
                        <?php if ($rashi_icon): ?>
                            <img 
                                src="<?php echo esc_url($rashi_icon); ?>" 
                                alt="<?php echo esc_attr($rashi_name); ?>" 
                                class="w-full h-full object-contain object-center" 
                                loading="lazy"
                            />
                        <?php endif; ?>
                    </a>
                    <?php if ($rashi_name): ?>
                        <h3 class="font-serif text-[15px] md:text-[17px] text-[#242424] group-hover:text-[#CC5600] font-normal mt-3 transition-colors">
                            <a href="<?php echo esc_url($rashi_link); ?>">
                                <?php echo esc_html($rashi_name); ?>
                            </a>
                        </h3>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
