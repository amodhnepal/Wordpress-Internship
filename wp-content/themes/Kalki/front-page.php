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

<!-- Slider -->
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
                }else {
                    echo '<p>No content found.</p>';
                }
            ?>
            <!-- Circles in Plus Formation -->
            <div class="circle-container">
            <!-- Top -->
                <div class="circle circle-top">
                    <i class="fas fa-gem"></i> <!-- Diamond icon -->
                    <h2>Automate</h2>
                    <h3>You are just a step away from leaving those</h3>
                </div>
                <div class="circle circle-left">
                    <i class="fa-solid fa-layer-group"></i> <!-- Layer icon -->
                    <h1>Design</h1>
                    <h3>You are just a step away from leaving those</h3>
                </div>
                <div class="circle circle-right">
                    <i class="fa-solid fa-desktop"></i>
                    <h1>Development</h1>
                    <h3>You are just a step away from leaving those</h3>
                </div>
                <div class="circle circle-bottom">
                    <i class="fa-solid fa-gear"></i> <!-- Settings gear icon -->
                    <h1>SEO</h1>
                    <h3>You are just a step away from leaving those</h3>
                </div>
            </div>

</script>
    <?php
    get_footer(); 
    ?>