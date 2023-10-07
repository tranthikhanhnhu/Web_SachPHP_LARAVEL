var widthClassOptions = [];
var widthClassOptions = ({
		bestseller       : 'bestseller_default_width',		
		featured         : 'featured_default_width',
		special          : 'special_default_width',
		latest           : 'latest_default_width',
		related          : 'related_default_width',
		additional       : 'additional_default_width',
		tabbestseller       : 'tabbestseller_default_width',		
		tabfeatured         : 'tabfeatured_default_width',
		tabspecial          : 'tabspecial_default_width',
		tablatest           : 'tablatest_default_width',
		blog         	 : 'blog_default_width',
		testimonial		 : 'testimonial_default_width',
		module           : 'module_default_width'		
});

$(document).ready(function(){
	
	$('ul.breadcrumb').prependTo('.row #title-content');
	/*$('.rating-wrapper').prependTo('.row #title-content');*/
	$('#content h1').prependTo('.row #title-content');
	$('#content h2').prependTo('.row #title-content');	
	$('#content select').customSelect();
	
	/*====== Search ==== */
		
		$('.search_button').click(function(event){
			$(this).toggleClass('active');
			event.stopPropagation();
		
		$(".searchbox").fadeToggle();
		 $(".header-search").focus();
		 $( '.searchbox' ).addClass('search-selected');
		});
		
		$(".searchbox").on("click", function (event) {
		
		event.stopPropagation();
		
		});
	
	/* Video CMS */	
	$('#video_content a').simpleLightboxVideo();
	
	/* Responsive touch and hover manage  */
	$( '#menu li:has(ul)' ).doubleTapToGo();
	
	
		
	/* catgory link active hover */	
	$(document).on('mouseenter mouseleave touchstart touchmove', 'li.top_level.dropdown', function(e){
	if(e.type == 'mouseenter' || e.type == 'touchstart'){
  		$(this).addClass('active');
		} else {
  	$(this).removeClass('active');
		}
	});
	
	/*For Parallex*/

	jQuery(window).load(function(){
				
						 
		var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
		if(!isMobile) {
			if($(".parallex").length){  $(".parallex").sitManParallex({  invert: false });};    
		}else{
			$(".parallex").sitManParallex({  invert: true });
			
			}	
	});
		
//toggle closed when other open
				
 	$("#cart .dropdown-toggle").click(function(){
            $(this).toggleClass("active");
			$(".cart-menu").slideToggle();
			$(".myaccount-menu").slideUp();
			$(".language-menu").slideUp();
			$(".currency-menu").slideUp();
            $(".myaccount .dropdown-toggle").removeClass('active');
        	return false;
    });
		
	$("#form-currency .dropdown-toggle").click(function(){
			$('#form-currency').addClass("active");
           	$(".language-menu").slideUp();
        	$(".currency-menu").slideToggle();
			$(".cart-menu").slideUp();
			$(".myaccount-menu").slideUp();
			$(".myaccount .dropdown-toggle").removeClass('active');
        	return false;
    });
		
    $("#form-language .dropdown-toggle").click(function(){
			$('#form-language').addClass("active");
            $(".currency-menu").slideUp();
        	$(".language-menu").slideToggle();
			$(".cart-menu").slideUp();
			$(".myaccount-menu").slideUp();
			$(".myaccount .dropdown-toggle").removeClass('active');
        	return false;
    });
		
	$(".myaccount > .dropdown-toggle").click(function(){          
			$(".cart-menu").slideUp();
			$(".myaccount-menu").slideToggle();
			$(".language-menu").slideUp();
			$(".currency-menu").slideUp();	
 			$(this).toggleClass("active");		
			$("#cart .dropdown-toggle").removeClass('active');
        	return false;
    });
	
	$('.write-review,.review-count').on('click', function() {
	$('html, body').animate({scrollTop: $('#tabs_info').offset().top}, 'slow');
	});
	
});

$(document).click(function(){
	$(".cart-menu").slideUp('slow');
	$(".myaccount-menu").slideUp('slow');
	$(".language-menu").slideUp();
	$(".currency-menu").slideUp();
	$(".myaccount > .dropdown-toggle").removeClass('active');
	$("#cart .dropdown-toggle").removeClass('active');
});


jQuery(function($) {
     var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
     $('#menu .nav > li > a').each(function() {
      if (this.href === path) {
       $(this).addClass('active');
      }
     });
    });

function mobileToggleMenu(){
	//alert($(window).width());
	if ($(window).width() < 980)
	{
		$("#footer .mobile_togglemenu").remove();
		$("#footer .column h5").append( "<a class='mobile_togglemenu'>&nbsp;</a>" );
		$("#footer .column h5").addClass('toggle');
		$("#footer .mobile_togglemenu").click(function(){
			$(this).parent().toggleClass('active').parent().find('ul').toggle('slow');
		});

	}else{
		$("#footer .column h5").parent().find('ul').removeAttr('style');
		$("#footer .column h5").removeClass('active');
		$("#footer .column h5").removeClass('toggle');
		$("#footer .mobile_togglemenu").remove();
	}	
}
$(document).ready(function(){mobileToggleMenu();});
$(window).resize(function(){mobileToggleMenu();});

//LEFT-RIGHT COLUMN RESPONSIVE TOOGLE

function mobileToggleColumn(){
	if ($(window).width() < 980)
	{
		$('#column-left,#column-right').insertAfter('#content');
		$("#column-left .box-heading .mobile_togglemenu,#column-right .box-heading .mobile_togglemenu").remove();
		$("#column-left .box-heading,#column-right .box-heading").append( "<a class='mobile_togglemenu'>&nbsp;</a>" );
		$("#column-left .box-heading,#column-right .box-heading").addClass('toggle');
		$("#column-left .box-heading .mobile_togglemenu,#column-right .box-heading .mobile_togglemenu").click(function(){
			$(this).parent().toggleClass('active').parent().find('.box-content,.filterbox,.list-group').slideToggle('slow');
		});
	}else{
		$('#column-left').insertBefore('#content');
		$('#column-right').insertAfter('#content');
		$('.common-home #column-left,.common-home #column-right').insertBefore('#content-top');
		$("#column-left .box-heading,#column-right .box-heading").parent().find('.box-content,.filterbox,.list-group').removeAttr('style');
		$("#column-left .box-heading,#column-right .box-heading").removeClass('active');
		$("#column-left .box-heading,#column-right .box-heading").removeClass('toggle');
		$("#column-left .box-heading .mobile_togglemenu,#column-right .box-heading .mobile_togglemenu").remove();
	}
}
$(document).ready(function(){mobileToggleColumn();});
$(window).resize(function(){mobileToggleColumn();});


