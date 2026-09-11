<?php
/**
 * The template for displaying the master footer - Dynamic & Accessible
 *
 * @package Dharmgyan
 */

$site_name = get_bloginfo('name') ?: 'Bhaktirastore';

// Dynamic Site Logo (ACF option or Theme Custom Logo)
$site_logo = dharmgyan_get_field('site_logo');
$custom_logo_id = get_theme_mod('custom_logo');

// Tagline / About Text (Col 1)
$footer_about = dharmgyan_get_field('footer_about');
if (empty($footer_about)) {
    $footer_about = __('Our decorations are the difference you seek. We bring beauty to your home and light up your world.', 'dharmgyan');
}

// Contact Title (Col 1)
$contact_title = dharmgyan_get_field('footer_contact_title');
if (empty($contact_title)) {
    $contact_title = __('Contact us on', 'dharmgyan');
}

// Contact Phone (Col 1)
$contact_phone = dharmgyan_get_field('contact_phone');
if (empty($contact_phone)) {
    $contact_phone = '(+91) 9999999999';
}
$phone_tel = preg_replace('/[^0-9+]/', '', $contact_phone);

// Contact Email (Col 1)
$contact_email = dharmgyan_get_field('contact_email');
if (empty($contact_email)) {
    $contact_email = 'info@bhaktirastore.ddev.site';
}

// Business Operating Hours (Col 1)
$business_hours = dharmgyan_get_field('business_hours');
if (empty($business_hours)) {
    $business_hours = __('Monday - Friday: 09:00 AM - 06:00 PM', 'dharmgyan');
}

// Social Media Links (Repeater) - Moved to Col 1 directly below Business Hours
$social_links = dharmgyan_get_field('social_links');
if (empty($social_links) || !is_array($social_links)) {
    $social_links = array(
        array('platform' => 'facebook',  'url' => 'https://facebook.com'),
        array('platform' => 'instagram', 'url' => 'https://instagram.com'),
        array('platform' => 'youtube',   'url' => 'https://youtube.com'),
        array('platform' => 'pinterest', 'url' => 'https://pinterest.com'),
    );
}

// Column 2: About Us Title & Menu
$col2_title = dharmgyan_get_field('footer_col2_title');
if (empty($col2_title)) {
    $col2_title = has_nav_menu('footer') ? (wp_get_nav_menu_name('footer') ?: __('About Us', 'dharmgyan')) : __('About Us', 'dharmgyan');
}

// Column 3: Divine Collections Title & Menu
$col3_title = dharmgyan_get_field('footer_col3_title');
if (empty($col3_title)) {
    $col3_title = has_nav_menu('footerlist') ? (wp_get_nav_menu_name('footerlist') ?: __('Divine Collections', 'dharmgyan')) : __('Divine Collections', 'dharmgyan');
}

// Column 4: Customer Care & Newsletter Title, Description, Shortcode
$col4_title = dharmgyan_get_field('footer_col4_title');
if (empty($col4_title)) {
    $col4_title = dharmgyan_get_field('newsletter_title') ?: __('Customer Care', 'dharmgyan');
}

$newsletter_desc = dharmgyan_get_field('newsletter_description');
if (empty($newsletter_desc)) {
    $newsletter_desc = __('Subscribe to receive sacred auspicious updates, festive offers, and spiritual wisdom directly in your inbox.', 'dharmgyan');
}

$newsletter_shortcode = dharmgyan_get_field('footer_newsletter_shortcode');
if (empty($newsletter_shortcode)) {
    $newsletter_shortcode = '[contact-form-7 id="564" title="Footer Newsletter Form"]';
}

// Copyright Text
$copyright_text = dharmgyan_get_field('footer_copyright');
if (empty($copyright_text)) {
    $copyright_text = sprintf(__('© %s %s. All rights reserved.', 'dharmgyan'), date('Y'), $site_name);
} else {
    $copyright_text = str_replace(
        array('{year}', '{site_name}'),
        array(date('Y'), $site_name),
        $copyright_text
    );
}

// Footer Bottom Right Text (Brand of Sankat Mochan)
$footer_bottom_right = dharmgyan_get_field('footer_bottom_right_text');
if (empty($footer_bottom_right)) {
    $footer_bottom_right = __('Brand of Sankat Mochan', 'dharmgyan');
}
?>

