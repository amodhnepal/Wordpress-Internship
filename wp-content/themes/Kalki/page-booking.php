<?php
/* Template Name: Booking Page */
get_header();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_booking'])) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'appointments';

    // Sanitize input
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $date = sanitize_text_field($_POST['date']);
    $time = sanitize_text_field($_POST['time']);
    $service = sanitize_text_field($_POST['service']);

    // Insert into database
    $wpdb->insert($table_name, [
        'name'    => $name,
        'email'   => $email,
        'phone'   => $phone,
        'date'    => $date,
        'time'    => $time,
        'service' => $service,
        'status'  => 'Pending'
    ]);

    // Get the last inserted appointment ID
    $appointment_id = $wpdb->insert_id;

    // Get confirmation page URL dynamically
    $confirmation_page = get_permalink(get_page_by_path('confirmation'));

    if ($confirmation_page) {
        $confirmation_url = add_query_arg([
            'name'  => urlencode($name),
            'email' => urlencode($email),
        ], $confirmation_page);

        // Redirect to confirmation page
        wp_redirect($confirmation_url);
        exit;
    } else {
        echo "<script>alert('Error: Confirmation page not found!');</script>";
    }
}
?>

<div class="container-book">
    <?php   
    // Query to get the post with category 'booking' and the name 'Book Now'
    $booking = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 1,
        'category_name' => 'booking', 
        'title' => 'Book Now',
    ));

    if ($booking->have_posts()) :
        while ($booking->have_posts()) : $booking->the_post();
    ?>
        <div class="book-container">
            <div class="book-content">
                <h1 class="book-title"><?php the_title(); ?></h1>
                <div class="content-main">
                    <div class="content-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="book-image">
                        <?php endif; ?>
                    </div>
                    <div class="content-text">
                        <div class="post-content"><?php the_content(); ?></div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="book-appointment">
                <h2 class="booking-title">Book an Appointment</h2>
                <form method="post" action="" class="appointment-form">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="text" id="phone" name="phone" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="date">Select Date:</label>
                        <input type="date" id="date" name="date" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="time">Select Time:</label>
                        <input type="time" id="time" name="time" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="service">Select Service:</label>
                        <select id="service" name="service" class="form-input" required>
                            <option value="Consultation">Consultation</option>
                            <option value="Support Call">Support Call</option>
                            <option value="Development Meeting">Development Meeting</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit_booking" value="Book Now" class="form-submit">
                    </div>
                </form>
            </div>
        </div>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</div>

<?php get_footer(); ?>
