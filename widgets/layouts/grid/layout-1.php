<?php 
  if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly     

while ( $all_posts->have_posts() ) :
    $all_posts->the_post(); ?>
    <div class="swiper-slide">
    <article id="post-<?php the_ID(); ?>" class="postify__item">
                <?php $this->render_thumbnail(); ?>
            <?php $this->render_category(); ?>
            <div class="postify__item__content">
                <?php $this->render_meta(); ?>
                <?php $this->render_title(); ?>
                <?php $this->render_excerpt(); ?>
                <?php $this->render_readmore(); ?>
            </div>
        </article>
        </div>
        <?php
endwhile; 
wp_reset_postdata();