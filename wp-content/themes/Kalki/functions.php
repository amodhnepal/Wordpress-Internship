<?php
// Enqueue Styles and Scripts
function kalki_theme_assets() {
    // Swiper.js
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11.0.0');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0.0', true);

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', [], null);
    wp_localize_script('jquery', 'ajax_object', ['ajax_url' => admin_url('admin-ajax.php')]);

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

// Register Custom Post Type for Appointments
// Register Appointment Custom Post Type
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

// Add Custom Columns in Admin List View
function add_appointment_columns($columns) {
    $columns['service'] = 'Service';
    $columns['email']   = 'Email';
    $columns['status']  = 'Status';
    return $columns;
}
add_filter('manage_appointment_posts_columns', 'add_appointment_columns');

// Populate Custom Columns in Admin List
function populate_appointment_columns($column, $post_id) {
    switch ($column) {
        case 'service':
            echo esc_html(get_post_meta($post_id, '_appointment_service', true) ?: '—');
            break;
        case 'email':
            echo esc_html(get_post_meta($post_id, '_appointment_email', true) ?: '—');
            break;
        case 'status':
            echo esc_html(get_post_meta($post_id, '_appointment_status', true) ?: '—');
            break;
    }
}
add_action('manage_appointment_posts_custom_column', 'populate_appointment_columns', 10, 2);

// Sync Appointments from Custom Table to CPT
function sync_appointments_to_cpt() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'appointments';
    $appointments = $wpdb->get_results("SELECT * FROM $table_name");
    foreach ($appointments as $appointment) {
        $existing_post = get_posts([
            'post_type'   => 'appointment',
            'meta_query'  => [
                [
                    'key'   => '_appointment_id',
                    'value' => $appointment->id,
                ]
            ],
            'numberposts' => 1
        ]);
        if (empty($existing_post)) {
            $post_id = wp_insert_post([
                'post_title'  => sanitize_text_field($appointment->name), // Only name, no date
                'post_status' => 'publish',
                'post_type'   => 'appointment',
            ]);
            if ($post_id) {
                update_post_meta($post_id, '_appointment_id', $appointment->id);
                update_post_meta($post_id, '_appointment_date', $appointment->date);
                update_post_meta($post_id, '_appointment_time', $appointment->time);
                update_post_meta($post_id, '_appointment_service', $appointment->service);
                update_post_meta($post_id, '_appointment_email', $appointment->email);
                update_post_meta($post_id, '_appointment_status', $appointment->status);
            }
        }
    }
}
add_action('wp_loaded', 'sync_appointments_to_cpt');

// Add Meta Box for Appointment Details
// Add Meta Box for Appointment Details with Send Email Button
function add_appointment_meta_boxes() {
    add_meta_box('appointment_details', 'Appointment Details', 'render_appointment_meta_box', 'appointment', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_appointment_meta_boxes');

function render_appointment_meta_box($post) {
    $date    = get_post_meta($post->ID, '_appointment_date', true);
    $time    = get_post_meta($post->ID, '_appointment_time', true);
    $service = get_post_meta($post->ID, '_appointment_service', true);
    $email   = get_post_meta($post->ID, '_appointment_email', true);
    $status  = get_post_meta($post->ID, '_appointment_status', true);

    // Security nonce
    wp_nonce_field('send_appointment_email', 'send_email_nonce');

    echo '<div style="padding: 15px; background: #F9F9F9; border-radius: 8px;">';
    echo '<label for="_appointment_date"><strong>Date:</strong></label><br>';
    echo '<input type="date" id="_appointment_date" name="_appointment_date" value="' . esc_attr($date) . '" style="width:100%; padding:8px; margin-bottom:10px;" />';
    echo '<label for="_appointment_time"><strong>Time:</strong></label><br>';
    echo '<input type="time" id="_appointment_time" name="_appointment_time" value="' . esc_attr($time) . '" style="width:100%; padding:8px; margin-bottom:10px;" />';
    echo '<label for="_appointment_service"><strong>Service:</strong></label><br>';
    echo '<input type="text" id="_appointment_service" name="_appointment_service" value="' . esc_attr($service) . '" style="width:100%; padding:8px; margin-bottom:10px;" />';
    echo '<label for="_appointment_email"><strong>Email:</strong></label><br>';
    echo '<input type="email" id="_appointment_email" name="_appointment_email" value="' . esc_attr($email) . '" style="width:100%; padding:8px; margin-bottom:10px;" />';
    echo '<label for="_appointment_status"><strong>Status:</strong></label><br>';
    echo '<select id="_appointment_status" name="_appointment_status" style="width:100%; padding:8px; margin-bottom:10px;">';
    $statuses = ['Cancelled', 'Pending', 'Confirmed'];
    foreach ($statuses as $option) {
        $selected = ($status == $option) ? 'selected' : '';
        echo '<option value="' . esc_attr($option) . '" ' . $selected . '>' . esc_html($option) . '</option>';
    }
    echo '</select>';
    echo '<br><br>';

    // Send Email Button
    echo '<button type="button" id="send_appointment_email" class="button button-primary">Send Email</button>';
    echo '<span id="email_status" style="margin-left: 10px;"></span>';

    echo '</div>';

    // JavaScript for handling the button click
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('#send_appointment_email').click(function() {
            var post_id = '<?php echo $post->ID; ?>';
            var data = {
                action: 'send_appointment_email',
                post_id: post_id,
                security: '<?php echo wp_create_nonce("send_appointment_email_nonce"); ?>'
            };

            $.post(ajaxurl, data, function(response) {
                $('#email_status').html(response);
            });
        });
    });
    </script>
    <?php
}

