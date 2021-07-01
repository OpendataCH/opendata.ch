<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, etc.
*/


//flush_rewrite_rules( false ); //might be needed when setting up new custom post types, that is not displayed

if ( ! class_exists( 'Timber' ) ) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
    });

    add_filter('template_include', function($template) {
        return get_stylesheet_directory() . '/static/no-timber.html';
    });

    return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

    function __construct() {
        add_theme_support( 'post-formats' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'menus' );
        add_filter( 'timber_context', array( $this, 'add_to_context' ) );
        add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
        add_action( 'init', array( $this, 'register_post_types' ) );
        add_action( 'init', array( $this, 'register_taxonomies' ) );
        parent::__construct();
    }

    function register_post_types() {
        //this is where you can register custom post types
    }

    function register_taxonomies() {
        //this is where you can register custom taxonomies
    }

    function add_to_context( $context ) {
        $context['foo'] = 'bar';
        $context['stuff'] = 'I am a value set in your functions.php file';
        $context['notes'] = 'These values are available everytime you call Timber::get_context();';
        $context['menu'] = new TimberMenu();
        $context['site'] = $this;
        return $context;
    }

    function myfoo( $text ) {
        $text .= ' bar!';
        return $text;
    }

    function add_to_twig( $twig ) {
        /* this is where you can add your own functions to twig */
        $twig->addExtension( new Twig_Extension_StringLoader() );
        $twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
        return $twig;
    }

}

new StarterSite();

//LOAD EMBERA FOR VIDEO
require 'library/php/Embera/Autoload.php' ;

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
  $content_width = 680;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes

add_image_size( 'ptf-jury', 400, 400, true );
add_image_size( 'ptf-project', 450, 450, true );
add_image_size( 'ptf-news', 450, 450, true );

add_image_size('ptf-16x9_large', 1200, 675, true);
add_image_size('ptf-16x9_small', 800, 450, true);
add_image_size('ptf-4x3_large', 1200, 900, true);
add_image_size('ptf-4x3_small', 800, 600, true);

  /************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
  function bones_register_sidebars() {
    register_sidebar(array(
      'id' => 'sidebar1',
      'name' => __( 'Sidebar 1', 'bonestheme' ),
      'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
      ));
}

//Attachements
add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance

/*----------  Social Media Menu  ----------*/

register_nav_menus(
  array(
        'social-nav' => __( 'The Social Media Menu', 'bonestheme' ),   // main nav in header
        'canvas-nav' => __( 'The Canvas Menu', 'bonestheme' ),   // canvas nav in header
        'sharer-nav' => __( 'The Sharer Menu', 'bonestheme' ),   // sahrer nav in header
        'apply-nav' => __( 'The Apply Menu', 'bonestheme' ), // apply button
        'blog-nav' => __( 'The Blog Menu', 'bonestheme' ), // news button
        'project-nav' => __( 'The Project Menu', 'bonestheme' ), // news button
        'footer-nav' => __( 'The Footer Menu', 'bonestheme' ) // impressum
        )
  );

// make the menus available in timber
function add_to_context($data){

  $data['mainnav'] = new TimberMenu('main-nav');
  $data['canvasnav'] = new TimberMenu('canvas-nav');
  $data['sharernav'] = new TimberMenu('sharer-nav');
  $data['applynav'] = new TimberMenu('apply-nav');
  $data['blognav'] = new TimberMenu('blog-nav');
  $data['projectnav'] = new TimberMenu('project-nav');
  $data['footernav'] = new TimberMenu('footer-nav');

  require_once 'library/php/Mobile_Detect.php';
  $detect = new Mobile_Detect;
  $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

  $data['deviceType'] = $deviceType;

  return $data;
}
add_filter('timber_context', 'add_to_context');

/*----------  Option Pages  ----------*/
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page();
}

/*----------  ACF geolocation api key  ----------*/
function my_acf_google_map_api( $api ){

    $api['key'] = '';

    return $api;

}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

/*ALLOW SVG UPLOAD*/
function allow_svgimg_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'allow_svgimg_types');

    function ignore_upload_ext($checked, $file, $filename, $mimes){

        //we only need to worry if WP failed the first pass
        if(!$checked['type']){
            //rebuild the type info
            $wp_filetype = wp_check_filetype( $filename, $mimes );
            $ext = $wp_filetype['ext'];
            $type = $wp_filetype['type'];
            $proper_filename = $filename;

            //preserve failure for non-svg images
            if($type && 0 === strpos($type, 'image/') && $ext !== 'svg'){
                $ext = $type = false;
            }

            //everything else gets an OK, so e.g. we've disabled the error-prone finfo-related checks WP just went through. whether or not the upload will be allowed depends on the upload_mimes, etc.

            $checked = compact('ext','type','proper_filename');
        }

        return $checked;
    }
    add_filter('wp_check_filetype_and_ext', 'ignore_upload_ext', 10, 4);

