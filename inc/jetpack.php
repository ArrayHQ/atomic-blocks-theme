<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Atomic Blocks
 */

/**
 * Add theme support for Jetpack Features.
 */
function atomic_blocks_jetpack_setup() {
	/**
	 * Add support for Infinite Scroll
	 */
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'post-wrap',
		'footer'         => false,
		'footer_widgets' => array( 'footer-1', 'footer-2', 'footer-3' ),
		'render'         => 'atomic_blocks_render_infinite_posts',
		'wrapper'        => 'new-infinite-posts',
	) );

	/**
	 * Add support for Responsive Videos
	 */
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'atomic_blocks_jetpack_setup' );


/**
 * Remove Related Posts CSS
 */
function atomic_blocks_rp_css() {
	wp_deregister_style( 'jetpack_related-posts' );
}
add_action( 'wp_print_styles', 'atomic_blocks_rp_css' );
add_filter( 'jetpack_implode_frontend_css', '__return_false' );


/**
 * Render infinite posts by using template parts
 */
function atomic_blocks_render_infinite_posts() {
	while ( have_posts() ) {
		the_post();

		if ( is_search() ) {
			get_template_part( 'template-parts/content-search' );
		} else {
			get_template_part( 'template-parts/content' );
		}
	}
}


/**
 * Changes the text of the "Older posts" button in infinite scroll
 */
function atomic_blocks_infinite_scroll_button_text( $js_settings ) {
	$js_settings['text'] = esc_html__( 'Load more', 'atomic-blocks' );
	return $js_settings;
}
add_filter( 'infinite_scroll_js_settings', 'atomic_blocks_infinite_scroll_button_text' );