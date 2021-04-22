<?php
// ===================================================
// BLOCK - Team member
// ===================================================
// ===================================================
// ===================================================
?>
<div class="TeamMember">
<?php
	$featured_post = get_field('team_member');
	if( $featured_post ): ?>
		<?php 
			echo get_the_post_thumbnail( $featured_post->ID, 'medium', array( 'class' => 'TeamMember--image' ) );		
		?>	
		<div class='TeamMember--content'>
			<?php
				$title = get_the_title( $featured_post->ID );
				$position = get_field( 'position', $featured_post->ID );
				$content = get_post_field('post_content', $featured_post->ID);
			?>
			<h2 class='TeamMember--title'><?php echo esc_html( $title ); ?></h2>
			<?php if($position): ?>
				<span class='TeamMember--position'><?php echo esc_html( $position ); ?></span>
			<?php endif; ?>

			<div class='TeamMember--text'>
				<?php echo $content; ?>
			</div>
		</div>

	<?php endif; ?>
</div>