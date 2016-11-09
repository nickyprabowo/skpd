
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

<div class="earch">
    <div class="ui text container">
      <div class="ui stackable grid">
        <div class="ui sixteen wide column list">

          <div class="ui items">
            
            <?php if ( have_posts() ) : ?>
            
                <?php

                while ( have_posts() ) : the_post(); ?>
                    <div class="item">
                      <div class="content">
                        <div class="meta">
                          <span class="tanggal"><?php the_time('d F Y'); ?></span>
                        </div>
                        <div class="header">
                          <h2 class="stripe blue"><?php the_title(); ?></h2>
                        </div>
                        <div class="description">
                          <p><?php echo excerpt (60); ?></p>
                        </div>
                        <a class="read-more" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                          SELENGKAPNYA
                          <i class="long arrow right icon"></i>
                        </a>
                      </div>
                    </div>

                <?php endwhile; ?> 
            
                <!-- Add the pagination functions here. -->

                <?php 

                  wp_pagenavi(); 
                  wp_reset_postdata();

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