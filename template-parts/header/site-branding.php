<?php
/**
 * Site Branding / Logo Template Part - Pixel Perfect Figma
 * 
 * @package Dharmgyan
 */
?>
<div class="site-branding flex items-center flex-shrink-0">
    <?php if (has_custom_logo()): ?>
        <div class="site-logo">
            <?php the_custom_logo(); ?>
        </div>
    <?php else: ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-title-text font-serif text-[34px] md:text-[38px] font-normal tracking-wide text-[#000000] hover:text-[#CC5600] transition-colors leading-none">
            <?php bloginfo('name'); ?>
        </a>
    <?php endif; ?>
</div>
