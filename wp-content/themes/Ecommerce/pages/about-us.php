<?php
/**
 * Template Name: Lookbook
 */

get_template_part('assets/inc/header'); ?>

<main class="lookbook-container">
    <h1 class="page-title ">Lookbook</h1>

    <?php
    $lookbook_query = new WP_Query(array(
        'post_type' => 'lookbook',
        'posts_per_page' => -1,
        'order' => 'DESC',
    ));

    if ($lookbook_query->have_posts()) :
        while ($lookbook_query->have_posts()) : $lookbook_query->the_post(); ?>

            <section class="lookbook-item">
                <div class="lookbook-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
                <div class="lookbook-text">
                    <h2><?php the_title(); ?></h2>
                    <div class="lookbook-content">
                    <p><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="shop-btn">Shop Now</a>
                    </div>
                </div>
            </section>

        <?php endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No Lookbook items found.</p>';
    endif; ?>

</main>

<?php get_template_part('assets/inc/footer'); ?>
