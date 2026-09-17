<?php

function theme_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');

    register_nav_menus(
        array(
            'main-menu' => __('Hauptmenü', 'ingolstadt-chapter'),
            'top-menu' => __('Topbar', 'ingolstadt-chapter'),
        )
    );
}
add_action('after_setup_theme', 'theme_setup');

function theme_enqueue_styles()
{
    $stylesheet = get_template_directory() . '/css/style.css';
    wp_enqueue_style(
        'ingolstadt-chapter-style',
        get_template_directory_uri() . '/css/style.css',
        array(),
        file_exists($stylesheet) ? filemtime($stylesheet) : null
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

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
    $atts = shortcode_atts(array(
        'officer' => '',
        'id' => '',
        'mail' => '',
        'image' => '',
    ), $atts, 'member');
    $officers = preg_split('/\s+/', trim($atts['officer']), -1, PREG_SPLIT_NO_EMPTY);
    $name = trim($content);
    $output = '<div' . ($atts['id'] !== '' ? ' id="' . esc_attr($atts['id']) . '"' : '') . ' class="member">';
    $output .= '<div class="name">';
    $output .= '<h3>' . esc_html($name) . '</h3>';
    if ($atts['mail'] !== '') {
        $output .= '<p><a href="mailto:' . esc_attr(sanitize_email($atts['mail'])) . '">' . esc_html($atts['mail']) . '</a></p>';
    }
    foreach ($officers as $officer) {
        $output .= '<div class="patch ' . esc_attr($officer) . '"></div>';
    }
    $output .= '</div>';
    $output .= '<div class="image">';
    if ($atts['image'] !== '') {
        $output .= '<img src="' . esc_url($atts['image']) . '" alt="' . esc_attr($name) . '" />';
    } else {
        $output .= '<span class="member-image-placeholder"></span>';
    }
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode("member", "member");

function officer_filter_shortcode()
{
    static $instance = 0;
    $instance++;
    $filter_id = 'officer-filter-' . $instance;

    $output = '<div id="' . esc_attr($filter_id) . '" class="officer-filter">';
    $output .= '<div class="officer-filter-buttons" role="group" aria-label="Nach Funktion filtern"></div>';
    $output .= '</div>';
    $output .= '<script>
        function initOfficerFilter() {
            var filter = document.getElementById(' . wp_json_encode($filter_id) . ');
            if (!filter) {
                return;
            }

            var scope = filter.closest(".content") || document;
            var members = Array.from(scope.querySelectorAll(".member"));
            var buttons = filter.querySelector(".officer-filter-buttons");
            var sections = [];
            var labels = {
                activitiesofficer: "Activities Officer",
                assistantdirector: "Assistant Director",
                director: "Director",
                headroadcaptain: "Head Road Captain",
                ladiesofharleyofficer: "Ladies of Harley Officer",
                membershipofficer: "Membership Officer",
                merchandiseofficer: "Merchandise Officer",
                pastofficer: "Past Officer",
                photographer: "Photographer",
                roadcaptain: "Road Captain",
                safetyofficer: "Safety Officer",
                secretary: "Secretary",
                treasurer: "Treasurer",
                webmaster: "Webmaster"
            };
            var officers = new Set();

            members.forEach(function (member) {
                member.querySelectorAll(".patch").forEach(function (patch) {
                    patch.classList.forEach(function (className) {
                        if (className !== "patch") {
                            officers.add(className);
                        }
                    });
                });
            });

            Array.from(scope.querySelectorAll("h2.wp-block-heading, .member")).forEach(function (element) {
                if (element.matches("h2.wp-block-heading")) {
                    sections.push({
                        heading: element,
                        members: []
                    });
                } else if (sections.length > 0) {
                    sections[sections.length - 1].members.push(element);
                }
            });

            function getLabel(slug) {
                if (labels[slug]) {
                    return labels[slug];
                }
                return slug.replace(/([a-z])([A-Z])/g, "$1 $2").replace(/[-_]/g, " ");
            }

            function applyFilters() {
                var selectedOfficers = Array.from(buttons.querySelectorAll("button.is-active"))
                    .map(function (button) {
                        return button.dataset.officer;
                    });

                members.forEach(function (member) {
                    member.hidden = selectedOfficers.length > 0 && !selectedOfficers.some(function (officer) {
                        return member.querySelector(".patch." + CSS.escape(officer));
                    });
                });

                sections.forEach(function (section) {
                    section.heading.hidden = !section.members.some(function (member) {
                        return !member.hidden;
                    });
                });
            }

            Array.from(officers).sort().forEach(function (officer) {
                var button = document.createElement("button");
                button.type = "button";
                button.className = "officer-filter-button";
                button.dataset.officer = officer;
                button.textContent = getLabel(officer);
                button.setAttribute("aria-pressed", "false");
                button.addEventListener("click", function () {
                    button.classList.toggle("is-active");
                    button.setAttribute("aria-pressed", button.classList.contains("is-active") ? "true" : "false");
                    applyFilters();
                });
                buttons.appendChild(button);
            });

            applyFilters();
        }

        if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", initOfficerFilter);
        } else {
            initOfficerFilter();
        }
    </script>';

    return $output;
}
add_shortcode('officer_filter', 'officer_filter_shortcode');

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
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-cart',
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
    if (!isset($_POST['events_print_calendar_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['events_print_calendar_nonce'])), 'events_print_calendar_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    if (isset($_POST['google_calendar_access_token'])) {
        update_post_meta($post_id, 'google_calendar_access_token', sanitize_text_field(wp_unslash($_POST['google_calendar_access_token'])));
    }
    if (isset($_POST['google_calendar_id'])) {
        update_post_meta($post_id, 'google_calendar_id', sanitize_text_field(wp_unslash($_POST['google_calendar_id'])));
    }
}
add_action('save_post_page', 'events_print_calendar_meta_box_save');


add_action('admin_init', 'restrict_specific_user_from_admin');

function restrict_specific_user_from_admin() {
    // Prüfen, ob eine AJAX-Anfrage vorliegt (wichtig, damit Frontend-Funktionen nicht brechen)
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }

    $current_user = wp_get_current_user();

    // Option A: Abfrage nach Benutzernamen
    if ($current_user->user_login === 'atchy') {
        wp_redirect(home_url());
        exit;
    }
}