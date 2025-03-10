<?php
get_header(); // Includes the header.php file

if (have_posts()) :
    while (have_posts()) : the_post();
        ?>
        <div class="post-content">
            <?php
            // Check if the post has a featured image and display it
            if (has_post_thumbnail()) :
                ?>
                <div class="featured-image">
                    <?php the_post_thumbnail('full'); // You can adjust the size (e.g., 'medium') ?>
                </div>
            <?php endif; ?>

            <h1><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
        <?php
    endwhile;
endif;

get_footer(); // Includes the footer.php file
?>
