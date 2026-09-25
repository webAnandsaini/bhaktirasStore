<?php
/**
 * Homepage 'Join Our Newsletter Now' Banner Template Part
 * Spiritual Krishna Flute & Diya Theme with Golden Accents
 * Sourced dynamically from ACF Site Settings / Homepage fields.
 * 
 * @package Dharmgyan
 */

$title     = dharmgyan_get_field('newsletter_title');
if (empty($title)) {
    $title = __('Join Our Newsletter Now', 'dharmgyan');
}

$subtitle  = dharmgyan_get_field('newsletter_description') ?: dharmgyan_get_field('newsletter_subtitle');
if (empty($subtitle)) {
    $subtitle = __('Be the first to know about new arrivals, special offers and spiritual insights.', 'dharmgyan');
}

$bg_image  = dharmgyan_get_field('newsletter_bg_image');

$bg_url = '';
if (!empty($bg_image)) {
    if (is_array($bg_image) && !empty($bg_image['url'])) {
        $bg_url = $bg_image['url'];
    } elseif (is_numeric($bg_image)) {
        $bg_url = wp_get_attachment_image_url($bg_image, 'full');
    } elseif (is_string($bg_image)) {
        $bg_url = $bg_image;
    }
}

if (empty($bg_url)) {
    $bg_url = get_theme_file_uri('/assets/images/banners/newsletter-bg-krishna.png');
}

// Format title so "Newsletter" is highlighted in gold (#E5B869)
$formatted_title = esc_html($title);
if (stripos($formatted_title, 'Newsletter') !== false) {
    $formatted_title = preg_replace('/(newsletter)/i', '<span class="text-[#E5B869] font-serif">$1</span>', $formatted_title);
}
?>

