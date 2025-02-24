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

function register_appointment_cpt() {
    $labels = array(
        'name'               => _x('Appointment CPT', 'post type general name'),
        'singular_name'      => _x('Appointment CPT', 'post type singular name'),
        'menu_name'          => _x('Appointments', 'admin menu'),
        'name_admin_bar'     => _x('Appointment CPT', 'add new on admin bar'),
        'add_new'            => _x('Add New', 'appointment'),
        'add_new_item'       => __('Add New Appointment'),
        'new_item'           => __('New Appointment'),
        'edit_item'          => __('Edit Appointment'),
        'view_item'          => __('View Appointment'),
        'all_items'          => __('All Appointments'),
        'search_items'       => __('Search Appointments'),
        'parent_item_colon'  => __('Parent Appointments:'),
        'not_found'          => __('No appointments found.'),
        'not_found_in_trash' => __('No appointments found in Trash.')
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false, // make it non-public if it's for admin use only
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'appointment-cpt'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'supports'           => array('title'),
    );

    register_post_type('appointment_cpt', $args);
}
add_action('init', 'register_appointment_cpt');

function appointment_cpt_add_meta_boxes() {
    add_meta_box(
        'appointment_details',
        __('Appointment Details'),
        'appointment_cpt_render_meta_box',
        'appointment_cpt',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'appointment_cpt_add_meta_boxes');

function appointment_cpt_render_meta_box($post) {
    // Use nonce for verification
    wp_nonce_field('save_appointment_details', 'appointment_details_nonce');

    // Retrieve existing values if any
    $email   = get_post_meta($post->ID, '_appointment_email', true);
    $phone   = get_post_meta($post->ID, '_appointment_phone', true);
    $date    = get_post_meta($post->ID, '_appointment_date', true);
    $time    = get_post_meta($post->ID, '_appointment_time', true);
    $service = get_post_meta($post->ID, '_appointment_service', true);
    $status  = get_post_meta($post->ID, '_appointment_status', true);

    ?>
    <p>
        <label for="appointment_email"><?php _e('Email:'); ?></label>
        <input type="email" id="appointment_email" name="appointment_email" value="<?php echo esc_attr($email); ?>" class="widefat">
    </p>
    <p>
        <label for="appointment_phone"><?php _e('Phone:'); ?></label>
        <input type="text" id="appointment_phone" name="appointment_phone" value="<?php echo esc_attr($phone); ?>" class="widefat">
    </p>
    <p>
        <label for="appointment_date"><?php _e('Date:'); ?></label>
        <input type="date" id="appointment_date" name="appointment_date" value="<?php echo esc_attr($date); ?>" class="widefat">
    </p>
    <p>
        <label for="appointment_time"><?php _e('Time:'); ?></label>
        <input type="time" id="appointment_time" name="appointment_time" value="<?php echo esc_attr($time); ?>" class="widefat">
    </p>
    <p>
        <label for="appointment_service"><?php _e('Service:'); ?></label>
        <select id="appointment_service" name="appointment_service" class="widefat">
            <option value="Consultation" <?php selected($service, 'Consultation'); ?>>Consultation</option>
            <option value="Support Call" <?php selected($service, 'Support Call'); ?>>Support Call</option>
            <option value="Development Meeting" <?php selected($service, 'Development Meeting'); ?>>Development Meeting</option>
        </select>
    </p>
    <p>
        <label for="appointment_status"><?php _e('Status:'); ?></label>
        <select id="appointment_status" name="appointment_status" class="widefat">
            <option value="Pending" <?php selected($status, 'Pending'); ?>>Pending</option>
            <option value="Confirmed" <?php selected($status, 'Confirmed'); ?>>Confirmed</option>
            <option value="Cancelled" <?php selected($status, 'Cancelled'); ?>>Cancelled</option>
        </select>
    </p>
    <?php

}


function appointment_cpt_save_meta_box_data($post_id) {
    // Check if our nonce is set.
    if (!isset($_POST['appointment_details_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['appointment_details_nonce'], 'save_appointment_details')) {
        return;
    }

    // If this is an autosave, do nothing.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'appointment_cpt' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    // Sanitize and save data.
    if (isset($_POST['appointment_email'])) {
        update_post_meta($post_id, '_appointment_email', sanitize_email($_POST['appointment_email']));
    }
    if (isset($_POST['appointment_phone'])) {
        update_post_meta($post_id, '_appointment_phone', sanitize_text_field($_POST['appointment_phone']));
    }
    if (isset($_POST['appointment_date'])) {
        // Validate your date range if needed (example below)
        $date = sanitize_text_field($_POST['appointment_date']);
        if ($date < '2025-01-01' || $date > '2026-12-31') {
            // Optionally, you can add an admin notice if date is invalid.
            return;
        }
        update_post_meta($post_id, '_appointment_date', $date);
    }
    if (isset($_POST['appointment_time'])) {
        update_post_meta($post_id, '_appointment_time', sanitize_text_field($_POST['appointment_time']));
    }
    if (isset($_POST['appointment_service'])) {
        update_post_meta($post_id, '_appointment_service', sanitize_text_field($_POST['appointment_service']));
    }
    if (isset($_POST['appointment_status'])) {
        update_post_meta($post_id, '_appointment_status', sanitize_text_field($_POST['appointment_status']));
    }
}
add_action('save_post', 'appointment_cpt_save_meta_box_data');

function appointment_cpt_manage_columns($columns) {
    $new_columns = array(
        'cb'                 => $columns['cb'],
        'title'              => __('Name'),
        'email'              => __('Email'),
        'phone'              => __('Phone'),
        'date'               => __('Date'),
        'time'               => __('Time'),
        'service'            => __('Service'),
        'status'             => __('Status'),
    );
    return $new_columns;
}
add_filter('manage_appointment_cpt_posts_columns', 'appointment_cpt_manage_columns');

function appointment_cpt_custom_column($column, $post_id) {
    switch ($column) {
        case 'email':
            echo esc_html(get_post_meta($post_id, '_appointment_email', true));
            break;
        case 'phone':
            echo esc_html(get_post_meta($post_id, '_appointment_phone', true));
            break;
        case 'date':
            echo esc_html(get_post_meta($post_id, '_appointment_date', true));
            break;
        case 'time':
            echo esc_html(get_post_meta($post_id, '_appointment_time', true));
            break;
        case 'service':
            echo esc_html(get_post_meta($post_id, '_appointment_service', true));
            break;
        case 'status':
            echo esc_html(get_post_meta($post_id, '_appointment_status', true));
            break;
    }
}
add_action('manage_appointment_cpt_posts_custom_column', 'appointment_cpt_custom_column', 10, 2);

// Enqueue a custom script in the admin area (adjust file path as needed)
function appointment_cpt_admin_scripts() {
    wp_localize_script('appointment-cpt-admin', 'appointmentCPT', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('admin_enqueue_scripts', 'appointment_cpt_admin_scripts');

function appointment_cpt_update_status() {
    if (!isset($_POST['post_id']) || !isset($_POST['status'])) {
        wp_send_json_error('Invalid request');
    }

    $post_id = intval($_POST['post_id']);
    $status = sanitize_text_field($_POST['status']);

    // Update appointment status meta
    update_post_meta($post_id, '_appointment_status', $status);
    wp_send_json_success();
}
add_action('wp_ajax_update_appointment_status', 'appointment_cpt_update_status');


function appointment_cpt_send_booking_email($post_id) {
    // Get appointment meta values
    $name    = get_the_title($post_id);
    $email   = get_post_meta($post_id, '_appointment_email', true);
    $date    = get_post_meta($post_id, '_appointment_date', true);
    $time    = get_post_meta($post_id, '_appointment_time', true);
    $service = get_post_meta($post_id, '_appointment_service', true);
    $status  = get_post_meta($post_id, '_appointment_status', true);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return;
    }

    $subject = "Appointment Notification";
    $message = "Dear $name,\n\nYour appointment details:\nService: $service\nDate: $date\nTime: $time\nStatus: $status\n\nThank you!";
    wp_mail($email, $subject, $message);
}

// Example usage: call after saving if needed
// add_action('save_post_appointment_cpt', 'appointment_cpt_send_booking_email');

?>