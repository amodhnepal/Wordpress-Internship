<?php
/**
 * Template Name: Products Page
 */

get_template_part('assets/inc/header'); ?>

<main class="shop-container">
    <h1 class="shop-title">Shop</h1>

    <div class="shop-toolbar">
        <button class="filter-btn">☰ Filter Shoes</button>
        <div class="sorting">
            <?php woocommerce_catalog_ordering(); ?>
        </div>
    </div>

    <div class="products-grid">
        <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 12,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $loop = new WP_Query($args);

        if ($loop->have_posts()) :
            while ($loop->have_posts()) : $loop->the_post();
                global $product;
                $sale_price = $product->get_sale_price();
                $regular_price = $product->get_regular_price();
        ?>

        <div class="product-item">
            <a href="<?php the_permalink(); ?>">
                <div class="product-image">
                    <?php if ($product->is_on_sale()) : ?>
                        <span class="sale-badge">Sale!</span>
                    <?php endif; ?>
                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title_attribute(); ?>">
                </div>
                <h3><?php the_title(); ?></h3>
                <p class="price"><?php echo $product->get_price_html(); ?></p>
                <div class="rating"><?php echo wc_get_rating_html($product->get_average_rating()); ?></div>
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
        <?php echo paginate_links(array('total' => $loop->max_num_pages)); ?>
    </div>
</main>

<?php get_template_part('assets/inc/footer'); ?>
