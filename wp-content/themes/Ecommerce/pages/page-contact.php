<?php
/**
 * Template Name: Contact Us Page
 */

get_template_part('assets/inc/header'); ?>

<main class="contact-container">
    <h1 class="contact-title">Contact Us</h1>
    
    <div class="contact-content">
        <div class="contact-info">
            <h2>Our Address</h2>
            <p>Matat Technologies, Dhumbarahi, Kathmandu</p>

            <h2>Email</h2>
            <p><a href="mailto:info@matat.com">info@matat.com</a></p>

            <h2>Phone</h2>
            <p><a href="tel:+9779801009989">+977 9801009989</a></p>
        </div>

        <div class="contact-form">
            <h2>Send Us a Message</h2>
            <?php echo do_shortcode('[contact-form-7 id="6a4d89d" title="Contact Us Page"]'); ?>
        </div>
    </div>
</main>

<?php get_template_part('assets/inc/footer'); ?>  
