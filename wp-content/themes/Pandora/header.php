<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="top-bar">
    <div class="container">
        <!-- Logo on the left -->
        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/pandora.png" alt="Pandora Logo">
            </a>
        </div>

        <!-- Menu on the right -->
        <nav class="main-menu">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary_menu',
                'container' => false,
                'menu_class' => 'menu-items',
                'walker' => new Custom_Walker_Nav_Menu()
            ]);
            ?>
        </nav>

        <!-- Icons (Optional) -->
        <div class="icons">
            <a href="#"><i class="fas fa-user"></i></a>
            <a href="#"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>
</header>

<?php
// Display the featured image in the header section if it exists.
if (is_singular() && has_post_thumbnail()) : // Check if it's a single post or page with a featured image.
    ?>
    <div class="featured-image">
        <?php the_post_thumbnail('full'); // You can replace 'full' with other image sizes like 'medium', 'large' ?>
    </div>
<?php endif; ?>
