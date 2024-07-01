<?php defined( 'ABSPATH' ) || exit; ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'bareshelves' ); ?></a>

<header id="masthead" class="site-header">
    <div class="site-header__inner flex-row site-width-centered">

        <!-- Logo -->
        <div class="site-branding">
            <a href="" class="header-logo-link" rel="home" aria-current="page">
                <picture class="header-logo">
                    <?php 
                    if (function_exists('the_custom_logo')) {
                        the_custom_logo();
                    }
                    ?>
                </picture>
            </a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="desktop-nav" id="desktop-nav" aria-label="desktop-navigation">
            <div class="desktop-menu-container">
                <?php
                    wp_nav_menu( array( 'theme_location' => 'desktop-navigation' ) );
                ?>
            </div>
        </nav>

        <!-- Mobile Navigation -->
        <nav class="mobile-nav" id="mobile-nav" aria-label="mobile-navigation">
            <div class="mobile-menu-container">
                <?php
                    wp_nav_menu( array( 'theme_location' => 'mobile-navigation' ) );
                ?>
            </div>
        </nav>

        <!-- Hamburger Button -->
        <div class="hamburger-btn">
            <div class="hamburger-wrapper">
                <input type="checkbox" id="checkboxham" class="checkboxham" onclick="hamburgerBtnClick('mobile-nav');">
                <label for="checkboxham">
                    <div class="hamburger-menu">
                        <span class="bar bar1"></span>
                        <span class="bar bar2"></span>
                        <span class="bar bar3"></span>
                        <span class="bar bar4"></span>
                        <span class="screen-only">Menu</span>
                    </div>
                </label>
            </div>
        </div>

    </div>
</header>