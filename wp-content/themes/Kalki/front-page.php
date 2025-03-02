<?php
/*
Template Name: Front Page
*/
get_header(); 
?>

<!-- <div id="primary" class="content-area"> -->
    <!-- <main id="main" class="site-main"> -->
        <!-- Banner Section -->
        <div class="container-achieve">
            <?php
    $args = [
        'post_type' => 'page',
        'pagename' => 'Achievement', 
        'posts_per_page' => 1
];
$new_page_query = new WP_Query($args);

if ($new_page_query->have_posts()) :
    while ($new_page_query->have_posts()) : $new_page_query->the_post();
            ?>
            <div class="achieve"><?php the_content(); ?></div>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No content found.</p>';
    endif;
    ?>
</div>

<!-- Service Section -->

<div class="container-mata-service serv">
<?php
// Get the 'service' category details
$category = get_term_by('slug', 'service', 'category');

if ($category) {
    $category_name = $category->name;
    $category_description = $category->description;
    $category_image = get_option('z_taxonomy_image' . $category->term_id); // Custom category image
    $category_link = get_category_link($category->term_id);

    // Split the category name by space into words
    $category_words = explode(' ', trim($category_name));

    // Assign first and second words
    $first_word = !empty($category_words[0]) ? esc_html($category_words[0]) : '';
    $second_word = !empty($category_words[1]) ? esc_html($category_words[1]) : '';
?>

<!-- Category Section -->
<div class="service">
    <div class="wp-block-media-text">
        <!-- Image on the right -->
        <figure class="wp-block-media-text__media">
            <img src="<?php echo esc_url($category_image); ?>" alt="<?php echo esc_attr($category_name); ?>" class="category-image">
        </figure>

        <!-- Content on the left -->
        <div class="wp-block-media-text__content">
            <h1>
                <span style="color: black;"><?php echo $first_word; ?></span>
                <?php if ($second_word) : ?>
                    <br><span style="color: #007BFF;"><?php echo $second_word; ?></span>
                <?php endif; ?>
            </h1>
            <p class="category-description"><?php echo nl2br(esc_html($category_description)); ?></p>
            <div class="view-all-button">
                <a href="<?php echo esc_url($category_link); ?>" class="button">View All</a>
            </div>
        </div>
    </div>
</div>


<?php } else {
    echo '<p>Category not found.</p>';
} ?>

    <!-- Dynamic Circles in Plus Formation -->
    <div class="circle-container">
        <?php
        // Fetch 4 posts from 'service' category for circles
        $circle_args = [
            'category_name'  => 'service', 
            'posts_per_page' => 4,
            'post__not_in'   => [get_the_ID()] // Exclude "Our Services" from circles
        ];
        $circle_query = new WP_Query($circle_args);

        $circle_classes = ['circle-top', 'circle-left', 'circle-right', 'circle-bottom'];
        $icons = ['fa-gem', 'fa-layer-group', 'fa-desktop', 'fa-gear'];

        $i = 0;
        if ($circle_query->have_posts()) :
            while ($circle_query->have_posts() && $i < 4) :
                $circle_query->the_post();
                ?>
                <div class="circle <?php echo $circle_classes[$i]; ?>">
                    <i class="fas <?php echo $icons[$i]; ?>"></i>
                    <h1><?php the_title(); ?></h1>
                    <h3><?php the_excerpt(); ?></h3>
                </div>
                <?php
                $i++;
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>No service sections found.</p>';
        endif;
        ?>
    </div>
    </div>


<!-- Featured  -->
<section class="featured-projects">
    <div class="container">
        <!-- Left Column (Title, Buttons) -->
        <div class="left-column">
            <h2>Featured <span>Projects</span></h2>
<!-- View All Button -->
<a href="<?php echo get_category_link(get_cat_ID('Slider')); ?>" class="view-all">View All</a>
            <div class="swiper-navigation">
                <button class="swiper-button-prev"></button>
                <button class="swiper-button-next"></button>
            </div>

            <!-- Navigation Buttons -->
        </div>
        
        <!-- Right Column (Slider) -->
        <div class="right-column">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    // Query to get posts for the slider
                    $args = [
                        'post_type' => 'post',
                        'posts_per_page' => 4, // Limit to 4 slides
                        'category_name' => 'Slider' // Adjust to the category of your posts
                    ];
                    $query = new WP_Query($args);

                    if ($query->have_posts()) :
                        while ($query->have_posts()) : $query->the_post();
                            ?>
                            <div class="swiper-slide">
                                <div class="slide-content">
                                    <!-- Post Image -->
                                    <?php if (has_post_thumbnail()) : ?>
                                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="slide-image">
                                    <?php endif; ?>

                                    <!-- Post Title and Excerpt -->
                                    <h3 class="slide-title"><?php the_title(); ?></h3>
                                    <p class="slide-description"><?php the_excerpt(); ?></p>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p>No slides available.</p>';
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>







