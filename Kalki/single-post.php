<?php get_header(); ?>

<div class="single-post-container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="single-post-content">
            <h1 class="post-title"><?php the_title(); ?></h1>

            
            <?php if (get_post_type() == 'post') : ?>
                <p class="post-meta">Published on <?php echo get_the_date(); ?> by <?php the_author(); ?></p>
            <?php endif; ?>

            
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            
            <div class="post-content">
                <?php the_content(); ?>
            </div>

            
            <?php if (get_post_type() == 'post') : ?>
                <div class="post-categories">
                    <strong>Categories:</strong> <?php the_category(', '); ?>
                </div>
            <?php endif; ?>


        </article>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
