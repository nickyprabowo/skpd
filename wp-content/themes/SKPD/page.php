
<?php get_header(); ?>

    <div class="ui stackable grid container">
      <div class="ui sixteen wide column">
          
          <?php if ( have_posts() ) : ?>
          
              <?php

              while ( have_posts() ) : the_post(); ?>

                <?php the_content(); ?>

              <?php endwhile; ?> 

          <?php else : ?>

              <article class="post error">
                  <h1 class="404">Maaf, konten yang Anda cari tidak tersedia</h1>
              </article>

          <?php endif; ?>
      </div>
    </div>

</div>

<?php get_footer(); ?>