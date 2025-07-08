<?php get_header(); ?>
   <h1><?php post_type_archive_title(); ?></h1>
   <ul>
       <?php
       while ( have_posts() ) : the_post(); ?>
           <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
       <?php endwhile; ?>
   </ul>
   <?php get_footer(); ?>