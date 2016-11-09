<div class="ui grid container">
	<div class="ui items">
	<?php if ( have_posts() ) : ?>
              
    <?php
  
    	while ( have_posts() ) : the_post(); ?>

	  <div class="item">
	  	<div class="ui tiny image event-date-bg">
	  		<div class="event-date">
	  			<p class="event-day">17</p>
	  			<p class="event-month">June</p>
	  		</div>
	  	</div>
	    <div class="content">
	      <a class="header"><?php the_title(); ?></a>
	      <div class="meta">
	        <span><i class="marker icon"></i> Balai Kota</span>
	      </div>
	      <div class="description">
	        <p>Esse, voluptatibus minus necessitatibus veritatis itaque magnam recusandae, ad eum veniam sapiente cumque fugiat ipsam nesciunt nam cupiditate tempore, omnis beatae id!</p>
	      </div>
	    </div>
	  </div>

		<?php endwhile; ?>
	<?php endif; ?>
	</div>
</div>