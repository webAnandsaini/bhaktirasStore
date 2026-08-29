<?php
/**
 * Homepage 'Our Most Viewed' Showcase Template Part - 10 Products in 2 Rows of 5
 * Sourced from ACF Relationship fields (Global Option or Page Level) with fallback.
 * 
 * @package Dharmgyan
 */

$title = dharmgyan_get_field('most_viewed_title');
if (empty($title)) {
    $title = dharmgyan_get_field('trending_title') ?: __('Our Most Viewed', 'dharmgyan');
}

$selected_products = dharmgyan_get_field('most_viewed_products');
if (empty($selected_products)) {
    $selected_products = dharmgyan_get_field('most_viewed_products', 'option');
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
    $count = dharmgyan_get_field('trending_count') ? intval(dharmgyan_get_field('trending_count')) : 10;
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );
}

$query = new WP_Query($args);

if (!$query->have_posts()) {
    return;
}
?>

<section class="home-most-viewed-section w-full bg-white py-10 md:py-16" aria-label="<?php echo esc_attr($title); ?>">
    <div class="max-w-[1580px] mx-auto px-4">
        
        <!-- Section Header matching Figma Rosarivo 36px -->
        <div class="text-center mb-8 md:mb-12">
            <h2 class="font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-tight">
                <?php echo esc_html($title); ?>
            </h2>
        </div>

        <!-- 5-Column Responsive Product Grid (2 rows of 5 = 10 products matching Figma) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
            <?php while ($query->have_posts()): $query->the_post(); ?>
                <?php get_template_part('template-parts/shop/product-card'); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    </div>
</section>
