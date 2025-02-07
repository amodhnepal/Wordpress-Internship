<?php get_header(); ?>

<div class="service-container">
    <h1 class="service-page-title"><?php single_cat_title(); ?></h1>

    <?php if (have_posts()) : ?>
        <div class="service-items-grid">
            <?php
            // Define the icons array
            $icons = ['fa-gem', 'fa-layer-group', 'fa-desktop', 'fa-gear'];
            $index = 0; // To iterate through the icons
            ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="individual-service-item">
                    <a href="<?php the_permalink(); ?>">
                        <!-- Icon added -->
                        <div class="service-icon">
                            <i class="fas <?php echo $icons[$index % count($icons)]; ?>"></i>
                        </div>
                         <h2><?php the_title(); ?></h2>
                        <p><?php the_excerpt(); ?></p>
                    </a>
                </div>
                <?php $index++; ?>
            <?php endwhile; ?>
        </div>

        <!-- Pagination -->
        <div class="service-pagination">
            <?php echo paginate_links(); ?>
        </div>

    <?php else : ?>
        <p>No services found.</p>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
