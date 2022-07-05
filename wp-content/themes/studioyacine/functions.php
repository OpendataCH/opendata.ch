<?php
/*
Author: Yacine Belarbi
URL: http://studioyacine.ch
*/

/*	LOAD Bones
*   
*   LOAD BONES CORE (if you remove this, the theme will break)
*   
*/
require_once 'library/functions/bones.php';



/*	Load scripts and styles
*   
*   LOAD BONES CORE (if you remove this, the theme will break)
*   
*/
require_once 'library/functions/scripts_and_styles.php';


/*	Theme Support
*
*	  Used to add theme support for
*	  required functionality ( add_theme_support() )
*
*/
require_once 'library/functions/theme_support.php';



/**
 *  Custom Admin 
 */
require_once 'library/functions/admin.php';



/**
 *  Custom Post Types 
 */
require_once 'library/functions/custom-post-type.php';




/**
 *  Helpers
 */
require_once 'library/functions/helpers.php';




/*********************
LAUNCH BONES
Let's get everything up and running.
 *********************/

function bones_ahoy()
{

  //Allow editor style.
  add_editor_style(get_stylesheet_directory_uri() . '/library/css/editor-style.css');

  // let's get language support going, if you need it
  load_theme_textdomain('bonestheme', get_template_directory() . '/library/translation');

  // launching operation cleanup
  add_action('init', 'bones_head_cleanup');
  // A better title
  add_filter('wp_title', 'rw_title', 10, 3);
  // remove WP version from RSS
  add_filter('the_generator', 'bones_rss_version');
  // remove pesky injected css for recent comments widget
  add_filter('wp_head', 'bones_remove_wp_widget_recent_comments_style', 1);
  // clean up comment styles in the head
  add_action('wp_head', 'bones_remove_recent_comments_style', 1);
  // clean up gallery output in wp
  add_filter('gallery_style', 'bones_gallery_style');

  // enqueue base scripts and styles
  add_action('wp_enqueue_scripts', 'bones_scripts_and_styles', 999);
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // cleaning up random code around images
  add_filter('the_content', 'bones_filter_ptags_on_images');
  // cleaning up excerpt
  add_filter('excerpt_more', 'bones_excerpt_more');
} /* end bones ahoy */

// let's get this party started
add_action('after_setup_theme', 'bones_ahoy');


/************* THEME CUSTOMIZE *********************/

function bones_theme_customizer($wp_customize)
{
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections

  // $wp_customize->remove_section('title_tagline');
  $wp_customize->remove_section('colors');
  $wp_customize->remove_section('background_image');
  $wp_customize->remove_section('static_front_page');
  $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');

  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __('Theme Colors');
  // $wp_customize->get_section('background_image')->title = __('Images');
}

add_action('customize_register', 'bones_theme_customizer');



/**
 *  Gutenberg settings
 */
require_once 'library/functions/gutenberg-settings.php';


/**
 *  ACF settings
 */
require_once 'library/functions/acf.php';



// Changing excerpt more
function new_excerpt_more($more)
{
  global $post;
  remove_filter('excerpt_more', 'new_excerpt_more');
  return '';
}
add_filter('excerpt_more', 'new_excerpt_more', 11);


// Add new styles to the TinyMCE "formats" menu dropdown
if (!function_exists('studioyacine_styles_dropdown')) {
  function studioyacine_styles_dropdown($settings)
  {

    // Create array of new styles
    $new_styles = array(
      array(
        'title'  => __('Custom Styles', 'studioyacine'),
        'items'  => array(
          array(
            'title'    => __('Button', 'studioyacine'),
            'selector'  => 'p',
            'classes'  => 'button'
          ),
          // array(
          //   'title'    => __('Button Red', 'studioyacine'),
          //   'selector'  => 'p',
          //   'classes'  => 'button-red'
          // ),
          // array(
          //   'title'    => __('Large', 'studioyacine'),
          //   'selector'  => 'p',
          //   'classes'  => 'text-large'
          // ),
          // array(
          //   'title'    => __('Medium', 'studioyacine'),
          //   'selector'  => 'p',
          //   'classes'  => 'text-medium'
          // )
        ),
      ),
    );

    // Merge old & new styles
    $settings['style_formats_merge'] = true;

    // Add new styles
    $settings['style_formats'] = json_encode($new_styles);
    $settings['block_formats'] = 'Paragraph=p; Header 2=h2; Header 3=h3;';

    // Return New Settings
    return $settings;
  }
}
add_filter('tiny_mce_before_init', 'studioyacine_styles_dropdown');


