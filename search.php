<?php
/**
 * The template for displaying search results.
 *
 * @package Dharmgyan
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-8" role="main">
    <header class="page-header mb-8">
        <h1 class="text-3xl font-bold">
            <?php
            printf(
                /* translators: %s: Search query. */
                esc_html__('Search results for: %s', 'dharmgyan'),
                esc_html(get_search_query())
            );
            ?>
        </h1>
    </header>

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <article <?php post_class('mb-8'); ?>>
                <h2 class="text-2xl font-bold mb-2">
                    <a class="hover:underline" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
                <div class="prose max-w-none">
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>

        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p class="mb-6"><?php esc_html_e('No matching content was found. Please try another search.', 'dharmgyan'); ?></p>
        <?php get_search_form(); ?>
    <?php endif; ?>
</main>

<?php
get_footer();
