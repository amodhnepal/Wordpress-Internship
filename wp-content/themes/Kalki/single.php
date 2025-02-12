<?php get_header(); ?>

<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="single-post">
            <h1><?php the_title(); ?></h1>
            <p class="post-meta">Published on <?php echo get_the_date(); ?> by <?php the_author(); ?></p>

            <!-- Featured Image -->
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
            <?php endif; ?>

            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <!-- Back to Blog Button -->
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="back-button">Back to Blogs</a>
        </article>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
