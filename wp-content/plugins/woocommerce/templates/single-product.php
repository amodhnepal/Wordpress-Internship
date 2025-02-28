

<?php
/**
 * Template Name: Product Details
 */

get_template_part('assets/inc/header');
?>
// Ensure WooCommerce global product object is set
<?php
global $post, $product;

if (empty($product) || !$product->is_type('simple') && !$product->is_type('variable')) {
    $product = wc_get_product(get_the_ID());
}

?>

<main class="product-container">
    <?php if ($product) : ?>
        <div class="product-details">
            <div class="product-gallery">
                <?php echo woocommerce_get_product_thumbnail(); ?>
            </div>

            <div class="product-info">
                <h1 class="product-title"><?php the_title(); ?></h1>
                <span class="product-price"><?php echo $product->get_price_html(); ?></span>

                <!-- Short Description -->
                <p class="short-description"><?php echo $product->get_short_description(); ?></p>

                <!-- Add to Cart -->
                <form class="cart" method="post" enctype="multipart/form-data">
                    <?php woocommerce_template_single_add_to_cart(); ?>
                </form>

                <!-- Product Meta -->
                <div class="product-meta">
                    <p><strong>Categories:</strong> <?php echo wc_get_product_category_list($product->get_id()); ?></p>
                </div>

                <!-- Payment Icons -->
                <div class="payment-icons">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/payment-icons.png" alt="Payment Methods">
                </div>
            </div>
        </div>

        <!-- Product Tabs (Description & Reviews) -->
        <div class="product-tabs">
            <ul class="tabs">
                <li class="active" data-tab="description">Description</li>
                <li data-tab="reviews">Reviews (<?php echo $product->get_review_count(); ?>)</li>
            </ul>

            <div id="description" class="tab-content active">
                <?php echo apply_filters('the_content', $product->get_description()); ?>
            </div>

            <div id="reviews" class="tab-content">
                <?php comments_template(); ?>
            </div>
        </div>

        <!-- Related Products -->
        <section class="related-products">
            <h2>Related Products</h2>
            <?php woocommerce_output_related_products(); ?>
        </section>

    <?php else : ?>
        <p>Product not found.</p>
    <?php endif; ?>
</main>


<?php get_template_part('assets/inc/footer'); ?>
