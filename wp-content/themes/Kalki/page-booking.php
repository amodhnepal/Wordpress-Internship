<?php
/* Template Name: Booking Page */
get_header();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_booking'])) {
    // Sanitize form data
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $date = sanitize_text_field($_POST['date']);
    $time = sanitize_text_field($_POST['time']);
    $service = sanitize_text_field($_POST['service']);

    // Prepare new appointment post data
    $appointment_data = array(
        'post_title'   => 'Appointment on ' . $date . ' at ' . $time,
        'post_content' => 'Service: ' . $service . '<br>Name: ' . $name . '<br>Phone: ' . $phone,
        'post_type'    => 'appointment',
        'post_status'  => 'publish', // Change to 'pending' if admin approval is needed
        'meta_input'   => array(
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
            'date'    => $date,
            'time'    => $time,
            'service' => $service,
        ),
    );

    // Insert the new appointment post into the database
    $post_id = wp_insert_post($appointment_data);

    // Check if the appointment post was created successfully
    if ($post_id) {
        echo '<p>Appointment successfully booked!</p>';
    } else {
        echo '<p>Error booking the appointment. Please try again.</p>';
    }
}
?>

<div class="booking-section">
    <div class="booking-image">
        <h2>Book an Appointment</h2>
        <img src="<?php the_post_thumbnail_url('large') ?>" alt="">
    </div>
    <div class="app-container">
        <div class="app-content">
            <form class="app-form" method="post" action="">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" required>
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date" required>
                <label for="time">Select Time:</label>
                <input type="time" id="time" required name="time">
                <label for="service">Select Service:</label>
                <select id="service" name="service" required>
                    <option value="Consultation">Consultation</option>
                    <option value="Support Call">Support Call</option>
                    <option value="Development Meeting">Development Meeting</option>
                </select>
                <input type="submit" name="submit_booking" value="Book Now">
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>
