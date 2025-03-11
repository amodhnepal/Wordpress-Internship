<?php get_header(); ?>

<section class="arrivals-archive">
    <h1>New Arrivals</h1>
    <div class="arrival-grid">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="seller-item">
                <a href="<?php the_permalink(); ?>">
                    <div class="seller-image">
                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title(); ?>">
                    </div>
                    <h3><?php the_title(); ?></h3>
                    <p class="excerpt"><?php echo get_the_excerpt(); ?></p>
                </a>
            </div>
        <?php endwhile; else : ?>
            <p>No arrivals found.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
