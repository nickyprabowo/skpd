<div class="wrap" id="siteorigin-importer">

	<h1><?php esc_attr_e( 'Site Packs', 'siteorigin-importer' ) ?></h1>

	<input type="text" class="filter-results" value="" placeholder="<?php esc_attr_e( 'Search', 'siteorigin-importer' ) ?>" />

	<div class="importer-packs">
		<?php
		foreach( glob( ABSPATH . 'wp-content/packs/*/import-data.php' ) as $filename ) {
			$pack = basename( dirname( $filename ) );
			$import_data = $this->get_import_data( $pack );
			$screenshot = 'http://s.wordpress.com/mshots/v1/' . urlencode( $import_data['site_url'] ) . '?w=480';
			$theme = wp_get_theme( $import_data['template'], plugin_dir_path( $this->base ) . 'themes/' );

			?>
			<div class="importer-pack">
				<div class="importer-pack-inside">
					<div class="importer-pack-screenshot">
						<img src="<?php echo $screenshot ?>" width="480" height="360" />
					</div>
					<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'pack', $pack ) ), 'import-pack' ) ?>" class="import link"><?php _e( 'Import', 'siteorigin-importer' ) ?></a>
					<h3><?php echo esc_html( $import_data['options']['blogname'] ) ?></h3>
				</div>
			</div>
			<?php
		}
		?>
	</div>

</div>