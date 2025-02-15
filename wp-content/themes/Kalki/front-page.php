<?php
/*
Template Name: Front Page
*/
require get_template_directory() . '/banner.php';
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



<!-- Featured Projects Section -->
<section class="featured-projects">
    <!-- Rectangle Image -->
    <img src="/wp-content/themes/kalki/assets/img/featured-rectangle.png" alt="Featured Rectangle" class="background-rectangle">

    <div class="content">
        <h2>Featured <span>Projects</span></h2>
        <button class="view-all">View All</button>
        <br>
        <div class="nav-buttons">
            <button id="prev">
                <img src="/wp-content/themes/kalki/assets/img/arrow-left.png" alt="Previous">
            </button>
            <button id="next">
                <img src="/wp-content/themes/kalki/assets/img/arrow-right.png" alt="Next">
            </button>
        </div>
    </div>

    <div class="slider-container">
        <div class="slider">
            <?php
            $args = [
                'post_type' => 'post',
                'posts_per_page' => 3,
                'category_name' => 'Slider'
            ];
            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    ?>
                    <div class="slide">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <h3><?php the_content(); ?></h3>
                        <h3><?php the_title(); ?></h3>
                        <p><?php the_excerpt(); ?></p>
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
    <div class="counter-box"><h2>400 <span class="blue">+</span></h2><p>Projects Completed</p></div>
    <div class="counter-box"><h2>150 <span class="blue">m</span></h2><p>Hours Coding</p></div>
    <div class="counter-box"><h2>700 <span class="blue">+</span></h2><p>Happy Clients</p></div>
</section>

<!-- Recent Posts Section -->
<section class="recent-posts">
    <div class="recent-posts-header">
        <h2>Recent <span>Posts</span></h2>
        <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="view-all">VIEW ALL</a>
    </div>
    <div class="posts-grid">
        <?php
        $args = ['post_type' => 'recent_post', 
        'posts_per_page' => 3, 
        'orderby' => 'date', 
        'order' => 'DESC'
        ];
        $recent_posts = new WP_Query($args);

        if ($recent_posts->have_posts()) :
            while ($recent_posts->have_posts()) : $recent_posts->the_post();
        ?>
                <article class="post-card">
                    <div class="post-image">
                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                    </div>
                    <div class="post-content">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p>Admin | <?php echo get_the_date('d M, Y'); ?></p>
                    </div>
                </article>
        <?php
            endwhile;
            wp_reset_postdata();
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