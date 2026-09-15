<?php get_header(); ?>

<div class="maincontent container">
    <div class="content text">
        <h1><?php printf(esc_html__('Suchergebnisse für: %s', 'ingolstadt-chapter'), '<span>' . esc_html(get_search_query()) . '</span>'); ?></h1>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p><?php esc_html_e('Keine passenden Inhalte gefunden.', 'ingolstadt-chapter'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
