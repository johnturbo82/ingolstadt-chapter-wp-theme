        <div class="prefooter container">
            <div class="content text">
                <div class="backpatch backpatch_old"></div>
                <div class="backpatch backpatch_current"></div>
                <div class="backpatch backpatch_new"></div>
            </div>
        </div>
        <div class="footer container">
            <div class="content text">
                <?php if ( is_active_sidebar( 'footer_sidebar' ) ) { ?>
                    <ul id="footer_sidebar">
                        <?php dynamic_sidebar('footer_sidebar'); ?>
                    </ul>
                <?php } ?>
                <div class="link_icons">
                    <a title="Facebook" href="https://www.facebook.com/groups/351111465258474/" target="_blank" class="icon facebook"></a>
                    <a title="Instagram" href="https://www.instagram.com/hog_ingolstadt_chapter/" target="_blank" class="icon instagram"></a>
                    <a title="Sponsoring Dealer" href="https://hd-ingolstadt.com/" target="_blank" class="icon dealer"></a>
                </div>
            </div>
        </div>
        <div class="postfooter container">
            <div class="content text">
                &copy; Ingolstadt Chapter
                <span class="right"><a href="mailto:webmaster@ingolstadt-chapter.de">webmaster@ingolstadt-chapter.de</a></span>
            </div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>
