<?php
/**
 * Homepage 'Trending Products' Showcase Template Part - 1 Row of 5 Products matching Figma
 * Sourced from ACF Relationship fields (Global Option or Page Level) with fallback.
 *
 * @package Dharmgyan
 */

$title = dharmgyan_get_field('trending_products_title');
if (empty($title)) {
    $title = dharmgyan_get_field('trending_products_title', 'option') ?: __('Trending Products', 'dharmgyan');
}

$selected_products = dharmgyan_get_field('trending_products');
if (empty($selected_products)) {
    $selected_products = dharmgyan_get_field('trending_products', 'option');
}

if (!empty($selected_products) && is_array($selected_products)) {
    $product_ids = array_map(function($p) {
        return is_object($p) ? $p->ID : intval($p);
    }, $selected_products);

    $args = array(
        'post_type'      => 'product',
        'post__in'       => $product_ids,
        'orderby'        => 'post__in',
        'posts_per_page' => count($product_ids),
        'post_status'    => 'publish',
    );
} else {
    $count = dharmgyan_get_field('trending_products_count') ? intval(dharmgyan_get_field('trending_products_count')) : 5;
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'rand',
    );
}

$query = new WP_Query($args);

if (!$query->have_posts()) {
    return;
}
?>

<section class="home-trending-products-section w-full bg-white pb-10 md:pb-16" aria-label="<?php echo esc_attr($title); ?>">
    <div class="max-w-[1580px] mx-auto px-4">

        <!-- Section Header matching Figma Rosarivo 36px -->
        <div class="text-center mb-6 md:mb-10">
            <h2 class="font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-tight">
                <?php echo esc_html($title); ?>
            </h2>
        </div>

        <!-- 5-Column Responsive Product Grid (1 Row of 5 Products) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-y-4 gap-x-2">
            <?php while ($query->have_posts()): $query->the_post(); ?>
                <?php get_template_part('template-parts/shop/product-card'); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    </div>
</section>
