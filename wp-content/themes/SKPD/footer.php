<div class="footer">
	<div class="ui vertical segment active-footer">
	    <?php if( is_active_sidebar( 'footer-sidebar' ) ) : ?>
		    <div class="ui stackable grid container">
		   				
				<?php dynamic_sidebar( 'footer-sidebar' ); ?>
						
		    </div>
		<?php endif; ?>
	</div>
	<div class="ui vertical center aligned inverted segment">
	   <div class="ui container">

	      	<?php if( is_active_sidebar( 'copyright-sidebar' ) ) : ?>
	      	<div class="copy">
	      		
	      		<?php dynamic_sidebar( 'copyright-sidebar' ); ?>
	      	
	      	</div>
	      	<?php endif; ?>
	    </div>
	</div>
</div>

<?php wp_footer(); ?>

</body>

</html>
 