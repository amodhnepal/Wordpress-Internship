<?php
/*
 Template Name: Contact Us
 */
get_header(); ?>

<div class="contact-page-container">
    <div class="contact-header">
        <!-- Fetch and display the page title dynamically -->
        <h1 class="contact-title"><?php the_title(); ?></h1>

        <!-- Fetch and display the page content dynamically -->
        <div class="contact-intro">
            <?php 
                // Display the content of the contact page dynamically
                while (have_posts()) : the_post();
                    the_content(); // Display the content of the page
                endwhile;
            ?>
        </div>
    </div>

<?php get_footer(); ?>
