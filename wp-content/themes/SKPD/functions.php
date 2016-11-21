<?php
	/*-----------------------------------------------------------------------------------*/
	/* This file will be referenced every time a template/page loads on your Wordpress site
	/* This is the place to define custom fxns and specialty code
	/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define( 'NAKED_VERSION', 1.0 );

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
require_once('walkah.php');
require_once('sider.php');
// require Search System
require_once('wp-advanced-search/wpas.php');

function demo_ajax_search() {
    $args = array();
    $args['wp_query'] = array( 'post_type' => 'attachment', 
                               'orderby' => 'title', 
                               'post_status' => 'any',
                               'order' => 'ASC',
                               'tax_query' => array(
					                            array(
					                              'taxonomy' => 'kategori_media',
					                              'field'    => 'slug',
					                              'terms'    => 'peraturan'
					                            )
					                          )
                        );

    $args['form'] = array( 

    					'auto_submit' => true,
    					'class'	=>	'ui form' 

    					);

    $args['form']['ajax'] = array( 'enabled' => true,
                                   'show_default_results' => true,
                                   'results_template' => 'template-ajax-results.php',
                                   'button_text' => 'Load More Results',
                                   'class' => 'jo'
                                   );

    $args['fields'][] = array( 'type' => 'search', 
    						   'pre_html' => '<div class="field">',
                          	   'post_html' => '</div>',
                               'placeholder' => 'Masukkan Kata Kunci' );

    /*$args['fields'][] = array( 'type' => 'post_type', 
                               'format' => 'hidden', 
                               'values' => array('media' => 'attachment') ,
                               'default_all' => true
                               );*/

    /*$args['fields'][] = array( 'type' => 'taxonomy', 
                               'format' => 'checkbox', 
                               'pre_html' => '<div class="field" style="display:none;">',
                          	   'post_html' => '</div>',
                               'label' => 'Filter', 
                               'taxonomy' => 'kategori_media',
                               'term-format' => 'slug',
                               'default' => 'peraturan'
                               );*/

    $args['fields'][] = array( 'type' => 'taxonomy', 
                               'format' => 'select', 
                               'pre_html' => '<div class="field">',
                          	   'post_html' => '</div>',
                               'label' => 'Kategori', 
                               'taxonomy' => 'kategori_peraturan',
                               'term-format' => 'slug',
                               'default' => ''
                               );

    $args['fields'][] = array( 'type' => 'taxonomy', 
                               'format' => 'select', 
                               'pre_html' => '<div class="field">',
                          	   'post_html' => '</div>',
                               'label' => 'Tahun Terbit', 
                               'taxonomy' => 'kategori_tahun',
                               'term-format' => 'slug'
                               );

    $args['fields'][] = array( 'type' => 'orderby', 
                               'format' => 'select', 
                               'pre_html' => '<div class="field">',
                          	   'post_html' => '</div>',
                               'label' => 'Urutkan Berdasarkan', 
                               'values' => array('title' => 'Judul', 'date' => 'Data Masuk') );

    $args['fields'][] = array( 'type' => 'order', 
                               'format' => 'radio',
                               'label' => 'Pengurutan', 
                               'pre_html' => '<div class="field">',
                          	   'post_html' => '</div>',
                               'values' => array('ASC' => 'ASC', 'DESC' => 'DESC'), 
                               'default' => 'ASC' );

    $args['fields'][] = array( 'type' => 'posts_per_page', 
                               'format' => 'select', 
                               'pre_html' => '<div class="field">',
                          	   'post_html' => '</div>',
                               'label' => 'Jumlah Pencarian', 
                               'values' => array(2=>2, 5=>5, 10=>10), 
                               'default' => 10 );

    $args['fields'][] = array( 'type' => 'reset',
                               'class' => 'ui fluid button',
                               'value' => 'Reset' );

    register_wpas_form('myform', $args);
}
add_action('init', 'demo_ajax_search');

