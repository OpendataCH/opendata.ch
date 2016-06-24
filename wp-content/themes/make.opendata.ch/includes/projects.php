<div id="projects">		
				
	<?php $page_skills = get_post_meta($post->ID, "_ttrust_page_skills_value", true); ?>
	
	<?php if ($page_skills) : // if there are a limited number of skills set ?>
		<?php $skill_slugs = ""; $skills = explode(",", $page_skills); ?>

		<?php if (sizeof($skills) > 1) : // if there is more than one skill, show the filter nav?>	
			<ul id="filterNav" class="clearfix">
				<li class="allBtn"><a href="#" data-filter="*" class="selected">All</a></li>

				<?php
				$j=1;					  
				foreach ($skills as $skill) {				
					$skill = get_term_by( 'slug', trim(htmlentities($skill)), 'skill');
					if($skill) {
						$skill_slug = $skill->slug;				

						$skill_slugs .= $skill_slug . ",";
		  				$a = '<li class="'.$skill_slug.'Btn"><span>/</span><a href="#" data-filter=".'.$skill_slug.'">';
						$a .= $skill->name;					
						$a .= '</a></li>';
						echo $a;
						echo "\n";
						$j++;
					}		  
				}?>
			</ul>
			<?php $skill_slugs = substr($skill_slugs, 0, strlen($skill_slugs)-1); ?>
		<?php else: ?>
			<?php $skill = $skills[0]; ?>
			<?php $s = get_term_by( 'name', trim(htmlentities($skill)), 'skill'); ?>
			<?php if($s) { $skill_slugs = $s->slug; } ?>
		<?php endif; 	

		query_posts( 'skill='.$skill_slugs.'&post_type=projects&posts_per_page=200' );

	else : // if not, use all the skills ?>

		<ul id="filterNav" class="clearfix">

			<?php $j=1;
			$skills = get_terms('skill');
			foreach ($skills as $skill) {
				$a = '<li class="'.$skill->slug.'Btn"><span>/</span><a href="#" data-filter=".'.$skill->slug.'">';
		    	$a .= $skill->name;					
				$a .= '</a></li>';
				echo $a;
				echo "\n";
				$j++;
			}?>
		</ul>
		<?php query_posts( 'post_type=projects&posts_per_page=200' );

	endif; ?>
	
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

