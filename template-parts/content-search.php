<?php
/**
 * The template used for displaying search results
 *
 * @package Atomic Blocks
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-content">
		<?php if( ! is_single() ) { ?>
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php atomic_blocks_post_byline(); ?>
			</header>
		<?php } ?>

		<div class="entry-content">
			<?php add_filter( 'excerpt_length', 'atomic_blocks_search_excerpt_length' ); ?>

			<?php echo wp_strip_all_tags( get_the_excerpt(), true ); ?>

			<?php remove_filter( 'excerpt_length', 'atomic_blocks_search_excerpt_length' ); ?>
		</div><!-- .entry-content -->
	</div><!-- .post-content-->

</article><!-- #post-## -->
