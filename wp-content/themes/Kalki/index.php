<?php
/**
 * The main template file
 *
 * @package Kalki_Automation_Services
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="content-section">
        <div class="page-layout">
            
            <?php if ( have_posts() ) : ?>

                <?php if ( is_home() && ! is_front_page() ) : ?>
                    <header class="section-header">
                        <h1 class="section-title"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>

                <div class="article-list">
                    <?php 
                    while ( have_posts() ) :
                        the_post();
                        get_template_part( 'template-parts/content', get_post_type() );
                    endwhile;
                    ?>
                </div>

                <?php the_posts_navigation(); ?>

            <?php else : ?>

                <div class="empty-content">
                    <?php get_template_part( 'template-parts/content', 'none' ); ?>
                </div>

            <?php endif; ?>

        </div> <!-- .page-layout -->
    </div> <!-- .content-section -->
</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
?>
