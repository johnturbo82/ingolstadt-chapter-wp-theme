<?php

/**
 * Add navigation menus.
 */
register_nav_menus(
    array(
        'main-menu' => __('Hauptmenü'),
        'top-menu' => __('Topbar')
    )
);

/**
 * Add a footer widget area.
 */
function footer_widget_area_init()
{
    register_sidebar(array(
        'name'          => __('Footer Sidebar', 'footer_sidebar'),
        'id'            => 'footer_sidebar',
        'description'   => __('Widgets in this area will be shown on all posts and pages in the footer.', 'footer_sidebar'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'footer_widget_area_init');

/**
 * Add member introduction shortcode.
 */
function member($atts, $content = null)
{
    if (str_contains($atts['officer'], " ")) {
        $officers = explode(" ", $atts['officer']);
    } else {
        $officers = array($atts['officer']);
    }
    $name = trim($content);
    $output = '';
    $output.= '<div class="member">';
    $output.= '<div class="name">';
    $output.= '<h3>' . $name . '</h3>';
    if (isset($atts['mail'])) {
        $output.= '<p><a href="mailto:' . $atts['mail'] . '">' . $atts['mail'] . '</a></p>';
    }
    foreach ($officers as $officer) {
        $output.= '<div class="patch ' . trim($officer) . '"></div>';
    }
    $output.= '</div>';
    $output.= '<div class="image">';
    $output.= '<img src="' . $atts['image'] . '" alt="' . $name . '"/>';
    $output.= '</div>';
    $output.= '</div>';
    return $output;
}
add_shortcode("member", "member");