// Add Email Button to Appointment List View// Add Email Button to Appointment List View
function add_send_email_column($columns) {
    $columns['send_email'] = 'Send Email';
    return $columns;
}
add_filter('manage_appointment_posts_columns', 'add_send_email_column');

function populate_send_email_column($column, $post_id) {
    if ($column === 'send_email') {
        $nonce = wp_create_nonce("send_appointment_email_nonce");
        echo '<button class="send-email-button button button-primary" data-post-id="' . esc_attr($post_id) . '" data-nonce="' . esc_attr($nonce) . '">Send Email</button>';
        echo '<span class="email-status" style="margin-left: 10px;"></span>';
    }
}
add_action('manage_appointment_posts_custom_column', 'populate_send_email_column', 10, 2);

// JavaScript for AJAX Email Sending
function enqueue_admin_email_script($hook) {
    if ($hook !== 'edit.php' || get_current_screen()->post_type !== 'appointment') {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('.send-email-button').click(function() {
            var button = $(this);
            var post_id = button.data('post-id');
            var nonce = button.data('nonce');
            var statusElement = button.next('.email-status');

            var data = {
                action: 'send_appointment_email',
                post_id: post_id,
                security: nonce
            };

            statusElement.html('<span style="color:blue;">Sending...</span>');

            $.ajax({
                url: ajaxurl, // Correct WP AJAX URL
                type: 'POST',
                data: data,
                success: function(response) {
                    statusElement.html(response);
                },
                error: function() {
                    statusElement.html('<span style="color:red;">Error sending email.</span>');
                }
            });
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'enqueue_admin_email_script');




// Handle AJAX request to send email
function send_appointment_email() {
    // Verify nonce for security
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'send_appointment_email_nonce')) {
        wp_die('<span style="color:red;">Security check failed.</span>');
    }

    if (!isset($_POST['post_id'])) {
        wp_die('<span style="color:red;">No appointment ID found.</span>');
    }

    $post_id = intval($_POST['post_id']);
    $email   = get_post_meta($post_id, '_appointment_email', true);
    $name    = get_the_title($post_id);
    $date    = get_post_meta($post_id, '_appointment_date', true);
    $time    = get_post_meta($post_id, '_appointment_time', true);
    $service = get_post_meta($post_id, '_appointment_service', true);
    $status  = get_post_meta($post_id, '_appointment_status', true);

    if (!is_email($email)) {
        wp_die('<span style="color:red;">Invalid email address.</span>');
    }

    // Email content
    $subject = "Appointment Confirmation - $service";
    $message = "Hello $name,\n\n";
    $message .= "Your appointment has been scheduled.\n\n";
    $message .= "Service: $service\n";
    $message .= "Date: $date\n";
    $message .= "Time: $time\n";
    $message .= "Status: $status\n\n";
    $message .= "If you have any questions, please contact us.\n\n";
    $message .= "Best regards,\nYour Company Name";

    $headers = ['Content-Type: text/plain; charset=UTF-8', 'From: Your Company <no-reply@yourcompany.com>'];

    // Send email
    $sent = wp_mail($email, $subject, $message, $headers);

    if ($sent) {
        echo '<span style="color:green;">Email Sent Successfully!</span>';
    } else {
        echo '<span style="color:red;">Email Sending Failed!</span>';
    }

    wp_die();
}
add_action('wp_ajax_send_appointment_email', 'send_appointment_email');



// Save Appointment Meta Box Data with Date Restriction
function save_appointment_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['_appointment_date']) && !isset($_POST['_appointment_time']) && !isset($_POST['_appointment_service']) && !isset($_POST['_appointment_email']) && !isset($_POST['_appointment_status'])) return;

    global $wpdb;
    $appointment_id = get_post_meta($post_id, '_appointment_id', true);
    $updated_data = [];

    if (isset($_POST['_appointment_date'])) {
        $updated_date = sanitize_text_field($_POST['_appointment_date']);
        // Restrict date updates to the current month
        $first_day = date('Y-m-01');
        $last_day  = date('Y-m-t');
        if ($updated_date >= $first_day && $updated_date <= $last_day) {
            $updated_data['date'] = $updated_date;
            update_post_meta($post_id, '_appointment_date', $updated_data['date']);
        }
    }
    if (isset($_POST['_appointment_time'])) {
        $updated_data['time'] = sanitize_text_field($_POST['_appointment_time']);
        update_post_meta($post_id, '_appointment_time', $updated_data['time']);
    }
    if (isset($_POST['_appointment_service'])) {
        $updated_data['service'] = sanitize_text_field($_POST['_appointment_service']);
        update_post_meta($post_id, '_appointment_service', $updated_data['service']);
    }
    if (isset($_POST['_appointment_email'])) {
        $updated_data['email'] = sanitize_email($_POST['_appointment_email']);
        update_post_meta($post_id, '_appointment_email', $updated_data['email']);
    }
    if (isset($_POST['_appointment_status'])) {
        $updated_data['status'] = sanitize_text_field($_POST['_appointment_status']);
        update_post_meta($post_id, '_appointment_status', $updated_data['status']);
    }
}
add_action('save_post', 'save_appointment_meta');

