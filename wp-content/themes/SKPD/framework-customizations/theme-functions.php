<?php
/**
 * @author Vive Vio Permana <vive.permana@gmail.com>
 *
 * This file is inital or setter and getter for plugin uniyson
 * You can read unyson documentation here http://manual.unyson.io/en/latest/options/integrate.html#content
 * 
 */

/**
 * Get header style from the chosen in admin
 * @return html
 */
function fw_theme_get_header_style() {

    if ( ! defined('FW') ) return; // prevent fatal error when the framework is not active

    $header_file = fw_get_db_settings_option('jsc_theme_header_style');

    include( get_template_directory() . '/framework-customizations/header-style/' . $header_file . '.php' );
   
}
