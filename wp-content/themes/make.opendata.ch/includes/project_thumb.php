<?php
$lightbox_media = ""; 
$lightbox_img = get_post_meta($post->ID, "_ttrust_lightbox_img_value", true); 
$lightbox_video = get_post_meta($post->ID, "_ttrust_lightbox_video_value", true); 			
if ($lightbox_img || $lightbox_video) : 
	$lightbox_media = ($lightbox_video != "") ? $lightbox_video : $lightbox_img; 
endif; 			
?>

<div class="project small <?php echo $p; ?>" id="project-<?php echo $post->post_name;?>">
	<?php if($lightbox_media) : ?>						
		<a href="<?php echo $lightbox_media; ?>" rel="prettyPhoto" title="">			
	<?php else : ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark" >
	<?php endif; ?>
	<h2><?php the_title(); ?></h2>
	<?php the_post_thumbnail("ttrust_one_fourth_cropped", array('class' => 'thumb', 'alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?>
	</a>																																
</div>