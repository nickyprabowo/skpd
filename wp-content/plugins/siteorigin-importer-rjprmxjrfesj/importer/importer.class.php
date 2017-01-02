<?php

include plugin_dir_path( __FILE__ ) . 'inc/utils.php';

/**
 * Class SiteOrigin_Importer
 *
 * Handle everything for importing the associated data.
 */
class SiteOrigin_Importer {

	private $base;

	function __construct( $base ) {
		$this->base = $base;

		register_activation_hook( $base, array( $this, 'activation_hook' ) );

		add_action( 'admin_init', array( $this, 'redirect_to_page' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		add_action( 'wp_ajax_importer_action', array( $this, 'importer_action' ) );
	}

	function activation_hook(){
		// Only redirect if the data file is available
		update_option( 'siteorigin_installer_redirect', true );
	}

	function redirect_to_page(){
		if( get_option( 'siteorigin_installer_redirect' ) ) {
			delete_option( 'siteorigin_installer_redirect' );
			wp_redirect( admin_url( 'tools.php?page=siteorigin-importer' ) );
			exit();
		}
	}

	function admin_notices(){
		$screen = get_current_screen();
		if( $screen->base == 'tools_page_siteorigin-importer' ) return;

		$done = get_option( 'so_import_done' );
		$import_data = $this->get_import_data();

		if( empty( $import_data ) ) return;

		if( empty( $done[ $import_data['import_id'] ] ) ) {
			// This import hasn't run yet
			?>
			<div class="notice notice-success">
				<p>
					<?php _e( 'The importer is ready to run.', 'siteorigin-importer' ) ?>
					<a href="<?php echo admin_url( 'tools.php?page=siteorigin-importer' ) ?>"><?php _e( 'Start Now', 'siteorigin-importer' ) ?></a>
				</p>
			</div>
			<?php
		}
		else {
			$plugin_file = plugin_basename( $this->base );
			?>
			<div class="notice notice-success">
				<p>
					<?php _e( 'The importer has run successfully. Unless you plan on running it again, you should deactivate the importer plugin.', 'siteorigin-importer' ) ?>
					<a href="<?php echo wp_nonce_url( 'plugins.php?action=deactivate&amp;plugin=' . $plugin_file, 'deactivate-plugin_' . $plugin_file ) ?>"><?php _e( 'Deactivate', 'siteorigin-importer' ) ?></a>
				</p>
			</div>
			<?php
		}
	}

	function add_menu_page( ){
		add_submenu_page(
			'tools.php',
			__( 'SiteOrigin Importer', 'siteorigin-importer' ),
			__( 'SiteOrigin Importer', 'siteorigin-importer' ),
			'install_plugins',
			'siteorigin-importer',
			array( $this, 'render_importer_page' )
		);
	}

	/**
	 * Display the importer page
	 */
	function render_importer_page(){
		$import_data = $this->get_import_data( );
		$screenshot = 'http://s.wordpress.com/mshots/v1/' . urlencode( $import_data['site_url'] ) . '?w=640';
		$theme = wp_get_theme( $import_data['template'], plugin_dir_path( $this->base ) . 'themes/' );
		$actions = $this->get_importer_actions( );

		include plugin_dir_path( __FILE__ ) . 'tpl/importer.php';
	}

	/**
	 * Enqueue the importer scripts
	 *
	 * @param $prefix
	 */
	function admin_enqueue_scripts( $prefix ){
		if( $prefix != 'tools_page_siteorigin-importer' ) return;

		wp_enqueue_style(
			'siteorigin-importer',
			plugin_dir_url( __FILE__ ) . '/css/importer.css',
			array( ),
			md5_file( plugin_dir_path( __FILE__ ) . '/css/importer.css' )
		);

		wp_enqueue_script(
			'siteorigin-importer',
			plugin_dir_url( __FILE__ ) . '/js/importer.js',
			array( 'jquery' ),
			md5_file( plugin_dir_path( __FILE__ ) . '/js/importer.js' )
		);

		wp_localize_script( 'siteorigin-importer', 'importerActions', $this->get_importer_actions( ) );
		wp_localize_script( 'siteorigin-importer', 'importerSettings', array(
			'url' => admin_url( 'admin-ajax.php' ),
			'strings' => array(
				'reset-installation' => __( 'Resetting WordPress database', 'siteorigin-importer' ),
				'load-settings' => __( 'Loading Settings', 'siteorigin-importer' ),
				'install-theme' => __( 'Installing %s Theme', 'siteorigin-importer' ),
				'load-theme-mods' => __( 'Loading Theme Mods', 'siteorigin-importer' ),
				'install-plugin' => __( 'Installing %s Plugin', 'siteorigin-importer' ),
				'import-user' =>  __( 'Importing user %s', 'siteorigin-importer' ),
				'import-term' =>  __( 'Importing term %s', 'siteorigin-importer' ),
				'import-post' => __( 'Importing item - %s', 'siteorigin-importer' ),
				'import-attachment' => __( 'Importing media - %s', 'siteorigin-importer' ),
				'import-comment' => __( 'Importing comment by - %s', 'siteorigin-importer' ),
				'finalize' => __( 'Finalizing', 'siteorigin-importer' ),
				'complete' => __( 'Import Complete!', 'siteorigin-importer' ),
				'confirm' => __( 'The importer is busy running, are you sure you want to leave this page?', 'siteorigin-importer' ),
			)
		) );
	}

	function get_importer_actions(){
		$actions = array();

		$base_path = plugin_dir_path( $this->base );
		$import_data = $this->get_import_data( );

		// Reset the WordPress database
		$actions[] = array(
			'action' => 'reset-installation',
			'id' => '',
		);

		// Load all the settings
		$actions[] = array(
			'action' => 'load-settings',
			'id' => '',
		);

		// Install the theme
		$theme = wp_get_theme( $import_data['template'], $base_path . 'themes/' );
		$actions[] = array(
			'text' => $theme->get('Name'),
			'action' => 'install-theme',
			'id' => $import_data['template'],
		);

		// Load all the settings
		$actions[] = array(
			'action' => 'load-theme-mods',
			'id' => '',
		);

		foreach( $import_data[ 'plugins' ] as $id => $title ) {
			$actions[] = array(
				'text' => $title,
				'action' => 'install-plugin',
				'id' => $id,
			);
		}

		// We also want the installer plugin
		$actions[] = array(
			'text' => __( 'SiteOrigin Installer', 'siteorigin-importer' ),
			'action' => 'install-plugin',
			'id' => 'siteorigin-installer-master/siteorigin-installer.php',
		);

		// Add the taxonomy term actions
		foreach( glob( $base_path . 'terms/*.php' ) as $file ) {
			$data = include $file;
			$actions[] = array(
				'text' => esc_html( $data[ 'name' ] ),
				'action' => 'import-term',
				'id' => $data['term_id'],
			);
		}

		// The posts actions
		foreach( glob( $base_path . 'posts/*.php' ) as $file ) {
			$data = include $file;
			$title = !empty( $data[ 'post_title' ] ) ? $data[ 'post_title' ] : $data[ 'post_name' ];

			$actions[] = array(
				'text' => esc_html( $title ),
				'action' => 'import-post',
				'id' => $data['ID'],
			);
		}

		// The comment actions
		foreach( glob( $base_path . 'comments/*.php' ) as $file ) {
			$data = include $file;

			$actions[] = array(
				'text' => esc_html( $data['comment_author'] ),
				'action' => 'import-comment',
				'id' => $data['comment_ID'],
			);
		}

		// Perform the final action
		$actions[] = array(
			'action' => 'finalize',
		);

		// Now lets sign all the actions
		$expires = time() + 43200; // Valid for 12 hours
		foreach( $actions as & $action ) {
			$action[ 'expires' ] = $expires;
			$action[ 'signature' ] = md5( NONCE_SALT + '|' + $action['action'] + $expires );
		}

		return $actions;
	}

	/**
	 *
	 */
	function importer_action() {
		if( empty( $_GET[ 'signature' ] ) || empty( $_GET['importer_action'] ) || empty( $_GET['expires'] ) ) exit();
		if( $_GET[ 'signature' ] != md5( NONCE_SALT + '|' + $_GET['importer_action'] + $_GET['expires'] ) ) exit();

		// Check the access rights for this action
		switch( $_GET['importer_action'] ) {
			case 'install-plugin':
				if( !current_user_can( 'install_plugins' ) ) exit();
				break;

			case 'install-theme':
				if( !current_user_can( 'switch_themes' ) ) exit();
				break;

			default:
				if( !current_user_can( 'manage_options' ) ) exit();
				break;
		}

		$method = 'action_' . str_replace( '-', '_', $_GET['importer_action'] );
		$action_id = !empty( $_GET['id'] ) ? $_GET['id'] : false;

		if ( method_exists( $this, $method ) ) {
			// Removing limits is important for some actions
			@ini_set('memory_limit','1024M');
			@ini_set('max_execution_time','0');

			try {
				call_user_func( array( $this, $method ), $action_id );
			}
			catch ( Exception $e ) {
				error_log( $e->getMessage() );
			}
		}
		else {
			// Display a message about the action not being available.
		}

		exit();
	}

	/**
	 * Action to reset the current WordPress installation
	 */
	function action_reset_installation(){
		global $current_user;

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

		$blogname = get_option( 'blogname' );
		$blog_public = get_option( 'blog_public' );

		if ( $current_user->user_login != 'admin' ) {
			$user = get_user_by( 'login', 'admin' );
		}

		if ( empty( $user->user_level ) || $user->user_level < 10 ){
			$user = $current_user;
		}

		global $wpdb;

		$prefix = str_replace( '_', '\_', $wpdb->prefix );
		$tables = $wpdb->get_col( "SHOW TABLES LIKE '{$prefix}%'" );
		foreach ( $tables as $table ) {
			$wpdb->query( "DROP TABLE $table" );
		}

		// Now delete the uploads folder
		$uploads = wp_upload_dir();

		siteorigin_recurse_rmdir( $uploads['basedir'] );

		$result = wp_install( $blogname, $user->user_login, $user->user_email, $blog_public );
		extract( $result, EXTR_SKIP );

		$wpdb->query( $wpdb->prepare(
			"UPDATE $wpdb->users SET user_pass = '%s', user_activation_key = '' WHERE ID =  %d",
			array( $user->user_pass, $user->ID )
		) );

		$get_user_meta = function_exists( 'get_user_meta' ) ? 'get_user_meta' : 'get_usermeta';
		$update_user_meta = function_exists( 'update_user_meta' ) ? 'update_user_meta' : 'update_usermeta';

		if ( $get_user_meta( $user->ID, 'default_password_nag' ) ) {
			$update_user_meta( $user->ID, 'default_password_nag', false );
		}

		if ( $get_user_meta( $user->ID, $wpdb->prefix . 'default_password_nag' ) ) {
			$update_user_meta( $user->ID, $wpdb->prefix . 'default_password_nag', false );
		}


		// This plugin must stay active
		@activate_plugin( plugin_basename( $this->base ) );

		// We don't need this redirect
		delete_option( 'siteorigin_installer_redirect' );

		// Reauth this user
		wp_clear_auth_cookie();
		wp_set_auth_cookie( $user->ID );

		// Remove the default posts/pages
		wp_delete_post( 1, true );
		wp_delete_post( 2, true );
		$wpdb->query("TRUNCATE TABLE  $wpdb->posts");

		// Clear the taxonomy table
		$wpdb->query("TRUNCATE TABLE  $wpdb->terms");
		$wpdb->query("TRUNCATE TABLE  $wpdb->term_taxonomy");
		$wpdb->query("TRUNCATE TABLE  $wpdb->term_relationships");
		$wpdb->query("TRUNCATE TABLE  $wpdb->termmeta");

		// Some other basic setup and default options
		add_option( 'siteorigin_installer_admin_notice', true, '', false );
	}

	function action_load_settings( ){
		$import_data = $this->get_import_data( );

		// Save the options
		if( !empty( $import_data['options'] ) ) {
			foreach( $import_data['options'] as $k => $v ) {
				update_option( $k, $v );
			}
		}

	}

	function action_load_theme_mods(){
		$import_data = $this->get_import_data( );

		// set the theme mods
		if( !empty( $import_data[ 'theme_mods' ] ) ) {
			foreach( $import_data['theme_mods'] as $name => $value ) {
				set_theme_mod( $name, $value );
			}
		}

		// Also get the sidebars widgets setting
		if( !empty( $import_data['options']['sidebars_widgets'] ) ) {
			update_option( 'sidebars_widgets', $import_data['options']['sidebars_widgets'] );
		}
	}

	function action_install_plugin( $plugin_file ) {
		list( $plugin, $file ) = explode( '/', $plugin_file );

		if( $plugin == 'siteorigin-installer-master' ) {
			$package = 'https://github.com/siteorigin/siteorigin-installer/archive/master.zip';
			$basename = $plugin_file;
		}
		else {
			$package = 'https://downloads.wordpress.org/plugin/' . urlencode( $plugin ) . '.zip';
			$basename = $plugin_file;
		}

		if( !class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}
		$upgrader = new WP_Upgrader();

		// Run the upgrader silently
		$upgrader->run( array(
			'package' => $package,
			'destination' => WP_PLUGIN_DIR,
			'clear_destination' => true,
			'abort_if_destination_exists' => false,
			'hook_extra' => array(
				'type' => 'plugin',
				'action' => 'install',
			)
		) );

		// We'll activate the plugin
		@activate_plugin( $basename );
	}

	function action_install_theme( $theme ){
		if( !class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}
		$upgrader = new WP_Upgrader();

		// TODO check SVN for the latest version instead
		$package = 'https://downloads.wordpress.org/theme/' . urlencode( $theme ) . '.zip';

		$upgrader->run( array(
			'package' => $package,
			'destination' => get_theme_root(),
			'clear_destination' => true,
			'clear_working' => true
		) );

		// Activate the theme
		switch_theme( $theme );
	}

	function action_import_term( $id ){
		$term = include plugin_dir_path( $this->base ) . 'terms/' . intval( $id ) . '.php';

		$meta = $term['term_meta'];
		$meta = array_map( 'maybe_unserialize', $meta );
		$taxonomy = $term['term_taxonomy'];

		unset( $term['term_meta'] );
		unset( $term['term_taxonomy'] );

		global $wpdb;
		$wpdb->insert(
			$wpdb->terms,
			$term
		);

		foreach( $meta as $k => $v ) {
			update_term_meta( $term['term_id'], $k, $v );
		}

		// Now add the taxonomies
		foreach( $taxonomy as $t ) {
			$wpdb->insert(
				$wpdb->term_taxonomy,
				$t
			);
		}

	}

	function action_import_post( $id ){
		$post = include plugin_dir_path( $this->base ) . 'posts/' . intval( $id ) . '.php';
		$import_data = $this->get_import_data();

		$meta = $post['post_meta'];
		$meta = array_map( 'maybe_unserialize', $meta );
		$terms = $post['terms'];
		$original_file = isset($post['original_file']) ? $post['original_file'] : false;

		unset( $post['post_meta'] );
		unset( $post['terms'] );
		unset( $post['author_login'] );
		unset( $post['author_email'] );
		unset( $post['original_file'] );

		// All posts are attributed to the current user
		$post['post_author'] = get_current_user_id();

		// Start by replacing all references to the original URL with
		$post['post_content'] = str_replace( $import_data['site_url'], site_url(), $post['post_content'] );

		global $wpdb;
		$wpdb->insert(
			$wpdb->posts,
			$post
		);

		foreach( $meta as $k => $v ) {
			if( $k == 'panels_data' && !empty( $v['widgets'] ) ) {
				$v['widgets'] = $this->replace_url_deep( $v['widgets'] );
			}

			update_post_meta( $post['ID'], $k, $v );
		}

		foreach( $terms as $taxonomy => $tax_terms ) {
			$post_terms = array();
			foreach ( $tax_terms as $term ) {
				$post_terms[] = $term['term_id'];
			}

			wp_set_post_terms( $post['ID'], $post_terms, $taxonomy );
		}

		// Handle the upload
		if( $post['post_type'] == 'attachment' && !empty( $original_file ) ) {
			// We need to save this file.
			$upload_date = $post['post_date'];
			if ( !empty( $meta ) && isset( $meta[ '_wp_attached_file' ] ) && preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta[ '_wp_attached_file' ], $matches) ) {
				$upload_date = $matches[0];
			}

			// Import the file
			$get = wp_remote_get( $original_file, array(
				'timeout' => 120,
			) );
			if( !is_wp_error( $get ) && $get['response']['code'] == 200 ) {
				$upload = wp_upload_bits( basename( $original_file ), 0, $get['body'], $upload_date );
				wp_generate_attachment_metadata( $post['ID'], $upload['file'] );
			}
			else {
				throw new Exception( __( 'Error fetching remote file', 'siteorigin-importer' ) );
			}
		}
	}

	function replace_url_deep( $in ){
		if( is_array( $in ) ) {
			foreach( $in as & $v ) {
				$v = $this->replace_url_deep( $v );
			}
		}
		else if( is_string( $in ) ) {
			$import_data = $this->get_import_data( );
			$in = str_replace( $import_data['site_url'], site_url( '/' ), $in );
		}

		return $in;
	}

	function action_import_comment( $id ){
		$comment = include plugin_dir_path( $this->base ) . 'comments/' . intval( $id ) . '.php';

		$meta = $comment['comment_meta'];
		$meta = array_map( 'maybe_unserialize', $meta );

		unset( $comment['comment_meta'] );

		global $wpdb;
		$wpdb->insert(
			$wpdb->comments,
			$comment
		);

		foreach( $meta as $k => $v ) {
			update_comment_meta( $comment['comment_ID'], $k, $v );
		}
	}

	/**
	 * Action to finalize that the import is complete
	 */
	function action_finalize(){
		$import_data = $this->get_import_data( );

		// Reset everything
		flush_rewrite_rules( true );

		$done = get_option( 'so_import_done', array() );
		$done[ $import_data[ 'import_id' ] ] = true;
		update_option( 'so_import_done', $done );
	}

	function get_import_data( ) {
		static $import_data = array();
		if( empty( $import_data ) && file_exists( plugin_dir_path( $this->base ) . 'import-data.php' ) ) {
			$import_data = include plugin_dir_path( $this->base ) . 'import-data.php';
		}

		return $import_data;
	}
}