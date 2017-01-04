<?php
	/*-----------------------------------------------------------------------------------*/
	/* This file will be referenced every time a template/page loads on your Wordpress site
	/* This is the place to define custom fxns and specialty code
	/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define( 'NAKED_VERSION', 1.0 );

require_once 'helper/helper.php';

/*-----------------------------------------------------------------------------------*/
/*  Set the maximum allowed width for any content in the theme
/*-----------------------------------------------------------------------------------*/
if ( ! isset( $content_width ) ) $content_width = 900;

/*-----------------------------------------------------------------------------------*/
/* Add Rss feed support to Head section
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'automatic-feed-links' );


/*-----------------------------------------------------------------------------------*/
/* Register main menu for Wordpress use
/*-----------------------------------------------------------------------------------*/
register_nav_menus( 
	array(
		'primary'	=>	__( 'Primary Menu', 'naked' ), // Register the Primary menu
		// Copy and paste the line above right here if you want to make another menu, 
		// just change the 'primary' to another name
	)
);

/* HIDE AUTHOR NAME */
add_action(‘template_redirect’, ‘bwp_template_redirect’);
function bwp_template_redirect()
{
	if (is_author())
	{
		wp_redirect( home_url() ); exit;
	}
}



// Register Custom Navigation Walker
require_once('walkah.php'); // this is for main navigation
require_once('sider.php'); // this is for mobile navigation

//image thumbnail
add_theme_support( 'post-thumbnails' );
// feel free to add more thumbnail filter
add_image_size( 'single-thumbnail', 1000, 400, true );

/**
 * Automatic featured image
 * A post cannot hold the same featured image from media except the image of bwskal2 whis is the default featured image for the post
 */
 function autoset_featured() {
  global $post;
  $already_has_thumb = has_post_thumbnail($post->ID);
      if (!$already_has_thumb) 
      {
          $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
          if ($attached_image)
          {
                foreach ($attached_image as $attachment_id => $attachment)
                {
                    set_post_thumbnail($post->ID, $attachment_id);
                }
           }
          else 
          {

            set_post_thumbnail($post->ID, '95');

          }
      }
}
add_action('the_post', 'autoset_featured');
add_action('save_post', 'autoset_featured');
add_action('draft_to_publish', 'autoset_featured');
add_action('new_to_publish', 'autoset_featured');
add_action('pending_to_publish', 'autoset_featured');
add_action('future_to_publish', 'autoset_featured');

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function naked_scripts()  { 

	global $wp_query;

	// Stylesheet
	wp_enqueue_style('semantic-css', get_stylesheet_directory_uri() . '/css/semantic.min.css');
	wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');

	// Javascripts
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery-3.1.0.min.js');
	wp_enqueue_script( 'semantic-js', get_template_directory_uri() . '/js/semantic.min.js');
	wp_enqueue_script( 'script-js', get_template_directory_uri() . '/js/script.js');

	$ajaxurl = '';
	if( in_array('sitepress-multilingual-cms/sitepress.php', get_option('active_plugins')) ){
		$ajaxurl .= admin_url( 'admin-ajax.php?lang=' . ICL_LANGUAGE_CODE );
	} else{
		$ajaxurl .= admin_url( 'admin-ajax.php');
	}
	 
	wp_localize_script( 'script-js', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'kelurahan' ),
		'collapse' => __( 'collapse child menu', 'kelurahan' ),
		'ajaxurl'  => $ajaxurl,
		'noposts'  => esc_html__('No older posts found', 'kelurahan'),
		'loadmore' => esc_html__('Load more', 'kelurahan'),
		'queryVars' => json_encode( $wp_query->query ),
		'timNonce'	=> wp_create_nonce('timNonceWp' )
	) );
  
}
add_action( 'wp_enqueue_scripts', 'naked_scripts' ); // Register this fxn and allow Wordpress to call it automatcally in the header

// Limiting Excerpt Length To Number of Words.
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

