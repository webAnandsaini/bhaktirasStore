<?php
/**
 * Customer Testimonials & Reviews Section (5-Card Swiper Carousel with Devotee Photos)
 * Purely sourced dynamically from ACF Global Theme Settings (Option: global-testimonials).
 * 
 * @package Dharmgyan
 */

$title = dharmgyan_get_field('testimonials_title', 'option') ?: (dharmgyan_get_field('testimonials_title') ?: __('What our clients Say', 'dharmgyan'));
$items = dharmgyan_get_field('testimonials_items', 'option');

// Fallback to page-level or standard demo items if option is empty
if (empty($items)) {
    $items = dharmgyan_get_field('testimonials_items');
}

if (empty($items) || !is_array($items)) {
    $items = array(
        array(
            'customer_photo'    => get_theme_file_uri('/assets/images/testimonials/testi-1.png'),
            'author_name'       => 'Pooja R.',
            'rating'            => 5,
            'review_text'       => 'The quality and spiritual aura of the idol are truly divine. Highly recommended!',
            'product_thumbnail' => get_theme_file_uri('/assets/images/products/prod-1.png'),
            'product_title'     => 'Handcrafted Marble Peacock Flower Vase',
        ),
        array(
            'customer_photo'    => get_theme_file_uri('/assets/images/testimonials/testi-2.png'),
            'author_name'       => 'Rahul M.',
            'rating'            => 5,
            'review_text'       => 'Flawless finish and fast delivery. It brought peace and prosperity to our home.',
            'product_thumbnail' => get_theme_file_uri('/assets/images/products/prod-2.png'),
            'product_title'     => 'Divine Brass Krishna Murti with Flute',
        ),
        array(
            'customer_photo'    => get_theme_file_uri('/assets/images/testimonials/testi-3.png'),
            'author_name'       => 'Sneha K.',
            'rating'            => 5,
            'review_text'       => 'Exquisite craftsmanship! The details on the sculpture are beyond expectations.',
            'product_thumbnail' => get_theme_file_uri('/assets/images/products/prod-3.png'),
            'product_title'     => 'Traditional Ganesha Temple Sculpture',
        ),
        array(
            'customer_photo'    => get_theme_file_uri('/assets/images/testimonials/testi-4.png'),
            'author_name'       => 'Babita C.',
            'rating'            => 5,
            'review_text'       => 'High quality illumination! Adds unmatched sacred elegance to our living area.',
            'product_thumbnail' => get_theme_file_uri('/assets/images/products/prod-4.png'),
            'product_title'     => 'Sacred Tirupati Illumination Wall Art',
        ),
        array(
            'customer_photo'    => get_theme_file_uri('/assets/images/testimonials/testi-5.png'),
            'author_name'       => 'Ananya B.',
            'rating'            => 5,
            'review_text'       => 'Truly inspiring devotional art. Everyone who visits our home compliments it.',
            'product_thumbnail' => get_theme_file_uri('/assets/images/products/prod-5.png'),
            'product_title'     => 'Seven Running White Horses Wall Art',
        ),
    );
}
?>

