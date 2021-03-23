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
    $settings['style_formats_merge'] = false;

    // Add new styles
    $settings['style_formats'] = json_encode($new_styles);
    $settings['block_formats'] = 'Paragraph=p; Header 2=h2; Header 3=h3;';

    // Return New Settings
    return $settings;
  }
}
add_filter('tiny_mce_before_init', 'studioyacine_styles_dropdown');


/*********************
EXHIBITION ARCHIVE FILTER AND CATEGORY POST ORDER
 *********************/
function custom_archive_query__events($query)
{
  $today = date('Y-m-d H:i:s');
  $q_object = get_queried_object();

  if (!is_admin() && $query->is_main_query()) {
    if (is_post_type_archive('event') && !isset($q_object->taxonomy)) {

      //   $query = new WP_Query(array(
      //     'tax_query' => array(
      //         array(
      //             'relation' => 'AND',
      //             array(
      //                 'taxonomy' => 'category',
      //                 'terms' => '1',
      //             ),
      //             array(
      //                 'taxonomy' => 'category',
      //                 'field' => 'slug',
      //                 'terms' => 'some-category-slug',
      //                 'operator' => 'NOT IN',
      //             ),
      //         ),
      //     )
      // ));


      $query->set('post_type', array('event'));
      $query->set('meta_key', 'date');
      $query->set('meta_compare', 'NOT EXISTS');
      // $query->set('posts_per_page', '2');
      // $query->set('meta_compare', '<');
      $query->set('meta_value', $today);
      // $query->set('orderby', 'meta_value');
      $query->set('order', 'desc');
      // $taxquery = array(
      //   array(
      //     'taxonomy' => 'exhibition_category',
      //     'field'    => 'term_id',
      //     'terms'    => array( 5 ),
      //     'operator' => 'NOT IN',
      //   )
      // );
      // $query->set( 'tax_query', $taxquery );
    }
  }
  return $query;
}
add_filter('pre_get_posts', 'custom_archive_query__events');

/* DON'T DELETE THIS CLOSING TAG */
