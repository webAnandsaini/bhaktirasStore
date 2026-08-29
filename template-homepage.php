<?php
/**
 * Template Name: Homepage
 * 
 * Master Homepage template rendering modular template parts matching Figma 1:1.
 *
 * @package Dharmgyan
 */

get_header();
?>

<main id="primary" class="site-main homepage bg-white">
    
    <!-- 1. Hero 3-Card Showcase Auto-Slider -->
    <?php get_template_part('template-parts/home/hero-banner'); ?>

    <!-- 2. Divine Collections (4-Category Grid Showcase) -->
    <?php get_template_part('template-parts/home/category-grid'); ?>

    <!-- 3. Dual Middle Promo Banners (2-Column Showcase) -->
    <?php get_template_part('template-parts/home/promo-banners'); ?>

    <!-- 4. Our Most Viewed (10 Products in 2 Rows of 5) -->
    <?php get_template_part('template-parts/home/products-carousel'); ?>

    <!-- 5. Discover Divine Energies (6-Card Swiper Slider with White Box Labels) -->
    <?php get_template_part('template-parts/home/divine-energies'); ?>

    <!-- 6. Our Most Discount Sale (5 Products Grid) -->
    <?php get_template_part('template-parts/home/discount-sale'); ?>

    <!-- 7. Full-Width Ganesha Feature Banner matching Figma Y: 3929 -->
    <?php get_template_part('template-parts/home/feature-banner'); ?>

    <!-- 8. Discover Divine Products by Your Rashi (12 Zodiac Signs in 2 Rows of 6) -->
    <?php get_template_part('template-parts/home/rashi-products'); ?>

    <!-- 9. Trending Products (5 Products Grid) -->
    <?php get_template_part('template-parts/home/trending-products'); ?>

    <!-- 10. Product Videos (Video Reels with Floating Product Card matching Figma) -->
    <?php get_template_part('template-parts/home/product-videos'); ?>

    <!-- 11. Customer Testimonials & Reviews (5 Devotee Photo Cards) -->
    <?php get_template_part('template-parts/home/testimonials'); ?>

    <!-- 12. Instagram Community Photo Gallery (2 Rows of 7 Photos) -->
    <?php get_template_part('template-parts/home/instagram-gallery'); ?>

    <!-- 13. Join Our Newsletter Now (Full-Width Krishna Flute Banner) -->
    <?php get_template_part('template-parts/home/newsletter-banner'); ?>

    <!-- 14. 4 Circular Saffron Badges (Made In India, Best Quality, Secured Payment, Free Shipping) -->
    <?php get_template_part('template-parts/home/trust-badges'); ?>

</main>

<?php 
get_footer();
