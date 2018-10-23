<?php
/**
 * This template displays the search form.
 *
 * @package Atomic Blocks
 */
?>

<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'atomic-blocks' ); ?></label>

		<input type="text" value="<?php echo get_search_query(); ?>" name="s" class="search-input" placeholder="<?php esc_attr_e( 'Search here...', 'atomic-blocks' ); ?>" />

		<button class="searchsubmit" type="submit">
			<i class="fa fa-search"></i> <span><?php esc_html_e( 'Search', 'atomic-blocks' ); ?></span>
		</button>
	</div>
</form>
