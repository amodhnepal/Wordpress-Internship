<?php
function kalki_theme_styles() {
    // Enqueue Swiper.js CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');

    // Enqueue Swiper.js JavaScript
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);

    // Enqueue custom slider script (with Swiper.js as dependency)
    wp_enqueue_script('slider-script', get_template_directory_uri() . '/assets/js/script.js', array('swiper-js'), null, true);

    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), null, 'all');

    // Enqueue custom styles
    wp_enqueue_style('kalki-starter-style', get_template_directory_uri() . '/assets/css/starter-style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'kalki_theme_styles');



// For logo
function theme_setup() {
    add_theme_support('custom-logo'); // Enables logo upload via WordPress Customizer
}
add_action('after_setup_theme', 'theme_setup');


function register_kalki_menus() {
    register_nav_menus(array(
        'kalki_menu' => __('Main Navigation Menu', 'kalki') // Menu slug must match
    ));
}
add_action('after_setup_theme', 'register_kalki_menus');




add_action('admin_enqueue_scripts','kalki_admin_style');
function kalki_admin_style(){
    wp_enqueue_script('custom-catagory-js', get_template_directory_uri() . '/assets/js/admin_js.js', array('jquery'), null, true);
}
add_action('category_add_form_fields', 'zAddTexonomyField_custom');
function zAddTexonomyField_custom() {
    wp_enqueue_media();
    echo '<div class="form-field">
        <input type="hidden" name="zci_taxonomy_image_id" id="zci_taxonomy_image_id" value="" />
        <label for="zci_taxonomy_image">' . __('Image', 'categories-images') . '</label>
        <input type="text" name="zci_taxonomy_image" id="zci_taxonomy_image" value="" />
        <br/>
        <button class="z_upload_image_button button">' . __('Upload/Add image', 'categories-images') . '</button>
    </div>';
}
add_action('category_edit_form_fields', 'zEditTexonomyField_custom');
function zEditTexonomyField_custom($taxonomy) {
    wp_enqueue_media();
    $image_url = get_option('z_taxonomy_image' . $taxonomy->term_id, '');
    $image_id  = get_option('z_taxonomy_image_id' . $taxonomy->term_id, '');
    echo '<tr class="form-field">
        <th scope="row" valign="top"><label for="zci_taxonomy_image">' . __('Image', 'categories-images') . '</label></th>
        <td><input type="hidden" name="zci_taxonomy_image_id" id="zci_taxonomy_image_id" value="'.esc_attr($image_id).'" />
        <img class="zci-taxonomy-image" src="' . esc_url($image_url) . '"/><br/>
        <input type="text" name="zci_taxonomy_image" id="zci_taxonomy_image" value="'.esc_url($image_url).'" /><br />
        <button class="z_upload_image_button button">' . __('Upload/Add image', 'categories-images') . '</button>
        <button class="z_remove_image_button button">' . __('Remove image', 'categories-images') . '</button>
        </td>
    </tr>';
}
function zSaveTaxonomyImage($term_id) {
    if (isset($_POST['zci_taxonomy_image'])) {
        update_option('z_taxonomy_image'.$term_id, $_POST['zci_taxonomy_image'], false);
    }
    if (isset($_POST['zci_taxonomy_image_id'])) {
        update_option('z_taxonomy_image_id'.$term_id, $_POST['zci_taxonomy_image_id'], false);
    }
}
add_action('edited_category', 'zSaveTaxonomyImage', 10, 2);
add_action('create_category', 'zSaveTaxonomyImage', 10, 2);
function zGetAttachmentIdByUrl($image_src) {
    global $wpdb;
    $query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src);
    $id = $wpdb->get_var($query);
    return (!empty($id)) ? $id : NULL;
}

// CPT recent post

function register_recent_posts_cpt() {
    // Register the Recent Posts Custom Post Type
    $args = array(
        'label'               => 'Recent Posts', 
        'description'         => 'Post type for recent posts',
        'public'              => true, 
        'show_ui'             => true, 
        'show_in_menu'        => true, 
        'query_var'           => true, 
        'rewrite'             => array('slug' => 'recent-posts'), // Custom URL slug
        'capability_type'     => 'post',
        'has_archive'         => true, 
        'hierarchical'        => false, 
        'show_in_rest'        => true, 
        'menu_icon'           => 'dashicons-admin-post', 
        'taxonomies'          => array('category'), 
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'), // Enable necessary features including thumbnail (featured image)
    );
    
    // Register the custom post type
    register_post_type('recent_posts', $args);
}

add_action('init', 'register_recent_posts_cpt');
function redirect_custom_post_type_to_single_post($template) {
    // Check if it's a single post of the 'recent_posts' custom post type
    if (is_singular('recent_posts')) {
        // Force it to use single-post.php
        $template = get_template_directory() . '/single-post.php';
    }
    return $template;
}
add_filter('template_include', 'redirect_custom_post_type_to_single_post');


add_theme_support('post-thumbnails'); // Enable featured images for posts

// footer registration

?>
