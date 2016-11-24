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
	
	<div class="ui container">
		<div class="ui centered grid">
		  <div class="column">
			<div class="large ui buttons basic" id="news-tab">
			  <button class="ui button" data-tab="news"><?php echo __( 'News', 'naked' ) ?></button>
			  <button class="ui button active" data-tab="events"><?php echo __( 'Events', 'naked' ) ?></button>
			</div>
		  </div>
		</div>
		
		<div class="custom-tab">
			<div class="ui tab" data-tab="news">
				<?php get_template_part('loop', 'news-default' ); ?>
			</div>
			<div class="ui active tab" data-tab="events">
				<form action="" method="get">
					<div class="ui stackable two column centered grid">
					  <div class="column">
						<div class="grid">
							<?php event_month_dropdown( esc_attr( get_query_var('m') ) ); ?>
						</div>
					  </div>
					  <div class="column">
					  	<div class="ui fluid action input">
						  <input type="text" name="s" value="<?php echo get_query_var('s') ?>" placeholder="Search...">
						  <button type="submit" class="ui icon button">
						    <i class="long arrow right icon"></i>
						  </button>
						</div>
					  </div>
					</div>
				</form>	

				<?php get_template_part('loop', 'events-default' ); ?>
			</div>
		</div><!-- end custom-tab -->
		
	</div>



</div><!-- end page-content -->
<?php
get_footer();
