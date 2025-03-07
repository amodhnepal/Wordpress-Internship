<?php
/* Template Name: Women Page */
get_template_part('assets/inc/header'); ?>

<div class="women-products">
  <h1>Women's Products</h1>

  <?php
  // Query products from 'Women' category
  $args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
      array(
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => 'women', // Women category slug
        'operator' => 'IN',
      ),
    ),
  );
  $query = new WP_Query( $args );
  
  if ( $query->have_posts() ) :
    while ( $query->have_posts() ) : $query->the_post();
      wc_get_template_part( 'content', 'product' );
    endwhile;
    wp_reset_postdata();
  else :
    echo 'No products found for Women.';
  endif;
  ?>
</div>

<?php get_template_part('assets/inc/footer');?>
