<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="site-header">
    <div class="nav-header">
        <nav id="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'main_menu',  // The location registered in functions.php
                'container' => false,             // No wrapping container
                'menu_class' => 'main-menu',      // Class for the <ul> tag
            ));
            ?>
        </nav>
    </div>
</header>
