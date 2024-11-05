<?php
/*
Plugin Name: Remove WordPress Branding
Description: Removes WordPress branding, Gravatar functionality, and other WordPress hints from the front and back end.
Version: 1.0
Author: Your Name
*/

// Remove WordPress version from head and feeds
function remove_wp_version() {
    return '';
}
add_filter('the_generator', 'remove_wp_version');

// Remove WordPress version from scripts and styles
function remove_wp_version_from_assets($src) {
    if (strpos($src, 'ver=' . get_bloginfo('version'))) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'remove_wp_version_from_assets', 9999);
add_filter('script_loader_src', 'remove_wp_version_from_assets', 9999);

// Remove "Powered by WordPress" from the admin footer
function custom_admin_footer() {
    echo '';
}
add_filter('admin_footer_text', 'custom_admin_footer');

// Disable Gravatar
function disable_gravatar($avatar) {
    return null;
}
add_filter('get_avatar', 'disable_gravatar', 1);

// Hide WordPress admin bar logo
function remove_admin_bar_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('wp-logo');
}
add_action('wp_before_admin_bar_render', 'remove_admin_bar_logo');

// Remove WordPress dashboard widgets
function remove_wp_dashboard_widgets() {
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side'); // Removes WordPress News
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Removes Activity
}
add_action('wp_dashboard_setup', 'remove_wp_dashboard_widgets');

// Disable the admin toolbar for all users on the frontend
add_filter('show_admin_bar', '__return_false');

// Optionally, remove the toolbar completely for non-admins
function remove_admin_bar_for_non_admins() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar_for_non_admins');

// Hide admin bar for all users, both frontend and backend
add_filter('show_admin_bar', '__return_false');

// Hide the admin bar menu elements in the backend (dashboard)
function hide_admin_bar_backend() {
    if (!current_user_can('administrator')) {
        remove_action('in_admin_header', 'wp_admin_bar_render');
    }
}
add_action('admin_init', 'hide_admin_bar_backend');


// Disable WordPress emoji script
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove WordPress REST API link in header
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// Remove WordPress RSD and WLW manifest links
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// Remove oEmbed discovery links
remove_action('wp_head', 'wp_oembed_add_discovery_links');

// Remove oEmbed-specific JavaScript from front-end and back-end
remove_action('wp_head', 'wp_oembed_add_host_js');

?>
