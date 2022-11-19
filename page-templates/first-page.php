<?php
/* 
Template Name: Startseite
*/
get_header(); ?>

<div class="header container first-page">
    <div class="content">
        <div class="title">
            <a href="<?php echo get_home_url() ?>"><img class="logo" src="<?php echo get_template_directory_uri(); ?>/images/logo/Ingolstadt_Chapter.svg" alt="Ingolstadt Chapter" /></a>
            <h1><?php echo get_bloginfo() ?></h1>
            <h2><?php echo get_bloginfo('description') ?></h2>
        </div>
    </div>
</div>
<div class="maincontent container">
    <div class="content text">
        <?php the_content(); ?>
        <h2>News</h2>
        <div class="news">
            <?php query_posts('posts_per_page=2&offset=0'); ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="news_article">
                    <div class="news_article_container">
                        <?php
                        if (has_post_thumbnail()) {
                        ?>
                            <div class="image" style="background-image: url(<?php echo get_the_post_thumbnail_url(null, 'medium'); ?>)"></div>
                        <?php } ?>
                        <div class="text">
                            <span class="date"><?php echo the_date(); ?></span>
                            <h3><?php the_title(); ?></h3>
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; // end of the loop.  
            ?>
        </div>
    </div>
    <?php
    $get_children_array = get_children(array('post_parent' => 10, 'post_type' => 'page'));
    foreach ($get_children_array as $child_page) {
        echo '<div class="wide_content ' . $child_page->post_name . '"></div>';
        echo '<div class="content text">';
        echo '<h1>' . $child_page->post_title . '</h1>';
        echo str_replace(']]>', ']]&gt;', apply_filters('the_content', $child_page->post_content));
        echo '</div>';
    }
    ?>
</div>

<?php get_footer(); ?>