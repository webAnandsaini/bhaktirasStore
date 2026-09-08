<?php
/**
 * Seed Blog Page & Figma Posts with ACF Pro Fields & Image Attachments
 */

defined('ABSPATH') || exit;

echo "Seeding Blog content...\n";

// 1. Create or Find 'Our Blogs' Page
$blog_page = get_page_by_path('blog');
if (!$blog_page) {
    $blog_page_id = wp_insert_post(array(
        'post_title'     => 'Our Blogs',
        'post_name'      => 'blog',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'comment_status' => 'closed',
    ));
    echo "Created 'Our Blogs' page with ID: $blog_page_id\n";
} else {
    $blog_page_id = $blog_page->ID;
    echo "Found existing 'Our Blogs' page with ID: $blog_page_id\n";
}

// Assign template
update_post_meta($blog_page_id, '_wp_page_template', 'page-blog.php');
update_option('page_for_posts', $blog_page_id);

// Set ACF fields for blog page
if (function_exists('update_field')) {
    update_field('blog_header_title', 'Our Blogs', $blog_page_id);
    update_field('blog_posts_per_page', 10, $blog_page_id);
    update_field('show_discount_sale', 1, $blog_page_id);
    update_field('show_trending_products', 1, $blog_page_id);
    update_field('show_testimonials', 1, $blog_page_id);
    update_field('show_trust_badges', 1, $blog_page_id);
}

// 2. Helper to import an image into media library if not already imported
function dharmgyan_import_media_if_needed($file_path, $title) {
    if (!file_exists($file_path)) {
        return 0;
    }
    
    // Check if attachment with this filename already exists
    $filename = basename($file_path);
    global $wpdb;
    $attachment_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND guid LIKE %s LIMIT 1",
        '%' . $wpdb->esc_like($filename) . '%'
    ));

    if ($attachment_id) {
        return (int) $attachment_id;
    }

    $upload_dir = wp_upload_dir();
    $dest_file  = $upload_dir['path'] . '/' . $filename;
    copy($file_path, $dest_file);

    $wp_filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => sanitize_text_field($title),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $dest_file);
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $dest_file);
    wp_update_attachment_metadata($attach_id, $attach_data);

    return (int) $attach_id;
}

$theme_dir = get_template_directory();
$img_card1 = dharmgyan_import_media_if_needed($theme_dir . '/assets/images/blog/blog_card_1.png', 'Radha Krishna Wall Art');
$img_card2 = dharmgyan_import_media_if_needed($theme_dir . '/assets/images/blog/blog_card_2.png', 'Sacred Devotion Art');
$img_hero  = dharmgyan_import_media_if_needed($theme_dir . '/assets/images/blog/blog_hero.png', 'Divine Forest Devotion');
$img_cta   = dharmgyan_import_media_if_needed($theme_dir . '/assets/images/blog/blog_cta_banner.png', 'Devotional Highlight Banner');

echo "Media IDs: Card1=$img_card1, Card2=$img_card2, Hero=$img_hero, CTA=$img_cta\n";

// 3. Categories & Tags creation
$categories_data = array(
    'Products Category' => 'Sacred art and puja essentials',
    'Vastu Shastra'     => 'Vastu compliant decor and idols',
    'Pooja Essentials'  => 'Pure brass diyas, samagri and dhoop',
    'Spiritual Decor'   => 'Devotional wall art and mandir decor',
    'Festive Traditions'=> 'Diwali, Janmashtami and sacred rituals',
    'Sacred Idols'      => 'Ashtadhatu, brass and marble idols'
);

$cat_ids = array();
foreach ($categories_data as $cat_name => $cat_desc) {
    $term = term_exists($cat_name, 'category');
    if (!$term) {
        $term = wp_insert_term($cat_name, 'category', array('description' => $cat_desc));
    }
    if (!is_wp_error($term)) {
        $cat_ids[$cat_name] = is_array($term) ? $term['term_id'] : $term;
    }
}

$tags_data = array('Vastu', 'Wall Art', 'Puja Samagri', 'Ganesh Idol', 'Brass Diya', 'Spiritual Energy', 'Home Decor', 'Bhakti');
foreach ($tags_data as $tag_name) {
    if (!term_exists($tag_name, 'post_tag')) {
        wp_insert_term($tag_name, 'post_tag');
    }
}

