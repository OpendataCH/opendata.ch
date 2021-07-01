<?php


$context = Timber::get_context();
//store global options page
$context['options'] = get_fields('options');
$context['options']['languageCode'] = ICL_LANGUAGE_CODE;

$context['options']['deadline'] = calc_deadline();
$context['options']['is_deadline_reached'] = is_deadline_reached();

$languages = wpml_get_active_languages_filter('skip_missing=1');
$context['options']['languages'] = $languages;

$context['isHome'] = is_front_page();
$context['isSingle'] = is_single();

//when on main projects page we need to include MAP js/css in html-header.twig
if(is_object($post)){
    $round_slug_array = get_field('round',$post->ID);
    if(is_array($round_slug_array)){
        if(count($round_slug_array) >= 2){
            $context['showMap'] = true;
        }
    }
}


if(ICL_LANGUAGE_CODE == 'de'){
    $context['photo_credits'] = 'Foto: ';
} else {
    $context['photo_credits'] = 'Photo: ';
    //this hides the filers, as there is no filtering for english
}

$post = new TimberPost();
$context['post'] = $post;


?>