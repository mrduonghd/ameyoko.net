/*!
 * ScriptName: shared.js
 *
 * FoodConnection
 * http://foodconnection.jp/
 * http://foodconnection.vn/
 *
 */


$(document).ready(function() {
	$('.slick_auto').on('touchstart',function(e) {
  	$(this).slick('slickPlay');
});	
	
	
	
	
	
});



$(function () {
	
	$('body').removeClass('navOpen');
		$(".hamburger").click(function () {
			if ($('body').hasClass('navOpen')) {
				$('body').addClass('navClose');
				$('body').removeClass('navOpen');
				//$('body').css('position', 'static');
      			//$(window).scrollTop(offsetY);
				//$(".hamburger").removeClass('is-active');
		
			} else {
				$('body').addClass('navOpen');
				$('body').removeClass('navClose');
			/*
				offsetY = window.pageYOffset;
				$('body').css({
					position: 'fixed',
					width: '100%',
					'top': -offsetY + 'px'
				});
				*/
				$(".hamburger").addClass('is-active');
				return false;
			}
		});

		$("#navigation a,body").click(function () {
			$('body').removeClass('navOpen');
			$('body').addClass('navClose');			
			$(".hamburger").removeClass('is-active');
			//$('body').css('position', 'static');
		});
	
	
});




$(document).ready(function() {	
	
		/*$(".togg").click(function () {
			
			
			if ($('#navigation').hasClass('togOpen')) {
				$('#navigation').addClass('togClose');
				$('#navigation').removeClass('togOpen');
				
		
			} else {
				$('#navigation').addClass('togOpen');
				$('#navigation').removeClass('togClose');
			
				return false;
			}
			
			
		});
*/
	
	/*
	 $("#navigation .togg").click(function () {
    if ($(this).parent().hasClass('popOpen')) {
      $(this).parent().addClass('popClose');
     $(this).parent().removeClass('popOpen');     
	
	
	
		
    } else {
     $(this).parent().addClass('popOpen');
      $(this).parent().removeClass('popClose');
	
  
   
      return false;
    }
  });
	
	*/

	var TargetPos =  $("section").offset().top;	
	var offsetY = window.pageYOffset;
	$(window).scroll(function () {
		//console.log(offsetY);
	
		var ScrollPos = $(window).scrollTop();
	
		if (ScrollPos > TargetPos) {

		
			
			$("body").addClass('has_nav');

		} else {

		
			$("body").removeClass('has_nav');

		}


	});
	
		
		
		
		});

function objectFitPolyfill() {
    // Internet Explorer 6-11
    var isIE = /*@cc_on!@*/ false || !!document.documentMode;
    // Edge 20+
    var isEdge = !isIE && !!window.StyleMedia;
    if (isIE === true || isEdge === true) {
        $('.object-fit-cover').each(function (index, element) {
            let src = $(element).attr('data-src');
            if (src === undefined) {
                src = $(element).attr('src')
            }
            $(element).css('display', 'none');
            $(element).parent().css({
                'background-image': "url('" + src + "')",
                'background-repear': 'no-repeat',
                'background-size': 'cover',
                'background-position': 'center center'
            });
        });
    }
}
$(document).ready(function(){
    objectFitPolyfill()
})



let vh = window.innerHeight * 0.01;
document.documentElement.style.setProperty('--vh', vh+'px');




//fix scroll ios
var overflowIsHidden = function(node) {
    var style = getComputedStyle(node);
    return style.overflow === "hidden" || style.overflowX === "hidden" || style.overflowY === "hidden";
}

var isItScrollableWithoutVisibleScrollbars = function(el) {
    if (el === null) return false;

    var isScrollable = false,
        hasScrollbars = false;

    isScrollable = el.scrollHeight > el.offsetHeight ? true : false; // first, lets find out if it has scrollable content
    // isScrollable = el.scrollHeight + 1 > el.clientHeight ? true : false; // first, lets find out if it has scrollable content

    if (isScrollable) hasScrollbars = (el.offsetWidth > el.scrollWidth) ? true : false; // if it's scrollable, let's see if it likely has scrollbars
    // if (isScrollable) hasScrollbars = (el.offsetWidth > el.scrollWidth - 1) ? true : false; // if it's scrollable, let's see if it likely has scrollbars

    if (isScrollable && !hasScrollbars && !overflowIsHidden(el)) return true;
    else return false;
};
//
//document.addEventListener("touchmove", function(e) {
//    if (document.body.classList.contains("nav--opened") && !isItScrollableWithoutVisibleScrollbars(document.getElementById("menu_toggle"))) e.preventDefault();
//}, {
//    passive: false
//});

document.addEventListener("touchmove", function(e) {
    if (document.body.classList.contains("navOpen")) {
        if (!isItScrollableWithoutVisibleScrollbars(document.getElementById("navigation")) || $(e.target).parents("#navigation").length < 1) e.preventDefault();
    }
}, {
    passive: false
});


window.addEventListener("resize", function() {
    var _event_ = new Event("touchmove");

    document.dispatchEvent(_event_); // trigger
}, {
    passive: false
});
// END: fix scroll iOS