/************* CUSTOM FUNCTIONS *********************/

    require "library/php/vendor/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;
    use enshrined\svgSanitize\Sanitizer;

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}


    /**
     * Return the remaining day till deadline
     */
    function is_deadline_reached(){
        $deadline_date = get_field('deadline_date', 'options', false, false);
        $deadline_date = new DateTime($deadline_date);
        $deadline_date_format = $deadline_date->format('Y-m-d');

        $upcoming_date = get_field('upcoming_date', 'options', false, false);
        $upcoming_date = new DateTime($upcoming_date);
        $upcoming_date_format = $upcoming_date->format('Y-m-d');

        $now = current_time('Y-m-d');
        $diff=date_diff(date_create($now),date_create($deadline_date_format));
        $diff_upcoming=date_diff(date_create($now),date_create($upcoming_date_format));

        if($diff_upcoming->days > 0 && $diff_upcoming->invert == 0){
            return true;
        }

        if($diff->days > 1 && $diff->invert == 0 || $diff->days == 1 && $diff->invert == 0 || $diff->days == 0){
            return false;
        } else {
            return true;
        }

    }

/**
 * This function calculates the days to go till deadline and will return a formatted result-string accordingly
 */
function calc_deadline(){

  $deadline_date = get_field('deadline_date', 'options', false, false);
  $deadline_date = new DateTime($deadline_date);
  $deadline_date_format = $deadline_date->format('Y-m-d');

    $upcoming_date = get_field('upcoming_date', 'options', false, false);
    $upcoming_date = new DateTime($upcoming_date);
    $upcoming_date_format = $upcoming_date->format('Y-m-d');

  $deadline_text = get_field('deadline_text', 'options');
  $upcoming_text = get_field('upcoming_text', 'options');
  $deadline_text_today = get_field('deadline_text_today', 'options');
  $deadline_text_over = get_field('deadline_text_over', 'options');
  $deadline_text_singular = get_field('deadline_text_singular', 'options');
  $deadline_text_plural = get_field('deadline_text_plural', 'options');

  $now = current_time('Y-m-d');

  $diff=date_diff(date_create($now),date_create($deadline_date_format));
  $diff_upcoming=date_diff(date_create($now),date_create($upcoming_date_format));

    //var_dump($diff->days);
    //var_dump($diff_upcoming->invert);

    if($diff_upcoming->days > 0 && $diff_upcoming->invert == 0){

        if($diff_upcoming->days > 1){

            $str = $diff_upcoming->days . ' ' . $deadline_text_plural;
            $result = str_replace('[[value]]',$str,$upcoming_text);

        } else {

            $str = $diff_upcoming->days . ' ' . $deadline_text_singular;
            $result = str_replace('[[value]]',$str,$upcoming_text);

        }

    } else {

        if($diff->days > 1 && $diff->invert == 0){
            //some days to go
            $str = $diff->days . ' ' . $deadline_text_plural;
            $result = str_replace('[[value]]',$str,$deadline_text);

        } else if($diff->days == 1 && $diff->invert == 0){
            //tomorrow
            $str = $diff->days . ' ' . $deadline_text_singular;
            $result = str_replace('[[value]]',$str,$deadline_text);

        } else if($diff->days == 0){
            //today
            $result = $deadline_text_today;
        } else {
            //deadline reached - show upcoming date
            $str = $diff_upcoming->days . ' ' . $deadline_text_plural;
            $result = str_replace('[[value]]',$str,$upcoming_text);
        }
    }

  return $result;

}
    /**
     * Returns the projects
     */
    function get_adjacent_project($post_id, $direction){

        if(!isset($_COOKIE['ptf-final-filters_'.ICL_LANGUAGE_CODE])) {
            $filters = NULL;
        } else {
            $temp_filters = ltrim($_COOKIE['ptf-final-filters_'.ICL_LANGUAGE_CODE], '.');
            $temp_filters = explode(".", $temp_filters);
            $filters = implode(',',$temp_filters);
        }

        $projects = get_projects($filters);

        //var_dump($projects);

        $prev_post = '';
        $next_post = '';
        foreach ($projects as $index => $project) {
            if($project->ID == $post_id){

                if(isset($projects[$index+1])){
                    $next_id = $projects[$index+1]->ID;
                    $next_post = new TimberPost($next_id);
                } else {
                    //last
                    $next_id = $projects[0]->ID;
                    $next_post = new TimberPost($next_id);
                }

                if(isset($projects[$index-1])){
                    $prev_id = $projects[$index-1]->ID;
                    $prev_post = new TimberPost($prev_id);
                } else {
                    //first
                    $prev_id = $projects[count($projects)-1]->ID;
                    $prev_post = new TimberPost($prev_id);
                }
            }
        }

        if($direction == 'next'){
            return $next_post;
        } else return $prev_post;

    }

/**
 * Returns the rounds for the language
 */
