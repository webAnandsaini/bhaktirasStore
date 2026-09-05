<?php
/**
 * Template Name: Contact Us
 * 
 * Pixel-Perfect Contact Us page matching Figma (367:873).
 * Fully dynamic via ACF with zero hardcoded default values.
 *
 * @package Dharmgyan
 */

defined('ABSPATH') || exit;

get_header();

// Fetch ACF fields (strictly dynamic - render ONLY if populated)
$support_title          = get_field('support_card_title');
$support_phone          = get_field('support_phone_number');
$email_title            = get_field('email_card_title');
$email_addr             = get_field('email_address');
$form_heading           = get_field('contact_form_heading');
$form_shortcode         = get_field('contact_form_shortcode');
$show_discount_sale     = get_field('show_discount_sale');
$show_trending_products = get_field('show_trending_products');
$show_testimonials      = get_field('show_testimonials');
$show_trust_badges      = get_field('show_trust_badges');

$has_support_card = !empty($support_title) || !empty($support_phone);
$has_email_card   = !empty($email_title) || !empty($email_addr);
$has_info_cards   = $has_support_card || $has_email_card;
?>

<main id="primary" class="site-main contact-us-page bg-white min-h-screen">

    <!-- Breadcrumb Bar matching Figma Section -->
    <div class="page-breadcrumb-bar w-full bg-[#FFF9F4] border-b border-[#F5EBE1] py-4 md:py-0 md:h-[68px] flex items-center justify-center mb-8 md:mb-12">
        <div class="max-w-[1580px] mx-auto px-4 flex items-center justify-center text-center flex-wrap gap-2 text-[15px] md:text-[16px] text-[#444444] font-body leading-tight">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#444444] hover:text-[#CC5600] transition-colors"><?php esc_html_e('Home', 'dharmgyan'); ?></a>
            <span class="text-[#444444] select-none mx-0.5">›</span>
            <span class="text-[#444444]"><?php echo esc_html(get_the_title()); ?></span>
        </div>
    </div>

    <div class="max-w-[1000px] mx-auto px-4 pb-16 md:pb-24">

        <?php if ($has_info_cards): ?>
            <!-- Top Support & Email Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                
                <?php if ($has_support_card): ?>
                    <div class="bg-[#FFF9F4] border border-[#F5EBE1] rounded-2xl p-6 flex items-center gap-5 transition-shadow hover:shadow-sm">
                        <div class="w-14 h-14 rounded-full bg-white border border-[#EADBC8] flex items-center justify-center shrink-0 text-[#CC5600]">
                            <!-- Customer Support Headset SVG -->
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                                <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
                            </svg>
                        </div>
                        <div>
                            <?php if (!empty($support_title)): ?>
                                <p class="text-sm font-semibold uppercase tracking-wider text-[#717171] mb-1 font-body">
                                    <?php echo esc_html($support_title); ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($support_phone)): ?>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9\+]/', '', $support_phone)); ?>" class="text-lg md:text-xl font-semibold text-[#111111] hover:text-[#CC5600] transition-colors font-body focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm" aria-label="<?php echo esc_attr(sprintf(__('Call customer support at %s', 'dharmgyan'), $support_phone)); ?>">
                                    <?php echo esc_html($support_phone); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($has_email_card): ?>
                    <div class="bg-[#FFF9F4] border border-[#F5EBE1] rounded-2xl p-6 flex items-center gap-5 transition-shadow hover:shadow-sm">
                        <div class="w-14 h-14 rounded-full bg-white border border-[#EADBC8] flex items-center justify-center shrink-0 text-[#CC5600]">
                            <!-- Email Envelope SVG -->
                            <svg class="w-7 h-7" aria-hidden="true" focusable="false" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div>
                            <?php if (!empty($email_title)): ?>
                                <p class="text-sm font-semibold uppercase tracking-wider text-[#717171] mb-1 font-body">
                                    <?php echo esc_html($email_title); ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($email_addr)): ?>
                                <a href="mailto:<?php echo esc_attr($email_addr); ?>" class="text-lg md:text-xl font-semibold text-[#111111] hover:text-[#CC5600] transition-colors font-body focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] rounded-sm" aria-label="<?php echo esc_attr(sprintf(__('Send email to %s', 'dharmgyan'), $email_addr)); ?>">
                                    <?php echo esc_html($email_addr); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <!-- Contact Us Main Form Section -->
        <section class="contact-form-section" aria-labelledby="contact-heading">
            
            <h1 id="contact-heading" class="text-3xl md:text-4xl lg:text-5xl font-serif text-center text-[#111111] font-medium mb-10">
                <?php echo esc_html(!empty($form_heading) ? $form_heading : get_the_title()); ?>
            </h1>

            <?php if (isset($_GET['contact_status']) && $_GET['contact_status'] === 'success'): ?>
                <div class="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3 shadow-xs" role="alert">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span><?php esc_html_e('Thank you! Your message has been sent successfully. We will get back to you shortly.', 'dharmgyan'); ?></span>
                </div>
            <?php elseif (isset($_GET['contact_status']) && $_GET['contact_status'] === 'error'): ?>
                <div class="mb-8 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-medium flex items-center gap-3 shadow-xs" role="alert">
                    <svg class="w-5 h-5 text-red-600 shrink-0" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span><?php esc_html_e('Please fill in all required fields and try again.', 'dharmgyan'); ?></span>
                </div>
            <?php endif; ?>

            <div class="contact-form-box bg-white">
                <?php if (!empty($form_shortcode)): ?>
                    <div class="cf7-custom-wrapper">
                        <?php echo do_shortcode($form_shortcode); ?>
                    </div>
                <?php else: ?>
                    <!-- Pixel-Perfect Figma Form Layout -->
                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="space-y-6" role="form" aria-label="<?php esc_attr_e('Contact Us Form', 'dharmgyan'); ?>">
                        <input type="hidden" name="action" value="dharmgyan_contact_form">
                        <?php wp_nonce_field('dharmgyan_contact_nonce', 'contact_nonce'); ?>

                        <!-- Row 1: Name and Phone Number -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="contact-name" class="block text-sm font-medium text-[#222222] mb-2 font-body">
                                    <?php esc_html_e('Name', 'dharmgyan'); ?> <span class="text-[#CC5600]" aria-hidden="true">*</span>
                                </label>
                                <input type="text" id="contact-name" name="contact_name" required aria-required="true" autocomplete="name" placeholder="<?php esc_attr_e('Your Name', 'dharmgyan'); ?>" class="w-full px-4 py-3.5 rounded-lg border border-[#D5D5D5] focus:border-[#CC5600] focus:ring-1 focus:ring-[#CC5600] outline-none text-sm text-[#333333] transition-colors">
                            </div>
                            <div>
                                <label for="contact-phone" class="block text-sm font-medium text-[#222222] mb-2 font-body">
                                    <?php esc_html_e('Phone Number', 'dharmgyan'); ?>
                                </label>
                                <input type="tel" id="contact-phone" name="contact_phone" autocomplete="tel" placeholder="<?php esc_attr_e('Your Phone Number', 'dharmgyan'); ?>" class="w-full px-4 py-3.5 rounded-lg border border-[#D5D5D5] focus:border-[#CC5600] focus:ring-1 focus:ring-[#CC5600] outline-none text-sm text-[#333333] transition-colors">
                            </div>
                        </div>

                        <!-- Row 2: Email -->
                        <div>
                            <label for="contact-email" class="block text-sm font-medium text-[#222222] mb-2 font-body">
                                <?php esc_html_e('Email', 'dharmgyan'); ?> <span class="text-[#CC5600]" aria-hidden="true">*</span>
                            </label>
                            <input type="email" id="contact-email" name="contact_email" required aria-required="true" autocomplete="email" placeholder="<?php esc_attr_e('Your Email', 'dharmgyan'); ?>" class="w-full px-4 py-3.5 rounded-lg border border-[#D5D5D5] focus:border-[#CC5600] focus:ring-1 focus:ring-[#CC5600] outline-none text-sm text-[#333333] transition-colors">
                        </div>

                        <!-- Row 3: Message -->
                        <div>
                            <label for="contact-message" class="block text-sm font-medium text-[#222222] mb-2 font-body">
                                <?php esc_html_e('Message', 'dharmgyan'); ?> <span class="text-[#CC5600]" aria-hidden="true">*</span>
                            </label>
                            <textarea id="contact-message" name="contact_message" rows="6" required aria-required="true" placeholder="<?php esc_attr_e('Your message here', 'dharmgyan'); ?>" class="w-full px-4 py-3.5 rounded-lg border border-[#D5D5D5] focus:border-[#CC5600] focus:ring-1 focus:ring-[#CC5600] outline-none text-sm text-[#333333] transition-colors resize-y"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="w-full py-4 px-6 bg-[#CC5600] hover:bg-[#B34B00] text-white font-medium text-base tracking-wider uppercase rounded-lg shadow transition duration-200 cursor-pointer text-center focus:outline-none focus-visible:ring-2 focus-visible:ring-[#CC5600] focus-visible:ring-offset-2">
                                <?php esc_html_e('SEND MESSAGE', 'dharmgyan'); ?>
                            </button>
                        </div>

                    </form>
                <?php endif; ?>
            </div>

        </section>

    </div>

    <!-- Conditional Pre-Footer Sections (Only render if enabled via ACF) -->
    <?php if ($show_discount_sale): ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/discount-sale'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_trending_products): ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/trending-products'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_testimonials): ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/testimonials'); ?>
        </div>
    <?php endif; ?>

    <?php if ($show_trust_badges): ?>
        <div class="border-t border-[#F0EAE4]">
            <?php get_template_part('template-parts/home/trust-badges'); ?>
        </div>
    <?php endif; ?>

</main>

<?php
get_footer();
