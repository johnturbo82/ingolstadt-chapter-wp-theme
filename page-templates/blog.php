<?php
/*
Template Name: Newsübersicht
*/
global $post;
get_header(); ?>

<div class="header container blog-overview">
    <div class="content">
        <div class="title">
            <h1><?php echo get_bloginfo(); ?></h1>
        </div>
    </div>
</div>
<div class="maincontent container">
    <div class="content text">
        <h1><?php the_title(); ?></h1>
        <?php
        $blog_query = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 10,
            'paged' => max(1, get_query_var('paged')),
        ));
        ?>
        <?php if ($blog_query->have_posts()) : ?>
            <div class="news blog-overview-list">
                <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                    <article class="news_article">
                        <div class="news_article_container">
                            <?php if (has_post_thumbnail()) : ?>
                                <a class="image" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(null, 'medium')); ?>')"></a>
                            <?php endif; ?>
                            <div class="text">
                                <span class="date"><?php echo esc_html(get_the_date()); ?></span>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <?php the_content("Weiterlesen"); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php
            echo paginate_links(array(
                'total' => $blog_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
            ));
            ?>
        <?php else : ?>
            <p>Es wurden noch keine Beiträge veröffentlicht.</p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>
