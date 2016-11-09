
<?php get_header(); ?>

  <div class="ui container">
    <div class="ui stackable grid">
      <div class="ui sixteen wide column">
        <div class="ui items">
          
          <?php if ( have_posts() ) : ?>
          
              <?php

              while ( have_posts() ) : the_post(); ?>
                <article class="content">
                  <div class="ui container">
                    <div class="single-post-title">
                      <div class="post-content">
                        <?php the_content(); ?>
                      </div>
                    </div>
                  </div>
                </article>

              <?php endwhile; ?> 

          <?php else : ?>

              <article class="post error">
                  <h1 class="404">Maaf, konten yang Anda cari tidak tersedia</h1>
              </article>

          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>

</div>

<?php get_footer(); ?>