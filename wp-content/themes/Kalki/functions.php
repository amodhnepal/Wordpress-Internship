<?php
function kalki_theme_styles() {
    wp_enqueue_script('slider-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), false, true);
    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), null, 'all');
   
    // Enqueue custom styles
    wp_enqueue_style('kalki-starter-style', get_template_directory_uri() . '/assets/css/starter-style.css', array(), '1.0.0');

}
add_action('wp_enqueue_scripts', 'kalki_theme_styles');






add_action('category_add_form_fields', 'zAddTexonomyField_custom');
// Add image field in add form
function zAddTexonomyField_custom() {
    wp_enqueue_media();
    ?>
    <div class="form-field">
        <input type="hidden" name="zci_taxonomy_image_id" id="zci_taxonomy_image_id" value="" />
        <label for="zci_taxonomy_image"><?php _e('Image', 'categories-images'); ?></label>
        <input type="text" name="zci_taxonomy_image" id="zci_taxonomy_image" value="" />
        <br/>
        <button class="z_upload_image_button button"><?php _e('Upload/Add image', 'categories-images'); ?></button>
    </div>
    <?php
}

add_action('category_edit_form_fields', 'zEditTexonomyField');
// Add image field in edit form
function zEditTexonomyField($taxonomy) {
    if (get_bloginfo('version') >= 3.5) {
        wp_enqueue_media();
    }

    // Retrieve stored image ID
    $image_id = get_term_meta($taxonomy->term_id, 'zci_taxonomy_image_id', true);
    $image_url = $image_id ? wp_get_attachment_url($image_id) : '';

    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="zci_taxonomy_image"><?php _e('Image', 'categories-images'); ?></label>
        </th>
        <td>
            <input type="hidden" name="zci_taxonomy_image_id" id="zci_taxonomy_image_id" value="<?php echo esc_attr($image_id); ?>" />
            <img class="zci-taxonomy-image" src="<?php echo esc_url($image_url); ?>" style="max-width: 150px; height: auto;" /><br/>
            <input type="text" name="zci_taxonomy_image" id="zci_taxonomy_image" value="<?php echo esc_url($image_url); ?>" /><br />
            <button class="z_upload_image_button button"><?php _e('Upload/Add image', 'categories-images'); ?></button>
            <button class="z_remove_image_button button"><?php _e('Remove image', 'categories-images'); ?></button>
        </td>
    </tr>
    <?php
}



// footer registration

function register_footer_menu() {
    register_nav_menu('footer_menu', __('Footer Menu'));
}
add_action('init', 'register_footer_menu');