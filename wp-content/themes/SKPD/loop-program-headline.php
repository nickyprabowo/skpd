
  <?php if ( have_posts() ) : ?>
	<!-- <div class="ui items"> -->
  <div class="ui two stackable link fluid cards headline-program">

    <?php
    
      while ( have_posts() ) : the_post(); ?>

        <a class="flat card" href="<?php the_permalink(); ?>">
          <div class="ui huge image">
            <?php 
              if ( has_post_thumbnail() ) {
                the_post_thumbnail();
              } ?>
          </div>
          <div class="content">
            <div class="ui medium header" href="<?php the_permalink(); ?>""><?php the_title(); ?></div>
            <div class="meta">
              <?php 

                global $post;
                echo custom_taxonomies_terms_links($post->ID);

               ?>
            </div>
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

  </div>
    
  <?php else : ?>

    <p><?php _e('Sorry, no programs available'); ?></p>

  <?php endif; ?>

