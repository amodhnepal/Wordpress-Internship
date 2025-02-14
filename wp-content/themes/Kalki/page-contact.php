<?php
/*
 Template Name: Contact Us
 */
get_header(); ?>

<div class="contact-page-container">
    <!-- Contact Title -->
    <div class="contact-header">
        <h1 class="contact-title"><?php the_title(); ?></h1>
    </div>

    <div class="contact-content">
        <!-- Left Column: Contact Form (Dynamically Loaded) -->
        <div class="contact-form-section">
            <?php 
                while (have_posts()) : the_post();
                    the_content(); // Dynamically loads the form and headings
                endwhile;
                wp_reset_postdata(); // Ensures ACF pulls the correct data
            ?>
        </div>

        <!-- Right Column: Contact Info (Generated from ACF) -->
        <div class="contact-info-box">
            <h3>Contact Info</h3>
            <p>Fill up the form and our team will get back to you within 24 hours.</p>

            <div class="contact-details">
                <?php if ($phone = get_field('phone_number')) : ?>
                    <p><i class="fas fa-phone-alt"></i> <?php echo esc_html($phone); ?></p>
                <?php endif; ?>

                <?php if ($email = get_field('_email_address_')) : ?>
                    <p><i class="fas fa-envelope"></i> <?php echo esc_html($email); ?></p>
                <?php endif; ?>

                <?php if ($address = get_field('address_')) : ?>
                    <p><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($address); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
