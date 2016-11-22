<div class="ui grid container">
	<div class="ui relaxed items">
	<?php if ( have_posts() ) : ?>
              
    <?php
  
    	while ( have_posts() ) : the_post(); ?>

		  <div class="item">
		    <div class="ui custom-img image">
		      <?php 
              if ( has_post_thumbnail() ) {
                the_post_thumbnail();
              } ?>
		    </div>
		    <div class="content">
		      	<a class="header"><?php the_title(); ?></a>
		      	<div class="meta">
			        <span><i class="calendar icon"></i> <?php the_time('d F Y'); ?></span>
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
		  
		<?php endwhile; ?>
	<?php endif; ?>
	</div>
</div>