<?php
// ===================================================
// SOCIAL LINKS
// ===================================================
// ===================================================
// ===================================================
?>
<?php if (have_rows('social_links', 'option')) : ?>
    <ul class="SocialLinks">
        <?php while (have_rows('social_links', 'option')) : the_row(); ?>
            <?php
            $link = get_sub_field('link');
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
            <li>
                <a rel="noopener" target="<?php echo esc_attr($link_target); ?>" title='<?php echo $link['title']; ?>' href="<?php echo $link['url']; ?>">
					<?php $linkUrl = $link['url']; ?>

                    <?php if(stristr($linkUrl,'twitter')):?>
                        <svg class="icon">
                            <use xlink:href="#social--twitter"></use>
                        </svg>  
                    <?php elseif(stristr($linkUrl,'facebook')):?>
                        <svg class="icon">
                            <use xlink:href="#social--facebook"></use>
                        </svg> 
                    <?php elseif (stristr($linkUrl,'instagram')):?>
                        <svg class="icon">
                            <use xlink:href="#social--instagram"></use>
                        </svg>
                   <?php elseif (stristr($linkUrl,'youtube')):?>
                        <svg class="icon">
                            <use xlink:href="#social--youtube"></use>
                        </svg>
					<?php elseif (stristr($linkUrl,'linkedin')):?>
						<svg class="icon">
							<use xlink:href="#social--linkedin"></use>
						</svg>
					<?php elseif (stristr($linkUrl,'mastadon')):?>
						<svg class="icon">
							<use xlink:href="#social--mastadon"></use>
						</svg>						
                    <?php endif; ?>					
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>