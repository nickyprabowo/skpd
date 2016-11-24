
<?php get_header(); ?>

    <?php if ( have_posts() ) : ?>

      <?php while ( have_posts() ) : the_post(); ?>

  
    <div class="ui container">
      <div class="white content">
        <h1 class="ui header"><?php the_title(); ?></h1>
        <div class="ui fluid featured image">
            <?php the_post_thumbnail('single-thumbnail'); ?>
        </div>
        <div class="description">
          <p><?php the_content(); ?></p>
        </div>
      </div>
  
      <?php endwhile; ?>

      <div class="comment-section">
        <?php
            if ( comments_open() || '0' != get_comments_number() )
              comments_template( '/comments.php', true );
          ?>
      </div>

    <?php else : ?>
        
        <div class="description">
          <h1 class="404">Nothing has been posted like that yet</h1>
        </div>

    <?php endif; ?>
    
    <?php wp_reset_query(); ?>
    </div>
  

</div>

<?php get_footer(); ?>