// 4. Sample Posts matching Figma
$posts_to_seed = array(
    array(
        'title'    => 'Radha Krishna Wall Art According To Vastu: Sacred Energy & Placement Guide',
        'slug'     => 'radha-krishna-wall-art-according-to-vastu',
        'category' => 'Products Category',
        'tags'     => array('Vastu', 'Wall Art', 'Bhakti'),
        'image'    => $img_card1,
        'excerpt'  => 'Discover the sacred energy and ideal directions to place Radha Krishna wall art in your home according to ancient Vastu Shastra principles.',
        'content'  => '
<p>Certainly, I can provide some general details about the sacred traditions of devotional home decor. Placing Radha Krishna wall art in your living room or prayer area radiates harmony, unconditional love, and spiritual serenity throughout your home.</p>

<p>According to ancient Vastu Shastra, placing the divine couple’s portrait on the Northeast (Ishanya) wall attracts auspicious cosmic vibrations, enhances peaceful interpersonal relationships, and cleanses the domestic atmosphere of negative energy.</p>

<blockquote>"Wherever the divine presence of Radha and Krishna is lovingly remembered, auspiciousness, peace, and eternal joy reside naturally."</blockquote>

<p>Safety and respect on an altar or sacred wall are paramount. Ensure the wall art is kept at eye level, well-lit with warm illumination, and never positioned directly opposing washroom doors or under heavy structural beams.</p>

<p>Each type of devotional art has unique spiritual considerations and craftsmanship standards. From hand-embossed gold foil finishes to archival museum-grade acrylic canvases, investing in authentic devotional art enriches your household sanctuary for generations.</p>
'
    ),
    array(
        'title'    => 'Result of a challenge I in as a guest on The Futuristic Sacred Design',
        'slug'     => 'result-of-a-challenge-i-in-as-a-guest-on-the-futuristic',
        'category' => 'Spiritual Decor',
        'tags'     => array('Spiritual Energy', 'Puja Samagri'),
        'image'    => $img_card2,
        'excerpt'  => 'Exploring how contemporary minimalist architecture blends harmoniously with timeless Vedic sanctum design aesthetics.',
        'content'  => '
<p>Blending contemporary architectural aesthetics with sacred Indian spiritual motifs offers a revitalizing approach to modern home temples and meditation spaces.</p>

<p>Implementing proper lighting fixtures, choosing acoustic wood paneling, and positioning handcrafted brass diyas creates an inspiring environment for daily morning mantra recitations and mindfulness practices.</p>

<p>Residential sanctuaries focus on fostering an intimate communion with the divine, while larger community mandirs involve broader congregational acoustics and elaborate ritual spaces.</p>
'
    ),
    array(
        'title'    => 'The Divine Significance of Handcrafted Brass Idols and Diyas in Daily Puja',
        'slug'     => 'divine-significance-brass-idols-diyas-daily-puja',
        'category' => 'Pooja Essentials',
        'tags'     => array('Brass Diya', 'Ganesh Idol', 'Bhakti'),
        'image'    => $img_hero,
        'excerpt'  => 'Why brass remains the most sacred alloy for puja utensils and deities, and how daily lamp lighting purifies household prana.',
        'content'  => '
<p>In Vedic traditions, brass (Pital) holds an esteemed position due to its unique ability to attract and sustain positive spiritual vibrations (sattva guna) during archana and aarti rituals.</p>

<p>Lighting a pure ghee or sesame oil diya each dawn and dusk is believed to dispel tamasic lethargy, stimulate clarity of intellect, and invite the blessings of Goddess Lakshmi into the abode.</p>

<blockquote>"Deepajyothi parabrahma deepa sarvathamopahaara, deepena saadhyathe sarvam sandhyaa deepa namosthuthe."</blockquote>

<p>Accurately maintaining and caring for brass deities involves natural cleaning using pitambari, tamarind, or lemon with salt, maintaining their radiant golden luster without harsh industrial chemicals.</p>
'
    ),
    array(
        'title'    => 'How Holy Rudraksha Beads Transform Mind, Peace and Emotional Prosperity',
        'slug'     => 'how-holy-rudraksha-beads-transform-mind-peace',
        'category' => 'Festive Traditions',
        'tags'     => array('Spiritual Energy', 'Home Decor'),
        'image'    => $img_card1,
        'excerpt'  => 'Understanding the electro-magnetic healing qualities of authentic Himalayan Rudraksha beads for modern seekers.',
        'content'  => '
<p>Revered for centuries as the sacred tears of Lord Shiva, natural Rudraksha beads have demonstrated measurable bio-electric properties that stabilize nervous tension, normalize blood circulation, and deepen meditative absorption.</p>

<p>Wearing a consecrated Panchamukhi (5-faced) Rudraksha mala or keeping it in your meditation altar provides a protective shield of pure consciousness against fatigue and stressful daily environments.</p>
'
    ),
    array(
        'title'    => 'Sacred Symbols and Murti Sthapana Rituals for Blessing New Homes',
        'slug'     => 'sacred-symbols-and-murti-sthapana-rituals-new-homes',
        'category' => 'Sacred Idols',
        'tags'     => array('Vastu', 'Sacred Idols'),
        'image'    => $img_card2,
        'excerpt'  => 'Step-by-step guidance for auspicious Griha Pravesh puja, threshold protection, and installing deities with Vedic devotion.',
        'content'  => '
<p>Entering a newly constructed residence represents a monumental spiritual milestone. Performing Navagraha shanti and Murti Sthapana aligns the dwelling with universal cosmic order.</p>

<p>Inscribing the sacred Om, Swastika, and Shubh-Labh at the main entryway prevents adverse energetic intrusions while welcoming prosperity, health, and spiritual evolution.</p>
'
    ),
    array(
        'title'    => 'The Power of Evening Aarti and Natural Dhoop in Vedic Philosophy',
        'slug'     => 'power-of-evening-aarti-natural-dhoop-vedic-philosophy',
        'category' => 'Pooja Essentials',
        'tags'     => array('Puja Samagri', 'Brass Diya', 'Bhakti'),
        'image'    => $img_hero,
        'excerpt'  => 'How the gentle resonance of bells and fragrant herbal resins clear atmospheric toxins and uplift family well-being.',
        'content'  => '
<p>The twilight transition known as Sandhyakaal carries profound energetic potency. Ringing the puja bell during aarti synchronizes the left and right hemispheres of the brain through pure acoustic resonance.</p>

<p>Burning organic cow dung sambrani cups, guggul, and camphor purifies the air of microscopic pathogens, filling the home with a fragrant aura of temple-like reverence.</p>
'
    )
);

