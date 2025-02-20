<?php
/* Template Name: Booking Confirmation */
get_header();
?>

<div class="container-book confirmation-page">
    <div class="confirmation-message">
        <h1>Thank You for Your Booking!</h1>
        <p>Hello, <strong><?php echo isset($_GET['name']) ? esc_html($_GET['name']) : 'Guest'; ?></strong>.</p>
        <p>We have received your booking request. A confirmation email has been sent to <strong><?php echo isset($_GET['email']) ? esc_html($_GET['email']) : 'your email'; ?></strong>.</p>
        <p>We will contact you shortly to confirm the details.</p>
        <a href="<?php echo site_url('/'); ?>" class="back-home">Return to Home</a>
    </div>
</div>

<?php get_footer(); ?>
