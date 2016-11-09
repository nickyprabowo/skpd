
<?php get_header(); ?>

  <div class="ui container">
    <div class="ui stackable grid">
      <div class="ui sixteen wide column">
        <div class="ui items">
          
          <?php if ( have_posts() ) : ?>
          
              <?php
  
              while ( have_posts() ) : the_post(); ?>
                  <div class="item">
                    <div class="content">
                      <div class="header">
                        <h2 class="stripe blue"><?php the_title(); ?></h2>
                      </div>
                      <div class="description">
                        <p><?php the_excerpt (); ?></p>
                      </div>
                    </div>
                  </div>

              <?php endwhile; ?> 

              <!-- Add the pagination functions here. -->

              <?php 

                /*wp_pagenavi(array('query' => $pos)); 
                wp_reset_postdata();*/

              ?>


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