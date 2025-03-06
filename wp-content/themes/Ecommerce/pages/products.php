<?php
/**
 * Template Name: Products Page
 */

 get_template_part('assets/inc/header'); ?>

<main class="shop-container">
    <h1 class="shop-title">Shop</h1>

    <div class="products-grid">
        <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 12, // Change the number of products per page
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $loop = new WP_Query($args);

        if ($loop->have_posts()) :
            while ($loop->have_posts()) : $loop->the_post();
                global $product; ?>

                
<div class="seller-item">                   
    <a href="<?php the_permalink(); ?>">
        <div class="seller-image">
            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title_attribute(); ?>">
        </div>
        <h3><?php the_title(); ?></h3>
        <p class="excerpt">
            <?php 
                $product = wc_get_product(get_the_ID()); // Get the WooCommerce product
                if ($product) {
                    echo $product->get_price_html(); // Display price
                }
            ?>
        </p>
    </a>
</div>

        <?php endwhile;
        else :
            echo '<p>No products found</p>';
        endif;
        wp_reset_postdata(); ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php
        echo paginate_links(array(
            'total' => $loop->max_num_pages
        ));
        ?>
    </div>
</main>

<?php get_template_part('assets/inc/footer'); ?>
 