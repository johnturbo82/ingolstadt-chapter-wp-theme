<?php
/* 
Template Name: Shop
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
        <?php while (have_posts()) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        <?php endwhile; ?>
        <?php
        global $post;
        get_header();

        if (!post_password_required($post)) {
            $articles = get_posts([
                'post_type' => 'shop_product',
                'post_status' => 'publish',
                'numberposts' => -1,
                'order'    => 'ASC'
            ]);
            $article_string = "";
            $categories = array();
            foreach ($articles as $article) {
                foreach (get_field('shopkategorie', $article->ID) as $cat) {
                    if (!in_array($cat, $categories)) {
                        $categories[] = $cat;
                    }
                }
                $article_string .= "<article class='" . implode(" ", get_field('shopkategorie', $article->ID)) . "'>";
                if (get_field('ausverkauft', $article->ID)) {
                    $article_string .= "<div class='sold-out'>AUSVERKAUFT</div>";
                }
                $article_string .= "<h2>" . $article->post_title . "</h2>";
                $article_string .= "<p>" . $article->post_content . "</p>";
                if (get_field('artikelbild_1', $article->ID) != "") {
                    $article_string .= "<a href='" . get_field('artikelbild_1', $article->ID) . "' class='gallery'><img src='" . get_field('artikelbild_1', $article->ID) . "' alt='" . $article->post_title . " 1' /></a>";
                }
                if (get_field('artikelbild_2', $article->ID) != "") {
                    $article_string .= "<a href='" . get_field('artikelbild_2', $article->ID) . "' class='gallery'><img src='" . get_field('artikelbild_2', $article->ID) . "' alt='" . $article->post_title . " 1' /></a>";
                }
                $article_string .= "<div class='price'>" . get_field('preis', $article->ID) . " Euro</div>";
                $article_string .= "</article>";
            }
            echo "<div class='cat_container'>";
            echo "<span onclick='resetCats(this)' class='shoplabel active'>Alle&nbsp;Kategorien</span>";
            foreach ($categories as $cat) {
                echo "<span onclick='showCats(this)' class='shoplabel'>" . $cat . "</span>";
            }

            echo "</div>";
            echo $article_string;
        }
        ?>
    </div>
    <script>
        function showCats(elem) {
            var hideArticles = document.getElementsByTagName('article');
            for (var i = 0; i < hideArticles.length; i++) {
                hideArticles[i].style.display = 'none';
            }
            var labels = document.getElementsByClassName('shoplabel');
            for (var i = 0; i < labels.length; i++) {
                labels[i].classList.remove('active')
            }
            var showArticles = document.getElementsByClassName(elem.textContent);
            for (var i = 0; i < showArticles.length; i++) {
                showArticles[i].style.display = 'block';
            }
            elem.classList.add('active');
        }

        function resetCats(elem) {
            var showArticles = document.getElementsByTagName('article');
            for (var i = 0; i < showArticles.length; i++) {
                showArticles[i].style.display = 'block';
            }
            var labels = document.getElementsByClassName('shoplabel');
            for (var i = 0; i < labels.length; i++) {
                labels[i].classList.remove('active')
            }
            elem.classList.add('active');
        }
    </script>
</div>

<?php get_footer(); ?>