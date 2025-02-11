<?php
function kalki_theme_styles() {
    wp_enqueue_script('slider-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), null, true);
    // Enqueue Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), null, 'all');
   
    // Enqueue custom styles
    wp_enqueue_style('kalki-starter-style', get_template_directory_uri() . '/assets/css/starter-style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'kalki_theme_styles');
add_theme_support('post-thumbnails');


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




// footer registration





// Register footer settings in the WordPress admin
function register_footer_settings() {
    add_option('footer_logo', ''); // Footer logo URL
    add_option('footer_address', ''); // Footer address
    add_option('footer_facebook', ''); // Facebook link
    add_option('footer_twitter', ''); // Twitter link
    add_option('footer_linkedin', ''); // LinkedIn link
    register_setting('footer_settings_group', 'footer_logo');
    register_setting('footer_settings_group', 'footer_address');
    register_setting('footer_settings_group', 'footer_facebook');
    register_setting('footer_settings_group', 'footer_twitter');
    register_setting('footer_settings_group', 'footer_linkedin');
}
add_action('admin_init', 'register_footer_settings');

// Add footer settings page to WordPress admin menu
function footer_settings_page() {
    add_menu_page(
        'Footer Settings',        // Page title
        'Footer Settings',        // Menu title
        'manage_options',         // Capability required
        'footer-settings',        // Menu slug
        'footer_settings_page_callback'  // Callback function to render the settings page
    );
}
add_action('admin_menu', 'footer_settings_page');

// Footer settings page callback function
function footer_settings_page_callback() {
    ?>
    <div class="wrap">
        <h1>Footer Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('footer_settings_group'); ?>
            <?php do_settings_sections('footer_settings_group'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="footer_logo">Footer Logo URL</label></th>
                    <td><input type="text" name="footer_logo" id="footer_logo" value="<?php echo esc_url(get_option('footer_logo')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="footer_address">Footer Address</label></th>
                    <td><textarea name="footer_address" id="footer_address" rows="4" class="large-text"><?php echo esc_textarea(get_option('footer_address')); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="footer_facebook">Facebook URL</label></th>
                    <td><input type="url" name="footer_facebook" id="footer_facebook" value="<?php echo esc_url(get_option('footer_facebook')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="footer_twitter">Twitter URL</label></th>
                    <td><input type="url" name="footer_twitter" id="footer_twitter" value="<?php echo esc_url(get_option('footer_twitter')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="footer_linkedin">LinkedIn URL</label></th>
                    <td><input type="url" name="footer_linkedin" id="footer_linkedin" value="<?php echo esc_url(get_option('footer_linkedin')); ?>" class="regular-text"></td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>