function FilterToggleMenu(){
	//alert($(window).width());
		$("#content .filter_togglemenu").remove();
		$("#content .sidebarFilter .box-heading").append( "<a class='filter_togglemenu'>&nbsp;</a>" );
		$("#content .sidebarFilter .box-heading").addClass('toggle');
		$("#content .filter_togglemenu").click(function(){
			$(this).parent().toggleClass('active').parent().find('.filterbox').slideToggle('slow');
		});	
}

$(document).ready(function(){FilterToggleMenu();});
$(window).resize(function(){FilterToggleMenu ();});


$(document).ready(function(){
  $(".dropdown-toggle").click(function(){
    $("ul.dropdown-toggle").toggle('slow');
  });
});


function LangCurDropDown(selector,subsel){
	var main_block = new HoverWatcher(selector);
	var sub_ul = new HoverWatcher(subsel);
	$(selector).click(function() {
		$(selector).addClass('active');
		$(subsel).slideToggle('slow');
		setTimeout(function() {
			if (!main_block.isHoveringOver() && !sub_ul.isHoveringOver())
				$(subsel).stop(true, true).slideUp(450);
				$(selector).removeClass('active');
		}, 3000);
	});
	
	$(subsel).hover(function() {
		setTimeout(function() {
			if (!main_block.isHoveringOver() && !sub_ul.isHoveringOver())
				$(subsel).stop(true, true).slideUp(450);
		}, 3000);
	});	
}

//$(document).ready(function(){
//	LangCurDropDown('.myaccount','.myaccount-menu');
//	LangCurDropDown('#currency','.currency-menu');
//	LangCurDropDown('#language','.language-menu');
//	LangCurDropDown('#cart','.cart-menu');
//
//});

function leftright()
{
	if ($(window).width() < 980){
			if($('.category_filter .col-md-3, .category_filter .col-md-2, .category_filter .col-md-1').hasClass('text-right')==true){
			$(".category_filter .col-md-3, .category_filter .col-md-2, .category_filter .col-md-1").addClass('text-left');
			$(".category_filter .col-md-3, .category_filter .col-md-2, .category_filter .col-md-1").removeClass('text-right');
			}
	}
}
$(document).ready(function(){leftright();});
$(window).resize(function(){leftright();});


function menuResponsive(){
	 
	if ($(window).width() < 980){
		//alert($(window).width());
		$('#menu').css('display','none');
		$('#res-menu').css('display','block');
		$('.nav-responsive').css('display','block');
		if($('.main-navigation').hasClass('treeview')!=true){
			$("#res-menu").addClass('responsive-menu');
			$("#res-menu").removeClass('main-menu');
			$("#res-menu .main-navigation").treeview({
				animated: true,
				collapsed: true,
				unique: true		
			});
			$('#res-menu .main-navigation a.active').parent().removeClass('expandable');
			$('#res-menu .main-navigation a.active').parent().addClass('collapsable');
			$('#res-menu .main-navigation .collapsable ul').css('display','block');		
		}
	
	}else{
		$('#menu').css('display','block');
		$('#res-menu').css('display','none');
		$("#res-menu .hitarea").remove();
		$("#res-menu").removeClass('responsive-menu');
		$("#res-menu").addClass('main-menu');
		$(".main-navigation").removeClass('treeview');
		$("#res-menu ul").removeAttr('style');
		$('#res-menu li').removeClass('expandable');
		$('#res-menu li').removeClass('collapsable');
		$('.nav-responsive').css('display','none');
	}

}
$(document).ready(function(){menuResponsive();});
$(window).resize(function(){menuResponsive();});


// JS for calling loadMore
//jQuery(document).ready(function () {
//  	var size_li = jQuery("#tab-latest #tablatest-grid > div").size();
//	var size_li_spec = jQuery("#tab-special #tabspecial-grid > div").size();
//	var size_li_best = jQuery("#tab-bestseller #tabbestseller-grid > div").size();
//	var x=8;
//	var y=8;	
//	var z=8;	
//		
//	jQuery('#tab-latest #tablatest-grid > div:lt('+x+')').fadeIn('slow');
//	jQuery('#tab-special #tabspecial-grid > div:lt('+y+')').fadeIn('slow');
//	jQuery('#tab-bestseller #tabbestseller-grid > div:lt('+z+')').fadeIn('slow');
//		    	
//    jQuery('#tab-latest .gridcount').click(function () {
//	if(x==size_li){									 	
//			 jQuery('#tab-latest .ct-message').show();
//			 jQuery('#tab-latest .gridcount').hide();	 
//			 
//	}else{
//		x= (x+8 <= size_li) ? x+8 : size_li;
//        jQuery('#tab-latest #tablatest-grid > div:lt('+x+')').fadeIn('slow');
//	}
//    });
//	
//	jQuery('#tab-special .gridcount').click(function () {
//	if(y==size_li_spec){									 
//			 jQuery('#tab-special .gridcount').hide();
//			 jQuery('#tab-special .ct-message').show();
//			 
//	}else{
//		y= (y+8 <= size_li_spec) ? y+8 : size_li_spec;
//        jQuery('#tab-special #tabspecial-grid > div:lt('+y+')').fadeIn('slow');
//	}
//    });
//	
//   
//	jQuery('#tab-bestseller .gridcount').click(function () {
//	if(z==size_li_best){									 
//			 jQuery('#tab-bestseller  .gridcount').hide();
//			 jQuery('#tab-bestseller  .ct-message').show();
//			 
//	}else{
//		z= (z+8 <= size_li_best) ? z+8 : size_li_best;
//        jQuery('#tab-bestseller #tabbestseller-grid > div:lt('+z+')').fadeIn('slow');
//	}
//    });			
//	
//});