// get taxonomies terms links
function custom_taxonomies_terms_links($id) {
    // get post by post id
    $post = get_post($id);
    // get post type by post
    $post_type = $post->post_type;
    // get post type taxonomies
    $taxonomies = get_object_taxonomies($post_type);
    $out = '';
    foreach ($taxonomies as $taxonomy) {        
        $out .= "";
        // get the terms related to post
        $terms = get_the_terms( $post->ID, $taxonomy );
        if ( !empty( $terms ) ) {
            foreach ( $terms as $term )
                $out .= '<a class="cat ui label" href="' .get_term_link($term->slug, $taxonomy) .'"><i class="tag icon"></i> '.$term->name.'</a> ';
        }
        $out .= "";
    }
    $out .= "";
    return $out;
}

// nick customizer is used in customization page
function nick_customizer( $wp_customize ) {
	// customizer build code
	$wp_customize->add_section( 'general_section' , array(
		'title'      => __( 'General', 'nick' ),
		'priority'   => 200,
	) );

	$wp_customize->add_section( 'header_section' , array(
		'title'      => __( 'Header', 'nick' ),
		'priority'   => 200,
	) );
	
	$wp_customize->add_section( 'body_section' , array(
		'title'      => __( 'Body', 'nick' ),
		'priority'   => 210,
	) );
	
	$wp_customize->add_section( 'footer_section' , array(
		'title'      => __( 'Footer', 'nick' ),
		'priority'   => 220,
	) );

	// SITE TITLE SETTING
	$wp_customize->add_setting('nick_title',
	array(
        'default' => 'SKPD di Jakarta',
    ) );
	
	$wp_customize->add_control('nick_title',
	array(
        'label' => 'Judul',
        'section' => 'general_section',
        'type' => 'text',
    ) );
	// END OF SITE TITLE SETTING

	// SITE TITLE SETTING
	$wp_customize->add_setting('nick_title_abr',
	array(
        'default' => 'YNWA',
    ) );
	
	$wp_customize->add_control('nick_title_abr',
	array(
        'label' => 'Judul Singkatan',
        'section' => 'general_section',
        'type' => 'text',
    ) );
	// END OF SITE TITLE SETTING

	// SITE's CITY' SETTING
	$wp_customize->add_setting('nick_city',
	array(
        'default' => 'Jakarta',
    ) );
	
	$wp_customize->add_control('nick_city',
	array(
        'label' => 'Kota',
        'section' => 'general_section',
        'type' => 'text',
    ) );
	// END OF SITE TITLE SETTING

	// IMG UPLOAD SETTING FOR LOGO
    $wp_customize->add_setting( 'img-upload' );

    $wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'img-upload',
	        array(
	            'label' => 'Upload Logo',
	            'section' => 'general_section',
	            'settings' => 'img-upload'
	        )
	    )
	);
	
	// ADD COLOR PICKER SETTING FOR HEADER BACKGROUND
	$wp_customize->add_setting( 'header_color', array(
		'default' => '#FFFFFF'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
		'label' => 'Header Background Color',
		'section' => 'header_section',
		'settings' => 'header_color',
		) ) 
	);
	// END OF COLOR PICKER
	
	// FONT COLOR SETTING IN HEADER
	$wp_customize->add_setting( 'font_header_color', array(
		'default' => '#333333'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_header_color', array(
		'label' => 'Font Color',
		'section' => 'header_section',
		'settings' => 'font_header_color',
		) ) 
	);
	// END OF FONT SETTING
	
	// FONT LINK SETTING IN FOOTER
	$wp_customize->add_setting( 'font_footer_link_color', array(
		'default' => '#1C98E3'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_footer_link_color', array(
		'label' => 'Font Link Color',
		'section' => 'footer_section',
		'settings' => 'font_footer_link_color',
		) ) 
	);
	// END OF FONT LINK SETTING

	$wp_customize->remove_section( 'title_tagline' );
	$wp_customize->remove_section( 'static_front_page' );
}
add_action( 'customize_register', 'nick_customizer' );

