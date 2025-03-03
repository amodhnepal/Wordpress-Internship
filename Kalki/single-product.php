<?php
get_header();
?>

<div class="single-product-container">
    <?php while (have_posts()) : the_post(); 
        global $product; 
    ?>
        <div class="product-wrapper">
            <!-- Product Image -->
            <div class="product-image">
                <?php the_post_thumbnail('large', ['class' => 'product-img']); ?>
            </div>

            <!-- Product Details -->
            <div class="product-details">
                <h1 class="product-title"><?php the_title(); ?></h1>
                <p class="product-price"><?php echo $product->get_price_html(); ?></p>

                <div class="product-description">
                    <?php the_content(); ?>
                </div>

                <!-- Add to Cart -->
                <div class="add-to-cart">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
