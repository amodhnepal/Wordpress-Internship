<?php get_header(); ?>
<section class="service-container">
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Move title outside of the content -->
        <h1 class="service-title"><?php the_title(); ?></h1>

        <div class="service-page-content">
            <div class="service-content">
                <?php the_content(); ?>
            </div>
        </div>
    
    <?php endwhile; ?>

    <div class="service-sec">
    <?php   
    $service_posts = new WP_Query(array(
        "post_type"=> "post",
        "category_name"=> "servicepage",
        "posts_per_page"=> -1,
        "order"=> "ASC",
    ));

    $post_index = 0; // Initialize index

    if ($service_posts->have_posts()) {
        while ($service_posts->have_posts()) {
            $service_posts->the_post();
            $is_even = $post_index % 2 == 0; // Check if index is even or odd
            ?>

            <div class="service-post-item <?php echo $is_even ? 'image-left' : 'image-right'; ?>">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="service-post-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="service-post-content">
                    <h2><?php the_title(); ?></h2>
                    <div class="service-post-excerpt">
                        <?php the_content(); ?>
                        <a href="<?php the_permalink(); ?>" class="read-more-btn">Read More</a>
                    </div>
                    
                </div>
            </div>

            <?php
            $post_index++; // Increment post index
        }
    }
    wp_reset_postdata();
    ?>
</div>

</section>

<?php get_footer(); ?>
