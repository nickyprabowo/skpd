
<?php 

  get_header(); 
  global $wp_query;
  $total_results = $wp_query->found_posts;

?>

  <div class="ui light-grey vertical searchform segment">
    <div class="ui text container">
      <form action="<?php echo home_url( '/' ); ?>" method="get">
        <div class="ui search fluid icon input">
          <input class="prompt" type="text" placeholder="Search ....." name="s" id="search" value="<?php the_search_query(); ?>">
          <i class="search icon"></i>
      </div>
      </form>
      <h1 class="page-title"><?php printf( __( 'Hasil Pencarian untuk : %s', 'kelurahan ' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
      <h3><?php echo $total_results; ?> Dokumen ditemukan</h3>
    </div>
  </div>

  <div class="page-content">
    <div class="ui text container">
      <div class="ui stackable grid">
        <div class="ui sixteen wide column">
          <div class="ui very relaxed divided items">
          <?php if ( have_posts() ) : ?>
            
            <?php while ( have_posts() ) : the_post(); ?>

              
                <div class="item">
                  <?php global $post; ?>
                  <div class="content">
                    <a class="header" href="<?php echo get_the_permalink(); ?>"><?php the_title() ?></a>
                    <div class="meta">
                      <span class="price"><?php the_date(); ?></span>
                    </div>
                    <div class="description">
                      <p><?php echo excerpt(20); ?></p>
                    </div>
                    <div class="extra">
                      <div class="ui label"><i class="comment icon"></i> <?php echo $post->comment_count;?></div>
                    </div>
                  </div>
                </div>
              

            <?php endwhile; ?> 
              
                <!-- Add the pagination functions here. -->
              <?php 

                // wp_pagenavi(); 
                wp_reset_postdata();

              ?>
          </div>
        </div>
            
        <div class="ui centered grid">
          <div class="column">
            <?php echo paginate_links(); ?>
          </div>
        </div>

        <?php else : ?>

            <article class="post error">
                <h1 class="404">Maaf, konten yang Anda cari tidak tersedia</h1>
            </article>

        <?php endif; ?>
      </div>
    </div>
  </div>

<?php get_footer(); ?>