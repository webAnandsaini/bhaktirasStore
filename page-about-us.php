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

    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 pt-10 md:pt-16 pb-7 md:pb-12 space-y-20 md:space-y-28 font-body">

        <!-- ─── Section 1: Who We Are / A Devotion Born in Vrindavan ─── -->
        <section class="story-block grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center">

            <!-- Left Narrative Column (7 cols) -->
            <div class="lg:col-span-7 space-y-5">
                <span class="inline-block text-[#CC5600] text-sm md:text-[15px] font-semibold tracking-wider font-body">
                    <?php echo esc_html($story_subtitle); ?>
                </span>

                <h1 class="text-3xl sm:text-4xl md:text-[42px] lg:text-[46px] font-serif text-[#111111] font-medium leading-[1.18]">
                    <?php echo esc_html($story_title); ?>
                </h1>

                <div class="prose prose-stone max-w-none text-[#444444] text-sm md:text-[15px] leading-[1.8] space-y-4 pt-1 font-body">
                    <?php if (!empty($story_content)): ?>
                        <?php echo wp_kses_post(wpautop($story_content)); ?>
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
                <span class="inline-block text-[#CC5600] text-sm md:text-[15px] font-semibold tracking-wider font-body">
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
            <div class="bg-[#FAFAFA] border border-[#F0EAE4] rounded-2xl p-8 sm:p-10 transition-shadow hover:shadow-sm">
                <!-- Eye Sketch Illustration Icon -->
                <div class="mb-5">
                <svg width="121" height="121" viewBox="0 0 121 121" fill="none" class="max-md:max-w-20 max-md:h-auto" xmlns="http://www.w3.org/2000/svg">
<path d="M64.3633 41.5696V49.583C67.6512 50.7481 70.2534 53.3482 71.4164 56.6362H79.4299C77.8943 49.067 71.9324 43.1052 64.3633 41.5696Z" fill="#CC5600"/>
<path d="M71.4123 64.3632C69.8223 68.8624 65.5453 72.0906 60.4992 72.0906C54.0972 72.0906 48.9081 66.9015 48.9081 60.4995C48.9081 55.4555 52.1363 51.1784 56.6355 49.5864V41.5754C47.8184 43.3661 41.1807 51.1537 41.1807 60.5C41.1807 71.1695 49.8296 79.8185 60.4992 79.8185C69.8434 79.8185 77.6326 73.1807 79.4237 64.3637L71.4123 64.3632Z" fill="#CC5600"/>
<path d="M119.921 59.2447C118.952 58.1126 95.7559 31.5225 60.4996 31.5225C25.2433 31.5225 2.04786 58.1122 1.07813 59.2447L0 60.4996L1.07813 61.7554C2.04786 62.8875 25.2437 89.4776 60.5 89.4776C95.7563 89.4776 118.952 62.8875 119.922 61.7554L121 60.4996L119.921 59.2447ZM85.6139 60.4996C85.6139 74.3471 74.3475 85.6139 60.4996 85.6139C46.6517 85.6139 35.3857 74.3471 35.3857 60.4996C35.3857 46.6521 46.6525 35.3853 60.4996 35.3853C74.3467 35.3853 85.6139 46.6521 85.6139 60.4996ZM5.17715 60.498C9.11051 56.4121 22.7318 43.4824 42.3478 37.9455C35.7546 43.2619 31.5216 51.3912 31.5216 60.5C31.5216 69.6027 35.7484 77.7282 42.3322 83.0447C22.7474 77.4999 9.11257 64.5797 5.17715 60.498ZM78.6514 83.0541C85.2446 77.7377 89.4776 69.6085 89.4776 60.4996C89.4776 51.3965 85.2508 43.2714 78.667 37.955C98.2542 43.4993 111.887 56.4195 115.822 60.5017C111.889 64.5875 98.2674 77.5176 78.6514 83.0541Z" fill="#333333"/>
<path d="M60.4998 23.7946C76.7986 23.7946 92.6882 28.8601 107.728 38.8513L109.864 35.633C94.4015 25.3615 77.3299 19.9309 60.4994 19.9309C47.0673 19.9309 33.7721 23.2671 20.9775 29.8451L22.7452 33.2818C34.9862 26.9861 47.69 23.7946 60.4998 23.7946Z" fill="#333333"/>
<path d="M18.959 35.351L17.0406 31.9976C14.9696 33.1816 12.9819 34.4064 11.1348 35.6334L13.2712 38.8517C15.0492 37.673 16.9614 36.4947 18.959 35.351Z" fill="#333333"/>
<path d="M60.5 97.2049C44.2012 97.2049 28.3116 92.1394 13.2722 82.1482L11.1357 85.3665C26.5984 95.638 43.67 101.069 60.5004 101.069C73.9346 101.069 87.2294 97.7303 100.022 91.1524L98.2547 87.7156C86.0161 94.0134 73.3123 97.2049 60.5 97.2049Z" fill="#333333"/>
<path d="M102.04 85.6486L103.958 89.0021C106.029 87.818 108.017 86.5932 109.864 85.3663L107.728 82.1479C105.95 83.3266 104.038 84.5053 102.04 85.6486Z" fill="#333333"/>
</svg>

                </div>

                <h3 class="text-2xl sm:text-[28px] font-serif text-[#111111] font-medium mb-3">
                    <?php echo esc_html($vision_title); ?>
                </h3>

                <div class="text-[#555555] text-sm md:text-[15px] leading-[1.8] space-y-3 font-body">
                    <?php if (!empty($vision_desc)): ?>
                        <?php echo wp_kses_post(wpautop($vision_desc)); ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Card 2: Our Mission -->
            <div class="bg-[#FAFAFA] border border-[#F0EAE4] rounded-2xl p-8 sm:p-10 transition-shadow hover:shadow-sm">
                <!-- Target / Mission Sketch Illustration Icon -->
                <div class="mb-5">
                <svg width="104" height="104" viewBox="0 0 104 104" fill="none" class="max-md:max-w-20 max-md:h-auto" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_381_2411)">
