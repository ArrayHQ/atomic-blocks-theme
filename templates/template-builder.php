<?php
/**
 * Template Name: Page Builder
 *
 * This template has width, margin and padding containers removed for use with page builder plugins.
 *
 * @package Atomic Blocks
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php the_content(); ?>
				</article>

			<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
