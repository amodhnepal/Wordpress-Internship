<?php
/*
Template Name: Home Page
*/
get_template_part('assets/inc/header'); ?>

<!-- Hero Section -->
<!-- Hero Section -->
<section class="hero">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php
            $banner_args = array(
                'post_type'      => 'post',
                'posts_per_page' => 3, // Fetch latest 3 banners
                'category_name'  => 'banner',
                'orderby'        => 'date',
                'order'          => 'DESC'
            );
            $banner_query = new WP_Query($banner_args);

            if ($banner_query->have_posts()) :
                while ($banner_query->have_posts()) : $banner_query->the_post();
                    $banner_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '';
                    ?>
                    <div class="swiper-slide" style="background-image: url('<?php echo esc_url($banner_image); ?>');  ">
                        <div class="hero-content">
                            <h1><?php the_title(); ?></h1>
                            <p><?php the_excerpt(); ?></p>
                            <div class="hero-buttons">
                                <a href="#" class="btn">Shop Men</a>
                                <a href="#" class="btn">Shop Women</a>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <!-- Swiper Pagination and Navigation -->
        <div class="swiper-pagination hero-pagination"></div>
        <div class="swiper-button-next hero-next"></div>
        <div class="swiper-button-prev hero-prev"></div>
    </div>
</section>


<!-- Featured Logos Section -->
<section class="logo-posts">
    <div class="wrapper">
            <div class="logo-container">
                <?php
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => -1,
                    'category_name'  => 'logo',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );

                $logo_query = new WP_Query($args);
                if ($logo_query->have_posts()) :
                    while ($logo_query->have_posts()) : $logo_query->the_post();
                        $post_thumbnail_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : ''; // Fetch featured image
                        ?>
                        <div class="logo-item">
                            <?php if (!empty($post_thumbnail_url)) : ?>
                                <img src="<?php echo esc_url($post_thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                            <?php endif; ?>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No logos found.</p>';
                endif;
                ?>
            </div>
        </div>
        
</section>



<!-- Featured Images Section -->
<!-- Featured Logos Section -->


<!-- About Section -->
<section class="about-section">
    <?php
    // Fetch the latest post from the 'About' category
    $about_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 1, // Get only one post
        'category_name'  => 'about',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $about_query = new WP_Query($about_args);

    if ($about_query->have_posts()) :
        while ($about_query->have_posts()) : $about_query->the_post();
            $about_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '';
            $about_excerpt = get_the_excerpt();
            $about_title = get_the_title();
            $about_content = get_the_content();
            $about_link = get_permalink();
            ?>
            <div class="about-content">
                <!-- Left column: Featured Image -->
                <div class="about-image">
                    <img src="<?php echo esc_url($about_image); ?>" alt="<?php echo esc_attr($about_title); ?>">
                </div>
                <!-- Right column: Excerpt, Title, Content, Read More -->
                <div class="about-text">
                    <p class="excerpt"><?php echo esc_html($about_excerpt); ?></p>
                    <h2><?php echo esc_html($about_title); ?></h2>
                    <div class="content">
                        <?php echo wp_kses_post($about_content); ?>
                    </div>
                    <a href="<?php echo esc_url($about_link); ?>" class="btn read-more">Read More</a>
                </div>
            </div>
        <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No About content found.</p>';
    endif;
    ?>
</section>



<?php 
// Query to get posts from 'sellers' category
$args = array(
    'post_type'      => 'post', // Change to 'product' if using WooCommerce
    'posts_per_page' => 3,
    'category_name'  => 'sellers',
);

$sellers_query = new WP_Query($args);

if ($sellers_query->have_posts()) : ?>
    <section class="best-sellers">
        <h2>Our Best Sellers</h2>
        <div class="seller-grid">
            <?php while ($sellers_query->have_posts()) : $sellers_query->the_post(); 
                $product_link = get_permalink();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            ?>
                <div class="seller-item">
                    <a href="<?php echo esc_url($product_link); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>">
                        <h3><?php the_title(); ?></h3>
                        <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
        <a href="<?php echo get_category_link(get_category_by_slug('sellers')->term_id); ?>" class="view-all">View All Best Sellers</a>
    </section>
<?php endif; 
wp_reset_postdata();
?>

<?php
// Query to get 2 posts from the 'gender' category
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 2,
    'category_name'  => 'gender',
);

$gender_query = new WP_Query($args);

if ($gender_query->have_posts()) : ?>
    <section class="image-row">
        <?php while ($gender_query->have_posts()) : $gender_query->the_post();
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        ?>
            <div class="image-column">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>">
                <div class="overlay">
                    <h2 class="post-title"><?php the_title(); ?></h2>
                    <a href="<?php the_permalink(); ?>" class="view-more-btn">View More</a>
                </div>
            </div>
        <?php endwhile; ?>
    </section>
<?php endif;
wp_reset_postdata();
?>


<?php 
// Query to get posts from 'arrivals' category
$args = array(
    'post_type'      => 'post', // Change to 'product' if using WooCommerce
    'posts_per_page' => 3,
    'category_name'  => 'arrivals',
);

$arrivals_query = new WP_Query($args);

if ($arrivals_query->have_posts()) : ?>
    <section class="new-arrivals">
        <h2>New Arrivals</h2>
        <div class="arrival-grid">
            <?php while ($arrivals_query->have_posts()) : $arrivals_query->the_post(); 
                $product_link = get_permalink();
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            ?>
                <div class="arrival-item">
                    <a href="<?php echo esc_url($product_link); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>">
                        <h3><?php the_title(); ?></h3>
                        <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
        <a href="<?php echo get_category_link(get_category_by_slug('arrivals')->term_id); ?>" class="view-all">View All Arrivals</a>
    </section>
<?php endif; 
wp_reset_postdata();
?>


<?php get_template_part('assets/inc/footer'); ?>