<section class="home-testimonials-section w-full bg-white my-10 md:my-16" aria-label="<?php echo esc_attr($title); ?>">
    <div class="max-w-[1580px] mx-auto px-4">

        <!-- Section Header matching Figma Rosarivo 36px -->
        <div class="text-center mb-6 md:mb-10">
            <h2 class="font-serif text-3xl md:text-[36px] text-[#242424] font-normal leading-tight">
                <?php echo esc_html($title); ?>
            </h2>
        </div>

        <!-- 5-Card Customer Testimonials Swiper Carousel -->
        <div class="swiper testimonialSwiper relative w-full overflow-hidden">
            <div class="swiper-wrapper">
                <?php foreach ($items as $item): ?>
                    <?php
                    $photo_url = '';
                    if (!empty($item['customer_photo'])) {
                        if (is_array($item['customer_photo']) && !empty($item['customer_photo']['url'])) {
                            $photo_url = $item['customer_photo']['url'];
                        } elseif (is_numeric($item['customer_photo'])) {
                            $photo_url = wp_get_attachment_image_url($item['customer_photo'], 'large');
                        } elseif (is_string($item['customer_photo'])) {
                            $photo_url = $item['customer_photo'];
                        }
                    }

                    if (empty($photo_url)) continue;

                    $author_name = !empty($item['author_name']) ? $item['author_name'] : __('Devotee', 'dharmgyan');
                    $rating      = !empty($item['rating']) ? intval($item['rating']) : 5;
                    $prod_title  = !empty($item['product_title']) ? $item['product_title'] : '';
                    $review_text = !empty($item['review_text']) ? $item['review_text'] : '';

                    $prod_img_url = '';
                    if (!empty($item['product_thumbnail'])) {
                        if (is_array($item['product_thumbnail']) && !empty($item['product_thumbnail']['url'])) {
                            $prod_img_url = $item['product_thumbnail']['url'];
                        } elseif (is_numeric($item['product_thumbnail'])) {
                            $prod_img_url = wp_get_attachment_image_url($item['product_thumbnail'], 'thumbnail');
                        } elseif (is_string($item['product_thumbnail'])) {
                            $prod_img_url = $item['product_thumbnail'];
                        }
                    }
                    ?>

                    <div class="swiper-slide">
                        <div class="group flex flex-col justify-between h-full bg-white border border-[#EAE3DC] hover:border-[#CC5600] rounded-[6px] p-3 shadow-2xs hover:shadow-md transition-all duration-300 focus:outline-none">

                            <div>
                                <!-- Customer Devotee Photo -->
                                <div class="relative aspect-[3/4] w-full rounded-[4px] overflow-hidden bg-gray-100 shadow-xs mb-3">
                                    <img
                                        src="<?php echo esc_url($photo_url); ?>"
                                        alt="<?php echo esc_attr($author_name); ?>"
                                        class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500 ease-out"
                                        loading="lazy"
                                    />
                                </div>

                                <!-- Devotee Name (Rosarivo 17px) -->
                                <h3 class="font-serif text-[#333333] text-base md:text-[17px] font-normal leading-tight">
                                    <?php echo esc_html($author_name); ?>
                                </h3>

                                <!-- 5 Stars Rating -->
                                <div class="flex items-center gap-1 text-[#CC5600] mt-1.5 mb-2">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <svg class="w-3.5 h-3.5 <?php echo $i < $rating ? 'fill-current text-[#CC5600]' : 'text-gray-300 fill-current'; ?>" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    <?php endfor; ?>
                                </div>

                                <!-- Review Quote Text (Fixed & Visible) -->
                                <?php if ($review_text): ?>
                                    <p class="text-[#444444] text-[13px] font-body leading-relaxed line-clamp-3 mb-3">
                                        &ldquo;<?php echo esc_html($review_text); ?>&rdquo;
                                    </p>
                                <?php endif; ?>
                            </div>

                            <!-- Bottom Product Mention Box -->
                            <?php if ($prod_title || $prod_img_url): ?>
                                <div class="flex items-center gap-2 p-1.5 bg-[#FCFAF7] rounded-[4px] border border-[#EAE3DC] mt-auto">
                                    <?php if ($prod_img_url): ?>
                                        <div class="w-9 h-9 rounded-[3px] overflow-hidden bg-gray-200 flex-shrink-0">
                                            <img src="<?php echo esc_url($prod_img_url); ?>" alt="<?php echo esc_attr($prod_title); ?>" class="w-full h-full object-cover" />
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($prod_title): ?>
                                        <p class="font-body text-xs text-[#555555] line-clamp-2 leading-tight">
                                            <?php echo esc_html($prod_title); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Custom Styled Slider Navigation Arrows (Matching Figma spiritual luxury aesthetic) -->
            <button type="button" class="swiper-button-prev !w-11 !h-11 md:!w-12 md:!h-12 !rounded-full !bg-white/95 backdrop-blur-md !border !border-[#EAE3DC] hover:!border-[#CC5600] !shadow-lg hover:!shadow-xl !text-[#242424] hover:!text-white hover:!bg-[#CC5600] transition-all duration-300 flex items-center justify-center after:!hidden group !left-2 md:!left-4 z-30 focus:outline-none cursor-pointer" aria-label="<?php esc_attr_e('Previous Review', 'dharmgyan'); ?>">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <button type="button" class="swiper-button-next !w-11 !h-11 md:!w-12 md:!h-12 !rounded-full !bg-white/95 backdrop-blur-md !border !border-[#EAE3DC] hover:!border-[#CC5600] !shadow-lg hover:!shadow-xl !text-[#242424] hover:!text-white hover:!bg-[#CC5600] transition-all duration-300 flex items-center justify-center after:!hidden group !right-2 md:!right-4 z-30 focus:outline-none cursor-pointer" aria-label="<?php esc_attr_e('Next Review', 'dharmgyan'); ?>">
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>

    </div>
</section>
