<?php
// Enqueue styles and scripts
function instructo_learn_enqueue_styles() {
    // Load main stylesheet
    wp_enqueue_style('instructo-learn-style', get_stylesheet_uri());

    wp_enqueue_style('bootstrap-icons', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css', array(), '1.10.0');
    

    // Example: Load an additional stylesheet for custom styles
    // wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/custom.css');

    // Example: Load a JavaScript file
    // wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'instructo_learn_enqueue_styles');

// Add theme support for various features
function instructo_learn_setup() {
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'), // Elements to be hidden with the logo
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'instructo-learn'),
    ));

    // Add support for HTML5 markup for search forms, comment forms, and more
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'instructo_learn_setup');

// Function to create a custom widget area
function instructo_learn_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'instructo-learn'),
        'id'            => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'instructo_learn_widgets_init');

