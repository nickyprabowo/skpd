<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

get_header();
?>

<div class="page-content">
		<div class="ui stackable grid container">
			<div class="row">
				<div class="center aligned column">
					<h1 class="ui header margin-header">Acara</h1>
				</div>
			</div>
			
			<div class="row">
				<!--  -->
				<div class="eight wide column">
					<form action="" method="get" id="tim-event-search">
					<div class="grid">
						<?php event_month_dropdown( esc_attr( get_query_var('m') ) ); ?>
					</div>
				</div>
				<div class="eight wide column">
				  	<div class="ui fluid action input">
					  <input type="text" name="s" value="<?php echo get_query_var('s') ?>" placeholder="Search...">
					  <button type="submit" class="ui icon button">
					    <i class="long arrow right icon"></i>
					  </button>
					</div>
					</form>
				</div>
				<!-- 	 -->
			</div>
				  
			
			<?php 

				$args = array(
						's' => esc_sql( get_query_var('s') ),
						'posts_per_page' => get_option( 'posts_per_page' ),
					);
				$query_month = esc_sql( get_query_var('m') );
				// $query_year = esc_sql( get_query_var('year') );
				$query_year = date('Y');

				if( ! empty( $query_month ) && $query_month != '-' ) {

					$start_date = $query_year . '-' . $query_month;

					$date = new DateTime( $start_date . "-01");
					$date->add( new DateInterval("P1M") );
					
					$end_date = $date->format('Y-m');
					$args['start_date'] = $start_date;
					$args['end_date'] = $end_date;
				}

				$paged = get_query_var('paged');
				if( ! empty( $paged ) ) {
					$args['paged'] = $paged;			
				}

				$posts = tribe_get_events( $args );
				set_query_var( 'posts', $posts );

			?>
			
			<div class="row" id="event-list">
				<?php get_template_part('loop', 'events-default' ); ?>
			</div>
			

			
			<div class="sixteen wide center aligned column">
				<a class="ui right labeled icon button" id="event-next-page" data-page="2" href="<?php echo tribe_get_listview_next_link() ?>">
				  <i class="right arrow icon"></i>
				  <?php echo __( 'Load More', 'naked' ); ?>
				</a>
			</div>
		</div>
			
	
		    
			



</div><!-- end page-content -->
<?php
get_footer();
