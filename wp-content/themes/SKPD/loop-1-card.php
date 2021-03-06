
  <?php if ( have_posts() ) : ?>

    <?php
  
    while ( have_posts() ) : the_post(); ?>

        <a class="ui flat fluid card" href="<?php the_permalink(); ?>"">
          <div class="ui image">
            <?php 
              if ( has_post_thumbnail() ) {
                the_post_thumbnail();
              } ?>
          </div>
          <div class="content">
            <div class="ui header"><?php the_title(); ?></div>
            
            <div class="description">
              <p><?php echo excerpt(20); ?></p>
            </div>
          </div>
          <div class="extra content">
            <span class="right floated">
              <div class="ui label"><i class="comment icon"></i> <?php echo $post->comment_count;?></div>
            </span>
            <span>
              <i class="calendar icon"></i> <?php the_time('d F Y'); ?>
            </span>
          </div>
        </a>
        
      <?php endwhile; ?>

  <?php else : ?>

    <p><?php _e('Sorry, no images available'); ?></p>

  <?php endif; ?>
  