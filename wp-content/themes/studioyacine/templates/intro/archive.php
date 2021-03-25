<?php
// ===================================================
// Intro
// ===================================================
// ===================================================
// ===================================================
?>
<?php
$title = get_field($args['prefix'] . '_title', 'option');
$intro = get_field($args['prefix'] . '_intro', 'option');
?>

<section class="Intro">

    <?php if ($intro) : ?>

        <strong><?php echo $intro; ?></strong>

    <?php else : ?>

        <?php if ($title) : ?>

            <h1><?php echo $title; ?></h1>

        <?php else : ?>

            <h1><?php post_type_archive_title(); ?></h1>

        <?php endif; ?>

    <?php endif; ?>

</section>