//image thumbnail
add_theme_support( 'post-thumbnails' );
add_image_size( 'gallery-thumbnail', 300, 150, true ); // 50 pixels wide by 50 pixels tall, crop mode
add_image_size( 'slider-thumbnail', 500, 400, true );
add_image_size( 'headline-thumbnail', 900, 235, true );
add_image_size( 'secondary-headline', 450, 255, true );
add_image_size( 'single-thumbnail', 1000, 400, true );
add_image_size( 'taker-thumbnail', 400, 400, true );

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
/* Activate sidebar for Wordpress use
/*-----------------------------------------------------------------------------------*/
function naked_register_sidebars() {
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'sidebar', 					// Make an ID
		'name' => 'Sidebar',				// Name it
		'description' => 'Take it on the side...', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title'=> '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar, 
		// just change the values of id and name to another word/name
	));
} 
// adding sidebars to Wordpress (these are created in functions.php)
add_action( 'widgets_init', 'naked_register_sidebars' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function naked_scripts()  { 

	// Stylesheet
	wp_enqueue_style('semantic-css', get_stylesheet_directory_uri() . '/css/semantic.min.css');
	/*wp_enqueue_style('Roboto', 'https://fonts.googleapis.com/css?family=Roboto');*/
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
		'loadmore' => esc_html__('Load more', 'kelurahan')
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
                $out .= '<a class="cat ui blue label" href="' .get_term_link($term->slug, $taxonomy) .'">'.$term->name.'</a> ';
        }
        $out .= "";
    }
    $out .= "";
    return $out;
}

// LOAD MORE GALLERY
add_action('wp_ajax_nopriv_mytheme_more_post_ajax', 'mytheme_more_post_ajax');
add_action('wp_ajax_mytheme_more_post_ajax', 'mytheme_more_post_ajax');
 
if (!function_exists('mytheme_more_post_ajax')) {
	function mytheme_more_post_ajax(){
 
	    $ppp     = (isset($_POST['ppp'])) ? $_POST['ppp'] : 4;
	    $cat     = (isset($_POST['cat'])) ? $_POST['cat'] : 0;
	    $offset  = (isset($_POST['offset'])) ? $_POST['offset'] : 0;
	    $exclude  = (isset($_POST['post_not_in'])) ? json_decode(stripslashes($_POST['post_not_in'])) : '';

	    $args = array(
	        'post_type'      => 'attachment',
	        'post_mime_type' => 'image',
          	'post_status' 	 => 'any',
          	'post_mime_type' => 'image/jpeg,image/gif,image/jpg,image/png',
	        'posts_per_page' => $ppp,
	        'offset'         => $offset,
	        'post__not_in'    => $exclude
	    );
 
	    $images = get_posts($args);
 
	    $out = '';
 
	    if ($images) :
	    	foreach ( $images as $attachment ) :

	    		// define attributes for image display
	            $imgattr = array(
	                'alt'   => trim( strip_tags( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) ) ),
	            ); 
	            $image_title = $attachment->post_title;
	            $caption = $attachment->post_excerpt;
	            $description = $attachment->post_content;
	            $attachment_page = wp_get_attachment_url( $attachment->ID );
		    	
				$out .= '<a class="ui card '. implode(' ', get_post_class()) .'" href="'.$attachment_page.'">
							<div class="ui image">'.wp_get_attachment_image( $attachment->ID, 'gallery-thumbnail', $imgattr ).'';
					
				$out .= '</div></a>';
 
	    	endforeach;
	    endif;
 
	    wp_reset_postdata();
 
	    wp_die($out);
	}
}

// nick customizer
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
        'default' => 'Kelurahan di Jakarta',
    ) );
	
	$wp_customize->add_control('nick_title',
	array(
        'label' => 'Judul',
        'section' => 'general_section',
        'type' => 'text',
    ) );
	// END OF SITE TITLE SETTING

	// SITE SUBTITLE SETTING
	$wp_customize->add_setting('nick_subtitle',
	array(
        'default' => 'Kelurahan',
    ) );
	
	$wp_customize->add_control('nick_subtitle',
	array(
        'label' => 'Subtitle',
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
	
	// ADD COLOR PICKER SETTING FOR FOOTER BACKGROUND
	$wp_customize->add_setting( 'footer_color', array(
		'default' => '#2D2C31'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color', array(
		'label' => 'Footer Background Color',
		'section' => 'footer_section',
		'settings' => 'footer_color',
		) ) 
	);
	// END OF COLOR PICKER
	
	// FONT SETTING IN FOOTER
	$wp_customize->add_setting( 'font_footer_color', array(
		'default' => '#FFFFFF'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'font_footer_color', array(
		'label' => 'Font Color',
		'section' => 'footer_section',
		'settings' => 'font_footer_color',
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
	
	if ( $footer_color != '#1b1c1d' ) :
	?>
		<style type="text/css">			
			.footer{
				background-color: <?php echo $footer_color; ?>;
			}
			.footer{

			}
		</style>
	<?php
	endif;
	
	if ( $font_color_footer != '#FFFFFF' ) :
	?>
		<style type="text/css">			
			.footer, .tautan .item a {
				color: <?php echo $font_color_footer; ?>;
			}
		</style>
	<?php
	endif;
	
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




