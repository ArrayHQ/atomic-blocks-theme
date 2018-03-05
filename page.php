<?php
/**
 * The template for displaying default pages.
 *
 * @package Atomic Blocks
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php while ( have_posts() ) : the_post();

				// Page content template
				get_template_part( 'template-parts/content-page' );

			endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
