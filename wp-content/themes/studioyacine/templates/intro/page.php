<?php
// ===================================================
// Intro
// ===================================================
// ===================================================
// ===================================================
?>
<?php
if (isset($args['id'])) {
    $intro = get_field($args['id']);
}
?>
<section class="Intro">

    <?php if ($intro) : ?>

        <strong><?php echo $intro; ?></strong>

    <?php else : ?>

        <h1><?php the_title(); ?></h1>

    <?php endif; ?>

</section>