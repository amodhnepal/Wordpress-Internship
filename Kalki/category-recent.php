<?php get_header(); ?>

<section class="recent-posts">
    <div class="recent-posts-header">
        <h2>Recent <span>Posts</span></h2>
        <!-- Link to the 'recent' category archive page -->
    </div>
    <div class="posts-grid">
        <?php
        // WP_Query to fetch posts from the 'recent' category
        $args = array(
            'post_type' => 'recent_posts', 
            'posts_per_page' => -1, 
            'post_status' => 'publish', 
            'orderby' => 'date', 
            'order' => 'DESC', 
            'tax_query' => array( 
                array(
                    'taxonomy' => 'category', 
                    'field'    => 'slug', 
                    'terms'    => 'recent', 
                ),
            ),
        );

        // Perform the query
        $recent_posts = new WP_Query($args);

        // Check if there are any posts
        if ($recent_posts->have_posts()) :
            while ($recent_posts->have_posts()) : $recent_posts->the_post();
        ?>
                <article class="post-card">
                    <div class="post-image">
                        <!-- Display post thumbnail image -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                        <?php else : ?>
                            <img src="path_to_default_image.jpg" alt="Default Image"> <!-- Optional default image if no thumbnail -->
                        <?php endif; ?>
                    </div>
                    <div class="post-content">
                        <!-- Display post title and date -->
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p>Admin | <?php echo get_the_date('d M, Y'); ?></p>
                    </div>
                </article>
        <?php
            endwhile;
            wp_reset_postdata(); // Reset post data after custom query
        else :
            echo '<p>No recent posts found.</p>';
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
