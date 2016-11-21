<div class="ui grid container">
	<div class="ui very relaxed items">
	
	<?php if ( have_posts() ) : ?>
    	<?php
  
    	while ( have_posts() ) : the_post(); ?>

	  <div class="item">
	  	<div class="ui tiny image event-date-bg">
	  		<div class="event-date">
	  			<p class="event-day"><?php echo date( 'd', intval($post->start) ); ?></p>
	  			<p class="event-month">June</p>
	  		</div>
	  	</div>
	    <div class="content">
	      <a class="header"><?php the_title(); ?></a>
	      <div class="meta">
	        <span><i class="marker icon"></i> <?php $post->venue; ?></span>
	      </div>
	      <div class="description">
	        <p><?php the_content();?></p>
	      </div>
	    </div>
	  </div>

		<?php endwhile; ?>
	<?php endif; ?>
	</div>
</div>