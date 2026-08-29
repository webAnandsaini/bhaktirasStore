<?php
/**
 * The template for displaying 404 pages.
 *
 * @package Dharmgyan
 */

get_header();
?>

<main id="main" class="site-main container mx-auto px-4 py-12" role="main">
    <section class="error-404 not-found max-w-3xl mx-auto text-center">
        <h1 class="text-3xl font-bold mb-4"><?php esc_html_e('Page not found', 'dharmgyan'); ?></h1>
        <p class="mb-6">
            <?php esc_html_e('The page you requested could not be found. Try searching the site or return to the homepage.', 'dharmgyan'); ?>
        </p>

        <?php get_search_form(); ?>

        <p class="mt-6">
            <a class="inline-block underline" href="<?php echo esc_url(home_url('/')); ?>">
                <?php esc_html_e('Return to homepage', 'dharmgyan'); ?>
            </a>
        </p>
    </section>
</main>

<?php
get_footer();