<section class="home-newsletter-banner-section w-full bg-white my-6 md:my-10" aria-label="<?php echo esc_attr($title ?: __('Newsletter Banner', 'dharmgyan')); ?>">
    <div class="max-w-[1444px] mx-auto px-4">
        
        <!-- Main Banner Container with Golden Ratio / Aspect Ratio (~3:1) -->
        <div class="newsletter-krishna-banner relative w-full min-h-[320px] md:h-[342px] rounded-[10px] md:rounded-[14px] overflow-hidden flex items-center justify-center text-center shadow-lg border border-[#EAE3DC]/50">
            
            <!-- Background Image -->
            <img 
                src="<?php echo esc_url($bg_url); ?>" 
                alt="<?php esc_attr_e('Lord Krishna Flute and Diya Spiritual Banner', 'dharmgyan'); ?>" 
                class="absolute inset-0 w-full h-full object-cover object-center transform scale-[1.01]" 
                loading="lazy"
            />

            <!-- Soft Center Vignette Overlay (Leaves sides bright & sacred, dims center for contrast) -->
            <div class="absolute inset-0 bg-black/20 pointer-events-none"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/15 via-black/45 to-black/15 pointer-events-none"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(0,0,0,0.5)_0%,_rgba(0,0,0,0.2)_65%,_transparent_100%)] pointer-events-none"></div>

            <!-- Foreground Content -->
            <div class="relative z-10 w-full max-w-2xl mx-auto px-4 py-8 flex flex-col items-center justify-center">
                
                <!-- Heading -->
                <h2 class="font-serif text-2xl sm:text-3xl md:text-[34px] lg:text-[38px] text-white font-normal leading-tight mb-2.5 tracking-wide drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                    <?php echo wp_kses($formatted_title, array('span' => array('class' => array()))); ?>
                </h2>

                <!-- Subtitle -->
                <p class="font-body text-xs sm:text-sm md:text-[15px] text-white/95 font-light mb-6 max-w-lg mx-auto leading-relaxed drop-shadow-[0_1px_3px_rgba(0,0,0,0.9)]">
                    <?php echo esc_html($subtitle); ?>
                </p>

                <!-- Newsletter Form (Contact Form 7 'Newsletter') -->
                <div class="newsletter-banner-form home-newsletter-cf7 w-full max-w-lg mx-auto mb-6">
                    <?php
                    $newsletter_shortcode = dharmgyan_get_field('newsletter_shortcode') ?: dharmgyan_get_field('footer_newsletter_shortcode') ?: '[contact-form-7 id="564" title="Newsletter"]';
                    $has_cf7 = !empty($newsletter_shortcode) && (strpos($newsletter_shortcode, '[') !== false) && shortcode_exists('contact-form-7');
                    
                    if ($has_cf7) {
                        echo do_shortcode($newsletter_shortcode);
                    } else {
                    ?>
                        <form class="newsletter-ajax-form flex flex-col sm:flex-row items-center justify-center gap-2.5 w-full" onsubmit="event.preventDefault(); this.querySelector('.newsletter-success-msg').classList.remove('hidden'); this.querySelector('.newsletter-input-group').classList.add('hidden');">
                            
                            <div class="newsletter-input-group flex flex-col sm:flex-row items-center gap-2.5 w-full">
                                <!-- Input with Email Icon -->
                                <div class="relative w-full sm:flex-1">
                                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#E5B869] pointer-events-none" aria-hidden="true">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                        </svg>
                                    </span>
                                    <input 
                                        type="email" 
                                        name="newsletter_email"
                                        placeholder="<?php esc_attr_e('Your email address', 'dharmgyan'); ?>" 
                                        class="w-full h-[44px] bg-black/45 backdrop-blur-md border border-white/35 text-white placeholder-white/70 rounded-[5px] pl-10 pr-4 text-sm focus:outline-none focus:border-[#E5B869] focus:bg-black/60 transition-all font-body shadow-inner" 
                                        required
                                    />
                                </div>

                                <!-- Sign Up Button in Gold -->
                                <button 
                                    type="submit" 
                                    class="w-full sm:w-auto h-[44px] bg-[#E5B869] hover:bg-[#D4A758] text-[#1E1E1E] font-bold text-xs sm:text-[13px] px-7 rounded-[5px] uppercase tracking-wider transition-all duration-200 flex-shrink-0 shadow-md hover:shadow-lg cursor-pointer font-body flex items-center justify-center"
                                >
                                    <?php esc_html_e('SIGN UP', 'dharmgyan'); ?>
                                </button>
                            </div>

                            <!-- Success Message -->
                            <div class="newsletter-success-msg hidden w-full py-2.5 px-4 bg-black/60 border border-[#E5B869] rounded-[5px] text-[#E5B869] text-sm font-medium">
                                <?php esc_html_e('✓ Thank you for subscribing! May you be blessed with peace and joy.', 'dharmgyan'); ?>
                            </div>

                        </form>
                    <?php } ?>
                </div>

                <!-- 3 Feature Badges underneath Form -->
                <div class="flex items-center justify-center gap-3.5 sm:gap-6 flex-wrap text-white drop-shadow-[0_1px_3px_rgba(0,0,0,0.9)]">
                    
                    <!-- Feature 1: Exclusive Offers -->
                    <div class="flex items-center gap-2">
                        <span class="text-[#E5B869] flex-shrink-0" aria-hidden="true">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m21 11-8-8H4a2 2 0 0 0-2 2v9l8 8a2 2 0 0 0 2.83 0l8.17-8.17a2 2 0 0 0 0-2.83z"></path>
                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                            </svg>
                        </span>
                        <div class="text-left text-[11px] sm:text-xs leading-tight">
                            <span class="block font-medium text-white/95"><?php esc_html_e('Exclusive', 'dharmgyan'); ?></span>
                            <span class="block font-medium text-white/95"><?php esc_html_e('Offers', 'dharmgyan'); ?></span>
                        </div>
                    </div>

                    <!-- Divider 1 -->
                    <span class="h-5 w-[1px] bg-white/40 hidden sm:inline-block" aria-hidden="true"></span>

                    <!-- Feature 2: New Arrivals -->
                    <div class="flex items-center gap-2">
                        <span class="text-[#E5B869] flex-shrink-0" aria-hidden="true">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                            </svg>
                        </span>
                        <div class="text-left text-[11px] sm:text-xs leading-tight">
                            <span class="block font-medium text-white/95"><?php esc_html_e('New', 'dharmgyan'); ?></span>
                            <span class="block font-medium text-white/95"><?php esc_html_e('Arrivals', 'dharmgyan'); ?></span>
                        </div>
                    </div>

                    <!-- Divider 2 -->
                    <span class="h-5 w-[1px] bg-white/40 hidden sm:inline-block" aria-hidden="true"></span>

                    <!-- Feature 3: Spiritual Updates -->
                    <div class="flex items-center gap-2">
                        <span class="text-[#E5B869] flex-shrink-0" aria-hidden="true">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3c-1.5 3-4 6.5-8 9 2.5 4 8 8 8 8s5.5-4 8-8c-4-2.5-6.5-6-8-9z"/>
                                <path d="M12 12c-2 2-3 5-3 8h6c0-3-1-6-3-8z"/>
                            </svg>
                        </span>
                        <div class="text-left text-[11px] sm:text-xs leading-tight">
                            <span class="block font-medium text-white/95"><?php esc_html_e('Spiritual', 'dharmgyan'); ?></span>
                            <span class="block font-medium text-white/95"><?php esc_html_e('Updates', 'dharmgyan'); ?></span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

