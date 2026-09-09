<?php 
get_header(); ?>

<div class="header container blog-entry <?php echo $post->post_name ?>">
    <div class="content">
        <div class="title">
            <h1><?php echo get_bloginfo() ?></h1>
        </div>
    </div>
</div>
<div class="maincontent container">
    <div class="content text">
        <?php while (have_posts()) : the_post(); ?>
            <?php if (has_post_thumbnail()) : ?>
                <div class="single-featured-image" role="img" aria-label="<?php the_title_attribute(); ?>" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(null, 'full')); ?>')"></div>
            <?php endif; ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>