function productCarouselAutoSet() { 
	$("#content .product-carousel, .banners-slider-carousel .product-carousel, #producttab .product-carousel, #products-related .product-carousel, .homepage-testimonial-inner .product-carousel ").each(function() {
		var objectID = $(this).attr('id');
		var myObject = objectID.replace('-carousel','');
		if(myObject.indexOf("-") >= 0)
			myObject = myObject.substring(0,myObject.indexOf("-"));		
		if(widthClassOptions[myObject])
			var myDefClass = widthClassOptions[myObject];
		else
			var myDefClass= 'grid_default_width';
		var slider = $("#content #" + objectID + ", #producttab #"+ objectID + ", .banners-slider-carousel #"+ objectID + ", #products-related #" + objectID + ", .homepage-testimonial-inner #"+ objectID);
		slider.sliderCarousel({
			defWidthClss : myDefClass,
			subElement   : '.slider-item',
			subClass     : 'product-block',
			firstClass   : 'first_item_ct',
			lastClass    : 'last_item_ct',
			slideSpeed : 200,
			paginationSpeed : 800,
			autoPlay : false,
			stopOnHover : false,
			goToFirst : true,
			goToFirstSpeed : 1000,
			goToFirstNav : true,
			pagination : true,
			paginationNumbers: false,
			responsive: true,
			responsiveRefreshRate : 200,
			baseClass : "slider-carousel",
			theme : "slider-theme",
			autoHeight : true
		});
		
		var nextButton = $(this).parent().find('.next');
		var prevButton = $(this).parent().find('.prev');
		nextButton.click(function(){
			slider.trigger('slider.next');
		})
		prevButton.click(function(){
			slider.trigger('slider.prev');
		})
	});
}
//$(window).load(function(){productCarouselAutoSet();});
$(document).ready(function(){productCarouselAutoSet();});

function productListAutoSet() { 
	$("#content .productbox-grid, #products-related .productbox-grid, #producttab .productbox-grid").each(function(){
		var objectID = $(this).attr('id');
		if(objectID.length >0){
			if(widthClassOptions[objectID.replace('-grid','')])
				var myDefClass= widthClassOptions[objectID.replace('-grid','')];
		}else{
			var myDefClass= 'grid_default_width';
		}	
		$(this).smartColumnsRows({
			defWidthClss : myDefClass,
			subElement   : '.product-items',
			subClass     : 'product-block'
		});
	});		
}
$(window).load(function(){productListAutoSet();});
$(window).resize(function(){productListAutoSet();});

/*For Grid and List View Buttons*/
function gridlistactive(){
$('.btn-list-grid button').on('click', function() {
if($(this).hasClass('grid')) {
  $('.btn-list-grid button').addClass('active');
  $('.btn-list-grid button.list').removeClass('active');
}
  else if($(this).hasClass('list')) {
$('.btn-list-grid button').addClass('active');
  $('.btn-list-grid button.grid').removeClass('active');
  }
});
}
$(document).ready(function(){gridlistactive()});
$(window).resize(function(){gridlistactive()});



function HoverWatcher(selector){
	this.hovering = false;
	var self = this;

	this.isHoveringOver = function() {
		return self.hovering;
	}

	$(selector).hover(function() {
		self.hovering = true;
	}, function() {
		self.hovering = false;
	})
}

function LangCurDropDown(selector,subsel){
	var main_block = new HoverWatcher(selector);
	var sub_ul = new HoverWatcher(subsel);
	$(selector).click(function() {
		$(selector).addClass('active');
		$(subsel).slideToggle('slow');
		setTimeout(function() {
			if (!main_block.isHoveringOver() && !sub_ul.isHoveringOver())
				$(subsel).stop(true, true).slideUp(450);
				$(selector).removeClass('active');
		}, 3000);
	});
	
	$(subsel).hover(function() {
		setTimeout(function() {
			if (!main_block.isHoveringOver() && !sub_ul.isHoveringOver())
				$(subsel).stop(true, true).slideUp(450);
		}, 3000);
	});	
}



$(document).ready(function(){

	LangCurDropDown('#currency','.currency_div');
	LangCurDropDown('#language','.language_div');

	$('.nav-responsive').click(function() {
        $('.responsive-menu .main-navigation').slideToggle();
		$('.nav-responsive div').toggleClass('active');
		
    }); 

	$(".treeview-list").treeview({
		animated: true,
		collapsed: true,
		unique: true		
	});
	$('.treeview-list a.active').parent().removeClass('expandable');
	$('.treeview-list a.active').parent().addClass('collapsable');
	$('.treeview-list .collapsable ul').css('display','block');
});

$(document).ready(function(){
	jQuery(function($){
	
		var max_elem = 5 ;
		$('.navbar-nav li').first().addClass('home_first');
		var items = $('.navbar-nav  li.top_level');
		var surplus = items.slice(max_elem, items.length);
		surplus.wrapAll('<li class="top_level hiden_menu"><div class="dropdown-inner">');
		$('.hiden_menu').prepend('<a class="level-top">More</a>');
	
	});
});

 
$(document).ready(function(){
  $(".ct_headerlinks_inner").click(function(){
    $(".header_links").toggle('slow');
  });
  
});

function blogResize() {
	if($('.allblog-top')) {
		// What a shame bootstrap does not take into account dynamically loaded columns
		cols = $('#column-right, #column-left').length;
//alert('ready');
		if (cols == 2) {
			$('#content .panel').attr('class', 'panel blog-content');
			$('#content .panel:nth-child(2n+2)').addClass('first-item');
			$('#content .panel:nth-child(2n+3)').addClass('last-item');
		} else if (cols == 1) {
			$('#content .panel').attr('class', 'panel blog-content');
			$('#content .panel:nth-child(2n+2)').addClass('first-item');
			$('#content .panel:nth-child(2n+3)').addClass('last-item');	
		if (document.documentElement.clientWidth < 479) {
				$('#content .panel').attr('class', 'panel blog-content last-item');
				$('#content .panel').attr('class', 'panel blog-content last-item');
			}
		} else {
			$('#content .panel').attr('class', 'panel blog-content');
			$('#content .panel:nth-child(2n+2)').addClass('first-item');
			$('#content .panel:nth-child(2n+3)').addClass('last-item');
		}
		}
}
$(document).ready(function() {blogResize();});
$( window ).resize(function() {blogResize();});