foreach ($posts_to_seed as $pdata) {
    $existing = get_page_by_path($pdata['slug'], OBJECT, 'post');
    $post_args = array(
        'post_title'    => $pdata['title'],
        'post_name'     => $pdata['slug'],
        'post_content'  => trim($pdata['content']),
        'post_excerpt'  => $pdata['excerpt'],
        'post_status'   => 'publish',
        'post_type'     => 'post',
        'post_author'   => 1,
    );

    if ($existing) {
        $post_args['ID'] = $existing->ID;
        $pid = wp_update_post($post_args);
        echo "Updated post: {$pdata['title']} (ID: $pid)\n";
    } else {
        $pid = wp_insert_post($post_args);
        echo "Created post: {$pdata['title']} (ID: $pid)\n";
    }

    // Set Category
    if (!empty($cat_ids[$pdata['category']])) {
        wp_set_post_categories($pid, array($cat_ids[$pdata['category']]));
    }

    // Set Tags
    wp_set_post_tags($pid, $pdata['tags'], false);

    // Set Featured Thumbnail
    if (!empty($pdata['image'])) {
        set_post_thumbnail($pid, $pdata['image']);
    }

    // Set ACF Pro Custom Fields for the single post!
    if (function_exists('update_field')) {
        update_field('post_cta_image', $img_cta ?: $pdata['image'], $pid);
        update_field('post_cta_button_text', 'Buy it now', $pid);
        update_field('post_cta_button_url', '/shop/', $pid);
        update_field('show_discount_sale', 1, $pid);
        update_field('show_trending_products', 1, $pid);
        update_field('show_testimonials', 1, $pid);
        update_field('show_trust_badges', 1, $pid);
    }
}

echo "Seeding completed successfully!\n";
