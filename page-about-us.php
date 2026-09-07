<?php
/**
 * Template Name: About Us
 * 
 * Pixel-Perfect About Us page matching Figma (378:1011).
 * Fully dynamic via ACF with graceful Figma fallbacks.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();

// Fetch ACF fields with graceful Figma fallbacks
$story_subtitle   = get_field('story_subtitle') ?: 'Who We Are';
$story_title      = get_field('story_title') ?: 'A Devotion Born in Vrindavan';
$story_content    = get_field('story_content');
$story_image      = get_field('story_image');
$story_quote      = get_field('story_quote_badge') ?: "\"हर मूर्ति में भगवान का वास है\"\n— Every idol is a divine abode.";

$craft_subtitle   = get_field('craft_subtitle') ?: 'The Craft';
$craft_title      = get_field('craft_title') ?: 'Handcrafted by Devoted Artisans';
$craft_content    = get_field('craft_content');
$craft_gallery    = get_field('craft_gallery');
$craft_stats      = get_field('craft_stats');

$vision_title     = get_field('vision_title') ?: 'Our Vision';
$vision_desc      = get_field('vision_description');
$mission_title    = get_field('mission_title') ?: 'Our Mission';
$mission_desc     = get_field('mission_description');

$show_discount_sale     = get_field('show_discount_sale');
$show_trending_products = get_field('show_trending_products');
$show_testimonials      = get_field('show_testimonials');
$show_trust_badges      = get_field('show_trust_badges');

// Fallback images from theme assets
$default_story_image = get_template_directory_uri() . '/assets/images/figma/asset_112caeaa19.png';
if (empty($story_image)) {
    $story_image_url = $default_story_image;
} else {
    $story_image_url = is_array($story_image) ? $story_image['url'] : $story_image;
}

$default_gallery = [
    get_template_directory_uri() . '/assets/images/figma/asset_6eb127a2a2.png',
    get_template_directory_uri() . '/assets/images/figma/asset_613a46d1e2.png',
    get_template_directory_uri() . '/assets/images/figma/asset_6245303df5.png',
    get_template_directory_uri() . '/assets/images/figma/asset_4456a13674.png',
];

if (empty($craft_gallery) || !is_array($craft_gallery)) {
    $gallery_items = $default_gallery;
} else {
    $gallery_items = [];
    foreach ($craft_gallery as $item) {
        $gallery_items[] = is_array($item) ? $item['url'] : $item;
    }
}

if (empty($craft_stats) || !is_array($craft_stats)) {
    $craft_stats = [
        ['stat_number' => '500+', 'stat_label' => 'Happy Clints'],
        ['stat_number' => '500+', 'stat_label' => 'Happy Clints'],
        ['stat_number' => '500+', 'stat_label' => 'Happy Clints'],
        ['stat_number' => '500+', 'stat_label' => 'Happy Clints'],
    ];
}
?>

<main id="primary" class="site-main about-us-page bg-white min-h-screen">

    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-10 md:pt-16 pb-16 md:pb-24 space-y-20 md:space-y-28 font-body">

        <!-- ─── Section 1: Who We Are / A Devotion Born in Vrindavan ─── -->
        <section class="story-block grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center">
            
            <!-- Left Narrative Column (7 cols) -->
            <div class="lg:col-span-7 space-y-5">
                <span class="inline-block text-[#CC5600] text-sm md:text-[15px] font-semibold tracking-wider uppercase font-body">
                    <?php echo esc_html($story_subtitle); ?>
                </span>

                <h1 class="text-3xl sm:text-4xl md:text-[42px] lg:text-[46px] font-serif text-[#111111] font-medium leading-[1.18]">
                    <?php echo esc_html($story_title); ?>
                </h1>

                <div class="prose prose-stone max-w-none text-[#444444] text-sm md:text-[15px] leading-[1.8] space-y-4 pt-1 font-body">
                    <?php if (!empty($story_content)): ?>
                        <?php echo wp_kses_post(wpautop($story_content)); ?>
                    <?php else: ?>
                        <p>In 2009, Ramesh Sharma — a devotee and artist from Mathura — started दिव्य भक्ति with five artisans in a small Vrindavan workshop. His dream was simple: create divine products that carry the soul of India's sacred traditions right into the heart of every home.</p>
                        <p>Today, we are a family of 50+ artisans crafting idols, pooja thalis, brass diyas, rangoli art, and home decor — each piece infused with bhakti and offered with love to 10,000+ families across India.</p>
                        <p>We believe every home deserves a divine corner — a space of peace, prayer, and beauty. That is why every piece we create is not just a product, but a blessing.</p>
                        <p>In 2009, Ramesh Sharma — a devotee and artist from Mathura — started दिव्य भक्ति with five artisans in a small Vrindavan workshop. His dream was simple: create divine products that carry the soul of India's sacred traditions right into the heart of every home.</p>
                        <p>Today, we are a family of 50+ artisans crafting idols, pooja thalis, brass diyas, rangoli art, and home decor — each piece infused with bhakti and offered with love to 10,000+ families across India.</p>
                        <p>We believe every home deserves a divine corner — a space of peace, prayer, and beauty. That is why every piece we create is not just a product, but a blessing.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Visual Column (5 cols) with Offset Saffron Quote Card -->
            <div class="lg:col-span-5 relative mt-6 lg:mt-0 pb-8 lg:pb-0">
                <div class="relative rounded-2xl overflow-hidden shadow-lg border border-[#F0EAE4]">
                    <img src="<?php echo esc_url($story_image_url); ?>" alt="<?php echo esc_attr($story_title); ?>" class="w-full h-[480px] sm:h-[540px] object-cover transition-transform duration-700 hover:scale-105">
                </div>
                
                <!-- Saffron Quote Overlay Card (hanging bottom-left outside the photo matching Figma PDP 1:1) -->
                <div class="absolute -bottom-6 -left-3 sm:-bottom-8 sm:-left-8 bg-[#CC5600] text-white p-5 sm:p-6 shadow-2xl rounded-[4px] z-20 max-w-[320px] sm:max-w-[360px]">
                    <p class="text-base sm:text-lg font-bold font-serif leading-tight">
                        "हर मूर्ति में भगवान का वास है"
                    </p>
                    <p class="text-xs sm:text-[13px] text-white/95 font-body mt-1">
                        — Every idol is a divine abode.
                    </p>
                </div>
            </div>

        </section>


        <!-- ─── Section 2: The Craft / Handcrafted by Devoted Artisans ─── -->
        <section class="craft-block grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center">
            
            <!-- Left: 2x2 Image Mosaic (5 cols) matching Figma -->
            <div class="lg:col-span-5 grid grid-cols-2 gap-3 sm:gap-4">
                <?php foreach (array_slice($gallery_items, 0, 4) as $index => $img): ?>
                    <div class="aspect-square rounded-xl overflow-hidden shadow-xs border border-[#F0EAE4] group">
                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(sprintf('%s image %d', $craft_title, $index + 1)); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Right: Narrative & Milestone Counters (7 cols) -->
            <div class="lg:col-span-7 space-y-6">
                <span class="inline-block text-[#CC5600] text-sm md:text-[15px] font-semibold tracking-wider uppercase font-body">
                    <?php echo esc_html($craft_subtitle); ?>
                </span>

                <h2 class="text-3xl sm:text-4xl md:text-[40px] lg:text-[44px] font-serif text-[#111111] font-medium leading-[1.2]">
                    <?php echo esc_html($craft_title); ?>
                </h2>

                <div class="prose prose-stone max-w-none text-[#444444] text-sm md:text-[15px] leading-[1.8] space-y-4 font-body">
                    <?php if (!empty($craft_content)): ?>
                        <?php echo wp_kses_post(wpautop($craft_content)); ?>
                    <?php else: ?>
                        <p>Our artisans — drawn from generations of sculptors in Mathura, Jaipur, and Varanasi — pour years of skill and spiritual intention into every creation. From hand-painting diyas to carving intricate Ganesh idols, each process is guided by devotion, not machinery.</p>
                        <p>We ensure fair wages, safe workshops, and creative freedom for every artisan. When you buy from us, you support not just a product, but a living tradition.</p>
                        <p>We ensure fair wages, safe workshops, and creative freedom for every artisan. When you buy from us, you support not just a product, but a living tradition.</p>
                    <?php endif; ?>
                </div>

                <!-- 4x Milestone Stats Row matching Figma (500+ Happy Clints) -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-[#F0EAE4]">
                    <?php foreach ($craft_stats as $stat): 
                        $s_num = $stat['stat_number'] ?? '500+';
                        $s_lbl = $stat['stat_label'] ?? 'Happy Clints';
                    ?>
                        <div>
                            <div class="text-3xl sm:text-[34px] font-bold font-serif text-[#111111] leading-none">
                                <?php echo esc_html($s_num); ?>
                            </div>
                            <div class="text-xs sm:text-[13px] font-medium text-[#CC5600] mt-1.5 font-body">
                                <?php echo esc_html($s_lbl); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </section>


        <!-- ─── Section 3: Vision & Mission Cards matching Figma ─── -->
        <section class="vision-mission-block grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            
            <!-- Card 1: Our Vision -->
            <div class="bg-[#FAF7F2] border border-[#F0EAE4] rounded-2xl p-8 sm:p-10 transition-shadow hover:shadow-sm">
                <!-- Eye Sketch Illustration Icon -->
                <div class="w-12 h-12 text-[#111111] mb-5">
                    <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.8" class="w-12 h-12">
                        <path d="M4 24C4 24 11 12 24 12C37 12 44 24 44 24C44 24 37 36 24 36C11 36 4 24 4 24Z" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="24" cy="24" r="7" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 21C21 19.3431 22.3431 18 24 18" stroke-linecap="round"/>
                        <path d="M24 6V9M12 9L14 11M36 9L34 11" stroke-linecap="round"/>
                    </svg>
                </div>

                <h3 class="text-2xl sm:text-[28px] font-serif text-[#111111] font-medium mb-3">
                    <?php echo esc_html($vision_title); ?>
                </h3>

                <div class="text-[#555555] text-sm md:text-[15px] leading-[1.8] space-y-3 font-body">
                    <?php if (!empty($vision_desc)): ?>
                        <?php echo wp_kses_post(wpautop($vision_desc)); ?>
                    <?php else: ?>
                        <p>Our artisans — drawn from generations of sculptors in Mathura, Jaipur, and Varanasi — pour years of skill and spiritual intention into every creation. From hand-painting diyas to carving intricate Ganesh idols, each process is guided by devotion, not machinery.</p>
                        <p>We ensure fair wages, safe workshops, and creative freedom for every artisan. When you buy from us, you support not just a product, but a living tradition.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card 2: Our Mission -->
            <div class="bg-[#FAF7F2] border border-[#F0EAE4] rounded-2xl p-8 sm:p-10 transition-shadow hover:shadow-sm">
                <!-- Target / Mission Sketch Illustration Icon -->
                <div class="w-12 h-12 text-[#111111] mb-5">
                    <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.8" class="w-12 h-12">
                        <circle cx="24" cy="24" r="18" stroke-linecap="round"/>
                        <circle cx="24" cy="24" r="11" stroke-linecap="round"/>
                        <circle cx="24" cy="24" r="4" fill="currentColor"/>
                        <path d="M24 2V6M24 42V46M2 24H6M42 24H46" stroke-linecap="round"/>
                        <path d="M38 10L35 13M10 38L13 35M10 10L13 13M38 38L35 35" stroke-linecap="round"/>
                    </svg>
                </div>

                <h3 class="text-2xl sm:text-[28px] font-serif text-[#111111] font-medium mb-3">
                    <?php echo esc_html($mission_title); ?>
                </h3>

                <div class="text-[#555555] text-sm md:text-[15px] leading-[1.8] space-y-3 font-body">
                    <?php if (!empty($mission_desc)): ?>
                        <?php echo wp_kses_post(wpautop($mission_desc)); ?>
                    <?php else: ?>
                        <p>Our artisans — drawn from generations of sculptors in Mathura, Jaipur, and Varanasi — pour years of skill and spiritual intention into every creation. From hand-painting diyas to carving intricate Ganesh idols, each process is guided by devotion, not machinery.</p>
                        <p>We ensure fair wages, safe workshops, and creative freedom for every artisan. When you buy from us, you support not just a product, but a living tradition.</p>
                    <?php endif; ?>
                </div>
            </div>

        </section>

    </div>

    <!-- ─── Bottom Sections Matching Figma PDP 1:1 ─── -->
    <?php if ($show_discount_sale !== false && $show_discount_sale !== '0'): ?>
        <div class="border-t border-[#F0EAE4] bg-white">
            <?php get_template_part('template-parts/home/discount-sale'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_trending_products !== false && $show_trending_products !== '0'): ?>
        <div class="border-t border-[#F0EAE4] bg-white">
            <?php get_template_part('template-parts/home/trending-products'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_testimonials !== false && $show_testimonials !== '0'): ?>
        <div class="border-t border-[#F0EAE4] bg-white">
            <?php get_template_part('template-parts/home/testimonials'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_trust_badges !== false && $show_trust_badges !== '0'): ?>
        <div class="border-t border-[#F0EAE4] bg-white">
            <?php get_template_part('template-parts/home/trust-badges'); ?>
        </div>
    <?php endif; ?>

</main>

<?php
get_footer();
