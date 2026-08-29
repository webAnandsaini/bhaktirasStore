<?php
/**
 * The template for displaying the master footer - Pixel Perfect Figma 1:1
 *
 * @package Dharmgyan
 */

$site_name = get_bloginfo('name') ?: 'Bhaktirastore';
?>

<footer id="colophon" class="site-footer bg-[#FAFAFA] border-t border-[#E5E5E5] text-[#444444] pt-14 pb-8" role="contentinfo">
    <div class="max-w-[1580px] mx-auto px-4">
        
        <!-- Main 4-Column Footer Grid matching Figma (ID: 1:3123) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12 pb-12 border-b border-[#E5E5E5]">
            
            <!-- Col 1: Brand & Contact (lg:col-span-4) -->
            <div class="lg:col-span-4 flex flex-col justify-between">
                <div>
                    <!-- Logo -->
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block font-serif text-3xl md:text-[36px] text-[#111111] font-normal leading-none mb-5 focus:outline-none">
                        <?php echo esc_html($site_name); ?>
                    </a>
                    
                    <!-- Tagline matching Figma -->
                    <p class="font-body text-[#444444] text-[15px] leading-relaxed max-w-sm mb-6">
                        <?php esc_html_e('Our decorations are the difference you seek. We bring beauty to your home and light up your world.', 'dharmgyan'); ?>
                    </p>
                </div>

                <!-- Contact Info matching Figma -->
                <div class="pt-2">
                    <h4 class="font-body text-base md:text-[18px] font-medium text-[#111111] mb-2">
                        <?php esc_html_e('Contact us on', 'dharmgyan'); ?>
                    </h4>
                    <p class="font-body text-[15px] text-[#444444] mb-1">
                        <a href="tel:+919999999999" class="hover:text-[#CC5600] transition-colors">(+91) 9999999999</a> / <a href="tel:+919999999999" class="hover:text-[#CC5600] transition-colors">(+91) 9999999999</a>
                    </p>
                    <p class="font-body text-xs md:text-sm text-[#717171]">
                        <?php esc_html_e('Monday - Friday: 09:00 AM - 06:00 PM', 'dharmgyan'); ?>
                    </p>
                </div>
            </div>

            <!-- Col 2: About Us (lg:col-span-2) -->
            <div class="lg:col-span-2">
                <h4 class="font-body text-base md:text-[18px] font-medium text-[#111111] mb-5">
                    <?php esc_html_e('About Us', 'dharmgyan'); ?>
                </h4>
                <ul class="space-y-3 font-body text-[15px]">
                    <li><a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('About Us', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/shipping-policy/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Shipping Policy', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms-of-service/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Terms of Service', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/refund-policy/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Refund Policy', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Privacy Policy', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact-us/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Contact Us', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/blog/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Spiritual Blog', 'dharmgyan'); ?></a></li>
                </ul>
            </div>

            <!-- Col 3: Divine Collections (lg:col-span-3) -->
            <div class="lg:col-span-3">
                <h4 class="font-body text-base md:text-[18px] font-medium text-[#111111] mb-5">
                    <?php esc_html_e('Divine Collections', 'dharmgyan'); ?>
                </h4>
                <ul class="space-y-3 font-body text-[15px]">
                    <li><a href="<?php echo esc_url(home_url('/product-category/collections/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Hindu Gods Artwork & Idols', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/aarti-diya/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Puja Essentials & Akhand Diyas', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/home-decor/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Spiritual Home Decor', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/wall-art/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Sacred Acrylic & Canvas Wall Art', 'dharmgyan'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/shop/')); ?>" class="hover:text-[#CC5600] transition-colors"><?php esc_html_e('Festive Devotional Gifting', 'dharmgyan'); ?></a></li>
                </ul>
            </div>

            <!-- Col 4: Customer Care & Newsletter (lg:col-span-3) -->
            <div class="lg:col-span-3">
                <h4 class="font-body text-base md:text-[18px] font-medium text-[#111111] mb-5">
                    <?php esc_html_e('Customer Care', 'dharmgyan'); ?>
                </h4>
                <p class="font-body text-sm text-[#717171] mb-4">
                    <?php esc_html_e('Subscribe to receive sacred auspicious updates, festive offers, and spiritual wisdom directly in your inbox.', 'dharmgyan'); ?>
                </p>
                
                <div class="footer-newsletter-cf7 mb-4">
                    <?php 
                    if (shortcode_exists('contact-form-7')) {
                        echo do_shortcode('[contact-form-7 id="564" title="Footer Newsletter Form"]');
                    } else {
                        ?>
                        <form class="flex items-center gap-2" onsubmit="event.preventDefault();">
                            <input type="email" placeholder="<?php esc_attr_e('Enter your email', 'dharmgyan'); ?>" class="w-full bg-white border border-[#D4D4D4] rounded-[4px] px-3.5 py-2 text-sm text-[#242424] focus:outline-none focus:border-[#CC5600] transition-colors" />
                            <button type="submit" class="bg-[#CC5600] hover:bg-[#B34B00] text-white px-4 py-2 rounded-[4px] text-sm font-medium transition-colors flex-shrink-0">
                                <?php esc_html_e('Join', 'dharmgyan'); ?>
                            </button>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>

        </div>

        <!-- Bottom Row matching Figma (ID: 1:3206) -->
        <div class="pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs md:text-sm text-[#717171] font-body">
            
            <div>
                <p><?php echo esc_html(sprintf(__('© %s %s. All rights reserved.', 'dharmgyan'), date('Y'), $site_name)); ?></p>
            </div>

            <!-- Social Links ('Connect with us') -->
            <div class="flex items-center gap-4">
                <span class="font-medium text-[#111111]"><?php esc_html_e('Connect with us:', 'dharmgyan'); ?></span>
                <div class="flex items-center gap-3 text-[#444444]">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#CC5600] transition-colors" aria-label="Facebook">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.6 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#CC5600] transition-colors" aria-label="Instagram">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    </a>
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#CC5600] transition-colors" aria-label="YouTube">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="https://pinterest.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#CC5600] transition-colors" aria-label="Pinterest">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/></svg>
                    </a>
                </div>
            </div>

        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
