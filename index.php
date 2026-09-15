<?php get_header(); ?>

<div class="maincontent container">
	<div class="content text">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<h1><?php esc_html_e('Keine Inhalte gefunden.', 'ingolstadt-chapter'); ?></h1>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>