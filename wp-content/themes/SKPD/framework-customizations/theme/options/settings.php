<?php

// check if unyson framework has defined/installed
if ( ! defined('FW') )	die();


$options = array(
    'jsc_unyson' => array(
	    'type'  => 'image-picker',
	    'value' => 'image-2',
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
	            // (optional) choice extra data for js, available in custom events
	            'data' => array()
	        ),
	        // 'value-3' => array(
	        //     // (required) url for thumbnail
	        //     'small' => array(
	        //         'src' => get_template_directory_uri() .'/images/thumbnail.png',
	        //         'height' => 70
	        //     ),
	        //     // (optional) url for large image that will appear in tooltip
	        //     'large' => array(
	        //         'src' => get_template_directory_uri() .'/images/preview.png',
	        //         'height' => 400
	        //     ),
	        //     // (optional) choice extra data for js, available in custom events
	        //     'data' => array()
	        // ),
	    ),
	    'blank' => true, // (optional) if true, images can be deselected
	)
);
?>