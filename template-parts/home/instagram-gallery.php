<?php
/**
 * Global Instagram Community Photo Gallery (14 Photos in 2 Rows of 7) - Matching Figma 1:1
 * Sourced dynamically from ACF Global Theme Settings (Option: global-instagram-gallery).
 * 
 * @package Dharmgyan
 */

$title = dharmgyan_get_field('instagram_title', 'option') ?: dharmgyan_get_field('instagram_title');
$items = dharmgyan_get_field('instagram_items', 'option');

if (empty($items)) {
    $items = dharmgyan_get_field('instagram_items');
}

if (empty($items) || !is_array($items)) {
    $items = array(
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-1.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-2.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-3.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-4.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-5.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-6.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-7.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-1.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-2.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-3.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-4.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-5.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-6.png'), 'instagram_link' => 'https://instagram.com'),
        array('instagram_image' => get_theme_file_uri('/assets/images/instagram/insta-7.png'), 'instagram_link' => 'https://instagram.com'),
    );
}
?>

<section class="home-instagram-gallery w-full bg-white my-10 md:my-16" aria-label="<?php echo esc_attr($title ?: __('Instagram Gallery', 'dharmgyan')); ?>">
    <div class="max-w-[1580px] mx-auto px-4">
        
        <!-- Section Header (Only rendered if title exists in backend) -->
        <?php if ($title): ?>
            <div class="text-center mb-8 md:mb-10">
                <h2 class="font-serif text-2xl md:text-[36px] text-[#242424] font-normal leading-tight">
                    <?php echo esc_html($title); ?>
                </h2>
            </div>
        <?php endif; ?>

        <!-- 2 Rows of 7 Square Photos Grid matching Figma (ID: 224:1277 to 224:1299) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2.5 md:gap-3">
            <?php foreach ($items as $item): ?>
                <?php
                $img_url = '';
                if (!empty($item['instagram_image'])) {
                    if (is_array($item['instagram_image']) && !empty($item['instagram_image']['url'])) {
                        $img_url = $item['instagram_image']['url'];
                    } elseif (is_numeric($item['instagram_image'])) {
                        $img_url = wp_get_attachment_image_url($item['instagram_image'], 'large');
                    } elseif (is_string($item['instagram_image'])) {
                        $img_url = $item['instagram_image'];
                    }
                }

                if (empty($img_url)) continue;

                $link = !empty($item['instagram_link']) ? $item['instagram_link'] : 'https://instagram.com';
                ?>
                <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer" class="group block relative aspect-square w-full rounded-[4px] overflow-hidden bg-gray-100 shadow-none hover:shadow-md transition-all duration-300 focus:outline-none">
                    <img 
                        src="<?php echo esc_url($img_url); ?>" 
                        alt="<?php esc_attr_e('Sacred Community Photo', 'dharmgyan'); ?>" 
                        class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500 ease-out"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/35 transition-colors duration-300 flex items-center justify-center">
                        <div class="w-9 h-9 rounded-full bg-white/20 backdrop-blur-sm text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transform scale-75 group-hover:scale-100 transition-all duration-300">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>
