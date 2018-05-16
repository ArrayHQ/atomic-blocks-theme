jQuery(document).ready(function ($) {

	// Tabs
	$( ".inline-list" ).each( function() {
		$( this ).find( "li" ).each( function(i) {
			$( this).click( function(){
				$( this ).addClass( "current" ).siblings().removeClass( "current" )
				.parents( "#wpbody" ).find( "div.panel-left" ).removeClass( "visible" ).end().find( 'div.panel-left:eq('+i+')' ).addClass( "visible" );

				equalHeight();
				
				return false;
			} );
		} );
	} );


	// Scroll to anchor
	$( ".anchor-nav a, .toc a" ).click( function(e) {
		e.preventDefault();

		var href = $( this ).attr( "href" );
		$( "html, body" ).animate( {
			scrollTop: $( href ).offset().top
		}, 'slow', 'swing' );
	} );


	// Back to top links
	$( "#help-panel h3" ).append( $( "<a class='back-to-top' href='#panel'><i class='fa fa-angle-up'></i> Back to top</a>" ) );

	// Equalize column heights
	function equalHeight() {
		$('.ab-block-features .ab-block-feature').matchHeight();
	} 
	equalHeight();

	$(window).on('load', function() {
		var current_width = $(window).width();

		// Only run on desktop
		if ( current_width > 600 ) {
			equalHeight();
		}
	});	
	
});