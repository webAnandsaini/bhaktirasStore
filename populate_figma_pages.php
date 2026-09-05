<?php
/**
 * Helper script to populate initial Figma values into ACF fields for About Us and Contact Us.
 */
require_once '/var/www/html/wp-load.php';

if (!function_exists('update_field')) {
    die("ACF update_field not found\n");
}

// 1. Populate Contact Us (Page ID 603)
$contact_id = 603;
update_field('support_card_title', 'Customer Support', $contact_id);
update_field('support_phone_number', '+91-91919191919', $contact_id);
update_field('email_card_title', 'Email', $contact_id);
update_field('email_address', 'myvaikunth@gmail.com', $contact_id);
update_field('contact_form_heading', 'Contact Us', $contact_id);
update_field('show_discount_sale', 1, $contact_id);
update_field('show_trending_products', 1, $contact_id);
update_field('show_testimonials', 1, $contact_id);
update_field('show_trust_badges', 1, $contact_id);
echo "Contact Us ACF populated for page $contact_id\n";

// 2. Populate About Us (Page ID 602)
$about_id = 602;
update_field('story_subtitle', 'Who We Are', $about_id);
update_field('story_title', 'A Devotion Born in Vrindavan', $about_id);
$story_html = "<p>In 2009, Ramesh Sharma — a devotee and artist from Mathura — started दिव्य भक्ति with five artisans in a small Vrindavan workshop. His dream was simple: create divine products that carry the soul of India's sacred traditions right into the heart of every home.</p>
<p>Today, we are a family of 50+ artisans crafting idols, pooja thalis, brass diyas, rangoli art, and home decor — each piece infused with bhakti and offered with love to 10,000+ families across India.</p>
<p>We believe every home deserves a divine corner — a space of peace, prayer, and beauty. That is why every piece we create is not just a product, but a blessing.</p>";
update_field('story_content', $story_html, $about_id);
update_field('story_image', 618, $about_id); // Krishna hands & flute portrait
update_field('story_quote_badge', "\"हर मूर्ति में भगवान का वास है\"\n— Every idol is a divine abode.", $about_id);

update_field('craft_subtitle', 'The Craft', $about_id);
update_field('craft_title', 'Handcrafted by Devoted Artisans', $about_id);
$craft_html = "<p>Our artisans — drawn from generations of sculptors in Mathura, Jaipur, and Varanasi — pour years of skill and spiritual intention into every creation. From hand-painting diyas to carving intricate Ganesh idols, each process is guided by devotion, not machinery.</p>
<p>We ensure fair wages, safe workshops, and creative freedom for every artisan. When you buy from us, you support not just a product, but a living tradition.</p>";
update_field('craft_content', $craft_html, $about_id);
update_field('craft_gallery', array(618, 619, 620, 621), $about_id);

$stats = array(
    array('stat_number' => '500+', 'stat_label' => 'Happy Clients'),
    array('stat_number' => '500+', 'stat_label' => 'Happy Clients'),
    array('stat_number' => '500+', 'stat_label' => 'Happy Clients'),
    array('stat_number' => '500+', 'stat_label' => 'Happy Clients'),
);
update_field('craft_stats', $stats, $about_id);

$vm_text = "Our artisans — drawn from generations of sculptors in Mathura, Jaipur, and Varanasi — pour years of skill and spiritual intention into every creation. From hand-painting diyas to carving intricate Ganesh idols, each process is guided by devotion, not machinery.\n\nWe ensure fair wages, safe workshops, and creative freedom for every artisan. When you buy from us, you support not just a product, but a living tradition.";
update_field('vision_title', 'Our Vision', $about_id);
update_field('vision_description', $vm_text, $about_id);
update_field('mission_title', 'Our Mission', $about_id);
update_field('mission_description', $vm_text, $about_id);

update_field('show_discount_sale', 1, $about_id);
update_field('show_trending_products', 1, $about_id);
update_field('show_testimonials', 1, $about_id);
update_field('show_trust_badges', 1, $about_id);
echo "About Us ACF populated for page $about_id\n";

// 3. Wishlist Pre-Footer Toggles (Page ID 111)
$wishlist_id = 111;
update_field('show_discount_sale', 1, $wishlist_id);
update_field('show_trending_products', 1, $wishlist_id);
update_field('show_testimonials', 1, $wishlist_id);
update_field('show_trust_badges', 1, $wishlist_id);
echo "Wishlist ACF populated for page $wishlist_id\n";
