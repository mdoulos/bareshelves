<?php defined( 'ABSPATH' ) || exit; ?>
<footer class="site-footer">
    <div class="site-width-centered site-footer__inner">
        <?php
            wp_nav_menu( array( 'theme_location' => 'footer-navigation' ) );
        ?>
        <div class="site-footer__copy">
            <p>&copy; <?php echo date('Y'); ?> Bareshelves. All Rights Reserved.</p>
        </div>
    </div>
</footer>