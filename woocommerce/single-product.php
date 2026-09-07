<?php
/**
 * Master Single Product Template
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<main id="primary" class="site-main single-product-page bg-white min-h-screen">
    <?php
    while (have_posts()) :
        the_post();
        wc_get_template_part('content', 'single-product');
    endwhile;
    ?>
</main>

<?php
get_footer('shop');
