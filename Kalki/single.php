<?php get_header(); ?>

<div class="single-service-container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="single-service-content">
            <h1 class="service-title"><?php the_title(); ?></h1>

            <!-- Optional: Service Icon -->
            <div class="service-icon">
                <i class="fas fa-gem"></i> <!-- You can change this dynamically -->
            </div>

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="service-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <!-- Service Description -->
            <div class="service-description">
                <?php the_content(); ?>
                <?php the_excerpt(); ?>
            </div>

            <!-- Back to Services Button -->
            <a href="<?php echo get_post_type_archive_link('service'); ?>" class="back-to-services">Back to Services</a>
        </div>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
