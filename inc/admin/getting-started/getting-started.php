<?php
/**
 * Getting Started page
 *
 * @package Atomic Blocks
 */

/**
 * Redirect to Getting Started page on theme activation
 */
function atomic_blocks_redirect_on_activation() {
	global $pagenow;

	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

		wp_redirect( admin_url( "admin.php?page=atomic-blocks" ) );

	}
}
add_action( 'admin_init', 'atomic_blocks_redirect_on_activation' );


/**
 * Load Getting Started styles in the admin
 *
 * since 1.0.0
 */
function atomic_blocks_start_load_admin_scripts() {

	global $pagenow;

	/**
	 * Load scripts and styles
	 *
	 * @since 1.0
	 */

	// Getting Started javascript
	wp_enqueue_script( 'atomic-blocks-getting-started', get_template_directory_uri() . '/inc/admin/getting-started/getting-started.js', array( 'jquery' ), '1.0.0', true );

	// Getting Started styles
	wp_register_style( 'atomic-blocks-getting-started', get_template_directory_uri() . '/inc/admin/getting-started/getting-started.css', false, '1.0.0' );
	wp_enqueue_style( 'atomic-blocks-getting-started' );  
}
add_action( 'admin_enqueue_scripts', 'atomic_blocks_start_load_admin_scripts' );


/**
 * Adds a menu item for the Getting Started page.
 *
 * since 1.0.0
 */
function getting_started_menu() {

	add_menu_page(
		__( 'Atomic Blocks', 'atomic-blocks' ),
		__( 'Atomic Blocks', 'atomic-blocks' ),
		'manage_options',
		'atomic-blocks',
		'getting_started_page',
		'dashicons-admin-settings'
	);

}
add_action( 'admin_menu', 'getting_started_menu' );


/**
 * Outputs the markup used on the theme license page.
 *
 * since 1.0.0
 */
function getting_started_page() {

	/**
	 * Retrieve help file and update changelog
	 *
	 * since 1.0.0
	 */

	// Grab the change log from arraythemes.com for display in the Latest Updates tab
	$changelog = wp_remote_get( 'https://atomicblocks.com/' );
	
	if( $changelog && !is_wp_error( $changelog ) && 200 === wp_remote_retrieve_response_code( $changelog ) ) {
		$changelog = $changelog['body'];
	} else {
		$changelog = esc_html__( 'There seems to be a temporary problem retrieving the latest updates. You can always see the latest changes by visiting the Atomic Blocks website.', 'atomic-blocks' );
	}


	/**
	 * Create recommended plugin install URLs
	 *
	 * since 1.0.0
	 */
	$gberg_install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-plugin',
				'plugin' => 'gutenberg'
			),
			admin_url( 'update.php' )
		),
		'install-plugin-gutenberg'
	);

	$ab_install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-plugin',
				'plugin' => 'atomic-blocks'
			),
			admin_url( 'update.php' )
		),
		'install-plugin-atomic-blocks'
	);
