<?php
/**
 * The template for displaying archives.
 *
 * @package Dharmgyan
 */

get_header();
?>

<main id="main" class="site-main container mx-auto px-4 py-8" role="main">
    <?php if (have_posts()) : ?>
        <header class="page-header mb-8">
            <?php the_archive_title('<h1 class="text-3xl font-bold mb-3">', '</h1>'); ?>
            <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
        </header>

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
        <p><?php esc_html_e('No posts found.', 'dharmgyan'); ?></p>
    <?php endif; ?>
</main>

<?php
get_footer();
