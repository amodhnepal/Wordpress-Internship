<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <!-- 🏷️ Post Title -->
    <h1 class="post-title"><?php the_title(); ?></h1>

    <!-- 🖊️ Author & Date -->
    <p class="post-meta">Published on <?php echo get_the_date(); ?> by <?php the_author(); ?></p>

    <!-- 📝 Post Content (NO Featured Image) -->
    <div class="post-content">
        <?php the_content(); ?>
    </div>

<?php endwhile; endif; ?>

<!-- 🔥 Recommended Posts Section -->
<?php
$categories = get_the_category();
$category_id = !empty($categories) ? $categories[0]->term_id : null;

if ($category_id) :
?>
    <div class="related-posts">
        
        <div class="related-posts-grid">
            <?php
            $related_args = array(
                'category__in'   => array($category_id),
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
<?php endif; ?>

<?php get_footer(); ?>
