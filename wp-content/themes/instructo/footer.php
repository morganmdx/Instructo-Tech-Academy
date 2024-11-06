</main><!-- #main -->

<footer id="site-footer" class="site-footer">
    <div class="container">
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            <nav class="footer-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer', // You can define a footer menu in functions.php
                    'menu_id'        => 'footer-menu',
                ));
                ?>
            </nav><!-- .footer-navigation -->
        </div><!-- .footer-content -->
    </div><!-- .container -->
</footer><!-- #site-footer -->

<?php wp_footer(); // Hook for enqueueing scripts and closing HTML ?>
</body>
</html>
