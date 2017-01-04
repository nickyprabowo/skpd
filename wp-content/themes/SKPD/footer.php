<div class="footer">
	<div class="ui vertical segment active-footer">
	   <div class="ui stackable grid container">
	   		<div class="four wide column">
	   			<h4 class="foot-head">Link Terkait</h4>
	   			<div class="items tautan">
	   				<?php
						$args = array(
								'post_type' => 'link',
						);

						$link = new WP_Query($args); 
					?>
					<?php if ( $link->have_posts() ) : ?>
							
						<?php while ( $link->have_posts() ) :$link->the_post(); ?>
						
							<div class="item"><?php echo $post->post_content; ?></div>

						<?php endwhile; ?>
					<?php endif; ?>
			  	</div>
	   		</div>
	   		<div class="four wide column">
	   			<h4 class="foot-head">Bantuan</h4>
	   			<div class="items tautan">

					<div class="item">link</div>
					<div class="item">link</div>
					<div class="item">link</div>
					<div class="item">link</div>
			  	</div>
	   		</div>
	   		<div class="eight wide column">
	   			<a href="<?php echo site_url(); ?>">
	                <div class="ui sub header">
	                	<h3><?php echo get_theme_mod( 'nick_title', 'your title' ); ?></h3>
	                </div>
	                <p><?php echo get_theme_mod( 'nick_subtitle', 'your subtitle' ); ?></p>
	            </a>
	   		</div>
	   </div>
	</div>
	<div class="ui vertical center aligned inverted segment">
	   <div class="ui container">
	      	<p class="copy">Crafted with <i id="heart" class="heart red inverted icon pulse"></i>by <strong>Jakarta Smart City</strong> <i class="copyright icon"></i>2016</p>
	    </div>
	</div>
</div>

<?php wp_footer(); ?>

</body>

</html>
 