
<div class="ui grid">	
	<?php if ( have_posts() ) : ?>
              
    <?php
  
    	while ( have_posts() ) : the_post(); global $post;?>

			<div class="eight wide column">
				<div class="ui items">
					<div class="item">
					    <div class="ui custom-img image">
					      <?php 
			              if ( has_post_thumbnail() ) {
			                the_post_thumbnail();
			              } ?>
					    </div>
					    <div class="content">
					      	<a class="ui medium header" href="<?php the_permalink(); ?>""><?php the_title(); ?></a>
					      	<div class="meta">
						        <p>
						        	<i class="calendar icon"></i> <?php the_time('d F Y'); ?>
						        	<i class="comment icon"></i> <?php echo $post->comment_count;?>
					            </p>
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
	<?php endif; ?>
</div>	