function get_rounds($rounds, $choices){
    $rounds_array = array();
    //query the single round page
    $args = array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_wp_page_template',
                'value' => 'page-projects-2020.php', // template name as stored in the dB
            ),
        )
    );

    $round_pages = get_posts($args);

    if(is_array($rounds)){
        foreach($rounds as $round){

            $round_filter = array();

            if (strpos($round, 'round') !== false) {
                $pos = strpos($round, '_');
                $round_id = substr($round, intval($pos)+1);

                if(ICL_LANGUAGE_CODE == 'de'){
                    $round_filter['title'] = 'Runde ' . $round_id;
                } else $round_filter['title'] = 'Round ' . $round_id;

                $round_filter['slug'] = $round;
            } else {
                //virus round

                $round_filter['title'] = $choices[$round];
                $round_filter['slug'] = $round;
            }

            $projects = get_posts($args);

            //there are projects for this round
            foreach($round_pages as $page){
                $r = get_field('round',$page->ID);
                if(is_array($r) && count($r) > 1){
                    //this is all projects page
                    break;
                }
                if(is_array($r)){
                    $r = $r[0];
                }
                if($r == $round){
                    $round_filter['url'] = get_permalink($page->ID);
                    $rounds_array[] = $round_filter;
                }
            }
        }
    }

    return $rounds_array;
}


/**
* Returns the projects
*/
function get_projects($rounds){

    //get all projects

    $projects_extended = array();

    $meta_query = array();
    $meta_query['relation'] = 'OR';

    if(is_array($rounds)){
        foreach($rounds as $round){
            $query = array();
            $query['key'] = 'round';
            $query['compare'] = 'LIKE';
            $query['value'] = $round;
            $meta_query[] = $query;
        }
    }

    $args = array(
        'post_type' => 'project',
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
        'posts_per_page' => -1,
        'meta_query' => $meta_query
    );

    $projects = Timber::get_posts($args);

    foreach ($projects as $post) {
        $post = extendProjectPost($post);
        $projects_extended[] = $post;
    }
    return $projects_extended;

}