//applying changes in customization to actual pages
function nick_customizer_head_styles() {
	$header_color = get_theme_mod( 'header_color' ); 
	$footer_color = get_theme_mod( 'footer_color' );
	$font_color_header = get_theme_mod( 'font_header_color' );
	$font_color_footer = get_theme_mod( 'font_footer_color' );
	$font_link_color_footer = get_theme_mod( 'font_footer_link_color' );
	
	if ( $header_color != '#0C2039' ) :
	?>
		<style type="text/css">
			/* HEADER */
			.navbar-ct-info {
				background-color: <?php echo $header_color; ?> !important;
			}
		</style>
	<?php
	endif;
	
	if ( $font_color_header != '#333333' ) :
	?>
		<style type="text/css">			
			.head a {
				color: <?php echo $font_color_header; ?>;
			}
		</style>

		<style type="text/css">
			.navbar a {
				color: <?php echo $font_color_header; ?>;
			}
		</style>

		<style type="text/css">
			.navbar li {
				color: <?php echo $font_color_header;?> !important;
			}
		</style>
	<?php
	endif;

	// Customizable link color in footer	
	if ( $font_link_color_footer != '#1C98E3' ) :
	?>
		<style type="text/css">			
			.tautan .item a:hover{
				color: <?php echo $font_link_color_footer; ?>;
			}
		</style>
	<?php
	endif;
}
add_action( 'wp_head', 'nick_customizer_head_styles' );

/** OVERRIDE DASHBOARD ICON **/
function replace_admin_menu_icons_css() {
    ?>
    <style>
        #adminmenu #menu-posts-berita div.wp-menu-image:before{
			content: "\f123";
		}
		#adminmenu #menu-posts-informasi div.wp-menu-image:before{
			content: "\f497";
		}
		#adminmenu #menu-posts-kontak div.wp-menu-image:before{
			content: "\f330";
		}
		#adminmenu #menu-posts-link div.wp-menu-image:before{
			content: "\f103";
		}
		#adminmenu #menu-posts-publik div.wp-menu-image:before{
			content: "\f177";
		}
    </style>
    <?php
}

add_action( 'admin_head', 'replace_admin_menu_icons_css' );


// CREATE FOOTER WIDGET
function skpd_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'skpd' ),
		'id'            => 'footer-sidebar',
		'description'   => '',
		'before_widget' => '<div class="widget-wrapper"><aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside></div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Copyright Widget', 'skpd' ),
		'id'            => 'copyright-sidebar',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'skpd_widgets_init' );

// Shortcode for adding icon based on semantic-ui
function icon_item( $atts ) {

	$input = shortcode_atts( array(
        'type' => '',
    ), $atts );

	return '<i class="'. $input['type'] .' icon"></i>' ;
}
add_shortcode( 'icon', 'icon_item' );

add_theme_support( 'title-tag' );
/*add_action( 'wp_ajax_nopriv_tim_event_ajax_pagination', 'vio_event_ajax_pagination' );
add_action( 'wp_ajax_vio_event_ajax_pagination', 'vio_event_ajax_pagination' );
function vio_event_ajax_pagination() {

	check_ajax_referer( 'timNonceWp', 'nonce' );

    $query_vars['paged'] 			= (int)$_POST['page'];
    $query_vars['posts_per_page'] 	= get_option( 'posts_per_page' );
    $query_vars['post_status'] 	= 'publish';
    $query_vars['s'] 			= esc_sql( $_POST['extraQuery']['s'] );

	$query_month = esc_sql( $_POST['extraQuery']['m']  );
	if( ! empty( $query_month ) && $query_month != '-' ) {


	    // $year 		= esc_sql( $_POST['extraQuery']['year'] );
	    $year 		= date('Y');
		$start_date = $year . '-' . $query_month;

		$date = new DateTime( $start_date . "-01");
		$date->add( new DateInterval("P1M") );
		
		$end_date = $date->format('Y-m');;
		$query_vars['start_date'] = $start_date;
		$query_vars['end_date'] = $end_date;

	}

	$posts = tribe_get_events( $query_vars );
    if( count( $posts ) <= 0 ) { 
    	echo '-1';
    } else {
    	set_query_var( 'posts', $posts );
    	get_template_part('loop', 'events-default' );
    }
	
	wp_reset_postdata();

    die();
}*/




