<div class="wrap" id="siteorigin-importer">

	<div class="importer-modal">

		<div class="container">

			<div class="importer-header">
				<h2><?php _e( 'SiteOrigin Site Import' ) ?></h2>
			</div>

			<div class="frames">
				<div class="frame" data-index="0">
					<div class="site-information">
						<img src="<?php echo esc_url( $screenshot ) ?>" />
						<div class="site-information-text">
							<h3><?php echo esc_html( $import_data['options']['blogname'] ) ?></h3>

							<ul class="import-attributes">
								<li>
									<strong><?php _e( 'Original URL', 'siteorigin-importer' ) ?></strong>:
									<a href="<?php echo esc_url( $import_data['site_url'] )  ?>" target="_blank">
										<?php echo esc_url( $import_data['site_url'] )  ?>
									</a>
								</li>
								<li>
									<strong><?php _e( 'Theme', 'siteorigin-importer' ) ?></strong>:
									<a href="<?php echo esc_url( $theme->get('ThemeURI') )  ?>" target="_blank">
										<?php echo $theme->get('Name')  ?>
									</a>
								</li>

								<li>
									<strong><?php _e( 'Importer Actions', 'siteorigin-importer' ) ?></strong>:
									<?php echo count( $actions )  ?>
								</li>
							</ul>
						</div>
					</div>

					<div class="import-note">
						<p>
							<strong><?php _e( 'Warning', 'siteorigin-importer' ) ?></strong>:
							<?php _e( 'This importer will overwrite your existing installation.', 'siteorigin-importer' ) ?>
							<?php _e( "You'll lose all existing content.", 'siteorigin-importer' ) ?>
							<?php _e( "You should only run this on new installations.", 'siteorigin-importer' ) ?>
							<?php _e( "Type <strong>Accept</strong> in the field below to continue.", 'siteorigin-importer' ) ?>
						</p>
						<input type="text" id="import-accept" />
					</div>

					<div class="buttons">
						<button class="button-primary" id="start-import" disabled><?php _e( 'Start Import', 'siteorigin-importer' ) ?></button>
						<a class="button-secondary" id="start-import" href="<?php echo admin_url('/') ?>"><?php _e( 'Not Now', 'siteorigin-importer' ) ?></a>
						<small>
							<?php _e( 'Type <strong>Accept</strong> in the box above to continue', 'siteorigin-panels' ) ?>
						</small>
					</div>
				</div>

				<div class="frame" data-index="1">
					<div class="progress-bar-wrapper">
						<div class="progress-bar">
							<div class="progress-bar-progress"></div>
						</div>
						<div class="progress-message">
						</div>
						<div class="complete-message">
							<p><?php _e( 'Import complete!', 'siteorigin-importer' ) ?></p>
							<a href="<?php echo site_url( '/' ) ?>" class="button-secondary"><?php _e( 'Visit Your Site', 'siteorigin-importer' ) ?></a>
							<a href="<?php echo admin_url( '/' ) ?>" class="button-secondary"><?php _e( 'Return to Dashboard', 'siteorigin-importer' ) ?></a>
						</div>
					</div>

					<div class="import-note">
						<p>
							<?php _e( "We're busy importing your site.", 'siteorigin-importer' ) ?>
							<?php _e( "This might take a few minutes.", 'siteorigin-importer' ) ?>

							<?php _e( "In the mean-time, sign up to our newsletter.", 'siteorigin-importer' ) ?>
							<?php _e( "We send out occasional updates with our new free theme and plugin releases.", 'siteorigin-importer' ) ?>
						</p>
					</div>

					<form class="buttons" action="//siteorigin.us1.list-manage.com/subscribe/post?u=22e0c978d464421794fc99304&amp;id=71413dedec" method="post" target="_blank">
						<div class="field-wrappers">
							<?php $user = wp_get_current_user() ?>
							<input type="text" name="EMAIL" value="<?php echo esc_attr( $user->data->user_email ) ?>" placeholder="<?php esc_attr_e( 'Your Email Address', 'siteorigin-importer' ) ?>" />
						</div>
						<button class="button-primary" id="start-import"><?php _e( 'Sign Up', 'siteorigin-importer' ) ?></button>
						<small>
							<?php _e( "This won't interrupt the import process", 'siteorigin-importer' ) ?>
						</small>
					</form>
				</div>

			</div>

		</div>

	</div>

</div>