<?php /*
Template Name: Landing
*/ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <?php $heading_font = of_get_option('ttrust_heading_font'); ?>
  <?php $body_font = of_get_option('ttrust_body_font'); ?>
  <?php $home_message_font = of_get_option('ttrust_home_message_font'); ?>
  <?php if ($heading_font != "") : ?>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=<?php echo(urlencode($heading_font)); ?>:regular,italic,bold,bolditalic" />
  <?php else : ?>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Droid+Sans:regular,bold" />
  <?php endif; ?>

  <?php if ($body_font != "" && $body_font != $heading_font) : ?>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=<?php echo(urlencode($body_font)); ?>:regular,italic,bold,bolditalic" />
  <?php elseif ($heading_font != "") : ?>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Droid+Sans:regular,bold" />
  <?php endif; ?>

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

  <?php if (of_get_option('ttrust_favicon')) : ?>
    <link rel="shortcut icon" href="<?php echo of_get_option('ttrust_favicon'); ?>" />
  <?php endif; ?>

  <?php wp_head(); ?>
  
  <style>
  body.page-template-landing {
    background-image: url("<?php the_post_thumbnail_url('full'); ?>");
  }
  </style>
</head>

<body <?php body_class(of_get_option('ttrust_background_texture')); ?>>

<?php $ttrust_logo = of_get_option('logo'); ?>
<div id="logo">
<?php if($ttrust_logo) : ?>
  <h1 class="logo"><a href="<?php bloginfo('url'); ?>"><img src="<?php echo $ttrust_logo; ?>" alt="<?php bloginfo('name'); ?>" /></a></h1>
<?php else : ?>
  <h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
<?php endif; ?>
</div>

<div id="mainNav" class="clearfix">
  <?php wp_nav_menu( array('menu_class' => '', 'theme_location' => 'main', 'fallback_cb' => 'default_nav' )); ?>
</div>

<div id="content">

<div id="container" class="clearfix">

  <?php $home_message = of_get_option('ttrust_home_message'); ?>
  <?php if($home_message && is_front_page()) : ?>
    <div id="homeMessage" class="withBorder">
      <p><?php echo $home_message; ?></p>
    </div>
  <?php endif; ?>

  <div class="clearfix">
    <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
  </div>

</div>

<?php
$args = array(
    'sort_order' => 'ASC',
    'sort_column' => 'menu_order',
    'child_of' => get_the_ID()
);
$children = get_pages($args);
?>
<?php foreach ($children as $child): ?>

  <?php
  $sectionCustom = get_post_custom_values('landing_section', $child->ID);
  $section = isset($sectionCustom[0]) ? 'landing-section-' . $sectionCustom[0] : '';

  $containerCustom = get_post_custom_values('landing_container', $child->ID);
  $container = isset($containerCustom[0]) ? 'landing-container-' . $containerCustom[0] : '';
  ?>
  <div class="landing-section <?php echo esc_html($section); ?>" id="section-<?php echo esc_html($child->post_name); ?>">

    <div class="landing-container <?php echo esc_html($container); ?>">
      <?php echo apply_filters('the_content', $child->post_content); ?>
    </div>

  </div>

<?php endforeach; ?>

</div>

<?php wp_footer(); ?>

</body>
</html>
