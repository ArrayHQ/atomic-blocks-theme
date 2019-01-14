/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($){

	// Site title and description
	wp.customize('blogname',function(value){
		value.bind(function(to){
			$('.site-title').text(to);
		});
	});


	wp.customize('blogdescription',function(value){
		value.bind(function(to){
			$('.site-description').text(to);
		});
	});


	// Accent background colors
	wp.customize('atomic_blocks_button_color',function(value) {
		value.bind( function( to ) {
			$('button:not(.preview-toggle), input[type="button"], input[type="reset"], input[type="submit"], .button, .comment-navigation a, .drawer .tax-widget a, .su-button, h3.comments-title, .page-numbers.current, .page-numbers:hover, .page-numbers a:hover, #page .more-link:hover').css('background-color',to);
		} );
	} );

	// Accent text colors
	wp.customize('atomic_blocks_button_color',function(value) {
		value.bind( function( to ) {
			$('.entry-content p a, .entry-content p a:hover, .post-navigation a:hover .post-title, .entry-header .entry-title a:hover, #page .more-link:hover, .site-footer a, .main-navigation a:hover, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current-page-item a').css('color',to);
		} );
	} );

	// Content width
	wp.customize('atomic_blocks_content_width',function(value) {
		value.bind( function( to ) {
			$('#primary').css('width',to+'%');
		} );
	} );

	// Title font size
	wp.customize('atomic_blocks_title_font_size',function(value) {
		value.bind( function( to ) {
			$('.entry-header .entry-title').css('font-size',to+'px');
		} );
	} );

})(jQuery);
