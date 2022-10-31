<?php 
global $post;
get_header(); ?>

<div class="header container <?php echo $post->post_name ?>">
    <div class="content">
        <div class="title">
            <h1><?php echo get_bloginfo() ?></h1>
        </div>
    </div>
</div>
<div class="maincontent container">
    <div class="content text">
        <?php while (have_posts()) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>