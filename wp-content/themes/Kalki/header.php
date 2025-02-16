<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); // Properly includes necessary styles, scripts, and other metadata ?>
</head>
<body <?php body_class(); ?>>
    <!-- Navigation Menu -->
    <nav class="main-nav">
        <div class="nav-container">
            <div class="logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php if (function_exists('the_custom_logo')) the_custom_logo(); ?>
                </a>
            </div>
            <?php
            // Ensure the menu is registered and exists
            wp_nav_menu([
                'theme_location' => 'kalki_menu', 
                'menu_class' => 'nav-menu', 
                'container' => false,
                'fallback_cb' => false, // Prevent fallback if menu doesn't exist
            ]);
            ?>
        </div>
    </nav>
</header>
