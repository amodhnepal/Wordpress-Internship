    <?php
    /*
    Template Name: Front Page
    */

        get_header(); 
    ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <!-- Banner Section -->
            <section class="banner-section">
                <?php
                // Display the banner image
                $banner_image = get_template_directory_uri() . '/assets/img/banner.png';
                ?>
                <img src="<?php echo esc_url($banner_image); ?>" alt="Banner Image" class="banner-image">
                <div class="banner-content">
                    <h1>Automate <br>Workflow With Us</h1>
                    <a href="#new-page-content" class="btn">VIEW MORE</a>
                </div>
            </section>

            <!-- New Page Content Below Banner -->
            <section id="new-page-content" class="new-page-content">
                <div class="container">
                    <?php
                
                $args = array(
                    'post_type'      => 'page', 
                    'pagename'       => 'Home', 
                    'posts_per_page' => 1, 
                    );
                    
                    $new_page_query = new WP_Query($args);
                    
                    if ($new_page_query->have_posts()) :
                        while ($new_page_query->have_posts()) : $new_page_query->the_post();
                        the_content(); 
                    endwhile;
                    wp_reset_postdata(); 
                    else :
                         echo '<p>No content found.</p>'; // Fallback message
                    endif;
                    ?>
                <nav class="main-nav">
                    <?php
                    // Display the navigation menu
                    wp_nav_menu(array(
                        'menu'=> 'kalki_menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false, 
                    ));
                    ?>
                </nav>
                </div>
            </section>

            <!-- Navigation Menu -->

        </main>
        </div>

        <div class="container-achieve">
    <?php
    $args = array(
        'post_type'      => 'page', 
        'pagename'       => 'Achievement', 
        'posts_per_page' => 1, 
    );
    
    $new_page_query = new WP_Query($args);
    
    if ($new_page_query->have_posts()) :
        ?>
            <?php
            while ($new_page_query->have_posts()) : $new_page_query->the_post();
            
            ?>
            <div class="achieve">
                <?php  the_content(); 
                
            endwhile;
            wp_reset_postdata(); 
            ?>
        </div>
    <?php
    else :
        echo '<p>No content found.</p>'; // Fallback message
    endif;
    ?>
</div>


<!-- Service section -->
 <?php
function service_custom_post_type() {
	register_post_type('service',
		array(
			'labels'      => array(
				'name'          => __('Services', 'service'),
				'singular_name' => __('Service', 'service'),
			),
				'public'      => true,
				'has_archive' => true,
		)
	);
}
add_action('init', 'service_custom_post_type');


$args = array(
	'post_type'      => 'service',
	'posts_per_page' => 1,
);
$loop = new WP_Query($args);
while ( $loop->have_posts() ) {
	$loop->the_post();
	?>
	<div class="entry-content">
		<!-- <?php the_title(); ?> -->
		<!-- <?php the_content(); ?> -->
        
	</div>
	<?php
}
?>
<hr>

 <!-- achievement Content Below Banner -->
 <div class="container-mata-service serv">
    <?php
        $args = array(
            'post_type'      => 'page',
            'pagename'       => 'service',
            'posts_per_page' => 1,
        );
        $new_page_query = new WP_Query($args);
        if ($new_page_query->have_posts()) {
            while ($new_page_query->have_posts()) {
                $new_page_query->the_post();
                ?>
                <div class="service">
                    <?php the_content(); ?>
                </div>
                <?php
            }
            wp_reset_postdata();
        } else {
            echo '<p>No content found.</p>';
        }
    ?>

    <!-- Dynamic Circles in Plus Formation -->
    <div class="circle-container">
        <?php
            $circle_args = array(
                'category_name'  => 'serv', 
                'posts_per_page' => 4, 
            );
            $circle_query = new WP_Query($circle_args);
            
            $circle_classes = ['circle-top', 'circle-left', 'circle-right', 'circle-bottom']; 
            $icons = ['fa-gem', 'fa-layer-group', 'fa-desktop', 'fa-gear']; 
            
            $i = 0;
            if ($circle_query->have_posts()) {
                while ($circle_query->have_posts() && $i < 4) { 
                    $circle_query->the_post();
                    ?>
                    <div class="circle <?php echo $circle_classes[$i]; ?>">
                        <i class="fas <?php echo $icons[$i]; ?>"></i>
                        <h1><?php the_title(); ?></h1>
                        <h3><?php the_excerpt(); ?></h3>
                    </div>
                    <?php
                    $i++;
                }
                wp_reset_postdata();
            } else {
                echo '<p>No service sections found in this category.</p>';
            }
        ?>
    </div>
