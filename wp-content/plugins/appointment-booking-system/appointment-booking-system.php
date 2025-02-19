<?php
/**
 * Plugin Name: Appointment Booking System
 * Plugin URI: https://wordpress.test/plugins/appointment-booking-system/
 * Description: A custom WordPress plugin for managing appointments.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://wordpress.test/appointment-booking-system/
 * License: GPL2
 */
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
// Register Admin Menu
function register_booking_menu() {
    add_menu_page(
        'Appointments',
        'Appointments',
        'manage_options',
        'booking_system',
        'show_bookings',
        'dashicons-calendar-alt',
        20
    );
}
add_action('admin_menu', 'register_booking_menu');
// Show Bookings in Admin Panel
function show_bookings() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'appointments';
    $appointments = $wpdb->get_results("SELECT * FROM $table_name");
    echo "<h2>Appointments</h2>";
    // Show notifications
    if (isset($_GET['updated'])) {
        echo "<div class='updated'><p>Appointment Updated Successfully!</p></div>";
    }
    if (isset($_GET['email_sent'])) {
        echo "<div class='updated'><p>Email Notification Sent!</p></div>";
    }
    echo "<table class='widefat'>";
    echo "<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date</th>
            <th>Time</th>
            <th>Service</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>";
    foreach ($appointments as $appointment) {
        echo "<tr>
                <td>{$appointment->id}</td>
                <td>{$appointment->name}</td>
                <td>{$appointment->email}</td>
                <td>{$appointment->phone}</td>
                <td>{$appointment->date}</td>
                <td>{$appointment->time}</td>
                <td>{$appointment->service}</td>
                <td>{$appointment->status}</td>
                <td>
                    <a href='?page=booking_system&edit={$appointment->id}' class='button'>Edit</a>
                    <a href='?page=booking_system&delete={$appointment->id}' class='button button-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
    if (isset($_GET['edit'])) {
        $appointment_id = intval($_GET['edit']);
        show_edit_booking_form($appointment_id);
    }
    if (isset($_GET['delete'])) {
        $appointment_id = intval($_GET['delete']);
        delete_booking($appointment_id);
    }
}
// Show Edit Booking Form
function show_edit_booking_form($appointment_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'appointments';
    $appointment = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $appointment_id");
    if ($appointment) {
        echo "<h3>Edit Appointment</h3>";
        echo "<form method='post' action=''>
                <input type='hidden' name='appointment_id' value='{$appointment->id}' />
                <p><label for='name'>Name:</label><input type='text' name='name' value='{$appointment->name}' required /></p>
                <p><label for='email'>Email:</label><input type='email' name='email' value='{$appointment->email}' required /></p>
                <p><label for='phone'>Phone:</label><input type='text' name='phone' value='{$appointment->phone}' required /></p>
                <p><label for='date'>Date:</label><input type='date' name='date' value='{$appointment->date}' required /></p>
                <p><label for='time'>Time:</label><input type='time' name='time' value='{$appointment->time}' required /></p>
                <p><label for='service'>Service:</label><input type='text' name='service' value='{$appointment->service}' required /></p>
                <p><label for='status'>Status:</label><select name='status'>
                    <option value='Pending' " . selected('Pending', $appointment->status, false) . ">Pending</option>
                    <option value='Confirmed' " . selected('Confirmed', $appointment->status, false) . ">Confirmed</option>
                    <option value='Cancelled' " . selected('Cancelled', $appointment->status, false) . ">Cancelled</option>
                </select></p>
                <p><input type='submit' name='update_booking' value='Update Appointment' class='button button-primary' /></p>
                <p><input type='submit' name='send_email' value='Send Email Notification' class='button' /></p>
              </form>";
    } else {
        echo "<p>Appointment not found!</p>";
    }
}
// Send Email Notification
function handle_send_email() {
    if (isset($_POST['send_email'])) {
        global $wpdb;
        $appointment_id = intval($_POST['appointment_id']);
        // Get the appointment data
        $table_name = $wpdb->prefix . 'appointments';
        $appointment = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $appointment_id");
        if ($appointment) {
            // Send email notification
            send_booking_email($appointment->name, $appointment->email, $appointment->date, $appointment->time, $appointment->service, $appointment->status);
            // Redirect after sending email
            wp_redirect(admin_url('admin.php?page=booking_system&email_sent=true'));
            exit;
        }
    }
}
add_action('init', 'handle_send_email');
// Send Booking Email
function send_booking_email($name, $email, $date, $time, $service, $status) {
    $subject = "Appointment Notification";
    $message = "Dear $name,\n\nThis is a notification regarding your appointment for the service '$service'.\n\nThe details are as follows:\n\nDate: $date\nTime: $time\nStatus: $status\n\nThank you!";
    wp_mail($email, $subject, $message);
}
// Send Admin Notification
function send_admin_notification($name, $email, $date, $time, $service, $status) {
    $admin_email = get_option('admin_email'); // Get the admin email from WordPress settings
    $subject = "New Appointment Booking";
    $message = "A new appointment has been booked.\n\nDetails:\n\nName: $name\nEmail: $email\nDate: $date\nTime: $time\nService: $service\nStatus: $status";
    wp_mail($admin_email, $subject, $message);
}
// Update Booking
function update_booking() {
    if (isset($_POST['update_booking'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'appointments';
        $appointment_id = intval($_POST['appointment_id']);
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $date = sanitize_text_field($_POST['date']);
        $time = sanitize_text_field($_POST['time']);
        $service = sanitize_text_field($_POST['service']);
        $status = sanitize_text_field($_POST['status']);
        $wpdb->update($table_name, [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'date' => $date,
            'time' => $time,
            'service' => $service,
            'status' => $status
        ], ['id' => $appointment_id]);
        // Send email notification
        send_booking_email($name, $email, $date, $time, $service, $status);
        wp_redirect(admin_url('admin.php?page=booking_system&updated=true&email_sent=true'));
        exit;
    }
}
add_action('init', 'update_booking');
// Delete Booking
function delete_booking($appointment_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'appointments';
    $wpdb->delete($table_name, ['id' => $appointment_id]);
    wp_redirect(admin_url('admin.php?page=booking_system'));
    exit;
}
// Handle New Booking Submission
function handle_booking_form() {
    if (isset($_POST['submit_booking'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'appointments';
        // Sanitize inputs
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $date = sanitize_text_field($_POST['date']);
        $time = sanitize_text_field($_POST['time']);
        $service = sanitize_text_field($_POST['service']);
        // Insert into database
        $wpdb->insert($table_name, [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'date' => $date,
            'time' => $time,
            'service' => $service,
            'status' => 'Pending'
        ]);
        // Send emails
        send_booking_email($name, $email, $date, $time, $service, 'Pending');
        send_admin_notification($name, $email, $date, $time, $service, 'Pending');
        // Redirect
        wp_redirect(site_url('/confirmation?email_sent=true'));
        exit;
    }
}
add_action('init', 'handle_booking_form');
?>