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
                <div class="product-item">
                    <a href="<?php the_permalink(); ?>" class="product-link">
                        <div class="product-image">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('medium');
                            } ?>
                            <?php if ($product->is_on_sale()) : ?>
                                <span class="sale-badge">Sale!</span>
                            <?php endif; ?>
                        </div>
                        <h2 class="product-title"><?php the_title(); ?></h2>
                        <span class="product-price"><?php echo $product->get_price_html(); ?></span>
                        <div class="product-rating">
                            <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                        </div>
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
 