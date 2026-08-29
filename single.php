<?php
/**
 * The template for displaying single posts.
 *
 * @package Dharmgyan
 */

get_header();
?>

<main id="main" class="site-main container mx-auto px-4 py-8" role="main">
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <article <?php post_class(); ?>>
            <header class="entry-header mb-6">
                <?php the_title('<h1 class="text-3xl font-bold">', '</h1>'); ?>
            </header>

            <div class="entry-content prose max-w-none">
                <?php the_content(); ?>
                <?php
                wp_link_pages(
                    array(
                        'before' => '<nav class="page-links">' . esc_html__('Pages:', 'dharmgyan'),
                        'after'  => '</nav>',
                    )
                );
                ?>
            </div>
        </article>

        <?php
        the_post_navigation();

        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>
    <?php endwhile; ?>
</main>

<?php
get_footer();
