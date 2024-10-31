<?php 
  if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly     
while ( $all_posts->have_posts() ) :
    $all_posts->the_post(); ?>
        <article id="post-<?php the_ID(); ?>" class="postify__item">
              <?php $this->render_meta(); ?>
              <?php $this->render_title(); ?>
              <?php $this->render_thumbnail(); ?>
              <div class="postify__item__content">
              <?php $this->render_excerpt(); ?>
              <?php $this->render_readmore(); ?>
              </div>
            </article>

        <?php
endwhile; 
wp_reset_postdata();