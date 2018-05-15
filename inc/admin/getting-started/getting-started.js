jQuery(document).ready(function ($) {

	// Tabs
	$( ".inline-list" ).each( function() {
		$( this ).find( "li" ).each( function(i) {
			$( this).click( function(){
				$( this ).addClass( "current" ).siblings().removeClass( "current" )
				.parents( "#wpbody" ).find( "div.panel-left" ).removeClass( "visible" ).end().find( 'div.panel-left:eq('+i+')' ).addClass( "visible" );

				boxHeight();



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


	function boxHeight(){
		$( ".ab-block-features" ).each(function() {  
			
			var highestBox = 0;
			
			$( ".ab-block-feature", this ).each( function() {
				if( $( this ).height() > highestBox ) {
					highestBox = $( this ).height(); 
				}
			});  
				  
			$( ".ab-block-feature", this ).height( highestBox );		  
		});
	} 

	$( window ).resize( function() {
		boxHeight();
	});
	
});