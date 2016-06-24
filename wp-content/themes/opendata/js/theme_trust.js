//////////////////////////////////////////////////////////////
// Set Variables
/////////////////////////////////////////////////////////////

var transitionSpeed = 500;
var scrollSpeed = 700;
var fadeDelay = 100;
var currentProject = "";
var nextProject = "";
var previousHeight = "";
var emptyProjectBoxHeight = 100;
var hasSlideshow = false;

///////////////////////////////
// iPad and iPod Detection
///////////////////////////////

function isiPad(){
    return (navigator.platform.indexOf("iPad") != -1);
}

function isiPhone(){
    return (
        //Detect iPhone
        (navigator.platform.indexOf("iPhone") != -1) ||
        //Detect iPod
        (navigator.platform.indexOf("iPod") != -1)
    );
}


///////////////////////////////
// Isotope Browser Check
///////////////////////////////

function isotopeAnimationEngine(){
	if(jQuery.browser.mozilla || jQuery.browser.msie){
		return "jquery";
	}else{
		return "css";
	}
}


///////////////////////////////
// Lightbox
///////////////////////////////

function lightboxInit() {
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({
		social_tools: false,
		deeplinking: false,
		overlay_gallery: false,
		show_title: false
	});
}


///////////////////////////////
// Project Filtering
///////////////////////////////

function projectFilterInit() {
	jQuery('#filterNav a').click(function(){
		var selector = jQuery(this).attr('data-filter');
		jQuery('#projects .thumbs').isotope({
			filter: selector,
			hiddenStyle : {
		    	opacity: 0,
		    	scale : 1
			}
		});

		if ( !jQuery(this).hasClass('selected') ) {
			jQuery(this).parents('#filterNav').find('.selected').removeClass('selected');
			jQuery(this).addClass('selected');
		}

		return false;
	});
}


///////////////////////////////
// Project thumbs
///////////////////////////////

function projectThumbInit() {

	if(!isiPad() && !isiPhone()) {
		if(jQuery.browser.msie) {
			jQuery(".project.small").hover(
				function() {
					jQuery(this).find('.title').show();
					jQuery(this).find('img:last').attr('title','');
				},
				function() {
					jQuery(this).find('.title').hide();
			});

		}else{
			jQuery(".project.small").hover(
				function() {
					jQuery(this).find('.title').stop().fadeTo("fast", 1);
					jQuery(this).find('img:last').attr('title','');
				},
				function() {
					jQuery(this).find('.title').stop().fadeTo("fast", 0);
			});
		}
	}


	jQuery('.thumbs.masonry').isotope({
		itemSelector : '.project.small',
		layoutMode : 'masonry',
	    animationEngine: isotopeAnimationEngine()
	});

	jQuery(".project.small").css("opacity", "1");

}


jQuery.noConflict();
jQuery(document).ready(function(){

	lightboxInit();
	projectThumbInit();
	projectFilterInit();

});
