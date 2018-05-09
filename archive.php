<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Atomic Blocks
 */
get_header();
?>

<section id="primary" class="content-area">
	<main id="main" class="site-main">
		<div id="post-wrap">
			<?php
				if ( have_posts() ) :

				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content' );

				endwhile;

				else :

				get_template_part( 'template-parts/content-none' );

				endif;
			?>
		</div>

		<?php the_posts_pagination(); ?>
	</main><!-- #main -->
</section><!-- #primary -->

<?php get_footer(); ?>
