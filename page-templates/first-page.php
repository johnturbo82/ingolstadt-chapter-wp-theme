<?php
/* 
Template Name: Startseite
*/
get_header(); ?>

<div class="header container first-page">
    <div class="wide_content">
        <!-- <video id="intro-video" autoplay loop muted poster="<?php echo get_template_directory_uri(); ?>/images/InChap_riding.webp">
                <source src="<?php echo get_template_directory_uri(); ?>/videos/intro.mp4" type="video/mp4">
            </video> -->
    </div>
    <div class="content">
        <div class="title">
            <a href="<?php echo get_home_url() ?>"><img class="logo" src="<?php echo get_template_directory_uri(); ?>/images/Ingolstadt_Chapter.svg" alt="Ingolstadt Chapter" /></a>
            <h1><?php echo get_bloginfo() ?></h1>
            <h2><?php echo get_bloginfo('description') ?></h2>
        </div>
    </div>
</div>
<div class="maincontent container">
    <div class="content text">
        <?php the_content(); ?>
    </div>
    <?php
    $get_children_array = get_children(array('post_parent' => $post->ID, 'post_type' => 'page'));
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