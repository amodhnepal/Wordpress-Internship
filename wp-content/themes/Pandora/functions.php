<?php
// Theme setup function
function pandora_theme_setup() {
    // Add support for featured images (post thumbnails)
    add_theme_support('post-thumbnails');

    // Add support for automatic title tag
    add_theme_support('title-tag');

    // Register navigation menus
    register_nav_menus([
        'primary_menu' => __('Primary Menu', 'pandora'),
    ]);
}
add_action('after_setup_theme', 'pandora_theme_setup');

// Enqueue theme styles and scripts
function pandora_enqueue_assets() {
    wp_enqueue_style('pandora-custom', get_template_directory_uri() . '/assets/css/custom.css');
    wp_enqueue_style('splide-css', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css');
    wp_enqueue_script('splide-js', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js', [], false, true);
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/assets/js/custom.js', ['splide-js'], false, true);
    // Add other stylesheets or scripts if needed
}
add_action('wp_enqueue_scripts', 'pandora_enqueue_assets');

// Register a custom walker class for the menu
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {

    // Start Level
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="sub-menu">';
    }

    // End Level
    function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</ul>';
    }

    // Customize the start of each menu item
    // function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
    //     $classes = empty($item->classes) ? [] : (array) $item->classes;
    //     $classes[] = 'menu-item-' . $item->ID;

    //     // Assuming you want to add an icon/image to each menu item
    //     $image_url = get_template_directory_uri() . '/assets/images/menu-icon.png'; // Path to the image

    //     // Start menu item
    //     $output .= '<li class="' . join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth)) . '">';

    //     // Add image and title inside the menu item link
    //     $output .= '<a href="' . esc_url($item->url) . '">';
    //     $output .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($item->title) . '" class="menu-icon">'; // Image HTML
    //     $output .= $item->title;
    //     $output .= '</a>';
        
    //     // End menu item
    //     $output .= '</li>';
    // }
}



?>
