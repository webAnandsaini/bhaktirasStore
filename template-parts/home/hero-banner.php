<?php
/**
 * Homepage Hero Banner (Full 3-Card Set Auto-Slider)
 * Sourced purely from ACF fields on Homepage (Post ID: 109).
 *
 * @package Dharmgyan
 */

$hero_sets = dharmgyan_get_field('hero_showcase_sets');

if (empty($hero_sets) || !is_array($hero_sets)) {
    return; // No hardcoded fallbacks: purely renders what is in ACF
}
?>

<section class="home-hero-section w-full bg-white py-4 md:py-6 md:pt-1" aria-label="<?php esc_attr_e('Featured Hero Collections', 'dharmgyan'); ?>">
    <div class="max-w-[1580px] mx-auto px-4">

        <!-- Master Swiper Container (Sliding the full 3-card grid together) -->
        <div class="swiper heroSwiper w-full relative">
            <div class="swiper-wrapper">
                <?php foreach ($hero_sets as $set_index => $set): ?>
                    <?php
                    // Card 1 (Left Large)
                    $c1_img = '';
                    $c1_alt = '';
                    if (is_array($set['card_1_image']) && !empty($set['card_1_image']['url'])) {
                        $c1_img = $set['card_1_image']['url'];
                        $c1_alt = !empty($set['card_1_image']['alt']) ? $set['card_1_image']['alt'] : (!empty($set['card_1_title']) ? $set['card_1_title'] : '');
                    } elseif (is_numeric($set['card_1_image'])) {
                        $c1_img = wp_get_attachment_image_url($set['card_1_image'], 'full');
                    } elseif (is_string($set['card_1_image'])) {
                        $c1_img = $set['card_1_image'];
                    }

                    if (empty($c1_img)) {
                        continue;
                    }

                    $c1_eyebrow  = !empty($set['card_1_eyebrow']) ? $set['card_1_eyebrow'] : '';
                    $c1_title    = !empty($set['card_1_title']) ? $set['card_1_title'] : '';
                    $c1_subtitle = !empty($set['card_1_subtitle']) ? $set['card_1_subtitle'] : '';
                    $c1_cta      = !empty($set['card_1_cta_text']) ? $set['card_1_cta_text'] : '';
                    $c1_link     = !empty($set['card_1_link']) ? $set['card_1_link'] : '';

                    // Card 2 (Right Top)
                    $c2_img = '';
                    $c2_alt = '';
                    if (is_array($set['card_2_image']) && !empty($set['card_2_image']['url'])) {
                        $c2_img = $set['card_2_image']['url'];
                        $c2_alt = !empty($set['card_2_image']['alt']) ? $set['card_2_image']['alt'] : (!empty($set['card_2_title']) ? $set['card_2_title'] : '');
                    } elseif (is_numeric($set['card_2_image'])) {
                        $c2_img = wp_get_attachment_image_url($set['card_2_image'], 'full');
                    } elseif (is_string($set['card_2_image'])) {
                        $c2_img = $set['card_2_image'];
                    }

                    $c2_title = !empty($set['card_2_title']) ? $set['card_2_title'] : '';
                    $c2_link  = !empty($set['card_2_link']) ? $set['card_2_link'] : '';

                    // Card 3 (Right Bottom)
                    $c3_img = '';
                    $c3_alt = '';
                    if (is_array($set['card_3_image']) && !empty($set['card_3_image']['url'])) {
                        $c3_img = $set['card_3_image']['url'];
                        $c3_alt = !empty($set['card_3_image']['alt']) ? $set['card_3_image']['alt'] : (!empty($set['card_3_title']) ? $set['card_3_title'] : '');
                    } elseif (is_numeric($set['card_3_image'])) {
                        $c3_img = wp_get_attachment_image_url($set['card_3_image'], 'full');
                    } elseif (is_string($set['card_3_image'])) {
                        $c3_img = $set['card_3_image'];
                    }

                    $c3_title = !empty($set['card_3_title']) ? $set['card_3_title'] : '';
                    $c3_link  = !empty($set['card_3_link']) ? $set['card_3_link'] : '';
                    ?>

                    <div class="swiper-slide w-full">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 md:gap-7 items-stretch">

                            <!-- Left Large Primary Card (lg:col-span-7) -->
                            <div class="lg:col-span-7 w-full h-[420px] sm:h-[480px] md:h-[540px] lg:h-[695px]">
                                <<?php echo $c1_link ? 'a href="' . esc_url($c1_link) . '"' : 'div'; ?> class="group block w-full h-full relative overflow-hidden rounded-[5px] shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]">
                                    <img
                                        src="<?php echo esc_url($c1_img); ?>"
                                        alt="<?php echo esc_attr($c1_alt ?: $c1_title); ?>"
                                        class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
                                        <?php if ($set_index === 0): ?>
                                            loading="eager"
                                            fetchpriority="high"
                                            decoding="sync"
                                        <?php else: ?>
                                            loading="lazy"
                                            decoding="async"
                                        <?php endif; ?>
                                    />

                                    <?php if ($c1_eyebrow || $c1_title || $c1_subtitle || $c1_cta): ?>
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/35 to-black/5 group-hover:from-black/90 transition-colors duration-300"></div>

                                        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 md:p-10 lg:p-12 z-10 flex flex-col justify-end text-left">
                                            <?php if ($c1_eyebrow): ?>
                                                <p class="text-[#FFB23D] text-xs sm:text-[13px] font-bold tracking-widest uppercase mb-2 font-body">
                                                    <?php echo esc_html($c1_eyebrow); ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php if ($c1_title): ?>
                                                <?php if ($set_index === 0): ?>
                                                    <h1 class="font-serif text-2xl sm:text-3xl md:text-4xl lg:text-[44px] text-white font-normal leading-[1.15] mb-3 tracking-tight">
                                                        <?php echo esc_html($c1_title); ?>
                                                    </h1>
                                                <?php else: ?>
                                                    <h2 class="font-serif text-2xl sm:text-3xl md:text-4xl lg:text-[44px] text-white font-normal leading-[1.15] mb-3 tracking-tight">
                                                        <?php echo esc_html($c1_title); ?>
                                                    </h2>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($c1_subtitle): ?>
                                                <p class="text-white/90 text-sm sm:text-base font-sub max-w-xl mb-6 line-clamp-2 leading-relaxed">
                                                    <?php echo esc_html($c1_subtitle); ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php if ($c1_cta): ?>
                                                <div>
                                                    <span class="inline-flex items-center gap-2 bg-[#CC5600] group-hover:bg-[#B34B00] text-white font-medium px-6 py-2.5 sm:py-3 rounded-[4px] text-sm sm:text-base transition-all duration-200 shadow-md">
                                                        <span><?php echo esc_html($c1_cta); ?></span>
                                                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                                            <polyline points="12 5 19 12 12 19"></polyline>
                                                        </svg>
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition-colors duration-300"></div>
                                    <?php endif; ?>
                                </<?php echo $c1_link ? 'a' : 'div'; ?>>
                            </div>

                            <!-- Right Secondary Stacked Cards (lg:col-span-5) -->
                            <div class="lg:col-span-5 flex flex-col gap-5 md:gap-7 w-full h-[420px] sm:h-[480px] md:h-[540px] lg:h-[695px] justify-between">

                                <!-- Card 2 (Right Top) -->
                                <?php if ($c2_img): ?>
                                    <div class="w-full h-[200px] sm:h-[230px] md:h-[260px] lg:h-[334px]">
                                        <<?php echo $c2_link ? 'a href="' . esc_url($c2_link) . '"' : 'div'; ?> class="group block w-full h-full relative rounded-[5px] overflow-hidden shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]">
                                            <img
                                                src="<?php echo esc_url($c2_img); ?>"
                                                alt="<?php echo esc_attr($c2_alt ?: $c2_title); ?>"
                                                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
                                                <?php if ($set_index === 0): ?>
                                                    loading="eager"
                                                    decoding="sync"
                                                <?php else: ?>
                                                    loading="lazy"
                                                    decoding="async"
                                                <?php endif; ?>
                                            />
                                            <?php if ($c2_title): ?>
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent group-hover:from-black/70 transition-colors duration-300"></div>
                                                <div class="absolute bottom-0 left-0 right-0 p-5 z-10">
                                                    <span class="inline-block bg-white/95 text-[#111111] text-xs font-semibold px-3 py-1.5 rounded-[3px] shadow-sm group-hover:bg-[#CC5600] group-hover:text-white transition-colors duration-200">
                                                        <?php echo esc_html($c2_title); ?> →
                                                    </span>
                                                </div>
                                            <?php else: ?>
                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition-colors duration-300"></div>
                                            <?php endif; ?>
                                        </<?php echo $c2_link ? 'a' : 'div'; ?>>
                                    </div>
                                <?php endif; ?>

                                <!-- Card 3 (Right Bottom) -->
                                <?php if ($c3_img): ?>
                                    <div class="w-full h-[200px] sm:h-[230px] md:h-[260px] lg:h-[334px]">
                                        <<?php echo $c3_link ? 'a href="' . esc_url($c3_link) . '"' : 'div'; ?> class="group block w-full h-full relative rounded-[5px] overflow-hidden shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]">
                                            <img
                                                src="<?php echo esc_url($c3_img); ?>"
                                                alt="<?php echo esc_attr($c3_alt ?: $c3_title); ?>"
                                                class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out"
                                                <?php if ($set_index === 0): ?>
                                                    loading="eager"
                                                    decoding="sync"
                                                <?php else: ?>
                                                    loading="lazy"
                                                    decoding="async"
                                                <?php endif; ?>
                                            />
                                            <?php if ($c3_title): ?>
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent group-hover:from-black/70 transition-colors duration-300"></div>
                                                <div class="absolute bottom-0 left-0 right-0 p-5 z-10">
                                                    <span class="inline-block bg-white/95 text-[#111111] text-xs font-semibold px-3 py-1.5 rounded-[3px] shadow-sm group-hover:bg-[#CC5600] group-hover:text-white transition-colors duration-200">
                                                        <?php echo esc_html($c3_title); ?> →
                                                    </span>
                                                </div>
                                            <?php else: ?>
                                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition-colors duration-300"></div>
                                            <?php endif; ?>
                                        </<?php echo $c3_link ? 'a' : 'div'; ?>>
                                    </div>
                                <?php endif; ?>

                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Full 3-Card Slider Pagination Bullets Centered Below -->
            <div class="hero-swiper-pagination flex items-center justify-center gap-2 mt-4 md:mt-6 z-20"></div>
        </div>

    </div>
</section>
