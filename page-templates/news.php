<?php
/*
Template Name: News Kachelübersicht
*/

get_header();

$news_search = isset($_GET['news_search']) ? sanitize_text_field(wp_unslash($_GET['news_search'])) : '';
$news_page = max(1, get_query_var('paged'), get_query_var('page'));
$news_query = new WP_Query(array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 10,
	'paged' => $news_page,
	's' => $news_search,
));
$news_fallback_image = wp_get_attachment_image_url(605, 'large');
if (!$news_fallback_image) {
	$news_fallback_image = 'https://www.ingolstadt-chapter.de/wp-content/uploads/2019/02/Bilder_Videos_Iphone6s-448.jpg';
}
?>

<div class="header container blog-overview">
	<div class="content">
		<div class="title">
			<h1><?php echo esc_html(get_bloginfo()); ?></h1>
		</div>
	</div>
</div>

<main id="main-content" class="maincontent container news-cards-page">
	<div class="content text">
		<div class="news-toolbar">
			<h1><?php the_title(); ?></h1>
			<form class="news-search" method="get" action="<?php echo esc_url(get_permalink()); ?>">
				<label class="screen-reader-text" for="news-search-input">News durchsuchen</label>
				<input id="news-search-input" type="search" name="news_search" value="<?php echo esc_attr($news_search); ?>" placeholder="News durchsuchen">
				<button type="submit">Suchen</button>
			</form>
		</div>

		<?php if ($news_query->have_posts()) : ?>
			<div class="news-card-grid">
				<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
					<?php $news_image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'large') : $news_fallback_image; ?>
					<article class="news-card">
						<a class="news-card-image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(sprintf('%s lesen', get_the_title())); ?>" style="background-image: url('<?php echo esc_url($news_image_url); ?>');"></a>
						<div class="news-card-body">
							<time class="news-card-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="news-card-excerpt"><?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_content()), 28, '...')); ?></p>
							<a class="news-card-link" href="<?php the_permalink(); ?>">Artikel lesen</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php if ($news_query->max_num_pages > 1) : ?>
				<nav class="news-pagination" aria-label="News Seiten">
					<?php echo wp_kses_post(paginate_links(array(
						'total' => $news_query->max_num_pages,
						'current' => $news_page,
						'type' => 'plain',
						'add_args' => $news_search !== '' ? array('news_search' => $news_search) : array(),
					))); ?>
				</nav>
			<?php endif; ?>
		<?php else : ?>
			<p>Es wurden keine passenden Beiträge gefunden.</p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</main>

<?php get_footer(); ?>
