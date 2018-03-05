<?php
/**
 * Template Name: Wide Featured Image
 * 
 * Template Post Type: post
 *
 * This template gives you a wide featured image.
 *
 * @package Atomic Blocks
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content' ); ?>

			<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