?>
	<div class="wrap getting-started">
		<div class="intro-wrap">
			<div class="intro">
				<h3><?php printf( esc_html__( 'Getting started with', 'atomic-blocks' ) ); ?> <strong><?php printf( esc_html__( 'Atomic Blocks', 'atomic-blocks' ) ); ?></strong></h3>
			</div>
		</div>

		<div class="panels">
			<ul class="inline-list">
				<li class="current"><a id="help" href="#"><i class="fa fa-check"></i> <?php esc_html_e( 'Theme Info', 'atomic-blocks' ); ?></a></li>
				<li><a id="updates" href="#"><i class="fa fa-refresh"></i> <?php esc_html_e( 'Latest Updates', 'atomic-blocks' ); ?></a></li>
				<li><a id="themes" href="#"><i class="fa fa-arrow-circle-down"></i> <?php esc_html_e( 'Get More Themes', 'atomic-blocks' ); ?></a></li>
			</ul>

			<div id="panel" class="panel">
				<!-- Help file panel -->
				<div id="help-panel" class="panel-left visible">
					<!-- Grab feed of help file -->
					<?php
						include_once( ABSPATH . WPINC . '/feed.php' );

						$rss = fetch_feed( 'https://arraythemes.com/articles/atomic-blocks/feed/?withoutcomments=1' );

						if ( ! is_wp_error( $rss ) ) :
							$maxitems = $rss->get_item_quantity( 1 );
							$rss_items = $rss->get_items( 0, $maxitems );
						endif;

						$rss_items_check = array_filter( $rss_items );
					?>

					<!-- Output the feed -->
					<?php if ( is_wp_error( $rss ) || empty( $rss_items_check ) ) : ?>
						<p><?php esc_html_e( 'This help file feed seems to be temporarily down. You can always view the help file on the Atomic Blocks site in the meantime.', 'atomic-blocks' ); ?> <a href="https://atomic-blocks.com" title="View help file"><?php esc_html_e( 'Atomic Blocks Help File &rarr;', 'atomic-blocks' ); ?></a></p>
					<?php else : ?>
						<?php foreach ( $rss_items as $item ) : ?>
							<?php echo $item->get_content(); ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

				<!-- Updates panel -->
				<div id="updates-panel" class="panel-left">
					<p><?php echo $changelog; ?></p>
				</div><!-- .panel-left updates -->

				<!-- More themes -->
				<div id="themes" class="panel-left">
					<div class="theme-intro clear">
						<div class="theme-intro-left">
							<p><?php _e( 'Array Themes has over 20 WordPress themes that will integrate seamlessly with the new block editor. Check them out below!', 'atomic-blocks' ); ?></p>
						</div>
						<div class="theme-intro-right">
							<a class="button-primary club-button" href="<?php echo esc_url('https://arraythemes.com/theme-club'); ?>"><?php esc_html_e( 'Learn about the Theme Club', 'atomic-blocks' ); ?> &rarr;</a>
						</div>
					</div>

					<div class="theme-list">
					<?php
					$themes_list = wp_remote_get( 'https://arraythemes.com/feed/themes' );

					if ( ! is_wp_error( $themes_list ) && 200 === wp_remote_retrieve_response_code( $themes_list ) ) {
						echo wp_remote_retrieve_body( $themes_list );
					} else {
						$themes_link = 'https://arraythemes.com/wordpress-themes';
						printf( __( 'This theme feed seems to be temporarily down. Please check back later, or visit our <a href="%s">Themes page on Array</a>.', 'atomic-blocks' ), esc_url( $themes_link ) );
					} ?>

					</div><!-- .theme-list -->
				</div><!-- .panel-left updates -->

				<div class="panel-right">
					
					<?php if( ! function_exists( 'gutenberg_init' ) || ! function_exists( 'atomic_block_loader' ) ) { ?>
					<div class="panel-aside panel-ab-plugin panel-club">
						<div class="panel-club-inside">
							<div class="cell panel-title">
								<h3><i class="fa fa-check"></i> <?php esc_html_e( 'Quick Start Checklist', 'atomic-blocks' ); ?></h3>
							</div>

							<ul>
								<li class="cell <?php if( function_exists( 'gutenberg_init' ) ) { echo 'step-complete'; } ?>">
									<strong><?php esc_html_e( '1. Install the Gutenberg plugin.', 'atomic-blocks' ); ?></strong>
									<p><?php esc_html_e( 'Gutenberg adds the new block-based editor to WordPress.', 'atomic-blocks' ); ?></p>
									
									<?php if( ! function_exists( 'gutenberg_init' ) ) { ?>
										<a class="button-primary club-button" href="<?php echo esc_url( $gberg_install_url ); ?>"><?php esc_html_e( 'Install Gutenberg now', 'atomic-blocks' ); ?> &rarr;</a>
									<?php } else { ?>
										<strong><i class="fa fa-check"></i> <?php esc_html_e( 'Plugin already installed!', 'atomic-blocks' ); ?></strong>
									<?php } ?>
								</li>
							
								<li class="cell <?php if( function_exists( 'atomic_block_loader' ) ) { echo 'step-complete'; } ?>">
									<strong><?php esc_html_e( '2. Install the Atomic Blocks plugin.', 'atomic-blocks' ); ?></strong>
									<p><?php esc_html_e( 'Atomic Blocks adds several handy blocks to the block editor.', 'atomic-blocks' ); ?></p>
									
									<?php if( ! function_exists( 'atomic_block_loader' ) ) { ?>
										<a class="button-primary club-button" href="<?php echo esc_url( $ab_install_url ); ?>"><?php esc_html_e( 'Install Atomic Blocks now', 'atomic-blocks' ); ?> &rarr;</a>
									<?php } else { ?>
										<strong><i class="fa fa-check"></i> <?php esc_html_e( 'Plugin already installed!', 'atomic-blocks' ); ?></strong>
									<?php } ?>
								</li>
							</ul>
						</div>
					</div>
					<?php } ?>

					<div class="panel-aside panel-ab-plugin panel-club">
						<div class="panel-club-inside">
							<div class="cell panel-title">
								<h3><i class="fa fa-envelope"></i> <?php esc_html_e( 'Stay Updated', 'atomic-blocks' ); ?></h3>
							</div>

							<ul>
								<li class="cell">
									<p><?php esc_html_e( 'The Atomic Blocks theme and plugin are both in early development. Join the newsletter and we will send you an email when we update the theme and plugin!', 'atomic-blocks' ); ?></p>
									
									<a class="button-primary club-button" href="<?php echo esc_url( 'https://atomicblocks.com/subscribe' ); ?>"><?php esc_html_e( 'Subscribe Now', 'atomic-blocks' ); ?> &rarr;</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="panel-aside panel-ab-plugin panel-club">
						<div class="panel-club-inside">
							<div class="cell panel-title">
								<h3><i class="fa fa-arrow-circle-down"></i> <?php esc_html_e( 'Free Blocks & Tutorials', 'atomic-blocks' ); ?></h3>
							</div>

							<ul>
								<li class="cell">
									<p><?php esc_html_e( 'Check out the Atomic Blocks site to find block editor tutorials, free blocks and updates about the Atomic Blocks plugin and theme!', 'atomic-blocks' ); ?></p>
									<a class="button-primary club-button" href="<?php echo esc_url( 'https://atomicblocks.com' ); ?>"><?php esc_html_e( 'Visit AtomicBlocks.com', 'atomic-blocks' ); ?> &rarr;</a>
								</li>
							</ul>
						</div>
					</div>
				</div><!-- .panel-right -->
			</div><!-- .panel -->
		</div><!-- .panels -->
	</div><!-- .getting-started -->
<?php
}