function extendProjectPost($post){

    $embera = new \Embera\Embera();

    //categories
    $cats = get_project_categories($post->ID);
    $cats_slugs = [];
    foreach($cats as $cat){
        $cats_slugs[] = $cat['slug'];
    }
    $post->filters = implode(' ',$cats_slugs);
    $post->cats = get_project_categories($post->ID,true);

    //round
    $round = get_field('round',$post->ID);
    if(is_array($round)){
        $round = $round[0];
    }

    $pos = strpos($round, '_');
    $round_id = substr($round, intval($pos)+1);
    if(ICL_LANGUAGE_CODE == 'de'){
        $post->project_round = 'Runde ' . $round_id;
    } else $post->project_round = 'Round ' . $round_id;

    //get the video embed code
    $url = get_field('video_embed_url',$post->ID);
    $post->video_embed = $embera->autoEmbed($url);

    return $post;

}

    /**
     * Returns all rounds for filtering
     */
    function get_projects_rounds_filters(){
        //get all projects
        $args = array(
            'post_type' => 'project',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        //get all projects
        $projects = Timber::get_posts($args);

        $projects_rounds = [];
        if($projects){
            foreach ($projects as $post) {

                //get filters ROUNDS
                $cats = get_project_round($post->ID);

                foreach ($cats as $cat) {
                    if(count($projects_rounds)>0){
                        $found=false;
                        foreach ($projects_rounds as $project_cat) {
                            if($cat['slug'] === $project_cat['slug']) $found = true;
                        }
                        if(!$found) $projects_rounds[] = $cat;
                    } else {
                        //first round added
                        $projects_rounds[] = $cat;
                    }
                }
            }
        }


        sort_array_of_array($projects_rounds, 'name');
        return $projects_rounds;

    }

/**
* Returns all categories used by projects
*/
function get_projects_filters($round_slug){
    //get all projects
    $args = array(
        'post_type' => 'project',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    if(isset($round_slug)){
        $slugs = explode(",", $round_slug);
        $add_args = array(
            'tax_query' => array(
                array (
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $slugs,
                )
            ),
        );
        $args = wp_parse_args( $add_args, $args );
    }

    $projects = Timber::get_posts($args);

    $projects_categories = [];
    foreach ($projects as $post) {

        //get filters without ROUNDS
        $cats = get_project_categories($post->ID, true);

        foreach ($cats as $cat) {
            if(count($projects_categories)>0){
                $found=false;
                foreach ($projects_categories as $project_cat) {
                    if($cat['slug'] === $project_cat['slug']) $found = true;
                }
                if(!$found){
                    $projects_categories[] = $cat;
                }
            } else {
                //first category
                $projects_categories[] = $cat;
            }
        }

    }

    sort_array_of_array($projects_categories, 'name');
    return $projects_categories;
}

    /*********************
    Sort array of arrays by subfield
    *********************/
    function sort_array_of_array(&$array, $subfield)
    {
        $sortarray = array();
        foreach ($array as $key => $row)
        {
            $sortarray[$key] = $row[$subfield];
        }

        array_multisort($sortarray, SORT_ASC, $array);
    }

/**
 * This function will return a unix_time sorted array of object containing tweets by ptf,
 * related tweets by searchstring and blogposts from Wordpress.
 * It will load content from a cached JSON file, if cachetime is is below defined time
 */
function get_twitterfeed(){
    //twitter
    $consumer_key = 'U8ThkInNyNVHFHLJ5n2t4MmOb';
    $consumer_secret = 'FX6Ldqh8ncHy6QbhErqDaa2Lo7QYWT19BEbWJ9a26Vj3HvTOT0';
    $accesstoken = '';
    $accesstokensecret = '';

    $twitter_username = get_field('twitter_username', 'options');
    $twitter_hash = get_field('twitter_hash', 'options');

    //caching
    $cache_file = realpath(dirname(__FILE__)) . '/cache/news-posts.json';
    $cachetime           = 60*10; // Seconds to cache feed (10 minutes).

    // Time that the cache was last updated.
    $cache_file_created  = ((file_exists($cache_file))) ? filemtime($cache_file) : 0;

    // Show cached version of tweets, if it's less than $cachetime.
    if (time() - $cachetime < $cache_file_created) {

        // Display tweets from the cache.
        $twitter_posts = file_get_contents($cache_file);
        $twitter_posts = json_decode($twitter_posts);

    } else {

        // Cache file not found, or old. Authenticate app.
        $connection = getConnectionWithAccessToken($consumer_key, $consumer_secret, $accesstoken, $accesstokensecret);

        $related_tweets = $connection->get("search/tweets",
            ["q" => $twitter_hash .  " -filter:retweets",
                "count" => 25]);

        $ptf_tweets = $connection->get("statuses/user_timeline",
            ["screen_name" => $twitter_username,
                "include_rts" => 0,
                "count" => 25 ]);


        //this will store all collected posts
        $twitter_posts = [];

        //collect needed data from PTF TWEETS
        if(count($ptf_tweets) > 0){
            foreach ($ptf_tweets as $tweet) {

                $tweet = parseTweetEntityLinks($tweet);

                $obj = new stdClass();
                $obj->type = 'twitter-ptf';
                $obj->created_at = $tweet->created_at;
                $obj->time_passed = timePassedSinceDate($obj->created_at);
                $obj->unix_time = strtotime($tweet->created_at);
                $obj->text = $tweet->text;
                $obj->id = $tweet->id_str; //id_str is correct one
                $obj->username = $tweet->user->screen_name;
                $obj->user = $tweet->user;
                $obj->url = 'https://twitter.com/intent/retweet?tweet_id=' . $obj->id;
                $twitter_posts[] = $obj;

            }
        }

        //collect needed data from RELATED TWEETS

        if(count($related_tweets->statuses) > 0){
            foreach ($related_tweets->statuses as $tweet) {

                $tweet = parseTweetEntityLinks($tweet);

                $obj = new stdClass();
                $obj->type = 'twitter-related';
                $obj->created_at = $tweet->created_at;
                $obj->time_passed = timePassedSinceDate($obj->created_at);
                $obj->unix_time = strtotime($tweet->created_at);

                //d($obj->unix_time);

                $obj->text = $tweet->text;
                $obj->id = $tweet->id_str; //id_str is correct one
                $obj->username = $tweet->user->screen_name;
                $obj->user = $tweet->user;
                $obj->url = 'https://twitter.com/intent/retweet?tweet_id=' . $obj->id;
                //$obj->url = 'https://twitter.com/' . $obj->user . '/status/tweet-id-str' . $obj->id;

                //check if post with this ID already exists
                $found = false;
                foreach($twitter_posts as $post){
                    if($post->id == $obj->id) $found = true;
                }
                if(!$found) $twitter_posts[] = $obj;
            }
        }


        // Generate new cache files.
        $file_ptf = fopen($cache_file, 'w');
        fwrite($file_ptf, json_encode($twitter_posts));
        fclose($file_ptf);

    }//end twitter fetch

    //sort the posts by unix_time
    usort($twitter_posts, 'sort_posts_by_unix_time');
    //done
    return $twitter_posts;
}

/**
 * This function will return the WP blogposts
 */
function get_newsfeed(){

    //wordpress blogposts
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    $posts = Timber::get_posts($args);
    $posts_extended = array();
    foreach ($posts as $post) {
        $cat_ids = wp_get_post_categories($post->ID);
        $cats = array();
        foreach ($cat_ids as $id) {
            $category = get_category($id);
            $cats[] = $category;
        }
        $post->cats = $cats;
        $post->type = 'wp-blogpost';
        $posts_extended[] = $post;
    }

    //done
    return $posts_extended;
}

/**
 * This sorts our posts by unix_date
 */
function sort_posts_by_unix_time($b, $a) {
  if($a->unix_time == $b->unix_time){ return 0 ; }
  return ($a->unix_time < $b->unix_time) ? -1 : 1;
}

    /**
     * @param array      $array
     * @param int|string $position
     * @param mixed      $insert
     */
    function array_insert(&$array, $position, $insert)
    {
        if (is_int($position)) {
            array_splice($array, $position, 0, $insert);
        } else {
            $pos   = array_search($position, array_keys($array));
            $array = array_merge(
                array_slice($array, 0, $pos),
                $insert,
                array_slice($array, $pos)
            );
        }
        return $array;
    }

/**
 * addTweetEntityLinks
 *
 * adds a link around any entities in a twitter feed
 * twitter entities include urls, user mentions, and hashtags
 *
 * @param      object $tweet a JSON tweet object v1.1 API
 * @return     string tweet
 */
function parseTweetEntityLinks( $tweet )
{
  $replace_index = array();
  if ( isset($tweet->entities) ) {
    foreach ($tweet->entities as $area => $items) {
      switch ( $area ) {
        case 'hashtags':
        $find = 'text';
        $prefix = '#';
        $url = 'https://twitter.com/search/?src=hash&q=%23';
        break;
        case 'user_mentions':
        $find = 'screen_name';
        $prefix = '@';
        $url = 'https://twitter.com/';
        break;
        case 'media': case 'urls':
        $find = 'display_url';
        $prefix = '';
        $url = '';
        break;
        default: break;
      }
      foreach ($items as $item) {
        $text = $tweet->text;
        if($area == 'urls') {
          $replace = mb_substr($text,$item->indices[0],$item->indices[1]-$item->indices[0]);
          $with = '<a class="word-break" href="'.$item->expanded_url.'" target="_blank">'.$item->display_url.'</a>';
        } else {
          $string = $item->$find;
          $href = $url.$string;
          if ($area != "hashtags" && $area != "user_mentions" && (!(strpos($href, 'https://') === 0) || !(strpos($href, 'http://') === 0)) ) $href = "http://".$href;
          $replace = mb_substr($text,$item->indices[0],$item->indices[1]-$item->indices[0]);

          if($area == 'media' || $area == 'urls'){
            $with = "<a class=\"word-break\" href=\"$href\" target=\"_blank\">{$prefix}{$string}</a>";
          } else $with = "<a href=\"$href\" target=\"_blank\">{$prefix}{$string}</a>";


        }
        $replace_index[$replace] = $with;
      }
    }
    foreach ($replace_index as $replace => $with) $tweet->text = str_replace($replace,$with,$tweet->text);
  }
  return $tweet;

} // end addTweetEntityLinks()

/**
 * timePassedSinceDate
 *
 * adds a link around any entities in a twitter feed
 * twitter entities include urls, user mentions, and hashtags
 *
 * @param      $time converted with strtotime()
 */
function timePassedSinceDate ($timestamp)
{
    $timestamp = strtotime($timestamp);

    $time = current_time('timestamp') - $timestamp; // to get the time since that moment

    $time = ($time<1)? 1 : $time;

    return date("d.M Y",$timestamp);

    $tokens = array (
      31536000 => 'year',
      2592000 => 'mth',
      604800 => 'week',
      86400 => 'd',
      3600 => 'h',
      60 => 'min',
      1 => 'sec'
      );

    if($time < 2592000 && $time >= 604800){
        //more then a week, less then a month
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            if($time > 604800){
                return '· ' . $numberOfUnits.$text.(($numberOfUnits>1)?'s':'');
            } else return '· ' . $numberOfUnits.$text.(($numberOfUnits>1)?'':'');

        }

    } else if($time < 604800){
        //less then a week
      foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        if($time < 3600){
          return '· ' . $numberOfUnits.$text.(($numberOfUnits>1)?'s':'');
        } else return '· ' . $numberOfUnits.$text.(($numberOfUnits>1)?'':'');

      }
    } else {
        //more than a month
      return '· ' . date("d.M Y",$timestamp);
    }



  }