function create_counter_post_type() {
    register_post_type('counter',
        array(
            'labels'      => array(
                'name'          => __('Counters', 'Kalki'),
                'singular_name' => __('Counter', 'Kalki'),
            ),
            'public'      => true,
            'has_archive' => false,
            'supports'    => array('title'),
            'menu_icon'   => 'dashicons-chart-line',
        )
    );
}
add_action('init', 'create_counter_post_type');


function counter_meta_boxes() {
    add_meta_box('counter_values', 'Counter Values', 'render_counter_meta_box', 'counter', 'normal', 'high');
}

function render_counter_meta_box($post) {
    // Retrieve existing values
    $projects_completed = get_post_meta($post->ID, 'projects_completed', true);
    $hours_coding = get_post_meta($post->ID, 'hours_coding', true);
    $happy_clients = get_post_meta($post->ID, 'happy_clients', true);
    ?>
    <p>
        <label>Projects Completed:</label>
        <input type="number" name="projects_completed" value="<?php echo esc_attr($projects_completed); ?>" />
    </p>
    <p>
        <label>Hours Coding:</label>
        <input type="number" name="hours_coding" value="<?php echo esc_attr($hours_coding); ?>" />
    </p>
    <p>
        <label>Happy Clients:</label>
        <input type="number" name="happy_clients" value="<?php echo esc_attr($happy_clients); ?>" />
    </p>
    <?php
}

// Save Meta Box Data
function save_counter_meta_box($post_id) {
    if (array_key_exists('projects_completed', $_POST)) {
        update_post_meta($post_id, 'projects_completed', sanitize_text_field($_POST['projects_completed']));
    }
    if (array_key_exists('hours_coding', $_POST)) {
        update_post_meta($post_id, 'hours_coding', sanitize_text_field($_POST['hours_coding']));
    }
    if (array_key_exists('happy_clients', $_POST)) {
        update_post_meta($post_id, 'happy_clients', sanitize_text_field($_POST['happy_clients']));
    }
}

add_action('add_meta_boxes', 'counter_meta_boxes');
add_action('save_post', 'save_counter_meta_box');
function custom_add_to_cart_redirect( $url ) {
    return wc_get_cart_url(); // Redirects to the correct cart page
}
add_filter( 'woocommerce_add_to_cart_redirect', 'custom_add_to_cart_redirect' );


function custom_woocommerce_styles() {
    if (is_wc_endpoint_url('order-received')) { // Only load on Thank You page
        wp_enqueue_style('custom-woocommerce', get_stylesheet_directory_uri() . '/woocommerce/custom-style.css', array(), '1.0', 'all');
    }
}
add_action('wp_enqueue_scripts', 'custom_woocommerce_styles');



function custom_login_redirect($redirect_to, $request, $user) {
    if (!is_wp_error($user) && $user->roles[0] === 'subscriber') {
        return home_url('/dashboard'); // Redirect subscribers to a dashboard
    }
    return $redirect_to;
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

function custom_user_orders() {
    if (!is_user_logged_in()) {
        echo '<p>You must be logged in to view your orders.</p>';
        return;
    }

    $customer_orders = wc_get_orders(array(
        'customer_id' => get_current_user_id(),
        'status' => array('processing', 'completed'),
        'limit' => -1
    ));

    if (!empty($customer_orders)) {
        echo '<h3>Your Orders</h3><ul>';
        foreach ($customer_orders as $order) {
            echo '<li>Order #'. esc_html($order->get_id()) .' - '. esc_html($order->get_status()) .'</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No orders found.</p>';
    }
}
add_shortcode('user_orders', 'custom_user_orders');



function custom_user_appointments() {
    if (!is_user_logged_in()) {
        echo '<p>You must be logged in to view your appointments.</p>';
        return;
    }

    $customer_orders = wc_get_orders(array(
        'customer_id' => get_current_user_id(),
        'status' => array('processing', 'completed'),
        'limit' => -1
    ));

    if (!empty($customer_orders)) {
        echo '<h3>Your Appointments</h3><ul>';
        foreach ($customer_orders as $order) {
            foreach ($order->get_items() as $item) {
                if (strpos(strtolower($item->get_name()), 'appointment') !== false) {
                    echo '<li>Appointment: '. esc_html($item->get_name()) .' on '. esc_html($order->get_date_created()->date('Y-m-d')) .'</li>';
                }
            }
        }
        echo '</ul>';
    } else {
        echo '<p>No appointments found.</p>';
    }
}
add_shortcode('user_appointments', 'custom_user_appointments');



?>


