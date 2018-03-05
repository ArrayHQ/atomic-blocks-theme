<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Atomic Blocks
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="masthead" class="site-header">
	<div class="top-navigation">
		<?php
			// Get the mobile menu
			get_template_part( 'template-parts/content-menu-drawer' );
		?>

		<div class="container">
			<div class="site-identity clear">
				<!-- Site title and logo -->
				<?php atomic_blocks_title_logo(); ?>

				<div class="top-navigation-right">
					<!-- Main navigation -->
					<nav id="site-navigation" class="main-navigation">
						<?php wp_nav_menu( array(
							'theme_location' => 'primary'
						) );?>
					</nav><!-- .main-navigation -->
				</div><!-- .top-navigation-right -->
			</div><!-- .site-identity-->
		</div><!-- .container -->
	</div><!-- .top-navigation -->

	<!-- Get the archive page titles -->
	<?php if( is_archive() || is_search() ) { ?>
		<div class="container text-container">
			<div class="header-text">
				<?php atomic_blocks_page_titles(); ?>
			</div><!-- .header-text -->
		</div><!-- .text-container -->
	<?php } ?>
</header><!-- .site-header -->

<?php
// Sticky bar for single pages
if( is_single() ) { ?>
	<nav class="home-nav single-nav">
		<h2 class="sticky-title"><?php the_title(); ?></h2>

		<?php
			// Sharing Buttons
			if ( function_exists( 'sharing_display' ) ) {
				echo sharing_display();
			}
		?>
	</nav>
<?php } ?>

<div id="page" class="hfeed site container">
	<div id="content" class="site-content">
