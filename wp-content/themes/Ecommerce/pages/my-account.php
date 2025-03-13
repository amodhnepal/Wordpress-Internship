<?php
/**
 * Template Name: My Account Page
 */

get_template_part('assets/inc/header'); ?>

<div class="container">
    <h1>My Account</h1>
    <?php echo do_shortcode('[woocommerce_my_account]');  ?>
</div>

<?php get_template_part('assets/inc/footer'); ?>
