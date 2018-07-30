<?php
/**
 * Getting Started page
 *
 * @package Atomic Blocks
 */


/**
 * Load Getting Started styles in the admin
 *
 * since 1.0.0
 */
function atomic_blocks_theme_admin_scripts() {

	global $pagenow;

	/**
	 * Load scripts and styles
	 *
	 * @since 1.0
	 */

	if( ! isset( $_GET['page'] ) || ( isset( $_GET['page'] ) && 'atomic-blocks' !== $_GET['page'] ) ) {
		return;
	}

	// Getting Started javascript
	wp_enqueue_script( 'atomic-blocks-getting-started', get_template_directory_uri() . '/inc/admin/getting-started/js/getting-started.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'atomic-blocks-matchHeight', get_template_directory_uri() . '/inc/admin/getting-started/js/jquery.matchHeight.js', array( 'jquery' ), '0.5.2', true );

	// Getting Started styles
	wp_register_style( 'atomic-blocks-getting-started', get_template_directory_uri() . '/inc/admin/getting-started/getting-started.css', false, '1.0.0' );
	wp_enqueue_style( 'atomic-blocks-getting-started' );

	// FontAwesome
	wp_register_style( 'atomic-blocks-fontawesome', get_template_directory_uri() . '/inc/fontawesome/css/fontawesome-all.css', false, '1.0.0' );
	wp_enqueue_style( 'atomic-blocks-fontawesome' );
}
add_action( 'admin_enqueue_scripts', 'atomic_blocks_theme_admin_scripts' );


/**
 * Adds a menu item for the Getting Started page.
 *
 * since 1.0.0
 */
function atomic_blocks_theme_getting_started_menu() {

	add_theme_page(
		__( 'Atomic Blocks', 'atomic-blocks' ),
		__( 'Atomic Blocks', 'atomic-blocks' ),
		'manage_options',
		'atomic-blocks',
		'atomic_blocks_theme_getting_started_page',
		'dashicons-admin-settings'
	);

}
add_action( 'admin_menu', 'atomic_blocks_theme_getting_started_menu' );


/**
 * Add a notice for the help file
 *
 * since 1.0.6
 */
function atomic_blocks_admin_help_file_notice() {
    
    if( ! isset( $_GET['activated'] ) ) {
        return;
    }

    $atomic_blocks_message = sprintf(
        '<p>%2$s <strong><a href="%1$s">%3$s</a></strong></p>',
        esc_url( admin_url( "themes.php?page=atomic-blocks" ) ),
        esc_html__( 'Atomic Blocks Activated! Get started by visiting the help file.', 'atomic-blocks' ),
        esc_html__( 'View Help File &rarr;', 'atomic-blocks' )
    );

    echo '<div class="notice notice-info is-dismissible">' . $atomic_blocks_message . '</div>';
}
add_action( 'load-themes.php', 'atomic_blocks_admin_help_file_notice' );


/**
 * Outputs the markup used on the theme license page.
 *
 * since 1.0.0
 */
function atomic_blocks_theme_getting_started_page() {

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
			esc_url ( admin_url( 'update.php' ) )
		),
		'install-plugin_gutenberg'
	);

	$ab_install_url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'install-plugin',
				'plugin' => 'atomic-blocks'
			),
			esc_url( admin_url( 'update.php' ) )
		),
		'install-plugin_atomic-blocks'
	);
