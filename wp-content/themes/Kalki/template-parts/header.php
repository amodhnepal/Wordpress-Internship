<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); // Properly includes necessary styles, scripts, and other metadata ?>
</head>
<body <?php body_class(); ?>>

    <?php if (is_front_page() || is_home()) : ?>
        <!-- Banner Section (Only for Front Page or Blog Page) -->
        <section class="banner-section">
            <?php
            $banner_image = get_template_directory_uri() . '/assets/img/banner-mask.png';
            ?>
            <img src="<?php echo esc_url($banner_image); ?>" alt="Banner Image" class="banner-image">

            <!-- Add Vector Images -->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/upper-banner-long-vector.png" alt="Vector 1" class="banner-vector top-right vector1">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/upper-banner-smaller-vector.png" alt="Vector 2" class="banner-vector top-right vector2">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner-bottom-vector.png" alt="Vector 3" class="banner-vector start-from-logo vector3">

            <div class="banner-content">
                <div class="rectangle">
                    <h1>Automate<br><span class="bold">Workflow</span> With Us</h1>
                    <a href="#" class="btn">VIEW MORE</a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Navigation Menu (Visible on All Pages) -->
    <nav class="main-nav">
        <div class="nav-container">
            <div class="logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php if (function_exists('the_custom_logo')) the_custom_logo(); ?>
                </a>
            </div>
            <?php
            // Display the navigation menu
            wp_nav_menu([
                'theme_location' => 'kalki_menu',
                'menu_class' => 'nav-menu',
                'container' => false, // Avoid extra divs
                'fallback_cb' => false, // Prevent fallback if menu doesn't exist
            ]);
            ?>
        </div>
    </nav>
