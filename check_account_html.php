<?php
require_once('/var/www/html/wp-load.php');
wp_set_current_user(1);
global $post, $wp_query;
$page = get_page_by_path('my-account');
$post = $page;
setup_postdata($post);
$wp_query->is_page = true;
$wp_query->is_singular = true;

ob_start();
// Let's call the shortcode directly to see its exact HTML
echo do_shortcode('[woocommerce_my_account]');
$out = ob_get_clean();
echo "SHORTCODE OUTPUT:\n";
echo substr($out, 0, 1000) . "\n...\n";
echo substr($out, -500) . "\n";