?>
	<div class="wrap ab-getting-started">
		<div class="intro-wrap">
			<div class="intro">
				<a href="https://atomicblocks.com/?utm_source=AB%20Theme%20Logo%20Link&utm_campaign=ab_theme_logo_link"><img class="atomic-logo" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/logo.png' ); ?>" alt="<?php esc_html_e( 'Visit Atomic Blocks', 'atomic-blocks' ); ?>" /></a>	
				<h3><?php printf( esc_html__( 'Getting started with', 'atomic-blocks' ) ); ?> <strong><?php printf( esc_html__( 'Atomic Blocks', 'atomic-blocks' ) ); ?></strong></h3>
			</div>
		</div>

		<div class="panels">
			<ul class="inline-list">
				<li class="current"><a id="atomic-blocks" href="#"><i class="fas fa-plug"></i> <?php esc_html_e( 'Atomic Blocks Plugin', 'atomic-blocks' ); ?></a></li>	
				<li><a id="theme-help" href="#"><i class="far fa-question-circle"></i> <?php esc_html_e( 'Theme Help File', 'atomic-blocks' ); ?></a></li>
				<li><a id="themes" href="#"><i class="fas fa-desktop"></i> <?php esc_html_e( 'Get More Themes', 'atomic-blocks' ); ?></a></li>
			</ul>

			<div id="panel" class="panel">
				<!-- Atomic Blocks panel -->
				<div id="atomic-blocks-panel" class="panel-left visible">
					<div class="ab-block-split clearfix">
						<div class="ab-block-split-left">
							<div class="ab-titles">
								<h2><?php esc_html_e( 'Download the free Atomic Blocks plugin and start building websites with Gutenberg today!', 'atomic-blocks' ); ?></h2>
								<p><?php esc_html_e( 'Atomic Blocks is a free collection of beautiful page-building blocks for the new WordPress editor. Add sharing icons, buttons, accordions, call-to-actions, and more to your site! Integrates seamlessly with the Atomic Blocks theme!', 'atomic-blocks' ); ?></p>
								
								<?php if( ! array_key_exists( 'atomic-blocks/atomicblocks.php', get_plugins() ) ) { ?>
									<a class="button-primary" href="<?php echo esc_url( $ab_install_url ); ?>"><?php esc_html_e( 'Install Atomic Blocks', 'atomic-blocks' ); ?> &rarr;</a>
								<?php } else if ( array_key_exists( 'atomic-blocks/atomicblocks.php', get_plugins() ) && ! is_plugin_active( 'atomic-blocks/atomicblocks.php' ) ) { ?>
									<a class="button-primary" href="<?php echo esc_url( admin_url( "plugins.php" ) ); ?>"><?php esc_html_e( 'Activate Atomic Blocks', 'atomic-blocks' ); ?></a>
								<?php } else { ?>
									<strong><i class="fa fa-check"></i> <?php esc_html_e( 'Plugin activated!', 'atomic-blocks' ); ?></strong>
								<?php } ?>
							</div>
						</div>
						<div class="ab-block-split-right">
							<div class="ab-block-theme">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/ab-theme-home.jpg' ) ?>" alt="<?php esc_html_e( 'Atomic Blocks Theme', 'atomic-blocks' ); ?>" />
							</div>
						</div>
					</div>

					<div class="ab-block-feature-wrap">
						<i class="fas fa-plug"></i>
						<h2><?php esc_html_e( 'Available Atomic Blocks', 'atomic-blocks' ); ?></h2>
						<p><?php esc_html_e( 'The following blocks are available in Atomic Blocks. More blocks are on the way so stay tuned!', 'atomic-blocks' ); ?></p>

						<div class="ab-block-features">
							<div class="ab-block-feature">
								<div class="ab-block-feature-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/cc41.svg' ) ?>" alt="<?php esc_html_e( 'Call To Action Block', 'atomic-blocks' ); ?>" /></div>
								<div class="ab-block-feature-text">
									<h3><?php esc_html_e( 'Call-To-Action Block', 'atomic-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add an eye-catching, full-width section with a big title, paragraph text, and a customizable button.', 'atomic-blocks' ); ?></p>
								</div>
							</div>

							<div class="ab-block-feature">
								<div class="ab-block-feature-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/cc4.svg' ) ?>" alt="<?php esc_html_e( 'Testimonials Block', 'atomic-blocks' ); ?>" /></div>
								<div class="ab-block-feature-text">
									<h3><?php esc_html_e( 'Testimonial Block', 'atomic-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a customer or client testimonial to your site with an avatar, text, citation and more.', 'atomic-blocks' ); ?></p>
								</div>
							</div>

							<div class="ab-block-feature">
								<div class="ab-block-feature-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/cc184.svg' ) ?>" alt="<?php esc_html_e( 'Inline Notices Block', 'atomic-blocks' ); ?>" /></div>
								<div class="ab-block-feature-text">
									<h3><?php esc_html_e( 'Inline Notice Block', 'atomic-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a colorful notice or message to your site with text, a title and a dismiss icon.', 'atomic-blocks' ); ?></p>
								</div>
							</div>

							<div class="ab-block-feature">
								<div class="ab-block-feature-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/cc50.svg' ) ?>" alt="<?php esc_html_e( 'Sharing Icons Block', 'atomic-blocks' ); ?>" /></div>
								<div class="ab-block-feature-text">
									<h3><?php esc_html_e( 'Sharing Icons Block', 'atomic-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add social sharing icons to your page with size, shape, color and style options.', 'atomic-blocks' ); ?></p>
								</div>
							</div>

							<div class="ab-block-feature">
								<div class="ab-block-feature-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/cc94-f.svg' ) ?>" alt="<?php esc_html_e( 'Author Profile Block', 'atomic-blocks' ); ?>" /></div>
								<div class="ab-block-feature-text">
									<h3><?php esc_html_e( 'Author Profile Block', 'atomic-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a user profile box to your site with a title, bio info, an avatar and social media links.', 'atomic-blocks' ); ?></p>
								</div>
							</div>

							<div class="ab-block-feature">
								<div class="ab-block-feature-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/cc115.svg' ) ?>" alt="<?php esc_html_e( 'Accordion Toggle', 'atomic-blocks' ); ?>" /></div>
								<div class="ab-block-feature-text">
									<h3><?php esc_html_e( 'Accordion Block', 'atomic-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add an accordion text toggle with a title and descriptive text. Includes font size and toggle options.', 'atomic-blocks' ); ?></p>
								</div>
							</div>

							<div class="ab-block-feature">
								<div class="ab-block-feature-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/cc45.svg' ) ?>" alt="<?php esc_html_e( 'Customizable Button Block', 'atomic-blocks' ); ?>" /></div>
								<div class="ab-block-feature-text">
									<h3><?php esc_html_e( 'Customizable Button', 'atomic-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a fancy stylized button to your post or page with size, shape, target, and color options.', 'atomic-blocks' ); ?></p>
								</div>
							</div>

							<div class="ab-block-feature">
								<div class="ab-block-feature-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/cc38.svg' ) ?>" alt="<?php esc_html_e( 'Drop Cap Block', 'atomic-blocks' ); ?>" /></div>
								<div class="ab-block-feature-text">
									<h3><?php esc_html_e( 'Drop Cap Block', 'atomic-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add a stylized drop cap to the beginning of your paragraph. Choose from three different styles.', 'atomic-blocks' ); ?></p>
								</div>
							</div>

							<div class="ab-block-feature">
								<div class="ab-block-feature-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/images/cc402.svg' ) ?>" alt="<?php esc_html_e( 'Spacer and Divider Block', 'atomic-blocks' ); ?>" /></div>
								<div class="ab-block-feature-text">
									<h3><?php esc_html_e( 'Spacer & Divider', 'atomic-blocks' ); ?></h3>
									<p><?php esc_html_e( 'Add an adjustable spacer between your blocks with an optional divider with styling options.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
						</div><!-- .ab-block-features -->
					</div><!-- .ab-block-feature-wrap -->
				</div><!-- .panel-left -->

				<!-- Theme help file panel -->
				<div id="theme-help" class="panel-left">
					<p>The Atomic Blocks theme and plugin is developed and maintained by <a href="https://arraythemes.com/">Array Themes</a>, creators of finely-crafted WordPress themes. We built Atomic Blocks to learn the new block editor and share what we've learned along the way. This help file will help you become acquainted with the new editor and our new plugin, Atomic Blocks.</p>
					<ul id="top" class="toc">
						<li><a href="#gutenberg">What is Gutenberg?</a></li>
						<li><a href="#what-are-blocks">What are blocks?</a></li>
						<li><a href="#how-to-use">How to use the Atomic Blocks theme</a></li>
						<li><a href="#theme-options">Theme Options</a></li>
						<li><a href="#menus">Menus</a></li>
						<li><a href="#widgets">Widgets</a></li>
						<li><a href="#media-alignment">Media Alignment Options</a></li>
						<li><a href="#updating">Updating the theme</a></li>
						<li><a href="#more-about-gutenberg">Learn more about Gutenberg</a></li>
						<li><a href="#photos">Finding Good Photos</a></li>
					</ul>
					<hr>
					<h2 id="gutenberg">What is Gutenberg?</h2>
					<p><img class="alignnone size-full wp-image-147" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/ab-gutenberg.jpg' ) ?>" alt="gutenberg block editor" width="1400" height="728"></p>
					<p>The new <a href="https://wordpress.org/gutenberg/">WordPress block editor</a>, currently referred to as Gutenberg, is a new way to build with WordPress. Instead of relying on page building plugins, shortcodes, and the like, WordPress is bringing block-based editing to the core editor. The Gutenberg editor uses blocks to create all types of content, replacing a half-dozen inconsistent ways of customizing WordPress, bringing it in line with modern coding standards, and aligning with open web initiatives.</p>
					<p>Please check out our <a href="https://atomicblocks.com/a-beginners-guide-to-gutenberg/">Beginners Guide to Gutenberg</a> article to become more familiar with the new Gutenberg block editor.</p>
					<hr>
					<h2 id="what-are-blocks">What are blocks?</h2>
					<p>When we refer to "blocks" or "Gutenberg blocks" we are talking anything that can be inserted into the new editor to create content. Basically, anything you insert into the new editor will be in the form of a block. The new editor comes with a handful of default blocks such as paragraph, image, gallery, and more, to help you create standard posts and pages. Developers will also be able to provide more advanced blocks to help you create even more dynamic posts and pages.</p>
					<div id="attachment_84" style="width: 1410px" class="wp-caption alignnone"><img class="size-full wp-image-84" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/ab-block-editor.jpg' ) ?>" alt="gutenberg block editor" width="1400" height="728"><p class="wp-caption-text">A look at the new block-based editor.</p></div>
					<p>The Atomic Blocks plugin provides you with a bunch of awesome content blocks that you can use to start building your site. Once the plugin is activated, the blocks will be activated and ready to use on your posts and pages. Atomic Blocks currently includes the following blocks:</p>
					<ul>
						<li>Testimonial Block</li>
						<li>Inline Notice Block</li>
						<li>Accordion Block</li>
						<li>Share Icons Block</li>
						<li>Call-To-Action Block</li>
						<li>Customizable Button Block</li>
						<li>Spacer &amp; Divider Block</li>
						<li>Author Profile Block</li>
						<li>Drop Cap Block</li>
					</ul>
					<h2 id="how-to-use">How to use the Atomic Blocks theme</h2>
					<p>The Atomic Blocks WordPress theme can be used without installing Gutenberg or the Atomic Blocks plugin, but we encourage you to install both of the plugins to get the most out of the theme. The theme was built with the new editor in mind and is most powerful with both Gutenberg and Atomic Blocks installed.</p>
					<p><strong>Install the Gutenberg plugin</strong></p>
					<p><img class="alignnone size-full wp-image-149" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/gberg-banner-1544x500.jpg' ) ?>" alt="install gutenberg" width="1544" height="500"></p>
					<p>Before you can use the Atomic Blocks plugin, you'll need to install the Gutenberg plugin. The plugin is available via the WordPress.org repository, so you can install it in your WordPress admin by going to <em>Plugins &rarr; Add New</em> and searching for "Gutenberg". You can also <a href="https://wordpress.org/plugins/gutenberg/">download it directly</a> from the repository and install it manually. Eventually, the Gutenberg plugin will not be required once the new editor is merged into WordPress core.</p>
					<p>Once Gutenberg is installed and activated, you'll notice that you have a new Gutenberg admin menu item, which takes you to a nice little Gutenberg demo. You'll also notice that your edit post and edit page views have a new appearance. There are lots of articles about the new editor and how to work with it. Check out the <a href="https://atomicblocks.com/blog">Atomic Blocks blog</a> and <a href="http://gutenberg.news">Gutenberg News</a> to find the best articles about the new block editor.</p>
					<p><strong>Install the Atomic Blocks plugin</strong></p>
					<p><img class="alignnone size-full wp-image-150" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/banner-1544x500.jpg' ) ?>" alt="install atomic blocks" width="1544" height="500"></p>
					<p>Once you've installed Gutenberg, you can install Atomic Blocks in the same way. You can either go to <em>Plugins &rarr; Add New</em> and search for "Atomic Blocks" or download it directly from our <a href="https://atomicblocks.com/">website</a> to install it manually.</p>
					<p>Once you've installed and activated Atomic Blocks, you'll be redirected to the Atomic Blocks Getting Started page which provides you with all kinds of info about the plugin, block usage, and more. You can also read the Atomic Blocks <a href="https://atomicblocks.com/plugin-help-file">help file here</a>.</p>
					<hr>
					<h2 id="theme-options">Theme Options</h2>
					<p><img class="alignnone size-full wp-image-155" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/ab-options.jpg' ) ?>" alt="atomic blocks theme options" width="1400" height="758"></p>
					<p>The Atomic Blocks theme comes with several Customizer settings that you can use to customize your site to your style. To access the theme options, click <em>Appearance &rarr; Customize &rarr; Theme Options</em> in your WordPress admin.</p>
					<p><strong>Theme Options</strong></p>
					<ul>
						<li><strong>Content Width</strong>: This setting will let you change the width of the content area in your posts and pages. Images and text will be constrained to this width unless you are using wide image styles.</li>
						<li><strong>Search Icon</strong>: Enable the Search Icon to add a search toggle to your menu in the header. The search toggle will drop down a search box that users can use to search your site.</li>
						<li><strong>Font Style</strong>: Choose between a sans-serif font style (Muli and Nunito Sans) or a serif font style (Frank Ruhl Libre). This will change the font displayed on the front end as well as in your post editor.</li>
						<li><strong>Body Font Size</strong>: Choose the font size you would like displayed in the main content area of your posts and pages.</li>
						<li><strong>Title Font Size</strong>: Choose the font size you would like displayed in the titles of your posts and pages.</li>
					</ul>
					<p><strong>Site Identity</strong></p>
					<ul>
						<li><strong>Logo</strong>: Upload your own logo image in place of the site title and tagline. You can also choose to hide or show your site tagline.</li>
						<li><strong>Site Icon</strong>: Upload an icon to be displayed in the browser tab of your site.</li>
					</ul>
					<p><strong>Colors</strong></p>
					<ul>
						<li><strong>Accent Color</strong>: Change the accent color you see throughout the theme such as links, buttons, and more.</li>
						<li><strong>Background Color</strong>: Change the background color of your entire site. Please note that changing this could require you to change the colors of fonts and other elements that may conflict with your new background color.</li>
					</ul>
					<hr>
					<h2 id="menus">Menus</h2>
					<p>This theme has two different menus that can be used throughout the theme.</p>
					<ul>
						<li><strong>Primary Menu</strong> - This is the main menu found in the header of your site.</li>
						<li><strong>Social Icon Menu</strong> This is the social media icon menu found in the footer of your site. See the instructions below to set up the Social Icon Menu.
						<ul>
							<li>To add a social icon menu, go to <em>Appearance &rarr; Menus</em>.</li>
							<li>On the left side of the Menu page, click the <strong>Links</strong> menu item to add to your social links.</li>
							<li><a href="http://cl.ly/image/1m2j0c0O1S1u">Add the URL</a> for each of your social profiles and a label for the link. The theme will detect which site you are linking to and display a matching graphic. Icons are supported for the following sites: Twitter, Facebook, Google, Instagram, YouTube, Vimeo, Dribbble, Github, Flickr, Codepen, Behance, Dropbox, Pinterest, Reddit, Soundcloud, Spotify, WordPress, LinkedIn, Stack Overflow, Slideshare, Medium, Apple, 500px, RSS and Email. If there is a popular service that isn't supported and has an icon on <a href="http://fontawesome.io/icons/#brand">FontAwesome</a>, let us know and we'll add it to the theme!</li>
							<li>Now that you have the menu created, you need to assign it to the Social Icon Menu in the <a href="http://cl.ly/fclS">Theme Locations section</a></li>
							<li>Save the menu when finished.</li>
						</ul>
						</li>
					</ul>
					<hr>
					<h2 id="templates">Page Templates</h2>
					<p>This theme comes with a few different page templates to help you help integrate with Gutenberg and other page builders. To apply a template to a page, use the Template drop down menu in the Page Attributes box.</p>
					<ul>
						<li><strong>Full Width</strong>: This template will stretch the content area to the full width of the content container. Your content will remain centered and have padding on the left and right side. You can also achieve this full width effect for all pages by going to <em>Appearance &rarr; Customize &rarr; Content Width</em>.</li>
						<li><strong>Page Builder</strong>: This template will stretch your content from one edge of the screen to the other and remove any margins or paddings for the entire content area. Essentially it gives you a blank canvas for your page, with the header and footer still available. This will allow you to use Gutenberg blocks or other page builders to add sections with their own content or padding.</li>
					</ul>
					<hr />
					<h2 id="widgets">Footer Widget Area</h2>
					<p><img class="alignnone size-full wp-image-153" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/ab-footer.jpg' ) ?>" alt="atomic blocks footer widgets" width="1400" height="466" srcset="https://atomicblocks.com/wp-content/uploads/2018/03/ab-footer.jpg 1400w, https://atomicblocks.com/wp-content/uploads/2018/03/ab-footer-300x100.jpg 300w, https://atomicblocks.com/wp-content/uploads/2018/03/ab-footer-768x256.jpg 768w, https://atomicblocks.com/wp-content/uploads/2018/03/ab-footer-1024x341.jpg 1024w, https://atomicblocks.com/wp-content/uploads/2018/03/ab-footer-800x266.jpg 800w, https://atomicblocks.com/wp-content/uploads/2018/03/ab-footer-1200x399.jpg 1200w, https://atomicblocks.com/wp-content/uploads/2018/03/ab-footer-600x200.jpg 600w" sizes="(max-width: 1400px) 100vw, 1400px"></p>
					<p>The Atomic Blocks theme comes with a footer widget area that you can use to customize your footer. There are three widget columns that you can use to add widgets. The footer widget columns have a dynamic width, meaning if you only choose to use two columns, the column width will adjust to display the columns evenly in the footer.</p>
					<hr>
					<h2 id="media-alignment">Media Alignment Options</h2>
					<p>One of the aims of the new block editor is to let you build outside of the box, so to speak. One way to do that is by adding wide image styles to your media such as images, galleries and videos. The Atomic Blocks theme provides wide and full-width media styles for you to use. Please note that you will need to have the Gutenberg plugin installed to take advantage of these new styles.</p>
					<div id="attachment_134" style="width: 1410px" class="wp-caption alignnone"><img class="wp-image-134 size-full" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/ab-toolbar.jpg' ) ?>" alt="atomic blocks alignment" width="1400" height="819"><p class="wp-caption-text">Alignment settings.</p></div>
					<p>After you've added a photo, gallery or video to your post in the new block editor, you'll get a toolbar above the content, as seen in the screenshot above. The toolbar have several alignment options including left, center, right, wide, and full width. Using these, you can determine the width and alignment of your media.</p>
					<div id="attachment_136" style="width: 1410px" class="wp-caption alignnone"><img class="wp-image-136 size-full" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/ab-wide-style.jpg' ) ?>" alt="atomic blocks wide styles" width="1400" height="728"><p class="wp-caption-text">Wide image alignment.</p></div>
					<p>Clicking wide alignment will make the content go almost the full width of the page, but it will not hit the edge of the page. Instead, the media will have a padding on the left and right side of the page.</p>
					<div id="attachment_137" style="width: 1410px" class="wp-caption alignnone"><img class="wp-image-137 size-full" src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/ab-full-screen.jpg' ) ?>" alt="atomic blocks full screen style" width="1400" height="728"><p class="wp-caption-text">Full width image alignment.</p></div>
					<p>Clicking full width alignment will take your media to the very edge of the page, giving you an edge-to-edge, full-screen display.</p>
					<p>Eventually, wide and full width alignment will be available for more than media, letting you create sections that expand to the full width of the page to accomodate more dynamic layouts.</p>
					<hr>
					<h2 id="more-about-gutenberg">Learn more about Gutenberg</h2>
					<p>If you'd like to learn more about Gutenberg, please visit our <a href="https://atomicblocks.com/a-beginners-guide-to-gutenberg/">Beginner's Guide to Gutenberg</a> and <a href="https://atomicblocks.com/blog/">visit our blog</a> which will have regular tutorials and resources. We also publish a blog called <a href="https://gutenberg.news">Gutenberg News</a>, which is a curated collection of Gutenberg tutorials &amp; resources!</p>
					<hr>
					<h2 id="photos">Finding good photos</h2>
					<p>Finding good photos for your site can be tough and expensive, but we've got a few sites that offer really nice photography for free. Feel free to browse these sites and find some photos that highlight your content.</p>
					<ul>
						<li><a href="http://unsplash.com">Unsplash</a></li>
						<li><a href="https://pixabay.com/">Pixabay</a></li>
						<li><a href="http://jaymantri.com/">Jay Mantri</a></li>
						<li><a href="http://startupstockphotos.com/">Startup Stock Photos</a></li>
						<li><a href="https://github.com/neutraltone/awesome-stock-resources">Massive Github repo of free resources</a></li>
					</ul>
				</div>

				<!-- More themes -->
				<div id="themes" class="panel-left">
					<div class="ab-block-split clearfix">
						<div class="ab-block-split-left">
							<div class="ab-titles">
								<h2><?php esc_html_e( 'We also create pixel-perfect WordPress themes for creative professionals.', 'atomic-blocks' ); ?></h2>
								<p><?php esc_html_e( 'Launch your website in minutes with one of our beautiful, responsive themes. No bloat, no headaches, just really good websites and speedy support when you need it.', 'atomic-blocks' ); ?></p>
								<a class="button-primary" href="https://arraythemes.com/wordpress-themes?utm_source=AB%20Theme%20GS%20View%20Theme%20Collection"><?php esc_html_e( 'View Theme Collection &rarr;', 'atomic-blocks' ); ?></a>
							</div>
						</div>
						<div class="ab-block-split-right">
							<div class="ab-block-theme">
								<a href="https://arraythemes.com/wordpress-themes?utm_source=AB%20Theme%20GS%20Theme%20Image%20Link"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/latest-featured-image.jpg' ) ?>" alt="<?php esc_html_e( 'Array Themes', 'atomic-blocks' ); ?>" /></a>	
							</div>
						</div>
					</div>

					<div class="ab-block-feature-wrap">
						<i class="fas fa-desktop"></i>
						<h2><?php esc_html_e( 'More WordPress themes by Array', 'atomic-blocks' ); ?></h2>
						<p><?php esc_html_e( 'Instantly download the best-designed WordPress theme collection on the web for one low price!', 'atomic-blocks' ); ?></p>

						<div class="ab-block-features">
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/atomic-blocks-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/array-ab-theme.jpg' ) ?>" alt="<?php esc_html_e( 'Atomic Blocks WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/atomic-blocks-wordpress-theme/"><?php esc_html_e( 'Atomic Blocks WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'A free Gutenberg theme that works seamlessly with the new WordPress editor and the Atomic Blocks plugin by Array Themes.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
								
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/latest-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/latest-featured-image.jpg' ) ?>" alt="<?php esc_html_e( 'Latest WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/latest-wordpress-theme/"><?php esc_html_e( 'Latest WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Launch a beautiful eCommerce shop, an impressive magazine, or a food or travel blog with Latest.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
								
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/meteor-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/meteor-desktop.jpg' ) ?>" alt="<?php esc_html_e( 'Meteor WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/meteor-wordpress-theme/"><?php esc_html_e( 'Meteor WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Launch a stunning portfolio and resume site to showcase your photos, designs, videos, services and more.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
								
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/atomic-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/atomic-home.jpg' ) ?>" alt="<?php esc_html_e( 'Atomic WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/atomic-wordpress-theme/"><?php esc_html_e( 'Atomic WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Build a bold business or portfolio site with beautiful templates for teams, services, testimonials, portfolio, blog posts and more.', 'atomic-blocks' ); ?></p>
								</div>
							</div>

							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/lenscap-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/lenscap-full-home.jpg' ) ?>" alt="<?php esc_html_e( 'Lenscap WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/lenscap-wordpress-theme/"><?php esc_html_e( 'Lenscap WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'A bold, magazine-style WordPress theme for creating engaging, media-rich content that integrates with the number one eCommerce plugin on the planet, WooCommerce.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/baseline-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/baseline-home-1.jpg' ) ?>" alt="<?php esc_html_e( 'Baseline WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/baseline-wordpress-theme/"><?php esc_html_e( 'Baseline WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'A beautiful, magazine-style theme with multiple layouts, featured content areas and simple customization options.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/paperback-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/paperback-full-home.jpg' ) ?>" alt="<?php esc_html_e( 'Paperback WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/paperback-wordpress-theme/"><?php esc_html_e( 'Paperback WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'A magazine theme that empowers you to quickly and easily create beautiful, immersive content.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/candid-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/candid-home.jpg' ) ?>" alt="<?php esc_html_e( 'Candid WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/candid-wordpress-theme/"><?php esc_html_e( 'Candid WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Quickly and easily create beautiful content-focused website with images, galleries, video, audio and more.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/checkout-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/checkout-screenshot.jpg' ) ?>" alt="<?php esc_html_e( 'Checkout WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/checkout-wordpress-theme/"><?php esc_html_e( 'Checkout WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'With Checkout and Easy Digital Downloads, you can turn your site into a handsome digital store or marketplace.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/camera-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/camera.jpg' ) ?>" alt="<?php esc_html_e( 'Camera WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/camera-wordpress-theme/"><?php esc_html_e( 'Camera WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Create a beautifully minimal and distraction-free photography series or photo blog with Camera.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
						
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/designer-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/designer.jpg' ) ?>" alt="<?php esc_html_e( 'Designer WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/designer-wordpress-theme/"><?php esc_html_e( 'Designer WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Designer enables you to quickly and easily showcase your latest design work, sketches, audio, photography and more.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/pocket-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/pocket.jpg' ) ?>" alt="<?php esc_html_e( 'Pocket WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/pocket-wordpress-theme/"><?php esc_html_e( 'Pocket WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Minimalist photoblogging at its finest. Highlight your writing with beautiful, expressive featured images.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/editor-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/editor.jpg' ) ?>" alt="<?php esc_html_e( 'Editor WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/editor-wordpress-theme/"><?php esc_html_e( 'Editor WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Editor is a typography-driven theme that puts bold and beautiful publishing right at your fingertips.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/north-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/north.jpg' ) ?>" alt="<?php esc_html_e( 'North WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/north-wordpress-theme/"><?php esc_html_e( 'North WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'A contemporary, clean and bold canvas for showing off your latest projects, photographs or video reels.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
								
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/publisher-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/publisher.jpg' ) ?>" alt="<?php esc_html_e( 'Publisher WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/publisher-wordpress-theme/"><?php esc_html_e( 'Publisher WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Featuring a responsive, masonry-style layout, Publisher is an eclectic scrapbook of photos, videos, audio and more.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/ampersand-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/ampersand1.jpg' ) ?>" alt="<?php esc_html_e( 'Ampersand WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/ampersand-wordpress-theme/"><?php esc_html_e( 'Ampersand WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'A portfolio and business theme with an emphasis on beautiful, legible typography and a graceful mobile experience.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/verb-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/verb.jpg' ) ?>" alt="<?php esc_html_e( 'Verb WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/verb-wordpress-theme/"><?php esc_html_e( 'Verb WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Quickly and easily showcase your latest design work, sketches, audio, photography and more.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/typable-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/typable.jpg' ) ?>" alt="<?php esc_html_e( 'Typable WordPress Theme', 'atomic-blocks' ); ?>">
								</a></div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/typable-wordpress-theme/"><?php esc_html_e( 'Typable WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'A lean, mean blogging machine with snappy AJAX post loading, a dynamic header and abundant white space.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/medium-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/medium-660x7031.jpg' ) ?>" alt="<?php esc_html_e( 'Medium WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/medium-wordpress-theme/"><?php esc_html_e( 'Medium WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Use Medium as a personal blog or a minimal portfolio to share your latest articles, photo galleries and videos.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/author-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/author.jpg' ) ?>" alt="<?php esc_html_e( 'Author WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/author-wordpress-theme/"><?php esc_html_e( 'Author WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'A blank canvas for your thoughts. Author features clean, readable type and abundant white space.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/fixed-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/fixed.jpg' ) ?>" alt="<?php esc_html_e( 'Fixed WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/fixed-wordpress-theme/"><?php esc_html_e( 'Fixed WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'Use Fixed as a personal blog or a minimal portfolio to share your latest articles, photo galleries and videos.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
							
							<div class="ab-block-feature">
								<div class="theme-image">
									<a class="theme-link" href="https://arraythemes.com/themes/transmit-wordpress-theme/"><img src="<?php echo esc_url( get_template_directory_uri() . '/inc/admin/getting-started/docs/images/transmit.jpg' ) ?>" alt="<?php esc_html_e( 'Transmit WordPress Theme', 'atomic-blocks' ); ?>"></a>
								</div>
								<div class="ab-block-feature-text">
									<h3><a href="https://arraythemes.com/themes/transmit-wordpress-theme/"><?php esc_html_e( 'Transmit WordPress Theme', 'atomic-blocks' ); ?></a></h3>
									<p><?php esc_html_e( 'A fully-featured landing page theme with MailChimp and Campaign Monitor subscription support.', 'atomic-blocks' ); ?></p>
								</div>
							</div>
						</div><!-- .ab-block-features -->
					</div><!-- .ab-block-feature-wrap -->
				</div><!-- .panel-left updates -->

				<div class="panel-right">

					<?php if( ! function_exists( 'gutenberg_init' ) || ! function_exists( 'atomic_blocks_loader' ) ) { ?>
					<div class="panel-aside panel-ab-plugin panel-club ab-quick-start">
						<div class="panel-club-inside">
							<div class="cell panel-title">
								<h3><i class="fa fa-check"></i> <?php esc_html_e( 'Quick Start Checklist', 'atomic-blocks' ); ?></h3>
							</div>

							<ul>
								<li class="cell <?php if( function_exists( 'gutenberg_init' ) ) { echo 'step-complete'; } ?>">
									<strong><?php esc_html_e( '1. Install the Gutenberg plugin.', 'atomic-blocks' ); ?></strong>
									<p><?php esc_html_e( 'Gutenberg adds the new block-based editor to WordPress. You will need this to work with the Atomic Blocks plugin.', 'atomic-blocks' ); ?></p>

									<?php if( ! array_key_exists( 'gutenberg/gutenberg.php', get_plugins() ) ) { ?>
										<a class="button-primary club-button" href="<?php echo esc_url( $gberg_install_url ); ?>"><?php esc_html_e( 'Install Gutenberg now', 'atomic-blocks' ); ?> &rarr;</a>
									<?php } else if ( array_key_exists( 'gutenberg/gutenberg.php', get_plugins() ) && ! is_plugin_active( 'gutenberg/gutenberg.php' ) ) { ?>
										<a class="button-primary" href="<?php echo esc_url( admin_url( "plugins.php" ) ); ?>"><?php esc_html_e( 'Activate Gutenberg', 'atomic-blocks' ); ?></a>
									<?php } else { ?>
										<strong><i class="fa fa-check"></i> <?php esc_html_e( 'Plugin activated!', 'atomic-blocks' ); ?></strong>
									<?php } ?>
								</li>

								<li class="cell <?php if( function_exists( 'atomic_blocks_loader' ) ) { echo 'step-complete'; } ?>">
									<strong><?php esc_html_e( '2. Install the Atomic Blocks plugin.', 'atomic-blocks' ); ?></strong>
									<p><?php esc_html_e( 'Atomic Blocks adds several handy content blocks to the Gutenberg block editor.', 'atomic-blocks' ); ?></p>

									<?php if( ! array_key_exists( 'atomic-blocks/atomicblocks.php', get_plugins() ) ) { ?>
										<a class="button-primary club-button" href="<?php echo esc_url( $ab_install_url ); ?>"><?php esc_html_e( 'Install Atomic Blocks now', 'atomic-blocks' ); ?> &rarr;</a>
									<?php } else if ( array_key_exists( 'atomic-blocks/atomicblocks.php', get_plugins() ) && ! is_plugin_active( 'atomic-blocks/atomicblocks.php' ) ) { ?>
										<a class="button-primary club-button" href="<?php echo esc_url( admin_url( "plugins.php" ) ); ?>"><?php esc_html_e( 'Activate Atomic Blocks', 'atomic-blocks' ); ?></a>
									<?php } else { ?>
										<strong><i class="fa fa-check"></i> <?php esc_html_e( 'Plugin activated!', 'atomic-blocks' ); ?></strong>
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
								<p><?php esc_html_e( 'Join the newsletter to receive emails when we add new blocks, release plugin and theme updates, send out free resources, and more!', 'atomic-blocks' ); ?></p>
									<a class="button-primary club-button" href="https://atomicblocks.com/subscribe/?utm_source=AB%20Getting%20Started%20Subscribe&utm_campaign=AB_Getting_Started_Subscribe"><?php esc_html_e( 'Subscribe Now', 'atomic-blocks' ); ?> &rarr;</a>
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
									<a class="button-primary club-button" href="https://atomicblocks.com/?utm_source=AB%20Getting%20Started%20Visit%20Site&utm_campaign=AB_Getting_Started_Visit_Site"><?php esc_html_e( 'Visit AtomicBlocks.com', 'atomic-blocks' ); ?> &rarr;</a>
								</li>
							</ul>
						</div>
					</div>
				</div><!-- .panel-right -->

				<h2 class="visit-title"><?php esc_html_e( 'Free Blocks and Resources', 'atomic-blocks' ); ?></h2>

				<div class="ab-block-footer">
					<div class="ab-block-footer-column">
						<i class="far fa-envelope"></i>
						<h3><?php esc_html_e( 'Blocks In Your Inbox', 'atomic-blocks' ); ?></h3>
						<p><?php esc_html_e( 'Join the newsletter to receive emails when we add new blocks, release plugin and theme updates, send out free resources, and more!', 'atomic-blocks' ); ?></p>
						<a class="button-primary" href="https://atomicblocks.com/subscribe?utm_source=AB%20Theme%20GS%20Page%20Footer%20Subscribe"><?php esc_html_e( 'Subscribe Today', 'atomic-blocks' ); ?></a>
					</div>

					<div class="ab-block-footer-column">
						<i class="far fa-edit"></i>
						<h3><?php esc_html_e( 'Articles & Tutorials', 'atomic-blocks' ); ?></h3>
						<p><?php esc_html_e( 'Check out the Atomic Blocks site to find block editor tutorials, free blocks and updates about the Atomic Blocks plugin and theme!', 'atomic-blocks' ); ?></p>
						<a class="button-primary" href="https://atomicblocks.com/blog?utm_source=AB%20Theme%20GS%20Page%20Footer%20Blog"><?php esc_html_e( 'Visit the Blog', 'atomic-blocks' ); ?></a>
					</div>

					<div class="ab-block-footer-column">
						<i class="far fa-newspaper"></i>
						<h3><?php esc_html_e( 'Gutenberg News', 'atomic-blocks' ); ?></h3>
						<p><?php esc_html_e( 'Stay up to date with the new WordPress editor. Gutenberg News curates Gutenberg articles, tutorials, videos and more free resources.', 'atomic-blocks' ); ?></p>
						<a class="button-primary" href="http://gutenberg.news/?utm_source=AB%20Theme%20GS%20Page%20Footer%20Gnews"><?php esc_html_e( 'Visit Gutenberg News', 'atomic-blocks' ); ?></a>
					</div>
				</div>

				<div class="ab-footer">
					<p><?php echo sprintf( esc_html__( 'Made by the fine folks at %1$s and %2$s.', 'atomic-blocks' ), '<a href="https://arraythemes.com/">Array Themes</a>', '<a href="https://gutenberg.news/">Gutenberg News</a>' ); ?></p>	
					<div class="ab-footer-links">
						<a href="https:/atomicblocks.com/"><?php esc_html_e( 'AtomicBlocks.com', 'atomic-blocks' ); ?></a>
						<a href="https://atomicblocks.com/blog/"><?php esc_html_e( 'Blog', 'atomic-blocks' ); ?></a>
						<a href="https://atomicblocks.com/atomic-blocks-docs/"><?php esc_html_e( 'Docs', 'atomic-blocks' ); ?></a>
						<a href="https:/twitter.com/atomicblocks"><?php esc_html_e( 'Twitter', 'atomic-blocks' ); ?></a>
					</div>
				</div>
			</div><!-- .panel -->
		</div><!-- .panels -->
	</div><!-- .getting-started -->
<?php
}
