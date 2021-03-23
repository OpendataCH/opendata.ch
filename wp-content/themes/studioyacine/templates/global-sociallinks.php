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
                <a target="<?php echo esc_attr($link_target); ?>" title='<?php echo $link['title']; ?>' href="<?php echo $link['url']; ?>">
                    <?php echo $link['title']; ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>