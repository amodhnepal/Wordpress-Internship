<?php
function kalki_theme_styles() {

    wp_enqueue_style('kalki-starter-style', get_template_directory_uri() . '/assets/css/starter-style.css',[],'1.0.0',);
}
add_action('wp_enqueue_scripts', 'kalki_theme_styles');