<?php
/**
 * Template Name: Checkout Page
 */

get_template_part('assets/inc/header'); ?>

<main class="checkout-container">
    <h1>Checkout</h1>
    
    <?php 
    // Display WooCommerce checkout form
    echo do_shortcode('[woocommerce_checkout]'); 
    ?>

</main>

<?php get_template_part('assets/inc/footer'); ?>