<!-- Testimonials Section -->
<section class="testimonials">
    <div class="testimonial-wrapper">
        <button id="prevTestimonial" class="arrow left">
            <img id="prevImage" src="" alt="Previous Testimonial">
            <div class="overlay"></div>
            <span>&#8592;</span>
        </button>

        <div class="testimonial-content">
            <div class="testimonial-slider">
                <?php
                $args = ['post_type' => 'testimonial', 'posts_per_page' => -1, 'post_status' => 'publish', 'order' => 'DESC'];
                $query = new WP_Query($args);
                $testimonials = [];

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $title_parts = explode(' ', get_the_title());
                        if (isset($title_parts[1])) {
                            $title_parts[1] = '<span class="blue-text">' . $title_parts[1] . '</span>';
                        }

                        $testimonials[] = [
                            'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                            'title' => $title_parts,
                            'content' => apply_filters('the_content', get_the_content())
                        ];
                    endwhile;
                    wp_reset_postdata();
                endif;

                foreach ($testimonials as $index => $testimonial) :
                    ?>
                    <div class="testimonial-slide" data-index="<?php echo $index; ?>">
                        <div class="testimonial-img">
                            <img src="<?php echo esc_url($testimonial['image']); ?>" alt="<?php echo esc_attr(implode(' ', $testimonial['title'])); ?>">
                        </div>
                        <div class="testimonial-text">
                            <p><?php echo wp_kses_post($testimonial['content']); ?></p>
                            <h3><?php echo wp_kses_post(implode(' ', $testimonial['title'])); ?></h3>
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>

        <button id="nextTestimonial" class="arrow right">
            <img id="nextImage" src="" alt="Next Testimonial">
            <div class="overlay"></div>
            <span>&#8594;</span>
        </button>
    </div>
</section>


<!-- Counter -->
<section class="counter-section">
    <?php
    $args = array(
     'post_type' => 'counter',
     'posts_per_page' => 1
    );
    $counter_query = new WP_Query($args);
    if ($counter_query->have_posts()) :
        while ($counter_query->have_posts()) : $counter_query->the_post();
            $projects_completed = get_post_meta(get_the_ID(), 'projects_completed', true);
            $hours_coding = get_post_meta(get_the_ID(), 'hours_coding', true);
            $happy_clients = get_post_meta(get_the_ID(), 'happy_clients', true);
    ?>
            <div class="counter-box">
                <h2><?php echo esc_html($projects_completed); ?> <span class="blue">+</span></h2>
                <p>Projects Completed</p>
            </div>
            <div class="counter-box">
                <h2><?php echo esc_html($hours_coding); ?> <span class="blue">m</span></h2>
                <p>Hours Coding</p>
            </div>
            <div class="counter-box">
                <h2><?php echo esc_html($happy_clients); ?> <span class="blue">+</span></h2>
                <p>Happy Clients</p>
            </div>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</section>



<!-- Recent Posts Section -->
<section class="recent-posts">
    <div class="recent-posts-header">
        <h2>Recent <span>Posts</span></h2>
        <!-- Link to the 'recent' category archive page -->
        <a href="<?php echo get_category_link( get_cat_ID( 'recent' ) ); ?>" class="view-all">VIEW ALL</a>
    </div>
    <div class="posts-grid">
        <?php
        // WP_Query to fetch recent posts of custom post type 'recent_posts' with the 'recent' category
        $args = array(
            'post_type' => 'recent_posts', // Custom Post Type
            'posts_per_page' => 3, // Fetch 3 posts
            'post_status' => 'publish', // Only published posts
            'orderby' => 'date', // Order by post date
            'order' => 'DESC', 
            'tax_query' => array( 
                array(
                    'taxonomy' => 'category', 
                    'field'    => 'slug', 
                    'terms'    => 'recent', 
                    'operator' => 'IN', 
                ),
            ),
        );

        // Perform the query
        $recent_posts = new WP_Query($args);

        // Check if there are any posts
        if ($recent_posts->have_posts()) :
            while ($recent_posts->have_posts()) : $recent_posts->the_post();
        ?>
                <article class="post-card">
                    <div class="post-image">
                        <!-- Display post thumbnail image -->
                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                    </div>
                    <div class="post-content">
                        <!-- Display post title and date -->
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p>Admin | <?php echo get_the_date('d M, Y'); ?></p>
                    </div>
                </article>
        <?php
            endwhile;
            wp_reset_postdata(); // Reset post data after custom query
        else :
            echo '<p>No recent posts found.</p>';
        endif;
        ?>
    </div>
</section>







<!-- Contact Section -->

<section class="contact-section">
    <div class="contact-container">
        <?php
        $args = array(
            'post_type'      => 'post',
            'name'           => 'contact-us', 
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => 'Contact',
                ),
            ),
        );
        $new_page_query = new WP_Query($args);
        if ($new_page_query->have_posts()) :
            while ($new_page_query->have_posts()) : $new_page_query->the_post();
            
            // Split the title at the "?" 
            $title_parts = explode("?", get_the_title());
            ?>
            <div class="contact-header">
                <h1 class="contact-title">
                    <?php 
                    echo $title_parts[0];

                    if (isset($title_parts[1])) {
                        echo ' <span style="color: blue;">?' . $title_parts[1] . '</span>';
                    }
                    ?>
                </h1>
            </div>
            <div class="contact">
                <?php the_content(); ?>
            </div>
            <?php endwhile;
            wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="no-content">No content found.</p>
        <?php endif; ?>
    </div>
</section>



    <?php
    get_footer(); 
    ?>