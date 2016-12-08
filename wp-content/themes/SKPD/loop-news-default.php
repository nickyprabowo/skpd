<div class="ui stackable grid two column">

	<?php 

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
				'post_type' => 'berita',
				'posts_per_page' => 6,
				'paged' => $paged
			);

		$berita = new WP_Query($args);

	?>

	<?php if ( $berita->have_posts() ) : ?>
              
    <?php
  
    	while ( $berita->have_posts() ) : $berita->the_post(); ?>

		<div class="column">
			<div class="ui relaxed items">
			  <div class="item">
			    <div class="ui custom-img image">
			    	<?php 
		              if ( has_post_thumbnail() ) {
		                the_post_thumbnail();
		              } 
		            ?>
			    </div>
			    <div class="content">
			      	<a class="ui header" href="<?php the_permalink(); ?>""><?php the_title(); ?></a>
			      	<div class="meta">
				        <span><i class="calendar icon"></i> <?php the_time('d F Y'); ?></span>
				        <span>
			              <i class="comment icon"></i> <?php echo $post->comment_count;?>
			            </span>
				    </div>
			      	<div class="description">
			        	<p><?php echo excerpt(20); ?></p>
			      	</div>
			      	<div class="extra">
			      		<?php 

		                global $post;
		                echo custom_taxonomies_terms_links($post->ID);

		               ?>
			      	</div>
			    </div>
			  </div>
			</div>
		</div>

		<?php endwhile; ?>

		<!-- Add the pagination functions here. -->
		  <div class="one column centered row">
		  	<div class="column">
		  		<?php 

		          wp_pagenavi(array( 'query' => $berita )); 
		          wp_reset_postdata();

		        ?>
		  	</div>
		  </div>
        
	<?php endif; ?>
</div>