/*********************
event ARCHIVE FILTER AND CATEGORY POST ORDER
 *********************/
function custom_archive_query__events($query)
{
  $today = date('Y-m-d H:i:s');
  $q_object = get_queried_object();

  if (!is_admin() && $query->is_main_query()) {
    if (is_post_type_archive('event') && !isset($q_object->taxonomy)) {

      $query->set('post_type', array('event'));

      $metaQuery = array(
        'relation' => 'OR',
        array(
          'key'       => 'date',
          'value'     =>  $today,
          'compare'   => 'NOT EXISTS',
        ),
        array(
          'key'       => 'date',
          'value'     =>  $today,
          'compare'   => '<',
        )
      );
      $query->set('meta_query', $metaQuery);
      $query->set('order', 'asc');
    }
  }
  return $query;
}
add_filter('pre_get_posts', 'custom_archive_query__events');












/*******************************************************************************
Add columns to event post list
 *******************************************************************************/

/*********************
ADD COLUMN LABELS
 *********************/
add_filter('manage_event_posts_columns', 'add_acf_columns');
function add_acf_columns($columns)
{
  return array_merge($columns, array(
    'event_date' => __('Event date')
  ));
}

/*********************
ADD COLUMN DATA
 *********************/
add_action('manage_event_posts_custom_column', 'event_custom_column', 10, 2);
function event_custom_column($column, $post_id)
{
  switch ($column) {
    case 'event_date':
      $oldDate = get_post_meta($post_id, 'date', true);
      if ($oldDate) {
        echo date("d M, Y", strtotime($oldDate));
      }
      break;
  }
}


add_filter('manage_edit-event_sortable_columns', 'make_event_sortable_columns');
function make_event_sortable_columns($columns)
{
  $columns['event_date'] = 'date';
  return $columns;
}


add_action('pre_get_posts', 'events_order');
function events_order($query)
{

  // Nothing to do:
  if (!$query->is_main_query() || 'event' != $query->get('post_type'))
    return;

  //-------------------------------------------
  // Modify the 'orderby' and 'meta_key' parts
  //-------------------------------------------
  $orderby = $query->get('orderby');

  switch ($orderby) {
    case 'date':
      $query->set('orderby',  'meta_value');
      $query->set('meta_key', 'date');
      $query->set('meta_type', 'date');
      break;
    default:
      break;
  }
}














/*********************
SUBMENU TOGGLE BUTTON
 *********************/

function yourprefix_menu_arrow($item_output, $item, $depth, $args)
{
  if (in_array('menu-item-has-children', $item->classes)) {
    $arrow = '<button class="submenu-toggle"><span class="visuallyhidden">Open</span><svg aria-hidden="true" class="icon"><use xlink:href="#base--chevron-down"></use></svg></button>';
    $item_output = str_replace('</a>', '</a>' . $arrow . '', $item_output);
  }
  return $item_output;
}
add_filter('walker_nav_menu_start_el', 'yourprefix_menu_arrow', 10, 4);

/* DON'T DELETE THIS CLOSING TAG */




/*********************
Yoast SEO Default Article Image
 *********************/

function be_schema_default_image($graph_piece)
{
  $use_default = false;
  if (has_post_thumbnail()) {
    $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
    if (empty($image_src[1]) || 1199 > $image_src[1])
      $use_default = true;
  } else {
    $use_default = true;
  }

  if ($use_default) {
    $graph_piece['image']['@id'] = home_url('#logo');
  }
  return $graph_piece;
}
add_filter('wpseo_schema_article', 'be_schema_default_image');
add_filter('wpseo_schema_webpage', 'be_schema_default_image');


function remove_post_type_page_from_search()
{
  global $wp_post_types;
  $wp_post_types['post']->exclude_from_search = true;
}
add_action('init', 'remove_post_type_page_from_search');


// DISABLE YOAST AUTOMATIC REDIRECTS
add_filter('wpseo_premium_post_redirect_slug_change', '__return_true');
add_filter('wpseo_premium_term_redirect_slug_change', '__return_true');


add_action('init', function () {
  pll_register_string('studioyacine', 'All News');
  pll_register_string('studioyacine', 'All Projects');
  pll_register_string('studioyacine', 'Links');
  pll_register_string('studioyacine', 'Contact');
  pll_register_string('studioyacine', 'Social');
  pll_register_string('studioyacine', 'News');
  pll_register_string('studioyacine', 'Events');
  pll_register_string('studioyacine', 'Upcoming Events');
  pll_register_string('studioyacine', 'Past Events');
});