/*Menu Fixed */

//function headerTopFixed() {	
//	 if (jQuery(window).width() > 979){
//     if (jQuery(this).scrollTop() > 145)
//        {     
//			jQuery('.header-container').addClass("fixed");
//			jQuery('.nav-container').addClass("fixed");
//			jQuery('.header-search').addClass("fixed");
//			jQuery('header').addClass("header-length");
//			jQuery('.header-logo').addClass("header-logo-fixed");
//			 
//    	}else{
//			jQuery('.header-container').removeClass("fixed");
//      		jQuery('.nav-container').removeClass("fixed");
//			jQuery('.header-search').removeClass("fixed");
//			jQuery('header').removeClass("header-length");
//			jQuery('.header-logo').removeClass("header-logo-fixed");
//      	}
//	    } else {
//	  jQuery('.header-container').removeClass("fixed");		
//      jQuery('.nav-container').removeClass("fixed");  
//	  jQuery('.header-search').removeClass("fixed");
//	  jQuery('header').removeClass("header-length");
//	  jQuery('.header-logo').removeClass("header-logo-fixed");
//      }
//}
// 
//$(document).ready(function(){headerTopFixed();});
//jQuery(window).resize(function() {headerTopFixed();});
//jQuery(window).scroll(function() {headerTopFixed();});


/*For Parallex*/

function mobile(){
   
      var parallax = document.querySelectorAll(".content-top-breadcum"),
         speed = 0.42;
  
  window.onscroll = function(){
    [].slice.call(parallax).forEach(function(el,i){

      var windowYOffset = window.pageYOffset,
          elBackgrounPos = "50%" + -(windowYOffset * speed) + "px";
      
      el.style.backgroundPosition = elBackgrounPos;

    });
  };
}
jQuery(document).ready(function() { mobile();});
jQuery(window).resize(function() { mobile();});

/*For Back to Top button*/
$(document).ready(function(){
$("body").append("<a class='top_button' title='Back To Top' href=''>TOP</a>");

$(function () {
	$(window).scroll(function () {
		if ($(this).scrollTop() > 70) {
			$('.top_button').fadeIn();
		} else {
			$('.top_button').fadeOut();
		}
	});
	// scroll body to 0px on click
	$('.top_button').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
});
});


function blogCrop(){
if ($(window).width() > 979) {
	$('.all-blog .blog-image').each(function() {									  
	var that = $(this);
	var url = that.find('img').attr('src');
	that.css({'background-image':'url("' + url + '")'});
});
}
}
jQuery(document).ready(function() { blogCrop();});
jQuery(window).resize(function() {blogCrop();});

