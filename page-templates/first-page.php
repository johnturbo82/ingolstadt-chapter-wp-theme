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
        <section class="news-cards-page first-page-news">
            <div class="news-card-grid">
                <?php
                $latest_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => 2,
                ));
                while ($latest_posts->have_posts()) : $latest_posts->the_post();
                    $news_image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'large') : wp_get_attachment_image_url(605, 'large');
                    if (!$news_image_url) {
                        $news_image_url = 'https://www.ingolstadt-chapter.de/wp-content/uploads/2019/02/Bilder_Videos_Iphone6s-448.jpg';
                    }
                ?>
                    <article class="news-card">
                        <a class="news-card-image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(sprintf('%s lesen', get_the_title())); ?>" style="background-image: url('<?php echo esc_url($news_image_url); ?>');"></a>
                        <div class="news-card-body">
                            <time class="news-card-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="news-card-excerpt"><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_content()), 28, '...')); ?></p>
                            <a class="news-card-link" href="<?php the_permalink(); ?>">Artikel lesen</a>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
        <a class="news-more-link" href="<?php echo esc_url(home_url('/news/')); ?>">Weitere News...</a>
    </div>
    <?php
    $get_children_array = get_children(array('post_parent' => 10, 'post_type' => 'page'));
    foreach ($get_children_array as $child_page) {
            echo '<div class="wide_content ' . esc_attr($child_page->post_name) . '"></div>';
        echo '<div class="content text">';
            echo '<h1>' . esc_html($child_page->post_title) . '</h1>';
        echo str_replace(']]>', ']]&gt;', apply_filters('the_content', $child_page->post_content));
        echo '</div>';
    }
    ?>
</div>

<?php get_footer(); ?>