<?php
function kalki_theme_styles() {
    wp_enqueue_script('slider-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), false, true);
    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), null, 'all');

    // Enqueue custom styles
    wp_enqueue_style('kalki-starter-style', get_template_directory_uri() . '/assets/css/starter-style.css', array(), '1.0.0');

}
add_action('wp_enqueue_scripts', 'kalki_theme_styles');
