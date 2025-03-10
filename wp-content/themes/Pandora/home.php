<?php get_header();  ?>
<section class="banner">
    <?php
    // WP_Query to fetch the latest post from the "banner" category
    $args = array(
        'post_type'      => 'post', 
        'posts_per_page' => 1, // Fetch only 1 latest banner post
        'category_name'  => 'banner' // Category slug should be 'banner'
    );
    
    $banner_query = new WP_Query($args);
    
    if ($banner_query->have_posts()) :
        while ($banner_query->have_posts()) : $banner_query->the_post();
            $banner_image = get_the_post_thumbnail_url(get_the_ID(), 'full'); // Get featured image
            $banner_text = get_the_title(); // Get post title
            $banner_link = get_permalink(); // Get post link
    ?>
            <img src="<?php echo esc_url($banner_image); ?>" alt="Banner Image">
            <!-- <div class="banner-text">
                <h1><?php echo esc_html($banner_text); ?></h1>
                <a href="<?php echo esc_url($banner_link); ?>" class="btn">SHOP NOW</a>
            </div> -->
    <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No banner found. Please add a post in the "banner" category with a featured image.</p>';
    endif;
    ?>
</section>

<section class="container">
    <div class="splide" id="product-slider">
        <div class="splide__track">
            <ul class="splide__list">
                <?php
                $args = array(
                    'post_type'      => 'product', // WooCommerce Products
                    'posts_per_page' => 8, // Adjust the number of products
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );

                $product_query = new WP_Query($args);

                if ($product_query->have_posts()) :
                    while ($product_query->have_posts()) : $product_query->the_post();
                        global $product;
                        if (has_post_thumbnail()) {
                            $product_img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                            ?>
                            <li class="splide__slide product-item">
                                <img src="<?php echo esc_url($product_img); ?>" alt="<?php the_title(); ?>">
                                <p class="product-title"><?php the_title(); ?></p>
                            </li>
                            <?php
                        }
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

                <!-- View All Slide -->
                <li class="splide__slide product-item view-all">
                    <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="view-all-btn">
                        <div class="view-all-circle">+</div>
                        <p>View All</p>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Navigation Buttons -->
        <div class="splide__arrows">
            <button class="splide__arrow splide__arrow--prev">‹</button>
            <button class="splide__arrow splide__arrow--next">›</button>
        </div>
    </div>
</section>


<section class="shirts-category">
    <h2>Shirts Collection</h2>

    <div class="shirts-products">
        <?php
        // WP Query to fetch 8 products from 'Shirts' category
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 6, // Limit to 8 products
            'orderby'        => 'date',
            'order'          => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => 'shirts', // Make sure 'shirts' is the correct category slug
                    'operator' => 'IN',
                ),
            ),
        );

        $product_query = new WP_Query($args);

        if ($product_query->have_posts()) :
            while ($product_query->have_posts()) : $product_query->the_post();
                global $product;
                ?>
                <div class="product-item">
                    <a href="<?php the_permalink(); ?>">
                        <div class="product-image">
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>">
                        </div>
                        <p class="product-title"><?php the_title(); ?></p>
                        <p class="product-price"><?php echo wc_price($product->get_price()); ?></p>
                    </a>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No products found.</p>';
        endif;
        ?>
    </div>
</section>


<?php get_footer();  ?>
