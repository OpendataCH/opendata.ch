<?php get_header(); ?>	
			<?php $home_content = of_get_option('ttrust_home_content'); ?>						
			<div id="content">				

				<?php if($home_content=="posts") : ?>
					<?php include( TEMPLATEPATH . '/includes/posts_home.php'); ?>
				<?php elseif($home_content=="projects" || $home_content=="") : ?>
					<?php include( TEMPLATEPATH . '/includes/projects_home.php'); ?>
				<?php endif; ?>
				
			</div>		
	
<?php get_footer(); ?>
