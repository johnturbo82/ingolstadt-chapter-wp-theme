<?php
/*
Template Name: Galerie
*/
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
        <?php
        // Auf Unterseiten liegen die Geschwister-Galerien unter der Elternseite.
        $is_gallery_subpage = (bool) $post->post_parent;
        $gallery_root_id    = $is_gallery_subpage ? $post->post_parent : $post->ID;

        $gallery_children = get_pages(array(
            'child_of'  => $gallery_root_id,
            'sort_column' => 'post_date',
            'sort_order'  => 'desc',
        ));
        if ($gallery_children) :
            $selected_gallery = $is_gallery_subpage ? $post : $gallery_children[0]; ?>
            <select class="gallery-select" onchange="if (this.value) { window.location.href = this.value; }">
                <?php foreach ($gallery_children as $child) : ?>
                    <option value="<?php echo esc_url(get_permalink($child->ID)); ?>" <?php selected($child->ID, $selected_gallery->ID); ?>><?php echo esc_html(get_the_date('', $child->ID)); ?> &ndash; <?php echo esc_html($child->post_title); ?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <?php while (have_posts()) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        <?php endwhile; ?>

        <?php if ($gallery_children && !$is_gallery_subpage) : ?>
            <div class="gallery-latest-content">
                <?php echo apply_filters('the_content', $selected_gallery->post_content); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>