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
    if (isset($atts['id'])) {
        $output .= '<div id="' .  $atts['id'] . '" class="member">';
    } else {
        $output .= '<div class="member">';
    }
    $output .= '<div class="name">';
    $output .= '<h3>' . $name . '</h3>';
    if (isset($atts['mail'])) {
        $output .= '<p><a href="mailto:' . $atts['mail'] . '">' . $atts['mail'] . '</a></p>';
    }
    foreach ($officers as $officer) {
        $output .= '<div class="patch ' . trim($officer) . '"></div>';
    }
    $output .= '</div>';
    $output .= '<div class="image">';
    $output .= '<img src="' . $atts['image'] . '" alt="' . $name . '"/>';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode("member", "member");

/**
 * Add custom post type for Shop
 */

 function wp_shop_custom_post_type() {
	register_post_type('shop_product',
		array(
			'labels'      => array(
				'name'          => __( 'Shopartikel', 'textdomain' ),
				'singular_name' => __( 'Shopartikel', 'textdomain' ),
			),
			'public'      => true,
			'has_archive' => true,
			'rewrite'     => array( 'slug' => 'shopartikel' ),
		)
	);
}
add_action('init', 'wp_shop_custom_post_type');

/**
 * Meta box for Google Calendar credentials on the "Events Druckansicht" template.
 */
function events_print_calendar_meta_box()
{
    add_meta_box(
        'events_print_calendar',
        __('Google Kalender Zugangsdaten', 'textdomain'),
        'events_print_calendar_meta_box_render',
        'page',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'events_print_calendar_meta_box');

function events_print_calendar_meta_box_render($post)
{
    if (get_page_template_slug($post->ID) !== 'page-templates/events_print.php') {
        return;
    }

    wp_nonce_field('events_print_calendar_save', 'events_print_calendar_nonce');
    $access_token = get_post_meta($post->ID, 'google_calendar_access_token', true);
    $calendar_id  = get_post_meta($post->ID, 'google_calendar_id', true);
?>
    <p>
        <label for="google_calendar_access_token"><?php _e('Access Token', 'textdomain'); ?></label><br>
        <input type="text" id="google_calendar_access_token" name="google_calendar_access_token" value="<?php echo esc_attr($access_token); ?>" style="width:100%;">
    </p>
    <p>
        <label for="google_calendar_id"><?php _e('Calendar ID', 'textdomain'); ?></label><br>
        <input type="text" id="google_calendar_id" name="google_calendar_id" value="<?php echo esc_attr($calendar_id); ?>" style="width:100%;">
    </p>
<?php
}

function events_print_calendar_meta_box_save($post_id)
{
    if (!isset($_POST['events_print_calendar_nonce']) || !wp_verify_nonce($_POST['events_print_calendar_nonce'], 'events_print_calendar_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    if (isset($_POST['google_calendar_access_token'])) {
        update_post_meta($post_id, 'google_calendar_access_token', sanitize_text_field($_POST['google_calendar_access_token']));
    }
    if (isset($_POST['google_calendar_id'])) {
        update_post_meta($post_id, 'google_calendar_id', sanitize_text_field($_POST['google_calendar_id']));
    }
}
add_action('save_post_page', 'events_print_calendar_meta_box_save');

