<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Ingolstadt Chapter">
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css?v=7">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon.ico">
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon.ico">
    <link rel="icon" type="image/gif" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon.gif">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon.png">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon.png">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-57x57.png" sizes="57x57">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-60x60.png" sizes="60x60">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-72x72.png" sizes="72x72">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-76x76.png" sizes="76x76">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-114x114.png" sizes="114x114">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-120x120.png" sizes="120x120">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-128x128.png" sizes="128x128">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-144x144.png" sizes="144x144">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-152x152.png" sizes="152x152">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-180x180.png" sizes="180x180">
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icons/apple-touch-icon-precomposed.png">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon-160x160.png" sizes="160x160">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/icons/favicon-196x196.png" sizes="196x196">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/images/icons/win8-tile-144x144.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-navbutton-color" content="#ffffff">
    <meta name="application-name" content="Ingolstadt Chapter" />
    <meta name="msapplication-tooltip" content="Ingolstadt Chapter" />
    <meta name="apple-mobile-web-app-title" content="Ingolstadt Chapter" />
    <meta name="msapplication-square70x70logo" content="<?php echo get_template_directory_uri(); ?>/images/icons/win8-tile-70x70.png">
    <meta name="msapplication-square144x144logo" content="<?php echo get_template_directory_uri(); ?>/images/icons/win8-tile-144x144.png">
    <meta name="msapplication-square150x150logo" content="<?php echo get_template_directory_uri(); ?>/images/icons/win8-tile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="<?php echo get_template_directory_uri(); ?>/images/icons/win8-tile-310x150.png">
    <meta name="msapplication-square310x310logo" content="<?php echo get_template_directory_uri(); ?>/images/icons/win8-tile-310x310.png">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="topbar container">
        <div class="content">
            <span>Official H.O.G. Chapter #8547</span>
            <?php wp_nav_menu(array('menu' => 'Pflichtangaben')) ?>
        </div>
    </div>
    <div class="navigation container">
        <div class="content">
            <a class="homebutton" href="<?php echo get_home_url() ?>">
                <img class="small_logo" src="<?php echo get_template_directory_uri(); ?>/images/logo/Ingolstadt_Chapter.svg" alt="Ingolstadt Chapter" />
            </a>
            <div class="current_page_title"><?php the_title(); ?></div>
            <input id="menu_toggle" type="checkbox"></input>
            <label for="menu_toggle" class="hamburger">
                <div class="top-bun"></div>
                <div class="meat"></div>
                <div class="bottom-bun"></div>
            </label>
            <div class="nav">
                <?php wp_nav_menu(array('menu' => 'Hauptmenü', 'container_class' => 'mainmenu')) ?>
            </div>
        </div>
    </div>