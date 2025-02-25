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




// Register Appointment Custom Post Type
// Register Custom Post Type (CPT) for Appointments
function register_appointment_cpt() {
    $labels = [
        'name'          => 'Appointments',
        'singular_name' => 'Appointment',
        'menu_name'     => 'Appointments',
        'add_new'       => 'Add Appointment',
        'add_new_item'  => 'Add New Appointment',
        'edit_item'     => 'Edit Appointment',
        'new_item'      => 'New Appointment',
        'view_item'     => 'View Appointment',
        'all_items'     => 'All Appointments'
    ];

    $args = [
        'labels'       => $labels,
        'public'       => true,
        'has_archive'  => true,
        'show_ui'      => true,
        'menu_icon'    => 'dashicons-calendar-alt',
        'supports'     => ['title', 'custom-fields'],
        'rewrite'      => ['slug' => 'appointments'],
    ];

    register_post_type('appointment', $args);
}
add_action('init', 'register_appointment_cpt');

// Sync Plugin Data to CPT Without Overwriting Manual Changes
function sync_appointments_to_cpt() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'appointments';
    $appointments = $wpdb->get_results("SELECT * FROM $table_name");

    foreach ($appointments as $appointment) {
        // Check if an existing post for this appointment exists
        $existing_post = get_posts([
            'post_type'  => 'appointment',
            'meta_key'   => '_appointment_id',
            'meta_value' => $appointment->id,
            'numberposts'=> 1
        ]);

        if ($existing_post) {
            $post_id = $existing_post[0]->ID;

            // Only update fields if they haven’t been manually edited
            if (!get_post_meta($post_id, '_is_manual_edit', true)) {
                update_post_meta($post_id, '_appointment_date', $appointment->date);
                update_post_meta($post_id, '_appointment_time', $appointment->time);
                update_post_meta($post_id, '_appointment_service', $appointment->service);
                update_post_meta($post_id, '_appointment_status', $appointment->status);
            }
        } else {
            // Insert new appointment post
            $post_id = wp_insert_post([
                'post_title'   => sanitize_text_field($appointment->name . ' - ' . $appointment->date),
                'post_status'  => 'publish',
                'post_type'    => 'appointment',
            ]);

            if ($post_id) {
                update_post_meta($post_id, '_appointment_id', $appointment->id);
                update_post_meta($post_id, '_appointment_date', $appointment->date);
                update_post_meta($post_id, '_appointment_time', $appointment->time);
                update_post_meta($post_id, '_appointment_service', $appointment->service);
                update_post_meta($post_id, '_appointment_status', $appointment->status);
            }
        }
    }
}
add_action('init', 'sync_appointments_to_cpt');

// Add Meta Box for Appointment Details
function add_appointment_meta_boxes() {
    add_meta_box(
        'appointment_details',
        'Appointment Details',
        'render_appointment_meta_box',
        'appointment',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_appointment_meta_boxes');

// Render Appointment Meta Box with Dropdowns and Inline CSS
function render_appointment_meta_box($post) {
    $date    = get_post_meta($post->ID, '_appointment_date', true);
    $time    = get_post_meta($post->ID, '_appointment_time', true);
    $service = get_post_meta($post->ID, '_appointment_service', true);
    $status  = get_post_meta($post->ID, '_appointment_status', true);

    // Define dropdown options (modify these based on your plugin's options)
    $services = ['Consultation', 'Service Call', 'Development Meeting'];
    $statuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];

    ?>
    <style>
        .appointment-meta-box label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        .appointment-meta-box input,
        .appointment-meta-box select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 5px;
        }
    </style>
    <div class="appointment-meta-box">
        <label for="appointment_date">Date:</label>
        <input type="date" name="appointment_date" value="<?php echo esc_attr($date); ?>" />

        <label for="appointment_time">Time:</label>
        <input type="time" name="appointment_time" value="<?php echo esc_attr($time); ?>" />

        <label for="appointment_service">Service:</label>
        <select name="appointment_service">
            <?php foreach ($services as $option) : ?>
                <option value="<?php echo esc_attr($option); ?>" <?php selected($service, $option); ?>>
                    <?php echo esc_html($option); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="appointment_status">Status:</label>
        <select name="appointment_status">
            <?php foreach ($statuses as $option) : ?>
                <option value="<?php echo esc_attr($option); ?>" <?php selected($status, $option); ?>>
                    <?php echo esc_html($option); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php
}

// Save Meta Box Data and Mark as Manually Edited
function save_appointment_meta_box_data($post_id) {
    if (array_key_exists('appointment_date', $_POST)) {
        update_post_meta($post_id, '_appointment_date', sanitize_text_field($_POST['appointment_date']));
    }
    if (array_key_exists('appointment_time', $_POST)) {
        update_post_meta($post_id, '_appointment_time', sanitize_text_field($_POST['appointment_time']));
    }
    if (array_key_exists('appointment_service', $_POST)) {
        update_post_meta($post_id, '_appointment_service', sanitize_text_field($_POST['appointment_service']));
    }
    if (array_key_exists('appointment_status', $_POST)) {
        update_post_meta($post_id, '_appointment_status', sanitize_text_field($_POST['appointment_status']));
    }

    // Mark this post as manually edited
    update_post_meta($post_id, '_is_manual_edit', true);
}
add_action('save_post', 'save_appointment_meta_box_data');


?>