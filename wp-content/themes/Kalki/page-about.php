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
            setup_postdata($about_page);
        ?>
            <div class="about-page-item">
                <h1><?php echo get_the_title($about_page); ?></h1>
                <div class="about-content">
                    <?php echo apply_filters('the_content', $about_page->post_content); ?>
                </div>
            </div>
        <?php
            wp_reset_postdata();
        else :
            echo "<p>No content found for About page.</p>";
        endif;
        ?>
    </div>

    <!-- Fetch Posts from "About" Category -->
    <div class="about-posts">
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
                <div class="about-post-item">
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
    <div class="team-section">
        <div class="team-member-wrapper">
            <?php
            $team_members = new WP_Query(array(
                'category_name' => 'person',
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'date'
            ));

            if ($team_members->have_posts()) :
                $first = true;
                while ($team_members->have_posts()) : $team_members->the_post();
                    $image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            ?>
                    <div class="team-member <?php echo $first ? 'active' : ''; ?>" data-id="<?php echo get_the_ID(); ?>">
                        <div class="team-member-content">
                            <!-- Left Side: Featured Image -->
                            <div class="team-member-image">
                                <?php if ($image) : ?>
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            </div>

                            <!-- Right Side: Name, Role, Description -->
                            <div class="team-member-details">
                                <h2><?php the_title(); ?></h2>
                                <p class="role"><?php the_excerpt(); ?></p>
                                <div class="team-description">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    $first = false;
                endwhile;
                wp_reset_postdata();
            else :
                echo "<p>No team members found.</p>";
            endif;
            ?>
        </div>

        <!-- Team Member Thumbnails -->
        <div class="team-thumbnails">
            <?php
            $team_members = new WP_Query(array(
                'category_name' => 'person',
                'posts_per_page' => 4,
                'order' => 'ASC',
                'orderby' => 'date'
            ));

            if ($team_members->have_posts()) :
                while ($team_members->have_posts()) : $team_members->the_post();
                    $image = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                    if ($image) :
            ?>
                    <div class="team-thumbnail" data-id="<?php echo get_the_ID(); ?>">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>">
                    </div>
            <?php
                    endif;
                endwhile;
                wp_reset_postdata();
            else :
                echo "<p>No team members found.</p>";
            endif;
            ?>
        </div>

        <!-- Navigation Buttons -->
        <div class="team-slider-controls">
            <button class="prev-slide">←</button>
            <button class="next-slide">→</button>
        </div>
    </div>
</div>

<?php get_footer(); ?>