</div>

</div>


<!-- Featured Projects Section -->
<section class="featured-projects">
    <div class="content">
        <h2>Featured <span>Projects</span></h2>
        <br>
        <button class="view-all">View All</button>
        <br>
        <br>
        <div class="nav-buttons">
            <button id="prev">&#8592;</button>
            <button id="next">&#8594;</button>
        </div>
    </div>
    <div class="slider-container">
        <div class="slider">
            <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'category_name'  => 'Slider',
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="slide">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <h3><?php the_content(); ?></h3>
                        <h3><?php the_title(); ?></h3>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p>No slides available.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<!-- Testimonial -->
<?php

function create_testimonial_post_type() {
    register_post_type('testimonial',
        array(
            'labels'      => array(
                'name'          => __('Testimonials'),
                'singular_name' => __('Testimonial'),
            ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array('title', 'editor', 'thumbnail'),
        )
    );
}
add_action('init', 'create_testimonial_post_type');
?>

<!-- Testimonials Section -->
<section class="testimonials">
    <div class="testimonial-wrapper">
        <button id="prevTestimonial" class="arrow left">
            <img id="prevImage" src="" alt="Previous">
            <span>&#8592;</span>
        </button>

        <div class="testimonial-content">
            <div class="testimonial-slider">
                <?php
                $args = array(
                    'post_type'      => 'testimonial',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'order'          => 'DESC'
                );

                $query = new WP_Query($args);
                $testimonials = [];

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $testimonials[] = array(
                            'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                            'title' => get_the_title(),
                            'content' => apply_filters('the_content', get_the_content()) // Fix content formatting
                        );
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>

                <?php foreach ($testimonials as $index => $testimonial) : ?>
                    <div class="testimonial-slide" data-index="<?php echo $index; ?>">
                        <div class="testimonial-img">
                            <img src="<?php echo esc_url($testimonial['image']); ?>" alt="<?php echo esc_attr($testimonial['title']); ?>">
                        </div>
                        <div class="testimonial-text">
                            <p><?php echo wp_kses_post($testimonial['content']); ?></p>
                            <h3><?php echo esc_html($testimonial['title']); ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button id="nextTestimonial" class="arrow right">
            <img id="nextImage" src="" alt="Next">
            <span>&#8594;</span>
        </button>
    </div>
</section>



<!-- Counter -->


<section class="counter-section">
    <div class="counter-box">
        <h2>400 <span class="blue">+</span></h2>
        <p>Projects Completed</p>
    </div>
    <div class="counter-box">
        <h2>150 <span class="blue">m</span></h2>
        <p>Hours Coding</p>
    </div>
    <div class="counter-box">
        <h2>700 <span class="blue">+</span></h2>
        <p>Happy Clients</p>
    </div>
</section>


<!-- Recent Posts Section -->
<section class="recent-posts">
    <div class="recent-posts-header">
        <h2>Recent <span >Posts</span></h2>
        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>" class="view-all">VIEW ALL</a>
    </div>

    <div class="posts-grid">
        <?php
        $args = array(
            'post_type'      => 'recent_post',
            'posts_per_page' => 3,
            'orderby'        => 'date',
            'order'          => 'DESC'
        );
        $recent_posts = new WP_Query($args);
        if ($recent_posts->have_posts()) :
            $post_count = 0;
            while ($recent_posts->have_posts()) : $recent_posts->the_post();
                $post_count++;
                ?>
                <article class="post-card <?php echo ($post_count == 2) ? 'active' : ''; ?>">
                    
                    <!-- Featured Image -->
                    <div class="post-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                        <?php else : ?>
                            <img src="https://via.placeholder.com/300" alt="Default Image">
                        <?php endif; ?>
                    </div>

                    <!-- Post Content -->
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
            'name'           => 'contact-us', // 'postname' should be 'name' and use the slug
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
        ?>
            <?php while ($new_page_query->have_posts()) : $new_page_query->the_post(); ?>
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