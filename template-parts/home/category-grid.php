<?php
/**
 * Divine Collections (4-Category Grid Showcase) - Pixel Perfect Figma
 *
 * @package Dharmgyan
 */

$title    = dharmgyan_get_field('categories_title');
$subtitle = dharmgyan_get_field('categories_subtitle');
$items    = dharmgyan_get_field('categories_items');

if (empty($items) || !is_array($items)) {
    return;
}
?>

<section class="home-divine-collections-section w-full bg-white my-8 md:my-14" aria-label="<?php echo esc_attr($title ?: __('Collections', 'dharmgyan')); ?>">
    <div class="max-w-[1580px] mx-auto px-4">

        <!-- Section Header (Only rendered if title or subtitle is populated in backend) -->
        <?php if ($title || $subtitle): ?>
            <div class="text-center mb-6 md:mb-10">
                <?php if ($title): ?>
                    <h2 class="font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-tight">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>
                <?php if ($subtitle): ?>
                    <p class="text-[#717171] text-sm md:text-base font-sub mt-2 max-w-xl mx-auto">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- 4-Column Category Grid matching Figma (370x370px square cards) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 md:gap-7">
            <?php foreach ($items as $item): ?>
                <?php
                $img_url = '';
                if (is_array($item['category_image']) && !empty($item['category_image']['url'])) {
                    $img_url = $item['category_image']['url'];
                } elseif (is_numeric($item['category_image'])) {
                    $img_url = wp_get_attachment_image_url($item['category_image'], 'large');
                } elseif (is_string($item['category_image'])) {
                    $img_url = $item['category_image'];
                }

                if (empty($img_url)) continue;

                $cat_title = !empty($item['category_title']) ? $item['category_title'] : '';
                $cat_count = !empty($item['category_count_text']) ? $item['category_count_text'] : '';
                $cat_link  = !empty($item['category_link']) ? $item['category_link'] : home_url('/shop/');
                ?>

                <div class="category-card group flex flex-col items-center text-center focus:outline-none">
                    <!-- Square Image Thumbnail with hover zoom -->
                    <a href="<?php echo esc_url($cat_link); ?>" class="block w-full aspect-square rounded-[5px] overflow-hidden bg-gray-100 shadow-sm relative">
                        <img
                            src="<?php echo esc_url($img_url); ?>"
                            alt="<?php echo esc_attr($cat_title); ?>"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                            loading="lazy"
                        />
                    </a>

                    <!-- Category Name & Count cleanly below card matching Figma -->
                    <div class="pt-4 pb-1">
                        <?php if ($cat_title): ?>
                            <h3 class="font-serif text-lg md:text-[20px] text-[#111111] group-hover:text-[#CC5600] font-normal leading-tight transition-colors">
                                <a href="<?php echo esc_url($cat_link); ?>">
                                    <?php echo esc_html($cat_title); ?>
                                </a>
                            </h3>
                        <?php endif; ?>
                        <?php if ($cat_count): ?>
                            <p class="text-xs md:text-sm text-[#717171] font-body mt-1">
                                <?php echo esc_html($cat_count); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
