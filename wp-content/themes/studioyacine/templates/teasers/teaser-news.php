<?php
// ===================================================
// Small Teaser
// ===================================================
// ===================================================
// ===================================================
?>
<a class='TeaserNews' title="<?php the_title_attribute(); ?>" href='<?php the_permalink() ?>'>

    <?php 
		$postTypeName = get_post_type($post->ID);
		$termsOutPut = array();
        $terms = get_the_terms($post->ID, $postTypeName.'_category');
        if ($terms):
            foreach ($terms as $term) {
                $termsOutPut[] = '<span>' .$term->name .'</span>';
            }
            $termsOutPut = join( ' / ', $termsOutPut );
        endif; 	
	?>

	<div class="TeaserNews--image">
        <?php if (has_post_thumbnail()) : ?>

			<?php if($args['teaserCount'] === 0): ?>
				<?php the_post_thumbnail('large'); ?>
			<?php else : ?>
            	<?php the_post_thumbnail('small'); ?>
			<?php endif; ?>

        <?php endif; ?>

    </div>
    <div class="TeaserNews--text">
        <div>
            <h3 class='TeaserNews--title'><?php the_title(); ?></h3>
            <?php if(!empty($termsOutPut)): ?>
                <div class='TeaserNews--terms'>
                    <?php echo $termsOutPut; ?>
                </div>
            <?php  endif; ?>
        </div>
        <time class='TeaserNews--date' datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished"><?php echo get_the_date('d M Y'); ?></time>

    </div>

</a>