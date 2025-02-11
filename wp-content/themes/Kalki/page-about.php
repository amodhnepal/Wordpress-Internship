<?php
/*
Template Name: About Us
*/
get_header();
?>

<div class="about-us-container">
    <!-- Fetch Content from "About" Page -->
    <div class="about-page-content">
        <?php
        $about_page = get_page_by_path('about'); 
        if ($about_page) :
        ?>
            <div class="about-page-item">
                <h1><?php echo esc_html(get_the_title($about_page)); ?></h1>
                <div class="about-content">
                    <?php echo apply_filters('the_content', $about_page->post_content); ?>
                </div>
            </div>
        <?php
        else :
            echo "<p>No content found for About page.</p>";
        endif;
        ?>
    </div>

    <!-- Fetch Posts from "About" Category -->
    <div class="about-posts slider"> 
        <?php
        $about_posts = new WP_Query(array(
            'category_name' => 'about', 
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'date'
        ));

        if ($about_posts->have_posts()) :
            while ($about_posts->have_posts()) : $about_posts->the_post();
        ?>
                <div class="about-post-item slide">
                    <h2><?php the_title(); ?></h2>
                    <div class="about-post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo "<p>No posts found in About category.</p>";
        endif;
        ?>
    </div>

   
    

    <!-- Team Member Section -->
    <?php
    $team_query = new WP_Query(array(
        'category_name' => 'person',
        'posts_per_page' => -1,
    ));

    if ($team_query->have_posts()) :
    ?>
    <section class="team-section">
        <div class="team-container">
            <!-- Left: Large Image -->
            <div class="team-main">
                <?php
                $first = true;
                while ($team_query->have_posts()) : $team_query->the_post();
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                ?>
                    <div class="team-member-large <?php echo $first ? 'active' : ''; ?>" data-id="<?php echo get_the_ID(); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>">
                    </div>
                <?php
                    $first = false;
                endwhile;
                ?>
            </div>

            <!-- Right: Name & Description -->
            <div class="team-info">
                <?php
                $first = true;
                $team_query->rewind_posts(); // Reset loop
                while ($team_query->have_posts()) : $team_query->the_post();
                ?>
                    <div class="team-member-text <?php echo $first ? 'active' : ''; ?>" data-id="<?php echo get_the_ID(); ?>">
                        <h2><?php the_title(); ?></h2>
                        <p><?php the_excerpt(); ?></p>
                    </div>
                <?php
                    $first = false;
                endwhile;
                ?>
            </div>
        </div>

        <!-- Navigation Arrows -->
        <div class="team-controls">

            <button id="prev-btn">←</button>
            <button id="next-btn">→</button>
        </div>

        <!-- Thumbnails -->
        <div class="team-thumbnails">
            <?php
            $first = true;
            $team_query->rewind_posts();
            while ($team_query->have_posts()) : $team_query->the_post();
                $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            ?>
                <div class="team-thumb <?php echo $first ? 'selected' : ''; ?>" data-id="<?php echo get_the_ID(); ?>">
                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title(); ?>">
                </div>
            <?php
                $first = false;
            endwhile;
            ?>
        </div>
    </section>
    <?php
    wp_reset_postdata();
    endif;
    ?>
</div>


<?php get_footer(); ?>
