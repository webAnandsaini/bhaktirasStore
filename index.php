<?php get_header(); ?>

<main class="container py-8 mx-auto">
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <article <?php post_class('mb-8'); ?>>
        <h2 class="mb-2 text-2xl font-bold"><a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a></h2>
        <div class="prose max-w-none">
          <?php the_excerpt(); ?>
        </div>
      </article>
    <?php endwhile; ?>
    <div class="mt-8">
      <?php the_posts_pagination(); ?>
    </div>
  <?php else : ?>
    <p><?php esc_html_e('No posts found.', 'dharmgyan'); ?></p>
  <?php endif; ?>
</main>

<?php get_footer(); ?>