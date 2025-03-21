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
        <?php if (is_user_logged_in()): 
    $current_user = wp_get_current_user();
?>
    <div class="user-info">
        <p>Welcome, <?php echo esc_html($current_user->display_name); ?>!</p>
        <a href="<?php echo wc_get_account_endpoint_url('orders'); ?>">View Orders</a>
        <a href="<?php echo wc_get_account_endpoint_url('edit-account'); ?>">Edit Profile</a>
        <a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a>
    </div>
<?php else: ?>
    <a href="<?php echo wc_get_page_permalink('myaccount'); ?>">Login / Register</a>
<?php endif; ?>

    </nav>
</header>
