
<form action="<?php echo home_url( '/' ); ?>" method="get">
	<div class="ui icon input">
    	<input type="text" placeholder="Search..." name="s" id="search" value="<?php the_search_query(); ?>">
    	<i class="search link icon"></i>
  	</div>
</form>