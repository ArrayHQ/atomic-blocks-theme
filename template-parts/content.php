<?php
/**
 * The template used for displaying standard post content
 *
 * @package Atomic Blocks
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-content">

		<header class="entry-header">
			<h2 class="entry-title">
				<?php if( is_single() ) { ?>	
					<?php the_title(); ?>
				<?php } else { ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				<?php } ?>
			</h2>
			<?php atomic_blocks_post_byline(); ?>
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

			if ( is_single()  ) {
	        	// Post meta sidebar
	        	get_template_part( 'template-parts/content-meta' );

				// Author profile box
				atomic_blocks_author_box();

				// Post navigations
				if( is_single() ) {
					if( get_next_post() || get_previous_post() ) {
						atomic_blocks_post_navs();
				} }

				// Comments template
				comments_template();
			} ?>
		</div><!-- .entry-content -->
	</div><!-- .post-content-->

</article><!-- #post-## -->
