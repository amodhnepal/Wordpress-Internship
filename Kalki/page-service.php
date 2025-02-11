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
        if ( $service_posts->have_posts() ) {
            while ( $service_posts->have_posts() ) {
                $service_posts->the_post();
                ?>
                <div class="service-post-item">
                    <h2><?php the_title(); ?></h2>
                    <!-- <div class="service-post-excerpt"> -->
                        <?php the_content(); ?>
                    <!-- </div> -->
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>

<?php get_footer(); ?>