/**
 * shortenString
 *
 * shorten a string to given length for the news area
 *
 */
function shortenString($title = '', $before = '', $after = '...', $length = false) {

  if ( $length && is_numeric($length) ) {
    $length = $length - count($before) - count($after);
    $title = substr( $title, 0, $length );
  }

  if ( strlen($title)> 0 ) {
    $title = apply_filters('shortenString', $before . $title . $after, $before, $after);
    return $title;
  }
}



/**
 * Save an image to media library and create post with attachment
 */
function upload_p_file($filename,$type) {

 if( !function_exists( 'wp_handle_sideload' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
  }

  if( !function_exists( 'wp_get_current_user' ) ) {
    require_once( ABSPATH . 'wp-includes/pluggable.php' );
  }

  $upload_dir       = wp_upload_dir();
  $upload_path      = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

    // @new
  $file             = array();
  $file['error']    = '';
  $file['tmp_name'] = $upload_path . $filename;
  $file['name']     = $filename;
  $file['type']     = $type;
  $file['size']     = filesize( $upload_path . $filename );

    // upload file to server
  $file_return      = wp_handle_sideload( $file, array( 'test_form' => false ) );
  return $file_return;

}

function create_p_attachment($file,$postId) {

      require_once(ABSPATH . 'wp-admin/includes/image.php');

      $upload_dir       = wp_upload_dir();

        $attachment = array(
          'post_mime_type' => $file['type'],
          'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['file'])),
          'post_content' => '',
          'post_status' => 'publish',
          'guid' => $upload_dir['url'] . '/' . basename($file['file'])
          );

        $attach_id = wp_insert_attachment( $attachment, $file['file'], $postId );
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file['file'] );
        wp_update_attachment_metadata( $attach_id, $attach_data );

        return $attach_id;
}


    function get_project_round($id){
        $post_categories = wp_get_post_categories( $id );
        $cats = array();
        foreach($post_categories as $c){
            $cat = get_category( $c );
            $link = get_category_link( $cat );

            if (strval(strpos($cat->slug, 'round')) == "0") {
                $cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug , 'link' => $link);
            }
        }
        return $cats;
    }

