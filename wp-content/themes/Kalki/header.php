<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); // Properly includes necessary styles, scripts, and other metadata ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
    <?php if (is_front_page() || is_home()) : ?>
        <!-- Banner Section for Front Page or Blog -->
        <section class="banner-section">
            <?php 
            // Dynamically fetch the banner image
            $banner_image = get_template_directory_uri() . '/assets/img/banner.png'; 
            ?>
            <img src="<?php echo esc_url($banner_image); ?>" alt="Banner Image" class="banner-image">
            <div class="banner-content">
                <div class="rectangle">
                    <h1>Automate<br><span class="bold">Workflow</span> With Us</h1>
                    <a href="#" class="btn">VIEW MORE</a>
                </div>
            </div>
        </section>
    <?php endif; ?>

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