<footer id="colophon" class="site-footer bg-[#FAFAFA] border-t border-[#E5E5E5] text-[#444444] pt-14 pb-8" role="contentinfo">
    <div class="max-w-[1580px] mx-auto px-4">
        
        <!-- Main 4-Column Footer Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12 pb-12 border-b border-[#E5E5E5]">
            
            <!-- Col 1: Brand, Tagline, Contact & Social Media (lg:col-span-4) -->
            <div class="lg:col-span-4 flex flex-col justify-between">
                <div>
                    <!-- Logo -->
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-none mb-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm" aria-label="<?php echo esc_attr($site_name); ?>">
                        <?php 
                        if (!empty($site_logo) && is_array($site_logo) && !empty($site_logo['url'])) {
                            echo '<img src="' . esc_url($site_logo['url']) . '" alt="' . esc_attr($site_name) . '" class="max-h-12 w-auto object-contain" />';
                        } elseif (!empty($custom_logo_id)) {
                            echo wp_get_attachment_image($custom_logo_id, 'full', false, array('class' => 'max-h-12 w-auto object-contain', 'alt' => esc_attr($site_name)));
                        } else {
                            echo esc_html($site_name);
                        }
                        ?>
                    </a>
                    
                    <!-- Tagline -->
                    <p class="font-body text-[#444444] text-[15px] leading-relaxed max-w-sm mb-6">
                        <?php echo nl2br(esc_html($footer_about)); ?>
                    </p>
                </div>

                <!-- Contact Info -->
                <address class="pt-2 not-italic">
                    <h2 class="font-body text-base md:text-[18px] font-medium text-[#111111] mb-2">
                        <?php echo esc_html($contact_title); ?>
                    </h2>
                    <?php if (!empty($contact_phone)) : ?>
                    <p class="font-body text-[15px] text-[#444444] mb-1">
                        <a href="tel:<?php echo esc_attr($phone_tel); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm" aria-label="<?php echo esc_attr(sprintf(__('Call customer service at %s', 'dharmgyan'), $contact_phone)); ?>">
                            <?php echo esc_html($contact_phone); ?>
                        </a>
                    </p>
                    <?php endif; ?>
                    <?php if (!empty($contact_email)) : ?>
                    <p class="font-body text-[15px] text-[#444444] mb-1">
                        <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm" aria-label="<?php echo esc_attr(sprintf(__('Email customer service at %s', 'dharmgyan'), $contact_email)); ?>">
                            <?php echo esc_html($contact_email); ?>
                        </a>
                    </p>
                    <?php endif; ?>
                    <?php if (!empty($business_hours)) : ?>
                    <p class="font-body text-xs md:text-sm text-[#717171]">
                        <?php echo esc_html($business_hours); ?>
                    </p>
                    <?php endif; ?>

                    <!-- Social Media Links (Moved right below Business Hours) -->
                    <?php if (!empty($social_links)) : ?>
                    <div class="footer-social-links flex items-center gap-3 pt-4 text-[#444444]">
                        <?php 
                        foreach ($social_links as $item) :
                            $platform = strtolower(trim($item['platform'] ?? ''));
                            $url = trim($item['url'] ?? '');
                            if (empty($url)) continue;

                            $label = sprintf(__('Follow us on %s (opens in new tab)', 'dharmgyan'), ucfirst($platform));
                            $icon_svg = '';

                            switch ($platform) {
                                case 'facebook':
                                    $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.6 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>';
                                    break;
                                case 'instagram':
                                    $icon_svg = '<svg class="w-4 h-4" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>';
                                    break;
                                case 'twitter':
                                case 'x':
                                    $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';
                                    break;
                                case 'youtube':
                                    $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>';
                                    break;
                                case 'pinterest':
                                    $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>';
                                    break;
                                case 'linkedin':
                                    $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>';
                                    break;
                                case 'whatsapp':
                                    $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>';
                                    break;
                                default:
                                    $icon_svg = '<svg class="w-4 h-4 fill-current" aria-hidden="true" focusable="false" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>';
                                    break;
                            }
                        ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm" aria-label="<?php echo esc_attr($label); ?>">
                                <?php echo $icon_svg; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </address>
            </div>

            <!-- Col 2: About Us (lg:col-span-2) -->
            <div class="lg:col-span-2">
                <h2 class="font-body text-base md:text-[18px] font-medium text-[#111111] mb-5">
                    <?php echo esc_html($col2_title); ?>
                </h2>
                <?php 
                if (has_nav_menu('footer')) :
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-menu space-y-3 font-body text-[15px]',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ));
                else :
                ?>
                <ul class="footer-menu space-y-3 font-body text-[15px]">
                    <li><a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('About Us', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Shipping Policy', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms-of-service/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Terms of Service', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/refund-policy/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Refund Policy', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Privacy Policy', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Contact Us', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/blog/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Spiritual Blog', 'dharmgyan'); ?></a></li>
                </ul>
                <?php endif; ?>
            </div>

            <!-- Col 3: Divine Collections (lg:col-span-3) -->
            <div class="lg:col-span-3">
                <h2 class="font-body text-base md:text-[18px] font-medium text-[#111111] mb-5">
                    <?php echo esc_html($col3_title); ?>
                </h2>
                <?php 
                if (has_nav_menu('footerlist')) :
                    wp_nav_menu(array(
                        'theme_location' => 'footerlist',
                        'container'      => false,
                        'menu_class'     => 'footer-menu space-y-3 font-body text-[15px]',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ));
                else :
                ?>
                <ul class="footer-menu space-y-3 font-body text-[15px]">
                    <li><a href="<?php echo esc_url(home_url('/product-category/collections/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Hindu Gods Artwork & Idols', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/aarti-diya/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Puja Essentials & Akhand Diyas', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/home-decor/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Spiritual Home Decor', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/wall-art/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Sacred Acrylic & Canvas Wall Art', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop/')); ?>" class="hover:text-[#CC5600] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm"><?php esc_html_e('Festive Devotional Gifting', 'dharmgyan'); ?></a></li>
                </ul>
                <?php endif; ?>
            </div>

            <!-- Col 4: Customer Care & Newsletter (lg:col-span-3) -->
            <div class="lg:col-span-3">
                <h2 class="font-body text-base md:text-[18px] font-medium text-[#111111] mb-5">
                    <?php echo esc_html($col4_title); ?>
                </h2>
                <p class="font-body text-sm text-[#717171] mb-4">
                    <?php echo esc_html($newsletter_desc); ?>
                </p>
                
                <div class="footer-newsletter-cf7 mb-4">
                    <?php 
                    $has_cf7 = !empty($newsletter_shortcode) && (strpos($newsletter_shortcode, '[') !== false) && shortcode_exists('contact-form-7');
                    if ($has_cf7) {
                        echo do_shortcode($newsletter_shortcode);
                    } else {
                        ?>
                        <form class="flex items-center gap-2" role="form" aria-label="<?php esc_attr_e('Newsletter Signup', 'dharmgyan'); ?>" onsubmit="event.preventDefault();">
                            <label for="footer-newsletter-email" class="sr-only"><?php esc_html_e('Email Address', 'dharmgyan'); ?></label>
                            <input id="footer-newsletter-email" type="email" autocomplete="email" required placeholder="<?php esc_attr_e('Enter your email', 'dharmgyan'); ?>" class="w-full bg-white border border-[#D4D4D4] rounded-[4px] px-3.5 py-2 text-sm text-[#242424] focus:outline-none focus:border-[#CC5600] transition-colors" />
                            <button type="submit" class="bg-[#CC5600] hover:bg-[#B34B00] text-white px-4 py-2 rounded-[4px] text-sm font-medium transition-colors flex-shrink-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600]" aria-label="<?php esc_attr_e('Subscribe to newsletter', 'dharmgyan'); ?>">
                                <?php esc_html_e('Join', 'dharmgyan'); ?>
                            </button>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>

        <!-- Bottom Row (Clean Copyright & Brand Tagline) -->
        <div class="pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs md:text-sm text-[#717171] font-body">
            <div>
                <p><?php echo wp_kses_post($copyright_text); ?></p>
            </div>

            <?php if (!empty($footer_bottom_right)) : ?>
            <div class="text-[#717171] font-medium text-xs md:text-sm">
                <p><?php echo esc_html($footer_bottom_right); ?></p>
            </div>
            <?php endif; ?>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
