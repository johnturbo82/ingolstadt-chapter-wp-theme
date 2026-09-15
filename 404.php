<?php get_header(); ?>

<div class="maincontent container">
    <div class="content text">
        <h1><?php esc_html_e('Seite nicht gefunden', 'ingolstadt-chapter'); ?></h1>
        <p><?php esc_html_e('Die gesuchte Seite existiert nicht oder wurde verschoben.', 'ingolstadt-chapter'); ?></p>
        <p><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Zur Startseite', 'ingolstadt-chapter'); ?></a></p>
    </div>
</div>

<?php get_footer(); ?>
