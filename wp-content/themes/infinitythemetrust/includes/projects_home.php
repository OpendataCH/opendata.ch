<div id="projects">		
					
		<?php if(of_get_option('ttrust_home_project_type') == "featured") : //Show only featured projects ?>			
			
			<?php
			query_posts( array(
				'ignore_sticky_posts' => 1,
    			'meta_key' => '_ttrust_featured_value',
				'meta_value' => 'true',
				'posts_per_page' => 500,   			
    			'post_type' => array(				
				'projects'					
				)
			));
			?>	
			
			<?php $skills_nav = array(); ?>			

			<?php  while (have_posts()) : the_post(); ?>	   			    
				<?php 				
				$s = "";
				$skills = get_the_terms( $post->ID, 'skill');
				if ($skills) {
				   foreach ($skills as $skill) {
					  if (isset($skills_nav[$skill->term_id])) {
					  	continue;
					  }
					  $skills_nav[$skill->term_id] = $skill;		      		  		
				   }		   
				}		

				?>
			<?php endwhile; ?>	

			<ul id="filterNav" class="clearfix">				
				<li class="allBtn"><a href="#" data-filter="*" class="selected">All</a></li>
				<?php
				$j=1;		  
				  foreach ($skills_nav as $skill) {
				  	$a = '<li class="'.$skill->slug.'Btn"><span>/</span><a href="#" data-filter=".'.$skill->slug.'">';
					$a .= $skill->name;					
					$a .= '</a></li>';
					echo $a;
					echo "\n";
					$j++;
				  }
				 ?>								
			</ul>			
			
		<?php else: //Show all projects ?>			
			
			<ul id="filterNav" class="clearfix">
				<li class="allBtn"><a href="#" data-filter="*" class="selected">All</a></li>	
				<?php
				$categories =  get_categories('taxonomy=skill'); 										
				foreach ($categories as $category) {					
					$a = '<li class="'.$category->slug.'Btn"><span>/</span><a href="#" data-filter=".'.$category->slug.'">';
					$a .= $category->name;					
					$a .= '</a></li>';
					echo $a;
					echo "\n";								
				 }
				 ?>					
			</ul>
			
			<?php
			query_posts( array(
				'ignore_sticky_posts' => 1,    			
    			'posts_per_page' => 500,
    			'post_type' => array(				
				'projects'					
				)
			));
			?>			
			
		<?php endif; ?>			
					
	<div class="thumbs masonry">			
		<?php  while (have_posts()) : the_post(); ?>
			
			<?php 				
			$p = "";
			$skills = get_the_terms( $post->ID, 'skill');
			if ($skills) {
			   foreach ($skills as $skill) {				
			      $p .= $skill->slug . " ";						
			   }
			}
			?>    		
			
			<?php include( TEMPLATEPATH . '/includes/project_thumb.php'); ?>

		<?php endwhile; ?>
		
	</div>
</div>
	