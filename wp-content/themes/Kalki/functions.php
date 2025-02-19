<?php
// Enqueue Styles and Scripts
function kalki_theme_assets() {
    // Swiper.js
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11.0.0');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0.0', true);

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', [], null);

    // Custom Theme Styles & Scripts
    wp_enqueue_style('kalki-style', get_template_directory_uri() . '/assets/css/starter-style.css', [], '1.0.0');
    wp_enqueue_script('kalki-script', get_template_directory_uri() . '/assets/js/script.js', ['swiper-js'], null, true);
}
add_action('wp_enqueue_scripts', 'kalki_theme_assets');

// Theme Support
function kalki_theme_setup() {
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'kalki_menu' => __('Main Navigation Menu', 'kalki'),
    ]);
}
add_action('after_setup_theme', 'kalki_theme_setup');

// Admin Panel Enhancements
function kalki_admin_assets() {
    wp_enqueue_script('custom-category-js', get_template_directory_uri() . '/assets/js/admin_js.js', ['jquery'], null, true);
}
add_action('admin_enqueue_scripts', 'kalki_admin_assets');

// Category Image Upload
function kalki_category_image_field($taxonomy) {
    wp_enqueue_media();
    $image_url = get_option('z_taxonomy_image' . $taxonomy->term_id, '');
    $image_id  = get_option('z_taxonomy_image_id' . $taxonomy->term_id, '');

    echo '<tr class="form-field">
        <th scope="row"><label for="zci_taxonomy_image">' . __('Category Image', 'categories-images') . '</label></th>
        <td>
            <input type="hidden" name="zci_taxonomy_image_id" id="zci_taxonomy_image_id" value="'.esc_attr($image_id).'" />
            <img class="zci-taxonomy-image" src="' . esc_url($image_url) . '" style="max-width:100px;"/><br/>
            <input type="text" name="zci_taxonomy_image" id="zci_taxonomy_image" value="'.esc_url($image_url).'" />
            <br/>
            <button class="z_upload_image_button button">' . __('Upload/Add Image', 'categories-images') . '</button>
            <button class="z_remove_image_button button">' . __('Remove Image', 'categories-images') . '</button>
        </td>
    </tr>';
}
add_action('category_edit_form_fields', 'kalki_category_image_field');
add_action('category_add_form_fields', 'kalki_category_image_field');

function kalki_save_category_image($term_id) {
    if (isset($_POST['zci_taxonomy_image'])) {
        update_option('z_taxonomy_image' . $term_id, esc_url($_POST['zci_taxonomy_image']));
    }
    if (isset($_POST['zci_taxonomy_image_id'])) {
        update_option('z_taxonomy_image_id' . $term_id, esc_attr($_POST['zci_taxonomy_image_id']));
    }
}
add_action('edited_category', 'kalki_save_category_image');
add_action('create_category', 'kalki_save_category_image');

// Helper Function to Retrieve Attachment ID by URL
function kalki_get_attachment_id_by_url($image_src) {
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src));
}

// Custom Post Type: Recent Posts
function register_recent_posts_cpt() {
    register_post_type('recent_posts', [
        'label'           => 'Recent Posts',
        'public'          => true,
        'show_ui'         => true,
        'menu_icon'       => 'dashicons-admin-post',
        'has_archive'     => true,
        'show_in_rest'    => true,
        'hierarchical'    => false,
        'supports'        => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'taxonomies'      => ['category'],
        'rewrite'         => ['slug' => 'recent-posts'],
    ]);
}
add_action('init', 'register_recent_posts_cpt');

// Redirect Recent Posts CPT to Single Post Template
function recent_posts_single_template($template) {
    if (is_singular('recent_posts')) {
        return get_template_directory() . '/single-post.php';
    }
    return $template;
}
add_filter('template_include', 'recent_posts_single_template');


    ?>