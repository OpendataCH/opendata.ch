<?php
/*
 Template Name: Team Page
 *
 * This is your custom page template. You can create as many of these as you need.
 * Simply name is "page-whatever.php" and in add the "Template Name" title at the
 * top, the same way it is here.
 *
 * When you create your page, you can just select the template and viola, you have
 * a custom page template to call your very own. Your mother would be so proud.
 *
 * For more info: http://codex.wordpress.org/Page_Templates
*/
?>

<?php
//mobile detection
require_once 'library/php/Mobile_Detect.php';
require 'library/php/Embera/Autoload.php' ;

include('partials/base-context.php');

$args = array(
    'post_type' => 'team',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'ignore_sticky_posts'=> 1
);
$context['members'] = Timber::get_posts($args);


$context['members_current'] = array();
$context['members_alumni'] = array();
foreach($context['members'] as $member){
    $cat = get_the_terms($member->ID,'teamtype');
    if(is_array($cat) && $cat[0]->name == 'Alumni'){
        $context['members_alumni'][] = $member;
    } else $context['members_current'][] = $member;
}

Timber::render( 'views/page-members.twig', $context );
?>
