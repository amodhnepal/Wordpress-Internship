<?php
// Enqueue styles and scripts
function ecommerce_enqueue_assets() {

    // Enqueue custom CSS from your assets folder (adjust path if needed)
    wp_enqueue_style( 'ecommerce-custom-css', get_template_directory_uri() . '/assets/css/style-starter.css' );
    
    wp_enqueue_style('google-fonts-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap', false, null);
    // Enqueue Swiper CSS (for logo slider)
    wp_enqueue_style('swiper-style', 'https://unpkg.com/swiper/swiper-bundle.min.css');

    // Enqueue Swiper JS (for logo slider)
    wp_enqueue_script('swiper-script', 'https://unpkg.com/swiper/swiper-bundle.min.js', array('jquery'), null, true);

    // Enqueue custom JavaScript file (for general theme functionality)
    wp_enqueue_script( 'ecommerce-custom-js', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'ecommerce_enqueue_assets' );

// Add support for post thumbnails (featured images)
add_theme_support( 'post-thumbnails' );

// Register navigation menu
function my_theme_register_menus() {
    register_nav_menus(
        array(
            'main_menu' => __( 'Main Menu', 'my_theme' )  // Standard menu
        )
    );
}
add_action( 'init', 'my_theme_register_menus' );

// Enqueue custom JS for admin area (for category image upload)
function ecommerce_admin_assets() {
    wp_enqueue_script('custom-category-js', get_template_directory_uri() . '/assets/js/admin-script.js', ['jquery'], null, true);
}
add_action('admin_enqueue_scripts', 'ecommerce_admin_assets');

// Category Image Upload
// Add category image field for both adding and editing categories
function ecommerce_category_image_field($taxonomy) {
    wp_enqueue_media();
    
    // For adding category (no $taxonomy->term_id available yet)
    $image_url = '';
    $image_id  = '';

    if (is_object($taxonomy)) {
        // Editing existing category
        $image_url = get_option('z_taxonomy_image' . $taxonomy->term_id, '');
        $image_id  = get_option('z_taxonomy_image_id' . $taxonomy->term_id, '');
    }

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
add_action('category_edit_form_fields', 'ecommerce_category_image_field');
add_action('category_add_form_fields', 'ecommerce_category_image_field');

// Save category image for both adding and editing categories
function ecommerce_save_category_image($term_id) {
    // Save the category image and its ID if they are set
    if (isset($_POST['zci_taxonomy_image'])) {
        update_option('z_taxonomy_image' . $term_id, esc_url($_POST['zci_taxonomy_image']));
    }
    if (isset($_POST['zci_taxonomy_image_id'])) {
        update_option('z_taxonomy_image_id' . $term_id, esc_attr($_POST['zci_taxonomy_image_id']));
    }
}
add_action('edited_category', 'ecommerce_save_category_image');
add_action('create_category', 'ecommerce_save_category_image');

// Optionally include other files from your inc folder
// require_once get_template_directory() . '/inc/some-file.php';

?>
