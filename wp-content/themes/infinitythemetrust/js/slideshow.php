<?php $slideshow_delay = of_get_option('ttrust_slideshow_delay'); ?>
<?php $autoPlay = ($slideshow_delay != "0") ? 1 : 0; ?>
<?php $slideshow_effect = of_get_option('ttrust_slideshow_effect'); ?>

<script type="text/javascript">
//<![CDATA[

jQuery(window).load(function() {			
	jQuery('.flexslider').flexslider({
		slideshowSpeed: <?php echo $slideshow_delay . '000'; ?>,  		
		slideshow: <?php echo $autoPlay; ?>,				 				
		animation: '<?php echo $slideshow_effect; ?>',
		animationLoop: true,
		controlNav: true,  
		smoothHeight: false,           
		directionNav: true,
		pauseOnAction: true,            
		pauseOnHover: false,            
		useCSS: true,                   
		touch: true,                  
		video: false
	});  
});

//]]>
</script>