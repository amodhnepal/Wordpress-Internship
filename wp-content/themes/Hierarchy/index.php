<?php

get_header();
 echo " This is index.php  ";
while(have_posts()){
    the_post();
    the_title();
    the_content();
}
    get_footer();
?>