<?php
/* Template Name: Men Page */
get_template_part('assets/inc/header'); 
?>

<div class="men-products">
    <h1>Men's Products</h1>

    <!-- Filter Form -->
    <form method="GET" action="">
        <div class="filter">
            <label for="price">Price Range:</label>
            <select name="price_range" id="price_range">
                <option value="">Select Price Range</option>
                <option value="0-50" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] === '1000-2000') ? 'selected' : ''; ?>>Rs.1000-2000</option>
                <option value="51-100" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] === '2100-3500') ? 'selected' : ''; ?>>Rs.2100-3500</option>
                <option value="101-200" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] === '3600-4500') ? 'selected' : ''; ?>>Rs.3600-4500</option>
                <option value="201+" <?php echo (isset($_GET['price_range']) && $_GET['price_range'] === '4500+') ? 'selected' : ''; ?>>Rs.4500+</option>
            </select>
        </div>

        <div class="filter">
            <label for="size">Size:</label>
            <select name="size" id="size">
                <option value="">Select Size</option>
                <?php
                // Get all available sizes from WooCommerce attributes
                $sizes = get_terms(array(
                    'taxonomy' => 'pa_size', // WooCommerce size attribute taxonomy
                    'orderby'  => 'name',
                    'hide_empty' => false,
                ));
                foreach ($sizes as $size) {
                    echo '<option value="' . $size->slug . '" ' . (isset($_GET['size']) && $_GET['size'] === $size->slug ? 'selected' : '') . '>' . $size->name . '</option>';
                }
                ?>
            </select>
        </div>

        <button type="submit" class="filter-button">Apply Filters</button>
    </form>

    <?php
    // Prepare Query with Filters
    $meta_query = array();
    $tax_query = array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'men', // 'men' category slug
            'operator' => 'IN',
        ),
    );

    // Apply Price Filter
    if (isset($_GET['price_range']) && !empty($_GET['price_range'])) {
        list($min_price, $max_price) = explode('-', $_GET['price_range']);
        $meta_query[] = array(
            'key'     => '_price',
            'value'   => array($min_price, $max_price),
            'compare' => 'BETWEEN',
            'type'    => 'NUMERIC',
        );
    }

    // Apply Size Filter
    if (isset($_GET['size']) && !empty($_GET['size'])) {
        $tax_query[] = array(
            'taxonomy' => 'pa_size', // WooCommerce size attribute taxonomy
            'field'    => 'slug',
            'terms'    => $_GET['size'],
            'operator' => 'IN',
        );
    }

    // Set up the WP_Query with filters
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => $tax_query,
        'meta_query'     => $meta_query,
    );
    $query = new WP_Query($args);

    // Display the Products
    if ($query->have_posts()) :
        echo '<div class="product-grid">';
        while ($query->have_posts()) : $query->the_post();
            $price = get_post_meta(get_the_ID(), '_price', true); // WooCommerce price meta
            ?>
            <div class="seller-item">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="seller-image">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>
                    <h2><?php the_title(); ?></h2>
                    <?php if ($price) : ?>
                        <p class="product-price">$<?php echo esc_html($price); ?></p>
                    <?php endif; ?>
                </a>
            </div>
            <?php
        endwhile;
        echo '</div>';
        wp_reset_postdata();
    else :
        echo '<p>No products found for Men with selected filters.</p>';
    endif;
    ?>
</div>

<?php get_template_part('assets/inc/footer'); ?>
