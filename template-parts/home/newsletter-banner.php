<?php
/**
 * Homepage 'Join Our Newsletter Now' Banner Template Part - Matching Figma 1:1
 * Sourced dynamically from ACF Homepage fields.
 * 
 * @package Dharmgyan
 */

$title     = dharmgyan_get_field('newsletter_title');
$subtitle  = dharmgyan_get_field('newsletter_subtitle');
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
    $bg_url = get_theme_file_uri('/assets/images/banners/newslettter-bg.jpg');
}
?>

<section class="home-newsletter-banner-section w-full bg-white my-6 md:my-10" aria-label="<?php echo esc_attr($title ?: __('Newsletter Banner', 'dharmgyan')); ?>">
    <div class="max-w-[1444px] mx-auto px-4">
        
        <!-- Main Banner Container matching Figma (1444x318px) -->
        <div class="relative w-full min-h-[290px] md:h-[318px] rounded-[6px] overflow-hidden flex items-center justify-center text-center shadow-md">
            
            <!-- Background Image -->
            <img 
                src="<?php echo esc_url($bg_url); ?>" 
                alt="<?php esc_attr_e('Spiritual Devotion Banner', 'dharmgyan'); ?>" 
                class="absolute inset-0 w-full h-full object-cover object-center" 
                loading="lazy"
            />

            <!-- Dark Overlay for Readability -->
            <div class="absolute inset-0 bg-black/45 backdrop-blur-[0.5px]"></div>

            <!-- Foreground Content -->
            <div class="relative z-10 w-full max-w-xl mx-auto px-4 py-8">
                
                <!-- Heading (Only rendered if exists in backend) -->
                <?php if ($title): ?>
                    <h2 class="font-serif text-2xl md:text-[36px] text-white font-normal leading-tight mb-2 tracking-wide">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <!-- Subtitle (Only rendered if exists in backend) -->
                <?php if ($subtitle): ?>
                    <p class="text-xs md:text-sm text-white/90 font-body mb-6 max-w-md mx-auto leading-relaxed">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <!-- Newsletter Form matching Figma -->
                <div class="newsletter-banner-form flex items-center justify-center gap-2 max-w-md mx-auto">
                    <form class="flex items-center justify-center gap-2 w-full" onsubmit="event.preventDefault();">
                        <input 
                            type="email" 
                            placeholder="<?php esc_attr_e('Your email address', 'dharmgyan'); ?>" 
                            class="w-full max-w-[290px] h-[42px] bg-black/40 border border-white/60 text-white placeholder-white/80 rounded-[4px] px-4 text-sm focus:outline-none focus:border-white focus:bg-black/60 transition-all font-body" 
                            required
                        />
                        <button 
                            type="submit" 
                            class="h-[42px] bg-white hover:bg-gray-100 text-[#111111] font-semibold text-xs md:text-[13px] px-6 rounded-[4px] uppercase tracking-wider transition-all duration-200 flex-shrink-0 shadow-md cursor-pointer font-body"
                        >
                            <?php esc_html_e('SIGN UP', 'dharmgyan'); ?>
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>
</section>
