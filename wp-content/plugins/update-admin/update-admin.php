<?php
/*
Plugin Name: Remove WordPress Branding and Style Admin
Description: Removes WordPress branding, hides the admin bar, and styles the admin menu to be horizontal with a Material Design look.
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

// Hide the admin bar for all users in the backend
function hide_admin_bar_backend_css() {
    if (is_admin()) {
        echo "<style type='text/css'>
                #wpadminbar {
                    display: none !important;
                }
                #wpcontent {
                    margin-top: 0 !important;
                }
              </style>";
    }
}
add_action('admin_head', 'hide_admin_bar_backend_css');

// Optionally, also hide the admin bar on the frontend for everyone:
add_filter('show_admin_bar', '__return_false');

// Style the admin menu to be horizontal with Material Design
function style_admin_menu() {
    echo "<style type='text/css'>
            /* Style the admin menu to be horizontal */

            #adminmenu, #adminmenu .wp-submenu, #adminmenuback, #adminmenuwrap {
                background: transparent;
            }

            #adminmenumain {
                background: #26c6da;
            }

            #adminmenu {
                display: flex;
                flex-direction: row;
                justify-content: space-around;
                background-color: transparent;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
                padding: 10px 0; /* Vertical padding */
                border-bottom: 1px solid #e0e0e0; /* Light border at the bottom */
            }

            /* Style each menu item */
            #adminmenu li {
                list-style: none;
                border-radius: 0px !important;
                margin: 0px; /* Space between menu items */
                transition: background-color 0.3s ease;
                position: relative; /* Position for hover effect */
            }

            #adminmenu li:hover {
                background-color: #f5f5f5; /* Light hover background */
            }

            #adminmenu a {
                color: #333; /* Dark text color */
                font-weight: 500; /* Medium weight */
                text-decoration: none;
                display: block;
                text-align: center;
                padding: 10px 15px; /* Padding around text */
                border-radius: 0px; /* Rounded corners */
                transition: color 0.3s ease; /* Smooth color transition */
            }

            #adminmenu div.wp-menu-name {
                padding: 0px;
            } 

            #adminmenu a:focus, #adminmenu a:hover, .folded #adminmenu .wp-submenu-head:hover {
                box-shadow: none;
                border: none;
            }

            /* Adjusting the submenu (if desired) */
            #adminmenu .wp-submenu {
                display: none !important; /* Hiding the submenu items */
            }

            /* Hide the WordPress logo */
            #wp-admin-bar-wp-logo {
                display: none;
            }

            /* Hide the admin menu background */
            #adminmenuback {
                display: none !important;
            }

            html.wp-toolbar {
                padding-top: 0px !important;
            }

            .sticky-menu #adminmenuwrap {
                float: none;
                width: 100%;
                position: relative !important;
            }

            /* Admin page content margin adjustment */
            #wpcontent {
                margin-top: 60px; /* Adjust space to fit new horizontal menu */
            }

            #adminmenu {
                margin-top: 0px;
                width: 100%;
                padding: 0px;
            }

            #adminmenu li.menu-top {
                padding: 0 7px;
            }

            #adminmenu a:focus, #adminmenu a:hover, .folded #adminmenu .wp-submenu-head:hover, #adminmenu li.menu-top:hover, #adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus {
                background: #e0f7fa;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                #adminmenu {
                    flex-direction: column; /* Stack items vertically on small screens */
                }
            }

            #adminmenu div.wp-menu-image {
                float: none;
                width: 65px;
            }

            /* Change position of main admin footer and body */
            #wpcontent, #wpfooter {
                margin-left: 0px;
            }
        </style>";
}
add_action('admin_head', 'style_admin_menu');
?>
