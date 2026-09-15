<?php get_header(); ?>

<div class="maincontent container">
    <div class="content text">
        <h1><?php the_archive_title(); ?></h1>
        <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
            <?php the_posts_pagination(); ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
