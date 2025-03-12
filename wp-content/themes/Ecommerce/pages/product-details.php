<?php
/**
 * Template Name: Custom Product Details
 */

global $post;
get_template_part('assets/inc/header');
$product = wc_get_product($post->ID);
if (!$product) {
    echo '<p class="error-message">Product not found.</p>';
    get_footer();
    return;
}
?>

<main class="custom-product-container">
    <!-- Product Info Section -->
    <section class="product-info">
        <div class="product-image">
            <?php echo $product->get_image(); ?>
        </div>
        <div class="product-details">
            <h1><?php echo esc_html($product->get_name()); ?></h1>
            <p class="price">Price: <?php echo wc_price($product->get_price()); ?></p>
            <p class="short-description"> <?php echo $product->get_short_description(); ?> </p>
            <button class="add-to-cart-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
    Add to Cart
</button>

        </div>
    </section>

    <!-- Product Tabs Section -->
    <section class="product-tabs-container">
        <ul class="tabs">
            <li class="active" data-tab="desc">Description</li>
            <li data-tab="reviews">Reviews (<?php echo $product->get_review_count(); ?>)</li>
        </ul>
        
        <div id="desc" class="tab-content active">
            <?php echo apply_filters('the_content', $product->get_description()); ?>
        </div>
        <div id="reviews" class="tab-content">
            <?php comments_template(); ?>
        </div>
    </section>

    <!-- Related Products Section (Single Instance) -->
    <section class="related-products">
        <div class="related-product-grid">
            <?php woocommerce_output_related_products(['posts_per_page' => 4]); ?>
        </div>
    </section>
</main>

<?php get_template_part('assets/inc/footer'); ?>