///*---------------------------------------image slider parllax-------------------------------*//////
jQuery(document).ready(function($) {
    (function($) {
        var CarouselEvo = function(element, options) {
            var settings = $.extend({}, $.fn.carousel.defaults, options),
                self = this,
                element = $(element),
                carousel = element.children('.slides');
            carousel.children('div').addClass('slideItem');
            var slideItems = carousel.children('.slideItem'),
                slideImage = slideItems.find('img'),
                currentSlide = 0,
                targetSlide = 0,
                numberSlides = slideItems.length,
                isAnimationRunning = false,
                pause = true;
            videos = {
                youtube: {
                    reg: /youtube\.com\/watch/i,
                    split: '=',
                    index: 1,
                    url: 'http://www.youtube.com/embed/%id%?autoplay=1&amp;fs=1&amp;rel=0'
                },
                vimeo: {
                    reg: /vimeo\.com/i,
                    split: '/',
                    index: 3,
                    url: 'http://player.vimeo.com/video/%id%?portrait=0&amp;autoplay=1'
                }
            };
            this.current = currentSlide;
            this.length = numberSlides;
            this.init = function() {
                var o = settings;
                initSlides();
                if (o.directionNav == true) {
                    initDirectionButton();
                }
                if (o.buttonNav != 'none') {
                    initButtonNav();
                }
                if (o.reflection == true) {
                    initReflection();
                }
                if (o.shadow == true) {
                    initShadow();
                }
                if (o.description == true) {
                    initDesc();
                }
                if (o.autoplay == true) {
                    runAutoplay();
                }
                initVideo();
            };
            var setImageSize = function(p) {
                var o = settings,
                    n = numberSlides,
                    w = o.frontWidth,
                    h = o.frontHeight,
                    ret;
                if (p != 0) {
                    if (o.hAlign == 'center') {
                        if (p > 0 && p <= Math.ceil((n - 1) / 2)) {
                            var front = setImageSize(p - 1);
                            w = o.backZoom * front.width;
                            h = o.backZoom * front.height;
                        } else {
                            var sz = setImageSize(n - p);
                            w = sz.width;
                            h = sz.height;
                        }
                    } else {
                        if (p == (n - 1)) {
                            w = o.frontWidth / o.backZoom;
                            h = o.frontHeight / o.backZoom;
                        } else {
                            var front = setImageSize(p - 1);
                            w = o.backZoom * front.width;
                            h = o.backZoom * front.height;
                        }
                    }
                }
                return ret = {
                    width: w,
                    height: h
                };
            };
            var setSlideSize = function(p) {
                var o = settings,
                    n = numberSlides,
                    w = o.frontWidth,
                    h = o.frontHeight + reflectionHeight(p) + shadowHeight(p),
                    ret;
                if (p != 0) {
                    if (o.hAlign == 'center') {
                        if (p > 0 && p <= Math.ceil((n - 1) / 2)) {
                            var front = setImageSize(p - 1);
                            w = o.backZoom * front.width;
                            h = (o.backZoom * front.height) + reflectionHeight(p) + shadowHeight(p);
                        } else {
                            var sz = setSlideSize(n - p);
                            w = sz.width;
                            h = sz.height;
                        }
                    } else {
                        if (p == (n - 1)) {
                            w = o.frontWidth / o.backZoom;
                            h = (o.frontHeight / o.backZoom) + reflectionHeight(p) + shadowHeight(p);
                        } else {
                            var front = setImageSize(p - 1);
                            w = o.backZoom * front.width;
                            h = (o.backZoom * front.height) + reflectionHeight(p) + shadowHeight(p);
                        }
                    }
                }
                return ret = {
                    width: w,
                    height: h
                };
            };
            var getMargin = function(p) {
                var o = settings,
                    vm, hm, ret, iz = setImageSize(p);
                vm = iz.height * o.vMargin;
                hm = iz.width * o.hMargin;
                return ret = {
                    vMargin: vm,
                    hMargin: hm
                };
            };
            var centerPos = function(p) {
                var o = settings,
                    c = topPos(p - 1) + (setImageSize(p - 1).height - setImageSize(p).height) / 2;
                if (o.hAlign != 'center') {
                    if (p == (numberSlides - 1)) {
                        c = o.top - ((setImageSize(p).height - setImageSize(0).height) / 2);
                    }
                }
                return c;
            };
            var topPos = function(p) {
                var o = settings,
                    t = o.top,
                    vm = getMargin(p).vMargin;
                if (o.vAlign == 'bottom') {
                    t = o.bottom;
                }
                if (p != 0) {
                    if (o.hAlign == 'center') {
                        if (p > 0 && p <= Math.ceil((numberSlides - 1) / 2)) {
                            if (o.vAlign == 'center') {
                                t = centerPos(p);
                            } else {
                                t = centerPos(p) + vm;
                            }
                        } else {
                            t = topPos(numberSlides - p);
                        }
                    } else {
                        if (p == (numberSlides - 1)) {
                            if (o.vAlign == 'center') {
                                t = centerPos(p);
                            } else {
                                t = centerPos(p) - vm;
                            }
                        } else {
                            if (o.vAlign == 'center') {
                                t = centerPos(p);
                            } else {
                                t = centerPos(p) + vm;
                            }
                        }
                    }
                }
                return t;
            };
            var horizonPos = function(p) {
                var o = settings,
                    n = numberSlides,
                    hPos, mod = n % 2,
                    endSlide = n / 2,
                    hm = getMargin(p).hMargin;
                if (p == 0) {
                    if (o.hAlign == 'center') {
                        hPos = (o.carouselWidth - o.frontWidth) / 2;
                    } else {
                        hPos = o.left;
                        if (o.hAlign == 'right') {
                            hPos = o.right;
                        }
                    }
                } else {
                    if (o.hAlign == 'center') {
                        if (p > 0 && p <= Math.ceil((n - 1) / 2)) {
                            hPos = horizonPos(p - 1) - hm;
                            if (mod == 0) {
                                if (p == endSlide) {
                                    hPos = (o.carouselWidth - setSlideSize(p).width) / 2;
                                }
                            }
                        } else {
                            hPos = o.carouselWidth - horizonPos(n - p) - setSlideSize(p).width;
                        }
                    } else {
                        if (p == (n - 1)) {
                            hPos = horizonPos(0) - (setSlideSize(p).width - setSlideSize(0).width) / 2 - hm;
                        } else {
                            hPos = horizonPos(p - 1) + (setSlideSize(p - 1).width - setSlideSize(p).width) / 2 + hm;
                        }
                    }
                }
                return hPos;
            };
            var setOpacity = function(p) {
                var o = settings,
                    n = numberSlides,
                    opc = 1,
                    hiddenSlide = n - o.slidesPerScroll;
                if (hiddenSlide < 2) {
                    hiddenSlide = 2;
                }
                if (o.hAlign == 'center') {
                    var s1 = (n - 1) / 2,
                        hs2 = hiddenSlide / 2,
                        lastSlide1 = (s1 + 1) - hs2,
                        lastSlide2 = s1 + hs2;
                    if (p == 0) {
                        opc = 1;
                    } else {
                        opc = o.backOpacity;
                        if (p >= lastSlide1 && p <= lastSlide2) {
                            opc = 0;
                        }
                    }
                } else {
                    if (p == 0) {
                        opc = 1;
                    } else {
                        opc = o.backOpacity;
                        if (!(p < (n - hiddenSlide))) {
                            opc = 0;
                        }
                    }
                }
                return opc;
            };
            var setSlidePosition = function(p) {
                var pos = new Array(),
                    o = settings,
                    n = numberSlides;
                for (var i = 0; i < n; i++) {
                    var sz = setSlideSize(i);
                    if (o.hAlign == 'left') {
                        pos[i] = {
                            width: sz.width,
                            height: sz.height,
                            top: topPos(i),
                            left: horizonPos(i),
                            opacity: setOpacity(i)
                        };
                        if (o.vAlign == 'bottom') {
                            pos[i] = {
                                width: sz.width,
                                height: sz.height,
                                bottom: topPos(i),
                                left: horizonPos(i),
                                opacity: setOpacity(i)
                            };
                        }
                    } else {
                        pos[i] = {
                            width: sz.width,
                            height: sz.height,
                            top: topPos(i),
                            right: horizonPos(i),
                            opacity: setOpacity(i)
                        };
                        if (o.vAlign == 'bottom') {
                            pos[i] = {
                                width: sz.width,
                                height: sz.height,
                                bottom: topPos(i),
                                right: horizonPos(i),
                                opacity: setOpacity(i)
                            };
                        }
                    }
                }
                return pos[p];
            };
            var slidePos = function(i) {
                var cs = currentSlide,
                    pos = i - cs;
                if (i < cs) {
                    pos += numberSlides;
                }
                return pos;
            };
            var zIndex = function(i) {
                var z, n = numberSlides,
                    hAlign = settings.hAlign;
                if (hAlign == 'left' || hAlign == 'right') {
                    if (i == (n - 1)) {
                        z = n - 1;
                    } else {
                        z = n - (2 + i);
                    }
                } else {
                    if (i >= 0 && i <= ((n - 1) / 2)) {
                        z = (n - 1) - i;
                    } else {
                        z = i - 1;
                    }
                }
                return z;
            };
            var slidesMouseOver = function(event) {
                var o = settings;
                if (o.autoplay == true && o.pauseOnHover == true) {
                    stopAutoplay();
                }
            };
            var slidesMouseOut = function(event) {
                var o = settings;
                if (o.autoplay == true && o.pauseOnHover == true) {
                    if (pause == true) {
                        runAutoplay();
                    }
                }
            };
            var initSlides = function() {
                var o = settings,
                    n = numberSlides,
                    images = slideImage;
                carousel.css({
                    'width': o.carouselWidth + 'px',
                    'height': o.carouselHeight + 'px'
                }).bind('mouseover', slidesMouseOver).bind('mouseout', slidesMouseOut);
                for (var i = 0; i < n; i++) {
                    var item = slideItems.eq(i);
                    item.css(setSlidePosition(slidePos(i))).bind('click', slideClick);
                    slideItems.eq(slidePos(i)).css({
                        'z-index': zIndex(i)
                    });
                    images.eq(i).css(setImageSize(slidePos(i)));
                    var op = item.css('opacity');
                    if (op == 0) {
                        item.hide();
                    } else {
                        item.show();
                    }
                }
            };
            var hideItem = function(slide) {
                var op = slide.css('opacity');
                if (op == 0) {
                    slide.hide();
                }
            };
            var goTo = function(index, isStopAutoplay, isPause) {
                if (isAnimationRunning == true) {
                    return;
                }
                var o = settings,
                    n = numberSlides;
                if (isStopAutoplay == true) {
                    stopAutoplay();
                }
                targetSlide = index;
                if (targetSlide == n) {
                    targetSlide = 0;
                }
                if (targetSlide == -1) {
                    targetSlide = n - 1;
                }
                o.before(self);
                animateSlide();
                pause = isPause;
            };
            var animateSlide = function() {
                var o = settings,
                    n = numberSlides;
                if (isAnimationRunning == true) {
                    return;
                }
                if (currentSlide == targetSlide) {
                    isAnimationRunning = false;
                    return;
                }
                isAnimationRunning = true;
                hideDesc(currentSlide);
                if (currentSlide > targetSlide) {
                    var forward = n - currentSlide + targetSlide,
                        backward = currentSlide - targetSlide;
                } else {
                    var forward = targetSlide - currentSlide,
                        backward = currentSlide + n - targetSlide;
                }
                if (forward > backward) {
                    dir = -1;
                } else {
                    dir = 1;
                }
                currentSlide += dir;
                if (currentSlide == n) {
                    currentSlide = 0;
                }
                if (currentSlide == -1) {
                    currentSlide = n - 1;
                }
                hideVideoOverlay();
                buttonNavState();
                showDesc(currentSlide);
                for (var i = 0; i < n; i++) {
                    animateImage(i);
                }
            };
            var animateImage = function(i) {
                var o = settings,
                    item = slideItems.eq(i),
                    pos = slidePos(i);
                item.show();
                item.animate(setSlidePosition(pos), o.speed, 'linear', function() {
                    hideItem($(this));
                    if (i == numberSlides - 1) {
                        isAnimationRunning = false;
                        if (currentSlide != targetSlide) {
                            animateSlide();
                        } else {
                            self.current = currentSlide;
                            showVideoOverlay(currentSlide);
                            o.after(self);
                        }
                    }
                });
                item.css({
                    'z-index': zIndex(pos)
                });
                slideImage.eq(i).animate(setImageSize(pos), o.speed, 'linear');
                if (o.reflection == true) {
                    animateReflection(o, item, i);
                }
                if (o.shadow == true) {
                    animateShadow(o, item, i);
                }
            };
            var slideClick = function(event) {
                var $this = $(this);
                if ($this.index() != currentSlide) {
                    goTo($this.index(), true, false);
                    return false;
                }
            };
            var reflectionHeight = function(p) {
                var h = 0,
                    o = settings;
                if (o.reflection == true) {
                    h = o.reflectionHeight * setImageSize(p).height;
                }
                return h;
            };
            var initReflection = function() {
                var o = settings,
                    items = slideItems,
                    images = slideImage,
                    n = numberSlides,
                    opc = o.reflectionOpacity,
                    start = 'rgba(' + o.reflectionColor + ',' + opc + ')',
                    end = 'rgba(' + o.reflectionColor + ',1)';
                var style = '<style type="text/css">';
                style += '.slideItem .gradient {';
                style += 'position:absolute; left:0; top:0; margin:0; padding:0; border:none; width:100%; height:100%; ';
                style += 'background: -moz-linear-gradient(' + start + ',' + end + '); ';
                style += 'background: -o-linear-gradient(' + start + ',' + end + '); ';
                style += 'background: -webkit-linear-gradient(' + start + ',' + end + '); ';
                style += 'background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(' + start + '), to(' + end + ')); ';
                style += 'background: linear-gradient(' + start + ',' + end + '); ';
                style += '} ';
                style += '.slideItem .reflection {';
                style += 'filter: progid:DXImageTransform.Microsoft.Alpha(style=1,opacity=' + (opc * 100) + ',finishOpacity=0,startX=0,finishX=0,startY=0,finishY=100)';
                style += '-ms-filter: progid:DXImageTransform.Microsoft.Alpha(style=1,opacity=' + (opc * 100) + ',finishOpacity=0,startX=0,finishX=0,startY=0,finishY=100)';
                style += '}';
                style += '</style>';
                $(style).appendTo('head');
                for (var i = 0; i < n; i++) {
                    var src = images.eq(i).attr('src'),
                        sz = setImageSize(i);
                    $('<div class="reflection"></div>').css({
                        'position': 'absolute',
                        'margin': '0',
                        'padding': '0',
                        'border': 'none',
                        'overflow': 'hidden',
                        'left': '0',
                        'top': setImageSize(i).height + 'px',
                        'width': '100%',
                        'height': reflectionHeight(i)
                    }).appendTo(items.eq(i)).append($('<img src="' + src + '" />').css({
                        'width': sz.width + 'px',
                        'height': sz.height + 'px',
                        'left': '0',
                        'margin': '0',
                        'padding': '0',
                        'border': 'none',
                        '-moz-transform': 'rotate(180deg) scale(-1,1)',
                        '-webkit-transform': 'rotate(180deg) scale(-1,1)',
                        '-o-transform': 'rotate(180deg) scale(-1,1)',
                        'transform': 'rotate(180deg) scale(-1,1)',
                        'filter': 'progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1)',
                        '-ms-filter': 'progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1)'
                    })).append('<div class="gradient"></div>');
                }
            };
            var animateReflection = function(option, item, i) {
                var ref = item.children('.reflection'),
                    speed = option.speed,
                    sz = setImageSize(slidePos(i));
                ref.animate({
                    'top': sz.height + 'px',
                    'height': reflectionHeight(slidePos(i))
                }, speed, 'linear');
                ref.children('img').animate(sz, speed, 'linear');
            };
            var shadowHeight = function(p) {
                var sh = 0;
                if (settings.shadow == true) {
                    sh = 0.1 * setImageSize(p).height;
                }
                return sh;
            };
            var shadowMiddleWidth = function(p) {
                var w, s = slideItems.eq(p).find('.shadow'),
                    sL = s.children('.shadowLeft'),
                    sR = s.children('.shadowRight'),
                    sM = s.children('.shadowMiddle');
                return w = setImageSize(p).width - (sL.width() + sR.width());
            };
            var initShadow = function() {
                var items = slideItems,
                    n = numberSlides,
                    sWidth = setImageSize(0).width,
                    sInner = '<div class="shadowLeft"></div><div class="shadowMiddle"></div><div class="shadowRight"></div>';
                if (settings.hAlign != 'center') {
                    sWidth = setImageSize(n - 1).width;
                }
                for (var i = 0; i < n; i++) {
                    var item = items.eq(i);
                    $('<div class="shadow"></div>').css({
                        'width': sWidth + 'px',
                        'z-index': '-1',
                        'position': 'absolute',
                        'margin': '0',
                        'padding': '0',
                        'border': 'none',
                        'overflow': 'hidden',
                        'left': '0',
                        'bottom': '0'
                    }).append(sInner).appendTo(item).children('div').css({
                        'position': 'relative',
                        'float': 'left'
                    });
                    item.find('.shadow').children('.shadowMiddle').width(shadowMiddleWidth(i));
                }
            };
            var animateShadow = function(option, item, i) {
                item.find('.shadow').children('.shadowMiddle').animate({
                    'width': shadowMiddleWidth(slidePos(i)) + 'px'
                }, option.speed, 'linear');
            };
            var initDirectionButton = function() {
                var el = element;
                el.append('<div class="nextButton"></div><div class="prevButton"></div>');
                el.children('.nextButton').bind('click', function(event) {
                    goTo(currentSlide + 1, true, false);
                });
                el.children('.prevButton').bind('click', function(event) {
                    goTo(currentSlide - 1, true, false);
                });
            };
            var initButtonNav = function() {
                var el = element,
                    n = numberSlides,
                    buttonName = 'bullet',
                    activeClass = 'bulletActive';
                if (settings.buttonNav == 'numbers') {
                    buttonName = 'numbers';
                    activeClass = 'numberActive';
                }
                el.append('<div class="buttonNav"></div>');
                var buttonNav = el.children('.buttonNav');
                for (var i = 0; i < n; i++) {
                    var number = '';
                    if (buttonName == 'numbers') {
                        number = i + 1;
                    }
                    $('<div class="' + buttonName + '">' + number + '</div>').css({
                        'text-align': 'center'
                    }).bind('click', function(event) {
                        goTo($(this).index(), true, false);
                    }).appendTo(buttonNav);
                }
                var b = buttonNav.children('.' + buttonName);
                b.eq(0).addClass(activeClass)
                buttonNav.css({
                    'width': numberSlides * b.outerWidth(true),
                    'height': b.outerHeight(true)
                });
            };
            var buttonNavState = function() {
                var o = settings,
                    buttonNav = element.children('.buttonNav');
                if (o.buttonNav == 'numbers') {
                    var numbers = buttonNav.children('.numbers');
                    numbers.removeClass('numberActive');
                    numbers.eq(currentSlide).addClass('numberActive');
                } else {
                    var bullet = buttonNav.children('.bullet');
                    bullet.removeClass('bulletActive');
                    bullet.eq(currentSlide).addClass('bulletActive');
                }
            };
            var initDesc = function() {
                var desc = $(settings.descriptionContainer),
                    w = desc.width(),
                    h = desc.height(),
                    descItems = desc.children('div'),
                    n = descItems.length;
                for (var i = 0; i < n; i++) {
                    descItems.eq(i).hide().css({
                        'position': 'absolute',
                        'top': '0',
                        'left': '0'
                    });
                }
                descItems.eq(0).show();
            };
            var hideDesc = function(index) {
                var o = settings;
                if (o.description == true) {
                    var desc = $(o.descriptionContainer);
                    desc.children('div').eq(index).hide();
                }
            };
            var showDesc = function(index) {
                var o = settings;
                if (o.description == true) {
                    var desc = $(o.descriptionContainer);
                    desc.children('div').eq(index).show();
                }
            };
            var initSpinner = function() {
                var sz = setImageSize(0);
                $('<div class="spinner"></div>').hide().css(setSlidePosition(0)).css({
                    'width': sz.width + 'px',
                    'height': sz.height + 'px',
                    'z-index': numberSlides + 3,
                    'position': 'absolute',
                    'cursor': 'pointer',
                    'overflow': 'hidden',
                    'padding': '0',
                    'margin': '0',
                    'border': 'none'
                }).appendTo(carousel);
            };
            var initVideo = function() {
                initSpinner();
                var sz = setImageSize(0);
                $('<div class="videoOverlay"></div>').hide().css(setSlidePosition(0)).css({
                    'width': sz.width + 'px',
                    'height': sz.height + 'px',
                    'z-index': numberSlides + 2,
                    'position': 'absolute',
                    'cursor': 'pointer',
                    'overflow': 'hidden',
                    'padding': '0',
                    'margin': '0',
                    'border': 'none'
                }).bind('click', videoOverlayClick).appendTo(carousel);
                showVideoOverlay(currentSlide);
            };
            var showVideoOverlay = function(index) {
                if (slideItems.eq(index).children('a').hasClass('video')) {
                    carousel.children('.videoOverlay').show();
                }
            };
            var hideVideoOverlay = function() {
                var car = carousel;
                car.children('.videoOverlay').hide().children().remove();
                car.children('.spinner').hide();
            };
            var getVideo = function(url) {
                var types = videos,
                    src;
                $.each(types, function(i, e) {
                    if (url.match(e.reg)) {
                        var id = url.split(e.split)[e.index].split('?')[0].split('&')[0];
                        src = e.url.replace("%id%", id);
                    }
                });
                return src;
            };
            var addVideoContent = function() {
                var vo = carousel.children('.videoOverlay'),
                    url = slideItems.eq(currentSlide).children('a').attr('href'),
                    src = getVideo(url);
                $('<iframe></iframe>').attr({
                    'width': vo.width() + 'px',
                    'height': vo.height() + 'px',
                    'src': src,
                    'frameborder': '0'
                }).bind('load', videoLoad).appendTo(vo);
            };
            var videoOverlayClick = function(event) {
                addVideoContent();
                carousel.children('.spinner').show();
                $(this).hide();
                if (settings.autoplay == true) {
                    stopAutoplay();
                    pause = false;
                }
            };
            var videoLoad = function(event) {
                var car = carousel;
                car.children('.videoOverlay').show();
                car.children('.spinner').hide();
            };
            var runAutoplay = function() {
                intervalProcess = setInterval(function() {
                    goTo(currentSlide + 1, false, true);
                }, settings.autoplayInterval);
            };
            var stopAutoplay = function() {
                if (settings.autoplay == true) {
                    clearInterval(intervalProcess);
                    return;
                }
            };
            this.prev = function() {
                goTo(currentSlide - 1, true, false);
            };
            this.next = function() {
                goTo(currentSlide + 1, true, false);
            };
            this.goTo = function(index) {
                goTo(index, true, false);
            };
            this.pause = function() {
                stopAutoplay();
                pause = false;
            };
            this.resume = function() {
                if (settings.autoplay == true) {
                    runAutoplay();
                }
            };
        };
        $.fn.carousel = function(options) {
            var returnArr = [];
            for (var i = 0; i < this.length; i++) {
                if (!this[i].carousel) {
                    this[i].carousel = new CarouselEvo(this[i], options);
                    this[i].carousel.init();
                }
                returnArr.push(this[i].carousel);
            }
            return returnArr.length > 1 ? returnArr : returnArr[0];
        };
        $.fn.carousel.defaults = {
            hAlign: 'center',
            vAlign: 'center',
            hMargin: 0.4,
            vMargin: 0.2,
            frontWidth: 249,
            frontHeight: 408,
            carouselWidth: 1000,
            carouselHeight: 360,
            left: 0,
            right: 0,
            top: 0,
            bottom: 0,
            backZoom: 0.8,
            slidesPerScroll: 5,
            speed: 500,
            buttonNav: 'none',
            directionNav: false,
            autoplay: true,
            autoplayInterval: 5000,
            pauseOnHover: true,
            mouse: true,
            shadow: false,
            reflection: false,
            reflectionHeight: 0.2,
            reflectionOpacity: 0.5,
            reflectionColor: '255,255,255',
            description: false,
            descriptionContainer: '.description',
            backOpacity: 1,
            before: function(carousel) {},
            after: function(carousel) {}
        };
    })(jQuery);
    initSoapGalleryCarouselStyle1();
});

