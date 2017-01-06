<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    License_Manager
 * @subpackage License_Manager/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    License_Manager
 * @subpackage License_Manager/public
 * @author     Your Name <email@example.com>
 */
class License_Manager_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the new "products" post type to use for products that
	 * are available for purchase through the license manager.
	 */
	public function add_products_post_type() {
	    register_post_type( 'wplm_product',
	        array(
	            'labels' => array(
	                'name' => __( 'Products', $this->plugin_name ),
	                'singular_name' => __( 'Product', $this->plugin_name ),
	                'menu_name' => __( 'Products', $this->plugin_name ),
	                'name_admin_bar' => __( 'Products', $this->plugin_name ),
	                'add_new' => __( 'Add New', $this->plugin_name ),
	                'add_new_item' => __( 'Add New Product', $this->plugin_name ),
	                'edit_item' => __( 'Edit Product', $this->plugin_name ),
	                'new_item' => __( 'New Product', $this->plugin_name ),
	                'view_item' => __( 'View Product', $this->plugin_name ),
	                'search_item' => __( 'Search Products', $this->plugin_name ),
	                'not_found' => __( 'No products found', $this->plugin_name ),
	                'not_found_in_trash' => __( 'No products found in trash', $this->plugin_name ),
	                'all_items' => __( 'All Products', $this->plugin_name ),
	            ),
	            'public' => true,
	            'has_archive' => true,
	            'supports' => array( 'title', 'editor', 'author', 'revisions', 'thumbnail' ),
	            'rewrite' => array( 'slug' => 'products' ),
	            'menu_icon' => 'dashicons-products',
	        )
	    );
	}

}
