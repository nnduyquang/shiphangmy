jQuery(document).ready(function($){
	if( $('#snshadona_layouttype').length > 0 ){
		var selector = document.getElementById('snshadona_layouttype');
		var imgLayoutHTML = '';
	    for(var i = 1; i < selector.options.length; i++){
	    	if( selector.options[i].value ){
	    		imgLayoutHTML = imgLayoutHTML + '<span class="img-layout '+selector.options[i].value+'" data-value="'+selector.options[i].value+'" title="'+selector.options[i].text+'"></span>';
	    	}
	    }
	    $('#snshadona_layouttype').parent().append(imgLayoutHTML); $('#snshadona_layouttype').css('display', 'none');
	}
	$('.img-layout').each(function(){
		// Add active class
		if($(this).attr('data-value') == $('#snshadona_layouttype').attr('value')){
			$(this).addClass('active');
		}
		showHideDependLayout($('#snshadona_layouttype').attr('value'));
		// Click img select
		$(this).unbind('click').click(function(){
			// Change active class
			$val = $(this).attr('data-value'); $('.img-layout').removeClass('active'); $(this).addClass('active');
			// Set value for select
			$('#post-body #snshadona_layouttype').attr('value', $val);
			// Hide or show field codition
			showHideDependLayout($val);
		});
	});
	//
	if ( $('#page_template').attr('value') == 'fullwidth.php' || $('#page_template').attr('value') == 'sidepage.php' ){
		$('#sns_layout').fadeOut(500);
	}else{
		$('#sns_layout').fadeIn(500);
	}
	
	$('#page_template').change(function(){
		if( $(this).attr('value') == 'fullwidth.php' || $('#page_template').attr('value') == 'sidepage.php' ){
			$('#sns_layout').fadeOut(500);
		}else{
			$('#sns_layout').fadeIn(500);
		}
	})
	function showHideDependLayout($val){
		if( $val == 'm' ){
			$('#post-body #snshadona_leftsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
			$('#post-body #snshadona_rightsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
		}else if( $val == 'l-m' ){
			$('#post-body #snshadona_leftsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
			$('#post-body #snshadona_rightsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
		}else if( $val == 'm-r' ){
			$('#post-body #snshadona_rightsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
			$('#post-body #snshadona_leftsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
		}
	}
	// Enable layout config
	$('#post-body input[name="snshadona_enablelayoutconfig"]').each(function(){
		if( $(this).attr('checked') == 'checked' ) enableLayoutConfig( $(this).attr('value') );
		$(this).change(function(){
			enableLayoutConfig( $(this).attr('value') );console.log($(this).attr('value'));
		})
	})
	// $('#post-body input[name="sns_enablelayoutconfig"]').change(function(){
	// 	enableLayoutConfig( $(this).attr('value') );
	// })
	function enableLayoutConfig($val){
		if( $val == '1' ){
			$('#post-body #snshadona_layouttype').parents('.rwmb-layouttype-wrapper').stop(true,true).fadeIn(500);
			showHideDependLayout($('#snshadona_layouttype').attr('value'));
		}else{
			$('#post-body #snshadona_leftsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
			$('#post-body #snshadona_rightsidebar').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
			$('#post-body #snshadona_layouttype').parents('.rwmb-layouttype-wrapper').stop(true,true).fadeOut(500);
		}
	}
	//
	showHideDependPostFormat($('#post-format-gallery').attr('checked'), '#sns-post-gallery' );
	showHideDependPostFormat($('#post-format-video').attr('checked'), '#sns-post-video' );
	showHideDependPostFormat($('#post-format-audio').attr('checked'), '#sns-post-audio' );
	showHideDependPostFormat($('#post-format-quote').attr('checked'), '#sns-post-quote' );
	showHideDependPostFormat($('#post-format-link').attr('checked'), '#sns-post-link' );
	$('#post-formats-select input').each(function(){
		$(this).unbind('click').click(function(){
			showHideDependPostFormat($('#post-format-gallery').attr('checked'), '#sns-post-gallery' );
			showHideDependPostFormat($('#post-format-video').attr('checked'), '#sns-post-video' );
			showHideDependPostFormat($('#post-format-audio').attr('checked'), '#sns-post-audio' );
			showHideDependPostFormat($('#post-format-quote').attr('checked'), '#sns-post-quote' );
			showHideDependPostFormat($('#post-format-link').attr('checked'), '#sns-post-link' );
		});
	});
	function showHideDependPostFormat($checked, $id){
		if( $checked == 'checked' ){
			$($id).stop(true,true).fadeIn(500);
		}else {
			$($id).stop(true,true).fadeOut(500);
		}
	}
	// Revolution
	$('#post-body input[name=snshadona_useslideshow]').each(function(){
		if( $(this).attr('checked') == 'checked' ){
			if ( $(this).attr('value') == '1' ) {
				$('#post-body select#snshadona_revolutionslider').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
			}else {
				$('#post-body select#snshadona_revolutionslider').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
			}
		}
		$(this).change(function(){
			if ( $(this).attr('value') == '1' ) {
				$('#post-body select#snshadona_revolutionslider').parents('.rwmb-select-wrapper').stop(true,true).fadeIn(500);
			}else {
				$('#post-body select#snshadona_revolutionslider').parents('.rwmb-select-wrapper').stop(true,true).fadeOut(500);
			}
		})
	});
	// Theme color
	$('#post-body input[name=snshadona_page_themecolor]').each(function(){
		if( $(this).attr('checked') == 'checked' ){
			if ( $(this).attr('value') == '1' ) {
				$('#post-body input#snshadona_theme_color').parents('.rwmb-color-wrapper').stop(true,true).fadeIn(500);
			}else {
				$('#post-body input#snshadona_theme_color').parents('.rwmb-color-wrapper').stop(true,true).fadeOut(500);
			}
		}
		$(this).change(function(){
			if ( $(this).attr('value') == '1' ) {
				$('#post-body input#snshadona_theme_color').parents('.rwmb-color-wrapper').stop(true,true).fadeIn(500);
			}else {
				$('#post-body input#snshadona_theme_color').parents('.rwmb-color-wrapper').stop(true,true).fadeOut(500);
			}
		})
	});
	
});
