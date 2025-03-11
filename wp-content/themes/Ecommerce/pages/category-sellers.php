<?php
/**
 * Template Name: Sellers Category Page
 */

get_header();  // Include the header file

// Check if we are viewing the "Sellers" category
if (is_category('best-sellers')) :

    // Start the WP Query for products
    $args = array(
        'post_type'      => 'product', // WooCommerce products
        'posts_per_page' => -1,        // Get all products (you can adjust this as needed)
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat', // WooCommerce product categories
                'field'    => 'slug',
                'terms'    => 'best-sellers', // Category slug, use 'sellers' if the category slug is 'sellers'
                'operator' => 'IN',
            ),
        ),
    );

    $query = new WP_Query($args);  // Create the custom query

    // Display the products if available
    if ($query->have_posts()) :
        echo '<div class="product-grid">';  // Wrap products in a grid

        // Loop through the products
        while ($query->have_posts()) :
            $query->the_post();
            global $product;
            ?>

            <div class="product-item">
                <ax href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="product-image">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>
                    <h2><?php the_title(); ?></h2>
                    <p class="product-price"><?php echo $product->get_price_html(); ?></p>
                </ax>
            </div>

            <?php
        endwhile;
        echo '</div>';  // Close product grid

        // Reset the query
        wp_reset_postdata();

    else :
        echo '<p>No products found in the "Sellers" category.</p>';
    endif;

else :
    echo '<p>Category not found.</p>';
endif;

get_footer();  // Include the footer file
