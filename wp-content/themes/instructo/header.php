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
        </div><!-- .container -->
    </header><!-- #site-header -->
