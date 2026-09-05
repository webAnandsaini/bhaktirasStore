<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>


</head>

<body <?php body_class(); ?>>
    <?php
    if (function_exists('wp_body_open')) {
        wp_body_open();
    }
    ?>
    <!-- Skip to Content link for Keyboard and Screen Reader Accessibility (WCAG 2.4.1) -->
    <a class="skip-link sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[9999] focus:px-5 focus:py-2.5 focus:bg-[#CC5600] focus:text-white focus:font-medium focus:rounded-[4px] focus:shadow-xl focus:outline-none focus:ring-2 focus:ring-[#CC5600] focus:ring-offset-2" href="#primary">
        <?php esc_html_e('Skip to main content', 'dharmgyan'); ?>
    </a>

    <?php get_template_part('template-parts/header/site-header'); ?>
