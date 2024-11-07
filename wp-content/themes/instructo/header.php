<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:ital,wght@0,100..900;1,100..900&family=Luckiest+Guy&display=swap" rel="stylesheet">
    <?php wp_head(); // Hook for enqueueing scripts and styles ?>
</head>

<body <?php body_class(); ?>>
    <header id="site-header" class="site-header">
        <div class="container">
            <div class="site-branding">
                <div class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>"><span>Instructo</span> Tech.Academy</a>
                </div>
                <p class="site-description"><?php bloginfo('description'); ?></p>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary', // This should match the registered menu location in functions.php
                    'menu_id'        => 'primary-menu',
                ));
                ?>
            </nav><!-- #site-navigation -->

            <?php
            // Query to count unread notifications
            global $wpdb;
            $table_name = $wpdb->prefix . 'user_notifications';
            $user_id = get_current_user_id();

            // Get the count of unread notifications
            $unread_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE user_id = $user_id AND is_read = 0");

            ?>

            <!-- Add the icon and notification count in the header -->
            <div class="fixed-settings">
                <h3>Settings</h3>
                <div class="notification-icon">
                    <a href="<?php echo esc_url( home_url( '/notifications' ) ); ?>"> <!-- Link to the notifications page -->
                        <i class="bi bi-bell" style="font-size: 24px;"></i> <!-- Bootstrap icon for the bell -->
                        <?php if ($unread_count > 0) : ?>
                            <span class="notification-count"><?php echo esc_html($unread_count); ?></span> <!-- Show the unread count -->
                        <?php else: ?>
                            <span class="notification-count">0</span> <!-- Show the unread count -->
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div><!-- .container -->
    </header><!-- #site-header -->
