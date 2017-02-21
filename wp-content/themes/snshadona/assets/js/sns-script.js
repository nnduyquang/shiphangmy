(function ($) {
	"use strict";
	$(document).ready(function($){
		var $win = $(window);
		// Sticky Menu for homepage 4
		$win.scroll(function(){
			if( $('#sticky-navigation-holder').length>0 ){
				var $doc 		= document.documentElement;
				var $top_offset = (window.pageYOffset || $doc.scrollTop) - ($doc.clientTop || 0);
				var $wpadminbar = $("#wpadminbar").height();
				if($win.width() < 767){
					$wpadminbar = 0;
				}
				if( $top_offset > $('#sns_menu').offset().top + 50 ){
					$('#sticky-navigation-holder').addClass('scrolled');
					$('#sns_menu .sns_menu_wrapper').appendTo($('#sticky-navigation-holder'));
					$('#sticky-navigation-holder').css({'top': $wpadminbar });
					
				}else{
					$('#sticky-navigation-holder').removeClass('scrolled');
					$('#sticky-navigation-holder').css('top',0);
					$('#sticky-navigation-holder .sns_menu_wrapper').appendTo($('#sns_menu'));
				}
			}
		});

		// lazyload for woo product
		if( $('body').hasClass('use_lazyload') ){
			$('.product_list, .sns-products-list').each(function(){
				if( $(this).length > 0 ){
					$(this).find('img.lazy').lazyload();
				}
			})
		}

		// handle-preload
		$('.handle-preload').removeClass('handle-preload');
		// Set color, border-color for social icon
		$('.connect-us [data-color]').hover(function(){
			$(this).css({
				'color':$(this).attr('data-color'), 
				'border-color':$(this).attr('data-color')
			});
		},function(){
			$(this).css({
				'color':'',
				'border-color':''
			})
		});
		// products slider preload
		if( $('.sns-products-slider').length > 0 ){
			setTimeout(function(){
				$('.sns-products-slider').addClass('loaded');
			},1100);
		}

		// SNS Preload
		if( $('.sns-preload').length > 0 ){
			setTimeout(function(){
				$('.sns-preload').addClass('sns-loaded');
			},1000);
		}
		// Category
		$('.sns-category').each(function(){
			$(this).waypoint(function() {
				$(this).addClass('active');
	        },{
			triggerOnce : true ,
			     offset : '100%'
	    	});
		});

		// Count to
		$('.counter-value').each(function(){
			$(this).waypoint(function() {
	        	var element = $(this).find(' > span');
		    	element.countTo({
		    		from: element.data('from'), 
		    		to: element.data('to'),
		    		efreshInterval: element.data('interval'),
		    		speed: element.data('speed')
		    	});
	        },{
			triggerOnce : true ,
			     offset : '100%'
	    	});
		});
		
		// Advance banner
		if( $('.sns-advance-banner').length ){
			$('.sns-advance-banner').each(function(){
				if($(this).hasClass('has-fist-letter-color')){
					//var elements = document.getElementsByClassName("each-word");
					var elements = $(this).find('.heading_text');
					  for (var i=0; i<elements.length; i++){
					    elements[i].innerHTML = elements[i].innerHTML.replace(/\\b([a-z])([a-z]+)?\\b/gim, "<span class='first-letter'>$1</span>$2")
					  }
				}
			});
		}

		if( $('.sns_show_video .content').length ){
			$('.sns_show_video .content').each(function(){
				if($(this).hasClass('has-fist-letter-color')){
					//var elements = document.getElementsByClassName("each-word");
					var elements = $(this).find('.heading_text');
					  for (var i=0; i<elements.length; i++){
					    elements[i].innerHTML = elements[i].innerHTML.replace(/\\b([a-z])([a-z]+)?\\b/gim, "<span class='first-letter'>$1</span>$2")
					  }
				}
			});
		}
		// blog masonry
		if($('.sns-grid-masonry').length > 0){
			$('.sns-grid-masonry').masonry({
				// options
				itemSelector: '.sns-grid-item',
			});
		}
		// Set animation for SNS Custobox
		$('.sns-key-feature-wrap').each(function(){
			$(this).waypoint(function() {
				SnsFunction.SnsSetAnimation('.sns-custom-box', '.sns-key-feature-wrap');
	        },{
			triggerOnce : true ,
			     offset : '100%'
	    	});
		});
		
		
	});
		
	$(window).load(function(){
		// Tooltip
	    $("body.use-tooltip *[data-toggle='tooltip']").each(function(){
			$(this).tooltip({
	    		container: 'body'
	    	}, 'show');
		});
		$(document).ajaxComplete(function(){
			$("body.use-tooltip *[data-toggle='tooltip']").each(function(){
				$(this).tooltip({
		    		container: 'body'
		    	});
			});
			// lazyload for woo product
			if( $('body').hasClass('use_lazyload') ){
				var timeout = setTimeout(function() {
					$(".sns-main img.lazy:not(.loaded)").lazyload();
				}, 1000);
			}
		});
	});

	$.fn.SnsAccordion = function(options) {
		var $el    = $(this);
		var defaults = {
			active: 'open',
			active_default: 'nav-2',
			el_wrap: 'li',
			el_content: 'ul',
			accordion: true,
			expand: true,
			btn_open: '<i class="fa fa-plus-square-o"></i>',
			btn_close: '<i class="fa fa-minus-square-o"></i>'
		};
		var options = $.extend({}, defaults, options);
		
		
		$(document).ready(function() {
			$el.find(options.el_wrap).each(function(){
				$(this).find('> a, > span, > h4').wrap('<div class="accr_header"></div>');
				if(($(this).find(options.el_content)).length){
					$(this).find('> .accr_header').append('<span class="btn_accor">' + options.btn_open + '</span>');
					$(this).find('> '+options.el_content+':not(".accr_header")').wrap('<div class="accr_content"></div>');
				}
			});
			if(options.accordion){
				$('.accr_content').hide();
				$el.find(options.el_wrap).each(function(){
					if(options.active_default!==''){
						if( $(this).hasClass(options.active_default) ){
							$(this).addClass(options.active);
						}
					}
					if($(this).hasClass(options.active)) {
						$(this).find('> .accr_content')
							   .addClass(options.active)
							   .slideDown();
						$(this).find('> .accr_header')
							   .addClass(options.active);
					}
				});
			} else {
				$el.find(options.el_wrap).each(function(){
					if(!options.expand){
						$('.accr_content').hide();
					} else {
						$(this).find('> .accr_content').addClass(options.active);
						$(this).find('> .accr_header').addClass(options.active);
						$(this).find('> .accr_header .btn_accor').html(options.btn_close);
					}
				});
			}

	    });
	    $(window).load(function() {
			$el.find(options.el_wrap).each(function(){
				var $wrap = $(this);
				var $accrhead = $wrap.find('> .accr_header');
				var btn_accor = '.btn_accor';
				
				$accrhead.find(btn_accor).on('click', function(event) {
					event.preventDefault();
					var obj = $(this);
					var slide = true;
					if($accrhead.hasClass(options.active)) {
						slide = false;
					}
					if(options.accordion){
						$wrap.siblings(options.el_wrap).find('> .accr_content').slideUp().removeClass(options.active);
						$wrap.siblings(options.el_wrap).find('> .accr_header').removeClass(options.active);
						$wrap.siblings(options.el_wrap).find('> .accr_header ' + btn_accor).html(options.btn_open);
					}
					if(slide) {
						$accrhead.addClass(options.active);
						obj.html(options.btn_close);
						$accrhead.siblings('.accr_content').addClass(options.active).stop(true, true).slideDown();
					} else {
						$accrhead.removeClass(options.active);
						obj.html(options.btn_open);
						$accrhead.siblings('.accr_content').removeClass(options.active).stop(true, true).slideUp();
					}
					return false;
				});
			});
		});
	};
	var SnsFunction= {
		SnsSetAnimation : function(el, pa_el) {
			var i = 0;
			$(el).each(function(){
				i++;
				$(this).attr("style", "-webkit-animation-delay:" + i * 300 + "ms;"
		                + "-moz-animation-delay:" + i * 300 + "ms;"
		                + "-o-animation-delay:" + i * 300 + "ms;"
		                + "animation-delay:" + i * 300 + "ms;");
				if (i == $(el).size() -1) {
		            $(pa_el).addClass('showed');
				}
			});
		}
	};
})(jQuery);