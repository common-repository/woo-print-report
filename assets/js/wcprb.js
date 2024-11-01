( function( $ ) {
	
	/* Create HTML Canvas Container */
	var $wcprbCanvas = $( '<div />', {
		'id'	: 'wcprbCanvasContainer',
	} );
	
	/* Add HTML2Canvas Container */
	if( $( '.postbox .main').length ) {
		
		$( '.postbox .main').append( $wcprbCanvas );
		
	}
	
	/* Create Print Button */
	let $print = $( '<a />', {
		class	: 'wcprb_print_report',
		href	: 'javascript:void(0);',
		text	: wcprb.labels.print,
	} )
	.on( 'click', function() {
		
		if( $wcprbCanvas.length ) {
			
			$wcprbCanvas.empty();
			html2canvas( $( '.postbox .main' )[0] ).then( function( $canvas ) {
				
				let image_url = $canvas.toDataURL( 'image/png' );
				
				$( '<img />', {
					'src'	: image_url,
				} ).appendTo( '#wcprbCanvasContainer' );
				
				let checkElm = setInterval( function() {
					
					if( $( '#wcprbCanvasContainer img' ).length ) {
						clearInterval( checkElm );
						window.print();
					}
					
				}, 100 );
				
			} );
			
		} else {
			
			window.print();
			
		}
		
	} );
	
	/* Add Print Button */
	if( $( '.postbox .stats_range' ).length ) {
		$( '.postbox .stats_range').prepend( $print );
	}
	
} )( jQuery );