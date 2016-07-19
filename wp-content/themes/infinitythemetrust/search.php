<?php get_header(); ?>

	<div id="pageHead">
		<h1><?php _e('Search Results', 'themetrust'); ?></h1>
	</div>
					 
	<div id="content" class="clearfix">
		<div class="posts clearfix">
			
		<?php if (have_posts()) : ?>	
			<?php while (have_posts()) : the_post(); ?>							
				<div <?php post_class('post'); ?> >																				
					<div class="inside">
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_title(); ?></a></h1>	
						<?php the_excerpt('',TRUE); ?>					
					</div>																									
				</div>		
			<?php endwhile; ?>
		<?php else : ?>
			<div <?php post_class('post'); ?> >																				
				<div class="inside">
					<h1><?php _e('No Results', 'themetrust'); ?></h1>	
					<p><?php _e('Nothing matched your search.', 'themetrust'); ?></p>
				</div>																									
			</div>
		<?php endif; ?>
		</div>
		<?php include( TEMPLATEPATH . '/includes/pagination.php'); ?>					    	
	</div>
		
	<?php get_sidebar(); ?>	
	
<?php get_footer(); ?>