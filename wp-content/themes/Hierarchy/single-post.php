<?php
get_header();


echo "This is single-post.php";
echo"Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aspernatur
 eaque unde nihil iure cupiditate at architecto a, quae tempore facere itaque et consequuntur maxime
  numquam omnis magnam reprehenderit sint voluptate?";
  the_content();
?>
<a href="<?php the_permalink() ?>">single post-hello world</a>
<?php


get_footer();


?>