<?php
/*
Plugin Name: Appointment Booking System
Description: A custom WordPress plugin for managing appointments.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit;
}

class AppointmentBookingSystem {

    private static $instance = null;
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'appointments';

        add_action('admin_menu', [$this, 'register_booking_menu']);
        add_action('init', [$this, 'handle_booking_form']);
        add_action('init', [$this, 'update_booking']);
        add_action('init', [$this, 'delete_booking']);
        add_action('init', [$this, 'add_booking']);
    }

    // Singleton instance
    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Register Admin Menu
    public function register_booking_menu() {
        add_menu_page(
            'Appointments',
            'Appointments',
            'manage_options',
            'booking_system',
            [$this, 'show_bookings'],
            'dashicons-calendar-alt',
            20
        );

        add_submenu_page(
            null, // Hidden from menu
            'Edit Appointment',
            'Edit Appointment',
            'manage_options',
            'edit_booking',
            [$this, 'edit_booking_page']
        );

        add_submenu_page(
            null, // Hidden from menu
            'Add Appointment',
            'Add Appointment',
            'manage_options',
            'add_booking',
            [$this, 'add_booking_page']
        );
    }

    // Show Bookings in Admin Panel
    public function show_bookings() {
        global $wpdb;
        $appointments = $wpdb->get_results("SELECT * FROM $this->table_name");

        echo "<div style='display: flex; align-items: center;'>";
        echo "<h2 style='margin: 0;'>Appointments</h2>";
        echo "<a href='" . admin_url("admin.php?page=add_booking") . "' class='button button-primary' style='margin-left: 10px;'>Add Appointment</a>";
        echo "</div>";

        if (isset($_GET['added'])) {
            echo "<div class='updated'><p>Appointment Added Successfully!</p></div>";
        } elseif (isset($_GET['updated'])) {
            echo "<div class='updated'><p>Appointment Updated Successfully!</p></div>";
        } elseif (isset($_GET['deleted'])) {
            echo "<div class='updated'><p>Appointment Deleted Successfully!</p></div>";
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
                        <a href='" . admin_url("admin.php?page=edit_booking&id={$appointment->id}") . "' class='button'>Edit</a>
                        <a href='?page=booking_system&delete={$appointment->id}' class='button button-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    }

    // Add Booking Page (Opens Separately)
    public function add_booking_page() {
        echo "<h2>Add Appointment</h2>";
        echo "<form method='post' action=''>";
        echo "<p><label>Name:</label><input type='text' name='name' required /></p>";
        echo "<p><label>Email:</label><input type='email' name='email' required /></p>";
        echo "<p><label>Phone:</label><input type='text' name='phone' required /></p>";
        echo "<p><label>Date:</label><input type='date' name='date' required /></p>";
        echo "<p><label>Time:</label><input type='time' name='time' required /></p>";
        echo "<p><label>Service:</label><input type='text' name='service' required /></p>";
        echo "<p><input type='submit' name='submit_booking' value='Add Appointment' class='button button-primary' /></p>";
        echo "</form>";
    }

    // Handle New Booking Submission (Admin)
    public function add_booking() {
        if (isset($_POST['submit_booking'])) {
            global $wpdb;
            $data = [
                'name' => sanitize_text_field($_POST['name']),
                'email' => sanitize_email($_POST['email']),
                'phone' => sanitize_text_field($_POST['phone']),
                'date' => sanitize_text_field($_POST['date']),
                'time' => sanitize_text_field($_POST['time']),
                'service' => sanitize_text_field($_POST['service']),
                'status' => 'Pending',
            ];

            $wpdb->insert($this->table_name, $data);
            wp_redirect(admin_url('admin.php?page=booking_system&added=true'));
            exit;
        }
    }

    // Edit Booking Page (Opens Separately)
    public function edit_booking_page() {
        if (!isset($_GET['id'])) {
            echo "<p>Invalid Appointment ID</p>";
            return;
        }

        global $wpdb;
        $appointment_id = intval($_GET['id']);
        $appointment = $wpdb->get_row("SELECT * FROM $this->table_name WHERE id = $appointment_id");

        if (!$appointment) {
            echo "<p>Appointment not found!</p>";
            return;
        }

        echo "<h2>Edit Appointment</h2>";
        echo "<form method='post' action=''>";
        echo "<input type='hidden' name='appointment_id' value='{$appointment->id}' />";
        echo "<p><label>Name:</label><input type='text' name='name' value='{$appointment->name}' required /></p>";
        echo "<p><label>Email:</label><input type='email' name='email' value='{$appointment->email}' required /></p>";
        echo "<p><label>Phone:</label><input type='text' name='phone' value='{$appointment->phone}' required /></p>";
        echo "<p><label>Date:</label><input type='date' name='date' value='{$appointment->date}' required /></p>";
        echo "<p><label>Time:</label><input type='time' name='time' value='{$appointment->time}' required /></p>";
        echo "<p><label>Service:</label><input type='text' name='service' value='{$appointment->service}' required /></p>";
        echo "<p><label>Status:</label><select name='status'>";
        echo "<option value='Pending' " . selected('Pending', $appointment->status, false) . ">Pending</option>";
        echo "<option value='Confirmed' " . selected('Confirmed', $appointment->status, false) . ">Confirmed</option>";
        echo "<option value='Cancelled' " . selected('Cancelled', $appointment->status, false) . ">Cancelled</option>";
        echo "</select></p>";
        echo "<p><input type='checkbox' name='send_mail' value='1'> Send Email Notification</p>";
        echo "<p><input type='submit' name='update_booking' value='Update Appointment' class='button button-primary' /></p>";
        echo "</form>";
    }

    // Update Booking
    public function update_booking() {
        if (isset($_POST['update_booking'])) {
            global $wpdb;
            $appointment_id = intval($_POST['appointment_id']);
            $data = [
                'name' => sanitize_text_field($_POST['name']),
                'email' => sanitize_email($_POST['email']),
                'phone' => sanitize_text_field($_POST['phone']),
                'date' => sanitize_text_field($_POST['date']),
                'time' => sanitize_text_field($_POST['time']),
                'service' => sanitize_text_field($_POST['service']),
                'status' => sanitize_text_field($_POST['status']),
            ];

            $wpdb->update($this->table_name, $data, ['id' => $appointment_id]);

            // Send email only if checkbox is checked
            if (isset($_POST['send_mail'])) {
                $this->send_user_update_notification(
                    $data['name'], $data['email'], $data['phone'],
                    $data['date'], $data['time'], $data['service'],
                    $data['status'], $appointment_id
                );
            }

            wp_redirect(admin_url('admin.php?page=booking_system&updated=true'));
            exit;
        }
    }

    // Delete Booking
    public function delete_booking() {
        if (isset($_GET['delete'])) {
            global $wpdb;
            $appointment_id = intval($_GET['delete']);
            $wpdb->delete($this->table_name, ['id' => $appointment_id]);

            wp_redirect(admin_url('admin.php?page=booking_system&deleted=true'));
            exit;
        }
    }

    // Handle New Booking Submission (Front-end)
    public function handle_booking_form() {
        if (isset($_POST['submit_booking'])) {
            global $wpdb;
            $data = [
                'name' => sanitize_text_field($_POST['name']),
                'email' => sanitize_email($_POST['email']),
                'phone' => sanitize_text_field($_POST['phone']),
                'date' => sanitize_text_field($_POST['date']),
                'time' => sanitize_text_field($_POST['time']),
                'service' => sanitize_text_field($_POST['service']),
                'status' => 'Pending',
            ];

            $wpdb->insert($this->table_name, $data);
            wp_redirect(admin_url('admin.php?page=booking_system&added=true'));
            exit;
        }
    }
}

// Initialize the plugin
AppointmentBookingSystem::get_instance();