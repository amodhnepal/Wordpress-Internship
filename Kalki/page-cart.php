<?php
/**
 * Template Name: Cart Page
 */

get_header(); ?>

<div class="cart-container">
    <h1 class="cart-title">Your Shopping Cart</h1>
    <div class="cart-content">
        <?php echo do_shortcode('[woocommerce_cart]'); ?>
    </div>
</div>

<?php get_footer(); ?>
