<?php
/* Template Name: Women Page */
get_template_part('assets/inc/header'); ?>

<div class="women-products">
    <h1>Women's Products</h1>

    <?php
    // Query products from 'Women' category
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => 'women', // Women category slug
                'operator' => 'IN',
            ),
        ),
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        echo '<div class="product-grid">'; // Open the product grid
        while ($query->have_posts()) : $query->the_post();
            $price = get_post_meta(get_the_ID(), '_price', true); // Get product price
            ?>
            <div class="product-item">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="product-image">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>
                    <h2><?php the_title(); ?></h2>
                </a>
                <?php if ($price) : ?>
                    <p class="product-price">$<?php echo esc_html($price); ?></p>
                <?php endif; ?>
            </div>
            <?php
        endwhile;
        echo '</div>'; // Close the product grid
        wp_reset_postdata();
    else :
        echo '<p>No products found for Women.</p>';
    endif;
    ?>
</div>

<?php get_template_part('assets/inc/footer'); ?>