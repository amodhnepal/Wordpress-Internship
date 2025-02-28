<?php
/**
 * Template Name: Product Details
 */

get_template_part('assets/inc/header');
?>

<main class="product-container">
    <?php
    while (have_posts()) :
        the_post();
        global $post;
        $product = wc_get_product($post->ID);
        ?>

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

    <?php endwhile; ?>
</main>

<?php get_template_part('assets/inc/footer'); ?>
