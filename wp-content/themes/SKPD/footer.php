<div class="footer">
	<div class="ui vertical segment active-footer">
	   <div class="ui stackable grid container">
	   		<div class="nine wide column">
	   			<h4 class="foot-head">Tautan</h4>
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
	   		<div class="seven wide column">
	   			<a href="<?php echo site_url(); ?>">
	                <div class="ui header">
	                	<h3><?php echo get_theme_mod( 'nick_title', 'your title' ); ?></h3>
	                </div>
	            </a>
				<div class="items profil-skpd">
	            <?php
					$args = array(
							'post_type' => 'profil_skpd',
							'name' => 'alamat'
					);

					$alamat = new WP_Query($args); 
				?>
				<?php if ( $alamat->have_posts() ) : ?>
							
					<?php while ( $alamat->have_posts() ) :$alamat->the_post(); ?>
					
						<div class="item"><?php the_content(); ?></div>

					<?php endwhile; ?>
				<?php endif; ?>

				<!------ TELEPON ------>
				<?php
					$args = array(
							'post_type' => 'profil_skpd',
							'name' => 'telepon'
					);

					$telepon = new WP_Query($args); 
				?>
				<?php if ( $telepon->have_posts() ) : ?>
							
					<?php while ( $telepon->have_posts() ) :$telepon->the_post(); ?>
					
						<div class="item"><i class="phone icon"></i> <?php echo $post->post_content; ?></div>

					<?php endwhile; ?>
				<?php endif; ?>
				<!---------- EMAIL ---------->
				<?php
					$args = array(
							'post_type' => 'profil_skpd',
							'name' => 'email'
					);

					$email = new WP_Query($args); 
				?>
				<?php if ( $email->have_posts() ) : ?>
							
					<?php while ( $email->have_posts() ) :$email->the_post(); ?>
					
						<div class="item"><i class="mail icon"></i> <?php echo $post->post_content; ?></div>

					<?php endwhile; ?>
				<?php endif; ?>
				</div>
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
 