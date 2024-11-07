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


function ajax_live_search() {
    if (!isset($_GET['query']) || empty($_GET['query'])) {
        wp_send_json([]);
        wp_die();
    }

    $query = sanitize_text_field($_GET['query']);
    $args = [
        's' => $query,
        'post_type' => 'pathway',  // Customize as needed
        'posts_per_page' => 10
    ];

    $search_query = new WP_Query($args);
    $results = [];

    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            $results[] = [
                'title' => get_the_title(),
                'link' => get_permalink(),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium')  // Medium thumbnail
            ];
        }
        wp_reset_postdata();
    }

    wp_send_json($results);
    wp_die();
}
add_action('wp_ajax_live_search', 'ajax_live_search');
add_action('wp_ajax_nopriv_live_search', 'ajax_live_search');


// Register Pathway Post Type
function register_pathway_post_type() {
    $args = [
        'labels' => [
            'name' => 'Pathways',
            'singular_name' => 'Pathway',
            'add_new_item' => 'Add New Pathway',
            'edit_item' => 'Edit Pathway',
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'author', 'thumbnail'],
        'rewrite' => ['slug' => 'pathways'],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
    ];
    register_post_type('pathway', $args);
}
add_action('init', 'register_pathway_post_type');

// Register Module Post Type
function register_module_post_type() {
    $args = [
        'labels' => [
            'name' => 'Modules',
            'singular_name' => 'Module',
            'add_new_item' => 'Add New Module',
            'edit_item' => 'Edit Module',
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'author', 'thumbnail'],
        'rewrite' => ['slug' => 'modules'],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
    ];
    register_post_type('module', $args);
}
add_action('init', 'register_module_post_type');

// Add custom meta box to the 'Pathways' post type for selecting Modules
function add_modules_meta_box() {
    add_meta_box(
        'pathway_modules_meta_box',         // Unique ID
        'Related Modules',                  // Box title
        'render_modules_meta_box',          // Content callback
        'pathway',                          // Post type
        'side',                             // Context
        'default'                           // Priority
    );
}
add_action('add_meta_boxes', 'add_modules_meta_box');

// Render the meta box content
function render_modules_meta_box($post) {
    // Use nonce for verification
    wp_nonce_field('save_modules_meta_box_data', 'modules_meta_box_nonce');

    // Get the currently selected modules
    $selected_modules = get_post_meta($post->ID, 'related_modules', true) ?: [];

    // Query all Modules
    $modules = get_posts([
        'post_type' => 'module',
        'numberposts' => -1,
    ]);

    // Render checkboxes for each Module
    echo '<label>Select related Modules:</label><br>';
    foreach ($modules as $module) {
        $checked = in_array($module->ID, $selected_modules) ? 'checked' : '';
        echo '<input type="checkbox" name="related_modules[]" value="' . esc_attr($module->ID) . '" ' . $checked . '> ' . esc_html($module->post_title) . '<br>';
    }
}

// Save the selected modules when the Pathway post is saved
function save_modules_meta_box_data($post_id) {
    // Check if our nonce is set and verify it
    if (!isset($_POST['modules_meta_box_nonce']) || !wp_verify_nonce($_POST['modules_meta_box_nonce'], 'save_modules_meta_box_data')) {
        return;
    }

    // Check if the current user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the selected modules
    if (isset($_POST['related_modules'])) {
        $related_modules = array_map('intval', $_POST['related_modules']);
        update_post_meta($post_id, 'related_modules', $related_modules);
    } else {
        delete_post_meta($post_id, 'related_modules');
    }
}
add_action('save_post', 'save_modules_meta_box_data');



global $wpdb;
$table_name = $wpdb->prefix . 'user_notifications';

function create_notifications_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_notifications';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id mediumint(9) NOT NULL,
        message text NOT NULL,
        is_read tinyint(1) DEFAULT 0 NOT NULL,
        date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'create_notifications_table');


function mark_message_as_read() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_notifications';

    if (isset($_POST['message_id'])) {
        $message_id = intval($_POST['message_id']);
        $wpdb->update($table_name, ['is_read' => 1], ['id' => $message_id]);
    }
    wp_die();
}
add_action('wp_ajax_mark_as_read', 'mark_message_as_read');


function enroll_user_in_pathway_ajax() {
    // Verify user is logged in
    if (!is_user_logged_in() || !isset($_POST['pathway_id'])) {
        wp_send_json(['success' => false, 'message' => 'You must be logged in to enroll.']);
        wp_die();
    }

    $user_id = get_current_user_id();
    $pathway_id = intval($_POST['pathway_id']);

    // Retrieve the user's enrolled pathways from user meta
    $enrolled_pathways = get_user_meta($user_id, 'enrolled_pathways', true);
    if (!$enrolled_pathways) {
        $enrolled_pathways = [];
    }
    
    // Enroll the user if they're not already enrolled in this pathway
    if (!in_array($pathway_id, $enrolled_pathways)) {
        $enrolled_pathways[] = $pathway_id;
        update_user_meta($user_id, 'enrolled_pathways', $enrolled_pathways);

        // Send an enrollment notification message to the user's inbox
        global $wpdb;
        $table_name = $wpdb->prefix . 'user_notifications';
        $pathway_title = get_the_title($pathway_id);
        $message = "You have enrolled in the pathway: $pathway_title.";

        $wpdb->insert($table_name, [
            'user_id' => $user_id,
            'message' => $message,
            'is_read' => 0,
            'date' => current_time('mysql')
        ]);

        // Check if the user has enrolled in 5 pathways and send a congratulatory message
        if (count($enrolled_pathways) === 5) {
            $congrats_message = "Congratulations! You have enrolled in 5 pathways. Keep up the great learning!";
            $wpdb->insert($table_name, [
                'user_id' => $user_id,
                'message' => $congrats_message,
                'is_read' => 0,
                'date' => current_time('mysql')
            ]);
        }

        wp_send_json(['success' => true, 'message' => 'Successfully enrolled']);
    } else {
        wp_send_json(['success' => false, 'message' => 'You are already enrolled in this pathway.']);
    }

    wp_die();
}
add_action('wp_ajax_enroll_user_in_pathway', 'enroll_user_in_pathway_ajax');

function check_user_enrollment($user_id, $pathway_id) {
    // You should replace this with actual logic to check if the user is enrolled.
    // For example, you might check if the user has a record in a custom table or user meta.
    // This is just an example using user meta.
    
    $enrollment = get_user_meta($user_id, 'enrolled_pathways', true);
    return in_array($pathway_id, (array)$enrollment); // Assumes 'enrolled_pathways' is an array of pathway IDs
}
