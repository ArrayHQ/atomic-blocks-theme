<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Atomic Blocks
 */

// Get the sidebar widgets
if ( is_active_sidebar( 'sidebar' ) ) { ?>
	<aside id="secondary" class="widget-area">
		<?php do_action( 'atomic_blocks_above_sidebar' );

		dynamic_sidebar( 'sidebar' );

		do_action( 'atomic_blocks_below_sidebar' ); ?>
	</aside><!-- #secondary .widget-area -->
<?php }
