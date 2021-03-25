<?php
// ===================================================
// LOGO
// ===================================================
// ===================================================
// ===================================================
?>
<p class="Logo" itemscope itemtype="http://schema.org/Organization">
    <a href="<?php echo home_url(); ?>" rel="nofollow">
        <?php
        if (function_exists('the_custom_logo')) {
            the_custom_logo();
        }
        ?>
    </a>
</p>