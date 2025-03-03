<?php
/**
 * Template Name: Projects for Sale
 */
get_header(); ?>

<div class="ps-container">
    <h2 class="ps-title">Available Projects for Sale</h2>
    <div class="ps-grid">
        <?php
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 10,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => 'project',
                ),
            ),
        );

        $loop = new WP_Query($args);

        if ($loop->have_posts()) :
            while ($loop->have_posts()) : $loop->the_post();
                global $product;
                ?>
                <div class="ps-project-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', ['class' => 'ps-project-img']); ?>
                        <h3 class="ps-project-title"><?php the_title(); ?></h3>
                        <p class="ps-project-price">Price: <?php echo $product->get_price_html(); ?></p>
                    </a>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo "<p class='ps-no-projects'>No projects available for sale.</p>";
        endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>