function get_project_categories($id,$filterRounds=false){
    $post_categories = get_the_terms( $id, 'projectcategory' );
    $cats = array();
    if(is_array($post_categories)){
        foreach($post_categories as $c){
            $cat = get_category( $c );
            $link = get_category_link( $cat );
            if($filterRounds){
                if (strpos($cat->slug, 'round') === false) {
                    $cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug , 'link' => $link, 'description' => $cat->description );
                }
            } else {
                $cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug , 'link' => $link, 'description' => $cat->description );
            }
        }
    }

    return $cats;
}

function create_user_submission( $data ) {

  $post_title='user-submission_'.current_time('Y-m-d_H-i-s');

  $filenameBase = 'user-svg_'.date('Y-m-d_H-i-s');

  $filename= $filenameBase . '.svg';

  $upload_dir       = wp_upload_dir();
  $upload_path      = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

  $decoded          = base64_decode( $data['svg']) ;

    // Create a new sanitizer instance
    $sanitizer = new Sanitizer();
    // Pass it to the sanitizer and get it back clean
    $cleanSVG = $sanitizer->sanitize($decoded);

  $hashed_filenameBase  = md5( $filenameBase . microtime() ) . '_' . $filenameBase;
  $hashed_filename  = $hashed_filenameBase . '.svg';

  $image_upload     = file_put_contents( $upload_path . $hashed_filename, $cleanSVG );

  $file_return = upload_p_file( $hashed_filename ,'image/jpg');

    //return error if there is one
  if(isset($file_return['error']) || isset($file_return['upload_error_handler'])) {

    $return = array(
      'status'  =>  'error'
      );

  } else {

    //create post
    $post_id = wp_insert_post( array(
      'post_title'        => $post_title,
      'post_status'       => 'publish',
      'post_type'         => 'user_submission',
      'post_author'       => 5
      ));

    //create attachment
    $attach_id = create_p_attachment($file_return,$post_id);

    set_post_thumbnail( $post_id, $attach_id );

    $attachmentURL = wp_get_attachment_url( $attach_id );
      $return = array(
          'status'  =>  'success',
          'filename'  =>   $attachmentURL,
          'url'  =>  get_post_permalink( $post_id )
      );

    // PNG conversion
      /*
    require_once('library/php/svg2png/svg2pngPhantomJS.php');

    try {

      $svg2png = new svg2png();
      $pngUrl = $svg2png->generatePng('file://' . get_attached_file($attach_id) , $upload_path . $hashed_filenameBase . '.png');

      $file_return = upload_p_file( $hashed_filenameBase . '.png' ,'image/png');

      //return error if there is one
      if(isset($file_return['error']) || isset($file_return['upload_error_handler'])) {

        $return = array(
          'status'  =>  'error'
          );

        error_log("Error uploading PNG to wordpress");

      } else {

        $attach_id = create_p_attachment($file_return,$post_id);

        update_field('png',$attach_id,$post_id);

        $return = array(
          'status'  =>  'success',
          'filename'  =>   $attachmentURL,
          'url'  =>  get_post_permalink( $post_id )
          );
      }

    } catch (Exception $e) {

        error_log($e->getMessage());
        $return = array(
          'status'  =>  'error'
        );
    }*/

  }

  return $return;
}

//create our custom root
add_action( 'rest_api_init', function () {
  register_rest_route( 'ptf/v1', '/create-submission', array(
    'methods' => 'POST',
    'callback' => 'create_user_submission',
    ) );
} );

