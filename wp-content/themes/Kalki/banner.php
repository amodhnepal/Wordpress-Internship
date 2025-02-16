<section class="banner-section">
    <?php 
    // Dynamically fetch the banner image
    $banner_image = get_template_directory_uri() . '/assets/img/banner-mask.png'; 
    ?>
    <img src="<?php echo esc_url($banner_image); ?>" alt="Banner Image" class="banner-image">

    <!-- Add Vector Images -->
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/upper-banner-long-vector.png" alt="Vector 1" class="banner-vector top-right vector1">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/upper-banner-smaller-vector.png" alt="Vector 2" class="banner-vector top-right vector2">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner-bottom-vector.png" alt="Vector 3" class="banner-vector start-from-logo vector3">

    <div class="banner-content">
        <div class="rectangle">
            <h1>Automate<br><span class="bold">Workflow</span> With Us</h1>
            <a href="#" class="btn">VIEW MORE</a>
        </div>
    </div>
</section>
