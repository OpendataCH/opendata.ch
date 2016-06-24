	</div>	
	<div id="footer">
		
		<div class="main clearfix">
		<?php	
		if(is_front_page() && is_active_sidebar('footer_home')) : dynamic_sidebar('footer_home'); 			
		elseif(is_archive() && is_active_sidebar('footer_posts')) : dynamic_sidebar('footer_posts');
		elseif(is_single() && is_active_sidebar('footer_posts')) : dynamic_sidebar('footer_posts');
		elseif(is_page() && is_active_sidebar('footer_pages')) : dynamic_sidebar('footer_pages');
		else : ?>
	
		<?php //if (!dynamic_sidebar('footer_default')) : ?>
	
		<!-- <div class = "widgetBox">        
		      <?php //include( TEMPLATEPATH . '/includes/no_widgets.php'); ?> 
		    </div> -->
				
		<?php //endif; ?>	
		<?php endif; ?>				
		</div><!-- end footer main -->		
		
								
			
		<div class="secondary clearfix">	
			<?php $footer_left = of_get_option('ttrust_footer_left'); ?>
			<?php $footer_right = of_get_option('ttrust_footer_right'); ?>
			<div class="left"><p>
			<?php 
			if($footer_left){echo($footer_left);} else{ ?>
			<a rel="license" href="http://creativecommons.org/licenses/by/3.0/ch/deed.en_US" target="_blank"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/ch/80x15.png"></a><a href="http://opendata.ch" rel="cc:attributionURL">opendata.ch</a> is licensed under a <a rel="license" target="_blank" href="http://creativecommons.org/licenses/by/3.0/ch/deed.en_US">Creative Commons Attribution 3.0 Switzerland License</a>.
			<?php }; ?>
			</p></div>
			<div class="right"><p><?php if($footer_right){echo($footer_right);} else{ ?><?php }; ?></p></div>
		</div><!-- end footer secondary-->
			
		
				
	</div><!-- end footer -->	
</div><!-- end container -->
<?php wp_footer(); ?>
</body>
</html>