<path d="M65.2075 -0.00210575L58.373 10.2502L68.6254 17.0847L75.4599 6.83238L65.2075 -0.00210575Z" fill="#CC5600"/>
<path d="M61.3734 86.817C62.0466 86.5728 62.672 86.1967 63.2016 85.6773C64.3567 84.5427 64.8965 82.9728 64.6829 81.3665L61.7922 59.687V44.2845L74.3993 39.7824C75.9816 39.2168 77.1519 37.8397 77.4526 36.1861L79.3695 25.6393L95.0452 35.6138L96.88 32.73L79.9213 21.9391C79.8819 20.8336 79.4821 19.7624 78.7578 18.8945C77.7992 17.7464 76.3916 17.087 74.895 17.087C74.1978 17.087 73.5402 17.239 72.9352 17.492L59.2925 8.81104L57.4577 11.6952L70.3845 19.9202C70.1691 20.3659 70.0018 20.8412 69.9216 21.3537L68.3361 31.6577L58.3069 35.0525C56.436 33.3952 54.0272 32.4639 51.541 32.4639C49.3402 32.4639 47.2237 33.178 45.3546 34.579L44.8268 35.0164C44.6985 35.1276 41.9 37.6699 39.5815 39.7762V34.3552C39.5815 31.7652 37.7431 29.5134 35.305 29.1169C33.8033 28.869 32.2842 29.2929 31.1379 30.2683C29.9879 31.244 29.3304 32.6669 29.3304 34.1723V48.1018C29.3304 51.7255 32.2794 54.6746 35.9031 54.6746C37.5313 54.6746 39.0931 54.075 40.2992 52.9866L41.2902 52.0966V59.6877L38.4166 81.2422C38.0886 83.7025 39.4966 86.021 41.7123 86.8156C38.9871 87.5843 36.334 88.6643 33.8241 90.0876L14.5195 101.027L16.2042 104L35.5088 93.0603C45.3994 87.4582 57.6873 87.4564 67.5762 93.0603L86.8808 104L88.5654 101.027L69.2608 90.0876C66.7499 88.6657 64.0968 87.5861 61.3734 86.817ZM38.0124 50.4476C37.4333 50.9703 36.6831 51.2575 35.9024 51.2575C34.1631 51.2575 32.7467 49.8411 32.7467 48.1018V34.1723C32.7467 33.67 32.9654 33.1951 33.3499 32.8703C33.7396 32.5405 34.2367 32.4074 34.7561 32.4876C35.5456 32.6174 36.1641 33.4375 36.1641 34.3549V47.4986L39.021 44.9016C39.021 44.9016 46.7776 37.8521 47.0374 37.6218L47.4664 37.2646C50.2788 35.1597 54.2648 35.5832 56.5884 38.1546L57.34 38.9868L71.396 34.2284L73.296 21.8724C73.3011 21.8432 73.3183 21.821 73.3234 21.7922L76.2553 23.658L74.0888 35.5748C74.005 36.0293 73.6838 36.4084 73.2483 36.564L58.3747 41.8779V59.8003L61.2946 81.8181C61.3646 82.3477 61.1871 82.8653 60.8059 83.2396C60.5839 83.4601 60.0969 83.8155 59.3501 83.6974C58.6445 83.5899 58.0551 82.9251 57.9476 82.1152L54.7441 58.0916H48.3354L45.113 82.2621C45.0481 82.7439 44.7798 83.1726 44.373 83.4408C43.9612 83.7142 43.4575 83.7878 42.9534 83.6511C42.1898 83.4394 41.6821 82.5817 41.8001 81.6949L44.6894 60.0256L44.7066 44.4234L38.0124 50.4476ZM46.931 85.7374C47.7766 84.9396 48.3456 83.8837 48.5012 82.7151L51.3271 61.509H51.7524L54.5611 82.5682C54.7284 83.8206 55.3266 84.9276 56.1824 85.7425C53.1127 85.346 50.0014 85.3445 46.931 85.7374Z" fill="#333333"/>
<path d="M61.7923 22.2128C61.7923 16.5593 57.1947 11.9617 51.5412 11.9617C45.8877 11.9617 41.29 16.5593 41.29 22.2128C41.29 27.8663 45.8877 32.464 51.5412 32.464C57.1947 32.464 61.7923 27.8663 61.7923 22.2128ZM51.5412 29.0469C47.772 29.0469 44.7071 25.982 44.7071 22.2128C44.7071 18.4437 47.772 15.3787 51.5412 15.3787C55.3103 15.3787 58.3753 18.4437 58.3753 22.2128C58.3753 25.982 55.3103 29.0469 51.5412 29.0469Z" fill="#333333"/>
<path d="M92.545 46.1321H89.128V49.5491H85.7109V52.9662H89.128V56.3832H92.545V52.9662H95.9621V49.5491H92.545V46.1321Z" fill="#333333"/>
<path d="M78.8773 63.2174V61.5087H80.586V58.0916H78.8773V56.3833H75.4603V58.0916H73.752V61.5087H75.4603V63.2174H78.8773Z" fill="#333333"/>
<path d="M89.128 61.5088H85.711V64.9258H82.2939V68.3429H85.711V71.7599H89.128V68.3429H92.5451V64.9258H89.128V61.5088Z" fill="#333333"/>
<path d="M25.9131 15.3788H29.3302V11.9618H32.7472V8.54473H29.3302V5.12769H25.9131V8.54473H22.4961V11.9618H25.9131V15.3788Z" fill="#333333"/>
<path d="M12.2445 10.253V8.5447H13.9532V5.12765H12.2445V3.41895H8.82748V5.12765H7.11914V8.5447H8.82748V10.253H12.2445Z" fill="#333333"/>
<path d="M17.3702 25.6298V22.2128H20.7873V18.7957H17.3702V15.3787H13.9532V18.7957H10.5361V22.2128H13.9532V25.6298H17.3702Z" fill="#333333"/>
</g>
<defs>
<clipPath id="clip0_381_2411">
<rect width="104" height="104" fill="white"/>
</clipPath>
</defs>
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
            <?php get_template_part('template-parts/home/discount-sale'); ?>
    <?php endif; ?>

    <?php if ($show_trending_products !== false && $show_trending_products !== '0'): ?>
            <?php get_template_part('template-parts/home/trending-products'); ?>
    <?php endif; ?>

    <?php if ($show_testimonials !== false && $show_testimonials !== '0'): ?>
            <?php get_template_part('template-parts/home/testimonials'); ?>
    <?php endif; ?>

    <?php if ($show_trust_badges !== false && $show_trust_badges !== '0'): ?>
            <?php get_template_part('template-parts/home/trust-badges'); ?>
    <?php endif; ?>

</main>

<?php
get_footer();
