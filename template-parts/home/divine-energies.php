<?php
/**
 * Homepage 'Discover Divine Energies' Full-Width Scroller Template Part
 * Sourced dynamically from ACF Settings (Tab: Discover Divine Energies).
 *
 * @package Dharmgyan
 */

$title = dharmgyan_get_field('energies_title') ?: (dharmgyan_get_field('divine_energies_title') ?: (dharmgyan_get_field('energies_title', 'option') ?: dharmgyan_get_field('divine_energies_title', 'option')));
$items = dharmgyan_get_field('energies_items') ?: (dharmgyan_get_field('divine_energies_items') ?: (dharmgyan_get_field('energies_items', 'option') ?: dharmgyan_get_field('divine_energies_items', 'option')));

if (empty($items) || !is_array($items)) {
    $items = array(
        array('energy_image' => get_theme_file_uri('/assets/images/energies/energy-1.png'), 'energy_label' => 'Prosperity',   'energy_link' => home_url('/product-category/collections/')),
        array('energy_image' => get_theme_file_uri('/assets/images/energies/energy-2.png'), 'energy_label' => 'Love',         'energy_link' => home_url('/product-category/collections/')),
        array('energy_image' => get_theme_file_uri('/assets/images/energies/energy-3.png'), 'energy_label' => 'Health',       'energy_link' => home_url('/product-category/collections/')),
        array('energy_image' => get_theme_file_uri('/assets/images/energies/energy-4.png'), 'energy_label' => 'Divine Shield', 'energy_link' => home_url('/product-category/collections/')),
        array('energy_image' => get_theme_file_uri('/assets/images/energies/energy-5.png'), 'energy_label' => 'Peace',        'energy_link' => home_url('/product-category/collections/')),
        array('energy_image' => get_theme_file_uri('/assets/images/energies/energy-6.png'), 'energy_label' => 'Inner Power',  'energy_link' => home_url('/product-category/collections/')),
    );
}
?>

<section class="home-divine-energies-section w-full bg-white my-10 md:my-16 overflow-hidden" aria-label="<?php echo esc_attr($title ?: __('Divine Energies', 'dharmgyan')); ?>">

    <!-- Section Header (Only rendered if title exists in backend) -->
    <?php if ($title): ?>
        <div class="max-w-[1580px] mx-auto px-4 text-center mb-6 md:mb-10">
            <h2 class="font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-tight">
                <?php echo esc_html($title); ?>
            </h2>
        </div>
    <?php endif; ?>

    <!-- Full-Width Continuous Edge-to-Edge Swiper Scroller -->
    <div class="w-full px-3 sm:px-6 lg:px-8">
        <div class="swiper energiesSwiper relative w-full overflow-hidden">
            <div class="swiper-wrapper ease-linear">
                <?php foreach ($items as $item): ?>
                    <?php
                    $img_url = '';
                    if (is_array($item['energy_image']) && !empty($item['energy_image']['url'])) {
                        $img_url = $item['energy_image']['url'];
                    } elseif (is_numeric($item['energy_image'])) {
                        $img_url = wp_get_attachment_image_url($item['energy_image'], 'large');
                    } elseif (is_string($item['energy_image'])) {
                        $img_url = $item['energy_image'];
                    }

                    if (empty($img_url)) continue;

                    $label = !empty($item['energy_label']) ? $item['energy_label'] : '';
                    $link  = !empty($item['energy_link']) ? $item['energy_link'] : home_url('/shop/');
                    ?>

                    <div class="swiper-slide">
                        <a href="<?php echo esc_url($link); ?>" class="group block relative aspect-[3/4] w-full rounded-[6px] overflow-hidden bg-[#F8F8F8] border border-[#EAE3DC] hover:border-[#CC5600] shadow-2xs hover:shadow-md transition-all duration-300 focus:outline-none">

                            <!-- Card Image with smooth hover zoom -->
                            <img
                                src="<?php echo esc_url($img_url); ?>"
                                alt="<?php echo esc_attr($label ?: __('Divine Energy', 'dharmgyan')); ?>"
                                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                                loading="lazy"
                            />

                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>

                            <!-- White Box / Pill Label at Bottom matching Figma -->
                            <?php if ($label): ?>
                                <div class="absolute bottom-4 left-0 right-0 px-3 z-10 text-center">
                                    <span class="inline-block w-full max-w-[190px] bg-white text-[#242424] group-hover:text-[#CC5600] text-xs sm:text-sm font-medium py-2 px-3 shadow-md rounded-[4px] border border-gray-100 transition-colors duration-200">
                                        <?php echo esc_html($label); ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</section>
