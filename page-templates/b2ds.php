<?php
/* 
Template Name: Bavarian 2 Days
*/
global $post;
get_header(); ?>

<div class="header container <?php echo $post->post_name ?>">
    <div class="content">
        <div class="title b2d">
            <img src="<?php echo get_template_directory_uri(); ?>/images/logo/b2d2025-logo.svg" alt="Bavarian 2 Days 2025" />
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