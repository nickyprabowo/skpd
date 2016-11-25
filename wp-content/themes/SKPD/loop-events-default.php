<div class="ui stackable grid two column">
	
	<?php
	$args = array(
			'posts_per_page' => get_option( 'posts_per_page' )
		);
	$posts = tribe_get_events( $args );
	if( count( $posts ) > 0 ) :  foreach( $posts as $post ) :

		$title 	 	= apply_filters( 'the_title', $post->post_title );
		$content 	= mb_substr( $post->post_content, 0, 120);
		$permalink 	= get_permalink( $post->ID );
		$time 		= tribe_get_start_date( $post->ID, TRUE, 'U');
		$month 		= date('M', $time);
		$day		= date('d', $time);
		$year		= date('Y', $time);
		$address 	= tribe_get_address( $post->ID );
		$city 		= tribe_get_city( $post->ID );
	?>
			
		<div class="column">
			<div class="ui very relaxed items">
			  <div class="item">
			  	<div class="ui tiny image event-date-bg">
			  		<div class="event-date">
			  			<p class="event-day"><?php echo $day; ?></p>
			  			<p class="event-month"><?php echo $month; ?></p>
			  		</div>
			  	</div>
			    <div class="content">
			      <a class="ui header"><?php echo $title; ?></a>
			      <div class="meta">
			        <span class="have-icon"><i class="marker icon"></i> <?php echo $address . ', ' . $city; ?></span>
			      </div>
			      <div class="description">
			        <p><?php echo $content; ?></p>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

		<?php endforeach; ?>
	<?php endif; ?>
</div>