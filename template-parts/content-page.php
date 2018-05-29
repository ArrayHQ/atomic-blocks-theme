<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Atomic Blocks
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-content">
		<header class="entry-header">
			<h2 class="entry-title">
				<?php the_title(); ?>
			</h2>
		</header>

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="featured-image">
				<?php the_post_thumbnail( 'atomic-blocks-featured-image' ); ?>
			</div>
		<?php } ?>

		<div class="entry-content">

			<?php
			// Get the content
			the_content( esc_html__( 'Read More', 'atomic-blocks' ) );

			// Post pagination links
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'atomic-blocks' ),
				'after'  => '</div>',
			) );

			// Comments template
			comments_template(); ?>
		</div><!-- .entry-content -->
	</div><!-- .post-content-->

</article><!-- #post-## -->