function initSoapGalleryCarouselStyle1() {
    $ = jQuery;
    $(".book-gallery.carousel-style1").each(function() {
        var $this = $(this);
        if ($this.next(".temp").length > 0) {
            $this = $this.next(".temp");
            $(this).remove();
            $this.removeClass("temp");
            $this.show();
        }
        var frontWidth = $this.data("front-width"),
            frontHeight = $this.data("front-height");
        if (typeof frontWidth == "undefined") {
            frontWidth = 249;
        } else {
            frontWidth = parseInt(frontWidth, 10);
        }
        if (typeof frontHeight == "undefined") {
            frontHeight = 408;
        } else {
            frontHeight = parseInt(frontHeight, 10);
        }
        var slidesCount = $this.data("slides"),
            hAlign = $this.data("halign"),
            vAlign = $this.data("valign");
        if (typeof slidesCount == "undefined") {
            slidesCount = 5;
        } else {
            slidesCount = parseInt(slidesCount, 5);
        }
        if (typeof hAlign == "undefined") {
            hAlign = "center";
        }
        if (typeof vAlign == "undefined") {
            vAlign = "center";
        }
        var containerWidth = 0;
        if (hAlign != "center") {
            containerWidth = $(".container").width("100%");
            frontWidth = frontWidth / (0 / containerWidth);
            frontHeight = frontHeight / (0 / containerWidth);
        }
        $this.clone().insertAfter($this).hide().addClass("temp");
        $this.carousel({
            hAlign: hAlign,
            vAlign: vAlign,
            hMargin: 1.1,
            vMargin: 0.1,
            backZoom: 0.8,
            carouselWidth: containerWidth,
            carouselHeight: frontHeight,
            frontWidth: frontWidth,
            frontHeight: frontHeight,
            left: 0,
            right: 0,
            directionNav: false,
            shadow: false,
            slidesPerScroll: slidesCount,
            reflection: false,
            buttonNav: 'none',
        });
    });
};
