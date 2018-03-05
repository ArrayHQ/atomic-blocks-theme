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

	/**
	 * Enable Jetpack Portfolio support
	 */
	add_theme_support( 'jetpack-portfolio' );
}
add_action( 'after_setup_theme', 'atomic_blocks_jetpack_setup' );


/**
 * Adjust content width for tiled gallery
 */
function atomic_blocks_custom_tiled_gallery_width() {
    return '1600';
}
add_filter( 'tiled_gallery_content_width', 'atomic_blocks_custom_tiled_gallery_width' );


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


/**
 * Move Related Posts
 */
function atomic_blocks_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'post_flair', $callback, 40 );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'atomic_blocks_remove_rp', 20 );


/**
 * Remove flair from excerpts and content
 */
function atomic_blocks_remove_flair() {
	// Remove Poll
	remove_filter( 'the_content', 'polldaddy_show_rating' );
	remove_filter( 'the_excerpt', 'polldaddy_show_rating' );
	// Remove sharing
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
}
add_action( 'loop_start', 'atomic_blocks_remove_flair' );


/**
 * Remove auto output of Sharing and Likes
 */
function atomic_blocks_remove_sharing() {
	if ( function_exists( 'sharing_display' ) ) {
		remove_filter( 'the_content', 'sharing_display', 19 );
		remove_filter( 'the_excerpt', 'sharing_display', 19 );
	}

	if ( class_exists( 'Jetpack_Likes' ) ) {
		remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
	}
}
