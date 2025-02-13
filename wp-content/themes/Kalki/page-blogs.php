<?php get_header(); ?>

<section class="blog-container">
    <h1 class="page-title">Blog</h1>
    
    <?php
        // Query posts only from the "blog" category
        $blog_query = new WP_Query(array(
            'category_name' => 'blog', // Fetch posts from category "blog"
            'posts_per_page' => 6, // Number of posts per page
            'order' => 'ASC',
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1 // Enable pagination
        ));
        
        if ($blog_query->have_posts()) : ?>
            <div class="blog-grid">
                <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                <div class="blog-post">
                    <!-- Featured Image -->
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="blog-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </a>
                        <?php endif; ?>
                        
                        <!-- Title -->
                        <h2 class="blog-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <!-- Excerpt -->
                        <p class="blog-excerpt">
                            <?php echo date('F j'); ?>
                            <?php the_excerpt(); ?> 
                        </p>
                        
                        <!-- Read More Button -->
                        <a href="<?php the_permalink(); ?>" class="read-more-btn">Read More</a>
                    </div>
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <div class="pagination">
                    <?php
                echo paginate_links(array(
                    'total' => $blog_query->max_num_pages,
                ));
                ?>
            </div>
            
            <div class="container">
                <!-- Header Section -->
                <div class="blog-after-pagination">
                    <div class="left-header">
                        <h1>Get the latest<br>news into your inbox</h1>
                    </div>
                    <div class="container">
                    <div class="right-header">
                        <h5>
                            Stay informed and up-to-date with the latest news
                            delivered straight to your inbox for a seamless and
                            convenient experience
            </h5>
        </div>
        </div>

        <!-- Content Section -->
        <div class="form-style">
            <!-- Content here (which includes Contact Form 7 form) -->
        <?php
            $args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'name'           => 'Blogs',
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    echo the_content();
                }
            }
        ?>
         </div>
    </div>
    </div>
    </section>

        <?php endif; ?>
<?php get_footer(); ?>
