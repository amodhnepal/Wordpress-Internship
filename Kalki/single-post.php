<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <!-- Post Title -->
    <h1 class="post-title"><?php the_title(); ?></h1>

    <!-- Author & Date -->
    <p class="post-meta">Published on <?php echo get_the_date(); ?> by <?php the_author(); ?></p>

    <?php
    // Get the categories for the post
    $categories = get_the_category();
    $category_slug = $categories[0]->slug; // Get the slug of the first category
    ?>

    <!-- Check for category and apply different layouts -->
    <div class="post-content">
        <?php if ($category_slug == 'blog') : ?>
            <!-- Blog Category Layout (current layout) -->
            <div class="blog-layout">
                <!-- Post Content for Blog Category (no major changes) -->
                <?php the_content(); ?>
            </div>

        <?php elseif ($category_slug == 'servicepage') : ?>
            <!-- Servicepage Category Layout -->
            <div class="servicepage-layout">
                <h2>Explore Our Service Pages</h2>
                <div class="servicepage-intro">
                    <p>Welcome to our service page. Here we offer specialized solutions.</p>
                </div>
                <!-- Add any custom fields or layout specific to servicepage -->
                <?php the_content(); ?>
            </div>

        <?php elseif ($category_slug == 'serv') : ?>
            <!-- Serv Category Layout -->
            <div class="serv-layout">
                <h2>Our Services</h2>
                <p>We provide top-notch services tailored to your needs.</p>
                <!-- You can display specific service-related info here -->
                <?php the_content(); ?>
            </div>

        <?php elseif ($category_slug == 'recent') : ?>
            <!-- Recent Category Layout (Custom Post Type 'recent_posts') -->
            <div class="recent-layout">
                <h2>Latest Updates</h2>
                <p>Stay updated with our recent posts and updates!</p>
                <!-- Custom layout for recent posts -->
                <?php the_content(); ?>
            </div>

        <?php else : ?>
            <!-- Default Layout for Other Categories (if any) -->
            <div class="default-layout">
                <p>Default layout for other categories</p>
                <?php the_content(); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Related Posts Section -->
    <div class="related-posts">
        <div class="related-posts-grid">
            <?php
            $related_args = array(
                'category__in'   => array($categories[0]->term_id),
                'post__not_in'   => array(get_the_ID()), // Exclude current post
                'posts_per_page' => 2, // Show 2 posts
                'orderby'        => 'rand' // Random order
            );

            $related_query = new WP_Query($related_args);

            if ($related_query->have_posts()) :
                while ($related_query->have_posts()) : $related_query->the_post(); ?>
                    <div class="related-post-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="related-post-thumbnail">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
                            <h3><?php the_title(); ?></h3>
                            <p class="related-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        </a>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else :
                echo "<p>No related posts found.</p>";
            endif;
            ?>
        </div>
    </div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
