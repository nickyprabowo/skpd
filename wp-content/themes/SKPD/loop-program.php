<div class="ui grid container">
  <?php if ( have_posts() ) : ?>
  <div class="ui link three stackable fluid cards">            
    <?php
  
    while ( have_posts() ) : the_post(); ?>

        <div class="flat card">
          <div class="ui massive image">
            <?php 
              if ( has_post_thumbnail() ) {
                the_post_thumbnail();
              } ?>
          </div>
          <div class="content">
            <div class="ui header"><?php the_title(); ?></div>
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
              <i class="calendar icon"></i> <?php the_time('d F Y'); ?>
            </span>
          </div>
        </div>
        

      <?php endwhile; ?>
      </div>
          <?php else : ?>

      <p><?php _e('Sorry, no images available'); ?></p>

      <?php endif; ?>
      
  </div>