//remove admin bar margin-top for logged in users on page
function my_admin_bar_init() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('admin_bar_init', 'my_admin_bar_init');


    function ptf_get_template( $atts ) {

        if(!empty($atts['type'])){
            ob_start();
            get_template_part( 'ptf/template', $atts['type'] );
            return ob_get_clean();

        } else {
            return 'Err. Please specify markup to retrieve.';
        }

    }
    add_shortcode( "ptf-template", "ptf_get_template" );


    function randomproject_scripts() {
            wp_enqueue_script( 'script-name', get_template_directory_uri() . '/library/js/utils/FetchRandomProjects.js', array('jquery'), '1.0.0', true );
            wp_localize_script( 'script-name', 'ptf_ajax', array(
                // URL to wp-admin/admin-ajax.php to process the request
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                // generate a nonce with a unique ID "myajax-post-comment-nonce"
                // so that you can check it later when an AJAX request is sent
                'security' => wp_create_nonce( 'my-special-string' )
            ));
    }
    add_action( 'wp_enqueue_scripts', 'randomproject_scripts' );

    // The function that handles the AJAX request

    function fetch_random_projects_callback() {
        check_ajax_referer( 'my-special-string', 'security' );

        $args = array(
            'post_type' => 'project',
            'posts_per_page' => 3,
            'orderby' => 'rand'
        );

        $posts = get_posts($args);
        foreach($posts as $post){
            $post->permalink = get_permalink($post->ID);
            $post->claim = get_field('content1',$post->ID);
        }
        echo json_encode($posts);

        wp_die();


    }
    add_action( 'wp_ajax_fetch_random_projects', 'fetch_random_projects_callback' );
    add_action('wp_ajax_nopriv_fetch_random_projects', 'fetch_random_projects_callback');

    function add_acf_columns ( $columns ) {
        return array_merge ( $columns, array (
            'event' => __ ( 'Event' )
        ) );
    }
    add_filter ( 'manage_ct_participant_posts_columns', 'add_acf_columns' );

    function ct_participant_custom_column ( $column, $post_id ) {
        switch ( $column ) {
            case 'event':
                echo get_field('event',$post_id);
                break;
        }
    }
    add_action ( 'manage_ct_participant_posts_custom_column', 'ct_participant_custom_column', 10, 2 );

    /**
     * Filter the mail content type.
     */
    function set_html_mail_content_type() {
        return 'text/html';
    }

    /*********************
    send email on participant entry
     *********************/
    add_action( 'transition_post_status', 'send_mails_on_publish', 10, 3 );

    function send_mails_on_publish( $new_status, $old_status, $post )
    {

        if ( 'publish' !== $new_status or 'publish' === $old_status
            or 'ct_participant' !== get_post_type( $post ) )
            return;

        add_filter( 'wp_mail_content_type', 'set_html_mail_content_type' );

        $emails      = array ();
        // check if the repeater field has rows of data
        if( have_rows('email_users','option') ):

            // loop through the rows of data
            while ( have_rows('email_users','option') ) : the_row();

                // display a sub field value
                $user = get_sub_field('user');
                $emails[] = $user['user_email'];

            endwhile;

        endif;


        ob_start();
        set_query_var( 'post_id', absint( $post->ID ) );
        set_query_var( 'the_post', $_POST );
        get_template_part( 'ptf/template', 'email' );
        $body = ob_get_clean();

        wp_mail( $emails, '[ ' . $_POST['event'] . ' ] Neue Teilnehmerregistrierung', $body );

        remove_filter( 'wp_mail_content_type', 'set_html_mail_content_type' );

    }

    function get_youtube_video_id($url){
        $matches = array();
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
        if(count($matches)>1){
            return $matches[1];
        } else return '';
    }

    function get_video_embedable_url( $link ) {
        $id = '';
        if (strpos($link, 'youtube') !== false || strpos($link, 'youtu.be') !== false) {
            $id = "https://www.youtube.com/embed/".parse_youtube($link);
        } else if(strpos($link, 'vimeo') !== false){
            //no parsing for now
            $id = "https://player.vimeo.com/video/".parse_vimeo($link);
        }
        return $id;
    }

    function get_video_poster_url( $link ) {
        $id = '';
        $poster_url = '';
        if (strpos($link, 'youtube') !== false || strpos($link, 'youtu.be') !== false) {
            $id = parse_youtube($link);
            $poster_url = get_youtube_poster($id);
        } else if(strpos($link, 'vimeo') !== false){
            //no parsing for now
            $id = parse_vimeo($link);
            $poster_url = get_vimeo_poster($id);
        }
        return $poster_url;
    }

    function get_youtube_poster($id){
        return 'https://img.youtube.com/vi/'.$id.'/0.jpg';
    }

    function get_vimeo_poster($id){
        $data = file_get_contents("http://vimeo.com/api/v2/video/$id.json");
        $data = json_decode($data);
        return $data[0]->thumbnail_large;
    }

    function parse_youtube($link){

        $regexstr = '~
			# Match Youtube link and embed code
			(?:				 				# Group to match embed codes
				(?:&lt;iframe [^&gt;]*src=")?	 	# If iframe match up to first quote of src
				|(?:				 		# Group to match if older embed
					(?:&lt;object .*&gt;)?		# Match opening Object tag
					(?:&lt;param .*&lt;/param&gt;)*  # Match all param tags
					(?:&lt;embed [^&gt;]*src=")?  # Match embed tag to the first quote of src
				)?				 			# End older embed code group
			)?				 				# End embed code groups
			(?:				 				# Group youtube url
				https?:\/\/		         	# Either http or https
				(?:[\w]+\.)*		        # Optional subdomains
				(?:               	        # Group host alternatives.
				youtu\.be/      	        # Either youtu.be,
				| youtube\.com		 		# or youtube.com
				| youtube-nocookie\.com	 	# or youtube-nocookie.com
				)				 			# End Host Group
				(?:\S*[^\w\-\s])?       	# Extra stuff up to VIDEO_ID
				([\w\-]{11})		        # $1: VIDEO_ID is numeric
				[^\s]*			 			# Not a space
			)				 				# End group
			"?				 				# Match end quote if part of src
			(?:[^&gt;]*&gt;)?			 			# Match any extra stuff up to close brace
			(?:				 				# Group to match last embed code
				&lt;/iframe&gt;		         	# Match the end of the iframe
				|&lt;/embed&gt;&lt;/object&gt;	        # or Match the end of the older embed
			)?				 				# End Group of last bit of embed code
			~ix';

        preg_match($regexstr, $link, $matches);

        return $matches[1];

    }

    function parse_vimeo($link){

        $regexstr = '~
			# Match Vimeo link and embed code
			(?:&lt;iframe [^&gt;]*src=")?		# If iframe match up to first quote of src
			(?:							# Group vimeo url
				https?:\/\/				# Either http or https
				(?:[\w]+\.)*			# Optional subdomains
				vimeo\.com				# Match vimeo.com
				(?:[\/\w]*\/videos?)?	# Optional video sub directory this handles groups links also
				\/						# Slash before Id
				([0-9]+)				# $1: VIDEO_ID is numeric
				[^\s]*					# Not a space
			)							# End group
			"?							# Match end quote if part of src
			(?:[^&gt;]*&gt;&lt;/iframe&gt;)?		# Match the end of the iframe
			(?:&lt;p&gt;.*&lt;/p&gt;)?		        # Match any title information stuff
			~ix';

        preg_match($regexstr, $link, $matches);

        return $matches[1];

    }

    /*********************
    parse a shortcode  ie [ru-template type=testimonials]
     *********************/
    function ru_get_template( $atts ) {

        if(!empty($atts['type'])){
            ob_start();

            get_template_part( 'shortcode', $atts['type'] );
            return ob_get_clean();

        } else {
            return 'Err. Please specify markup to retrieve.';
        }

    }
    add_shortcode( "ru-template", "ru_get_template" );

    add_filter( 'wpseo_metabox_prio', function() { return 'low'; } );


function wwp_custom_query_vars_filter($vars) {
    $vars[] .= 'filter';
    $vars[] .= 'topics';
    return $vars;
}
add_filter( 'query_vars', 'wwp_custom_query_vars_filter' );


/*********************
Modify the navigation items and alter them if the contain filter logic for projects/blogposts
*********************/
add_filter( 'wp_get_nav_menu_items','nav_items', 11, 3 );
function nav_items( $items, $menu, $args )
{
    if( is_admin() ){
        return $items;
    }

    foreach( $items as $item ) {


        $filter='';
        $filter_blog='';
        foreach($item->classes as $class){

            //check for projects filters
            if (strpos($class, 'nav-filter-') !== false) {
                $pos = strpos($class, 'nav-filter-');
                $lastIndex = strripos($class, '-');
                $filter = substr($class, $lastIndex+1, strlen($class)-1);
            }
            //check for blog filters
            if (strpos($class, 'nav-blog-') !== false) {
                $pos = strpos($class, 'nav-blog-');
                $lastIndex = strripos($class, '-');
                $filter_blog = substr($class, $lastIndex+1, strlen($class)-1);
            }
        }
        if(strlen($filter) > 0){
            $item->url .= '?filter=' . $filter;
        }
        if(strlen($filter_blog) > 0){
            $item->url .= '?filter=topics&topics=' . $filter_blog;
        }



        /*
        if ('Runden' == $item->post_title || 'Rounds' == $item->post_title){
            $item->url .= '?filter=rounds';
        }
        if ('Themen' == $item->post_title || 'Topics' == $item->post_title){
            $item->url .= '?filter=topics';
        }
        if ('Map' == $item->post_title){
            $item->url .= '?filter=map';
        }
        */
    }

    return $items;
}

// The map API endpoint

function api_map_items_home ( $data ) {

    $type = 'project';

    $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        // 'orderby' => 'title',
        // 'order' => 'ASC',
        'posts_per_page' => -1,
    );

    //$projects = get_posts($args);
    //$projects = get_data_from_post_query($projects);

    $page = $data['id'];
    //currently only all project are grapped

    $projects = get_posts($args);
    $projects = get_data_from_post_query($projects);
    $posts = $projects;


    if ( empty($posts ) ) {
        return null;
    }

    return $posts;

}

add_action( 'rest_api_init', function () {

    register_rest_route( 'map', '/home/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'api_map_items_home',
    ) );

    register_rest_route( 'map', '/home/all', array(
        'methods' => 'GET',
        'callback' => 'api_map_items_home',
    ));

} );

function get_data_from_post_query($items){

    $arr = [];
    foreach ($items as $item) {
        $row = [];
        $row['post_id'] = $item->ID;
        $row['post_type'] = $item->post_type;

        $row['post_title'] = $item->post_title;
        $row['post_link'] = get_permalink($item->ID);
        $row['post_thumbnail'] = get_the_post_thumbnail_url($item->ID,'post-thumbnail');

        $row['claim'] = get_field('content1', $item->ID);
        $row['city'] = get_field('city', $item->ID);
        $row['geolocation'] = get_field('geolocation', $item->ID);

        if(get_field('geolocation', $item->ID)){
            $arr[] = $row;
        }

    }
    return $arr;
}

/* DON'T DELETE THIS CLOSING TAG */ ?>
