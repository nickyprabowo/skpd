<?php
/**
 * You can read unyson documentation here http://manual.unyson.io/en/latest/options/built-in/introduction.html#content
 */


// check if unyson framework has defined/installed
if ( ! defined('FW') )	die();

$options = array(

	/**
	 * Header Picker style
	 * Header template is located on framework-customizations/header-style/{value of choices}
	 */
    'jsc_theme_header_style' => array(
	    'type'  => 'image-picker',
	    'value' => 'header_style',
	    'attr'  => array(
	        'class'    => 'custom-class',
	        'data-foo' => 'bar',
	    ),
	    'label' => __('Choose Header', 'naked'),
	    'desc'  => __('Choose header style for your website', 'naked'),
	    'help'  => __('Help tip', 'naked'),
	    'choices' => array(

	        'header_1' => array(
	            // (required) url for thumbnail
	            'small' => get_template_directory_uri() .'/framework-customizations/images/header-1-small.png',
	            // (optional) url for large image that will appear in tooltip
	            'large' => get_template_directory_uri() .'/framework-customizations/images/header-1.png',
	        ),
	        'header_2' => array(
	            // (required) url for thumbnail
	            'small' => get_template_directory_uri() .'/framework-customizations/images/header-2-small.png',
	            // (optional) url for large image that will appear in tooltip
	            'large' => get_template_directory_uri() .'/framework-customizations/images/header-2.png',
	        ),
	        
	    ),
	    'blank' => false, // (optional) if true, images can be deselected
	)
);
?>