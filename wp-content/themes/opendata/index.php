<?php get_header(); ?>
	<?php if(!is_front_page()) : ?>	
		<div id="pageHead">
			<?php $blog_page_id = get_option('page_for_posts'); ?>
			<?php $blog_page = get_page($blog_page_id); ?>
			<h1><?php echo $blog_page->post_title; ?></h1>
			<?php $page_description = get_post_meta($blog_page_id, "_ttrust_page_description_value", true); ?>
			<?php if ($page_description) : ?>
				<p><?php echo $page_description; ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>	
						 
		<div id="content">
			<div class="posts clearfix">			
			<?php while (have_posts()) : the_post(); ?>			    
				<div <?php post_class(); ?>>					
					<div class="inside">															
						<h1><a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_title(); ?></a></h1>
						<div class="meta clearfix">
							<?php $post_show_author = of_get_option('ttrust_post_show_author'); ?>
							<?php $post_show_date = of_get_option('ttrust_post_show_date'); ?>
							<?php $post_show_category = of_get_option('ttrust_post_show_category'); ?>
							<?php $post_show_comments = of_get_option('ttrust_post_show_comments'); ?>
										
							<?php // if($post_show_author || $post_show_date || $post_show_category){ _e('Posted ', 'themetrust'); } ?>
							<?php if($post_show_author) { /* _e('by ', 'themetrust'); */ the_author_posts_link(); }?> |
							<?php if($post_show_date) { /* _e('on', 'themetrust'); */?> <?php the_time('j. M Y'); } ?> |
							<?php if($post_show_category) { _e('in', 'themetrust'); ?> <?php the_category(', '); } ?>
							<?php if(($post_show_author || $post_show_date || $post_show_category) && $post_show_comments){ echo " | "; } ?>
							
							<?php if($post_show_comments) : ?>
								<a href="<?php comments_link(); ?>"><?php comments_number(__('No Comments', 'themetrust'), __('One Comment', 'themetrust'), __('% Comments', 'themetrust')); ?></a>
							<?php endif; ?>
						</div>						
						<div class="divPusher"></div>
						<?php if(has_post_thumbnail()) : ?>
							<?php if(of_get_option('ttrust_post_featured_img_size')=="large") : ?>											
				    			<a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_post_thumbnail('ttrust_post_thumb_big', array('class' => 'postThumb', 'alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?></a>		    	
							<?php else: ?>
								<a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_post_thumbnail('ttrust_post_thumb_small', array('class' => 'postThumb alignleft', 'alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?></a>
							<?php endif; ?>
						<?php endif; ?>															
						
						<?php the_content(); ?>
					</div>																				
			    </div>				
			
			<?php endwhile; ?>
			</div>
			<?php include( TEMPLATEPATH . '/includes/pagination.php'); ?>					    	
		</div>			
		
<?php get_footer(); ?>