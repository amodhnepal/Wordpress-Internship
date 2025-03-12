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
     // Enqueue Splide CSS
     wp_enqueue_style('splide-css', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/css/splide.min.css', array(), null);
    
     // Enqueue Splide JS
     wp_enqueue_script('splide-js', 'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.3/dist/js/splide.min.js', array('jquery'), null, true);

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

function create_testimonial_post_type() {
    register_post_type('testimonials',
        array(
            'labels'      => array(
                'name'          => __('Testimonials'),
                'singular_name' => __('Testimonial'),
            ),
            'public'      => true,
            'has_archive' => false,
            'supports'    => array('title', 'editor', 'thumbnail'),
            'menu_icon'   => 'dashicons-testimonial',
        )
    );
}
add_action('init', 'create_testimonial_post_type');


function testimonial_add_meta_box() {
    add_meta_box(
        'testimonial_star_rating',  // Unique ID
        'Star Rating',              // Box title
        'testimonial_meta_box_callback',  // Callback function
        'testimonials',             // Post type
        'side',                     // Context (where to show)
        'default'                    // Priority
    );
}
add_action('add_meta_boxes', 'testimonial_add_meta_box');

function testimonial_meta_box_callback($post) {
    $rating = get_post_meta($post->ID, '_testimonial_star_rating', true);

    echo '<label for="testimonial_star_rating">Select a Rating (1-5): </label>';
    echo '<select name="testimonial_star_rating" id="testimonial_star_rating">';
    for ($i = 1; $i <= 5; $i++) {
        echo '<option value="' . $i . '" ' . selected($rating, $i, false) . '>' . $i . ' Stars</option>';
    }
    echo '</select>';
}

function display_testimonials() {
    $args = array(
        'post_type'      => 'testimonials',
        'posts_per_page' => 3,
        'orderby'        => 'rand',
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        echo '<div class="testimonials-container">';
        while ($query->have_posts()) {
            $query->the_post();
            $customer_name = get_the_title();
            $testimonial_text = get_the_content();
            $profile_image = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $rating = get_field('star_rating'); // ACF Field for star rating

            echo '<div class="testimonial-box">';
            echo '<div class="testimonial-rating">';
            for ($i = 0; $i < $rating; $i++) {
                echo '<span style="color:gold;">★</span>';
            }
            echo '</div>';
            echo '<p class="testimonial-text">"' . esc_html($testimonial_text) . '"</p>';
            echo '<div class="testimonial-footer">';
            if ($profile_image) {
                echo '<img src="' . esc_url($profile_image) . '" alt="' . esc_attr($customer_name) . '" class="testimonial-img">';
            }
            echo '<span class="testimonial-name">' . esc_html($customer_name) . '</span>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
    wp_reset_postdata();
}


function register_footer_menus_widgets() {
    // Register footer menus
    register_nav_menus([
        'footer_menu_shop'    => __('Footer Menu - Shop'),
        'footer_menu_about'   => __('Footer Menu - About'),
        'footer_menu_help'    => __('Footer Menu - Need Help?'),
    ]);

    // Register Footer Widgets
    register_sidebar([
        'name'          => 'Footer Widget Area',
        'id'            => 'footer_widget',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);
}
add_action('init', 'register_footer_menus_widgets');


function customize_footer_settings($wp_customize) {
    // Footer Section
    $wp_customize->add_section('footer_settings', [
        'title'    => __('Footer Settings'),
        'priority' => 120,
    ]);

    // Secure Payment Text
    $wp_customize->add_setting('secure_payment_text', [
        'default'   => 'Secure Payment',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('secure_payment_text', [
        'label'   => __('Secure Payment Text'),
        'section' => 'footer_settings',
        'type'    => 'text',
    ]);

    // Express Shipping Text
    $wp_customize->add_setting('express_shipping_text', [
        'default'   => 'Express Shipping',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('express_shipping_text', [
        'label'   => __('Express Shipping Text'),
        'section' => 'footer_settings',
        'type'    => 'text',
    ]);

    // Free Return Text
    $wp_customize->add_setting('free_return_text', [
        'default'   => 'Free Return',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('free_return_text', [
        'label'   => __('Free Return Text'),
        'section' => 'footer_settings',
        'type'    => 'text',
    ]);

    // Social Media Links
    $socials = ['instagram', 'pinterest', 'facebook', 'twitter'];
    foreach ($socials as $social) {
        $wp_customize->add_setting("{$social}_link", [
            'default'   => '#',
            'transport' => 'refresh',
        ]);
        $wp_customize->add_control("{$social}_link", [
            'label'   => ucfirst($social) . ' Link',
            'section' => 'footer_settings',
            'type'    => 'url',
        ]);
    }

    // Payment Icons
    $payments = ['stripe', 'paypal', 'amex', 'visa', 'mastercard'];
    foreach ($payments as $payment) {
        $wp_customize->add_setting("{$payment}_icon", [
            'default'   => get_template_directory_uri() . "/images/{$payment}.png",
            'transport' => 'refresh',
        ]);
        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            "{$payment}_icon",
            [
                'label'    => ucfirst($payment) . ' Icon',
                'section'  => 'footer_settings',
                'settings' => "{$payment}_icon",
            ]
        ));
    }
}
add_action('customize_register', 'customize_footer_settings');


function override_woocommerce_template($template) {
    if (is_singular('product')) {
        return get_template_directory() . '/pages/product-details.php';
    }
    return $template;
}
add_filter('template_include', 'override_woocommerce_template');

function override_woocommerce_cart_template($template) {
    if (is_page('cart')) {
        return get_template_directory() . '/pages/cart.php';
    }
    return $template;
}
add_filter('template_include', 'override_woocommerce_cart_template');


add_filter('woocommerce_checkout_fields', 'fix_checkout_fields');

function fix_checkout_fields($fields) {
    if (isset($fields['billing']['billing_country']['options'])) {
        foreach ($fields['billing']['billing_country']['options'] as $key => $value) {
            // Remove any <span> elements inside options
            $fields['billing']['billing_country']['options'][$key] = strip_tags($value);
        }
    }
    return $fields;
}

function create_lookbook_cpt() {
    $args = array(
        'label' => 'Lookbook',
        'public' => true,
        'show_ui' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => false,
        'rewrite' => array('slug' => 'lookbook'),
    );
    register_post_type('lookbook', $args);
}
add_action('init', 'create_lookbook_cpt');





  function add_price_meta_box() {
    add_meta_box(
        'product_price_meta_box',
        'Product Price',
        'render_price_meta_box',
        'product', // Replace with your CPT slug if different
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'add_price_meta_box' );

function render_price_meta_box($post) {
    $price = get_post_meta($post->ID, '_product_price', true);
    ?>
    <label for="product_price">Price ($):</label>
    <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>" style="width: 100%;" />
    <?php
}

function save_price_meta_box($post_id) {
    if (isset($_POST['product_price'])) {
        update_post_meta($post_id, '_product_price', sanitize_text_field($_POST['product_price']));
    }
}
add_action( 'save_post', 'save_price_meta_box' );

// function disable_woocommerce_checkout_styles() {
//     if (is_checkout()) {
//         wp_dequeue_style('woocommerce-general');
//         wp_dequeue_style('woocommerce-layout');
//     }
// }
// add_action('wp_enqueue_scripts', 'disable_woocommerce_checkout_styles', 99);


function custom_checkout_script() {
    if (is_checkout() && !is_wc_endpoint_url('order-received')) {
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var checkoutForm = document.querySelector(".custom-checkout-container");
                if (checkoutForm) {
                    checkoutForm.style.opacity = "1";
                    checkoutForm.style.transform = "scale(1)";
                }
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'custom_checkout_script');
function add_khalti_logo_to_payment_gateway( $available_gateways ) {
    // Check if Khalti is an available payment gateway
    if ( isset($available_gateways['khalti_gateway']) ) {
        // Path to the Khalti logo
        $khalti_logo_url = get_template_directory_uri() . '/assets/img/Khalti.jpg';

        // Append the logo to the payment gateway description
        $available_gateways['khalti_gateway']->description .= '<br><img src="' . esc_url($khalti_logo_url) . '" alt="Khalti Payment Gateway" style="width: 150px; height: auto; margin-top: 10px;"/>';
    }

    return $available_gateways;
}
add_filter('woocommerce_available_payment_gateways', 'add_khalti_logo_to_payment_gateway');

function generate_pdf_invoice() {
    if (!isset($_GET['download_invoice'])) {
        return;
    }

    $order_id = intval($_GET['download_invoice']);
    $order = wc_get_order($order_id);
    if (!$order) {
        wp_die('Invalid Order');
    }

    require_once ABSPATH . 'wp-content/plugins/woocommerce/includes/vendor/dompdf/autoload.inc.php';

    $dompdf = new Dompdf\Dompdf();
    $html = '<h1>Order Invoice</h1>';
    $html .= '<p>Order Number: #' . $order->get_id() . '</p>';
    $html .= '<p>Order Date: ' . wc_format_datetime($order->get_date_created()) . '</p>';
    $html .= '<p>Payment Method: ' . $order->get_payment_method_title() . '</p>';
    $html .= '<h2>Products Purchased</h2><ul>';

    foreach ($order->get_items() as $item_id => $item) {
        $html .= '<li>' . esc_html($item->get_name()) . ' × ' . esc_html($item->get_quantity()) . '</li>';
    }
    $html .= '</ul>';
    $html .= '<p>Total Amount: ' . wc_price($order->get_total()) . '</p>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    header("Content-type: application/pdf");
    header("Content-Disposition: attachment; filename=invoice-" . $order->get_id() . ".pdf");

    echo $dompdf->output();
    exit;
}
add_action('init', 'generate_pdf_invoice');

// Handle AJAX Add to Cart
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart() {
    $product_id = absint($_POST['product_id']);

    if ($product_id && WC()->cart->add_to_cart($product_id)) {
        wp_send_json([
            'success'   => true,
            'cart_count' => WC()->cart->get_cart_contents_count(),
        ]);
    } else {
        wp_send_json(['success' => false]);
    }
    wp_die();
}




?>
