<?php get_header(); ?>			
		
		<div id="pageHead">
			<h1><?php the_title(); ?></h1>
		</div>		
				 
		<div id="content">			
			<?php while (have_posts()) : the_post(); ?>			    
			<div class="project clearfix">   						
				<?php the_content(); ?>				

				<?php $project_url = get_post_meta($post->ID, "_ttrust_url_value", true); ?>
				<?php $project_url_label = get_post_meta($post->ID, "_ttrust_url_label_value", true); ?>
				<?php $project_url_label = ($project_url_label!="") ? $project_url_label : __('Visit Site', 'themetrust'); ?>
				<ul class="skillList clearfix"><?php ttrust_get_terms_list(); ?></ul>	
				<?php if ($project_url) : ?>
					<p><a class="action" href="<?php echo $project_url; ?>"><?php echo $project_url_label; ?></a></p>
				<?php endif; ?>			
								
			</div>
			<?php comments_template('', true); ?>	
			<?php endwhile; ?>										    	
		</div>		
	
<?php get_footer(); ?>