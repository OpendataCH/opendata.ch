///////////////////////////////		
// Set Variables
///////////////////////////////

var container = jQuery('.thumbs.masonry');
var colWidth;
var gridGutter = 20;

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
		var container = jQuery('.thumbs.masonry');		
		container.isotope({
			filter: selector,			
			hiddenStyle : {
		    	opacity: 0,
		    	scale : 1
			},
			resizable: false
		});
	
		if ( !jQuery(this).hasClass('selected') ) {
			jQuery(this).parents('#filterNav').find('.selected').removeClass('selected');
			jQuery(this).addClass('selected');
		}
	
		return false;
	});	
}

///////////////////////////////
// Isotope Grid Resize
///////////////////////////////

function setColumns()
{
	
	var columns;	
	if(container.width() < 480) {
	    columns = 2;	
	} else {
	    columns = 3;
	}
	
	colW = Math.floor(container.width() / columns);
	jQuery('.thumbs.masonry .project.small').each(function(id){
		jQuery(this).css('width',colW-gridGutter+'px');
	});
}

function gridResize() {	
	setColumns();
	container.isotope({
		resizable: false,
		masonry: {
			columnWidth: colW
		}
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
	
	setColumns();
	container.isotope({		
		resizable: false,
		layoutMode: 'fitRows',
		masonry: {
			columnWidth: colW
		}		
	});	

	jQuery(".project.small").css("opacity", "1");	
	
}
	
	
jQuery.noConflict();
jQuery(window).load(function(){
	jQuery("#content").fitVids();
	lightboxInit();
	projectThumbInit();	
	projectFilterInit();
	
	jQuery(window).smartresize(function(){
		gridResize();
	});	
	
});