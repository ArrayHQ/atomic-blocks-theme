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

		<?php atomic_blocks_post_media(); ?>

		<div class="entry-content">

			<?php
			// Remove Jetpack Sharing output
			if( ! is_single() ) {
				atomic_blocks_remove_sharing();
			}

			// If it's a video format, filter out the first embed and return the rest of the content
			if ( has_post_format( 'video' ) || has_post_format( 'gallery' ) ) {
				atomic_blocks_filtered_content();
			} else {
				the_content( esc_html__( 'Read More', 'atomic-blocks' ) );
			}

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
