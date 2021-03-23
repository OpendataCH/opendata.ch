<?php


/**
 * ACF GLOBAL OPTION 
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'   => 'Global',
        'menu_title'   => 'Global',
        'menu_slug'   => 'global',
        'capability'   => 'edit_posts',
        'icon_url' => 'dashicons-admin-site',
        'position' => 20
    ));
}





/**
 * ACF ARCHIVE OPTION 
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_sub_page(array(
        'page_title'      => 'Projects Settings', /* Use whatever title you want */
        'parent_slug'     => 'edit.php?post_type=project', /* Change "services" to fit your situation */
        'capability' => 'manage_options'
    ));

    acf_add_options_sub_page(array(
        'page_title'      => 'News Settings', /* Use whatever title you want */
        'parent_slug'     => 'edit.php?post_type=news', /* Change "services" to fit your situation */
        'capability' => 'manage_options'
    ));

    acf_add_options_sub_page(array(
        'page_title'      => 'Events Settings', /* Use whatever title you want */
        'parent_slug'     => 'edit.php?post_type=event', /* Change "services" to fit your situation */
        'capability' => 'manage_options'
    ));
}






/**
 * WYSIWYG
 */
add_filter('acf/fields/wysiwyg/toolbars', 'my_toolbars');
function my_toolbars($toolbars)
{

    // Add a new toolbar called "studioyacine custom"
    // - this toolbar has only 1 row of buttons
    $toolbars['studioyacine custom'] = array();
    $toolbars['studioyacine custom'][1] = array('styleselect', 'formatselect', 'bold', 'italic', 'underline', 'alignleft', 'aligncenter', 'alignright', 'bullist', 'numlist', 'link', 'removeformat');


    // Edit the "Full" toolbar and remove 'code'
    // - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
    if (($key = array_search('code', $toolbars['Full'][2])) !== false) {
        unset($toolbars['Full'][2][$key]);
    }

    // remove the 'Basic' toolbar completely
    unset($toolbars['Basic']);

    // return $toolbars - IMPORTANT!
    return $toolbars;
}






/**
 * Dynamically select icon in ACF
 * @link https://www.billerickson.net/dynamic-dropdown-fields-in-acf/
 * @author Bill Erickson
 *
 * @param array $field, the field settings array 
 * @return array $field
 */
function be_acf_dynamic_icons($field)
{

    if (0 !== strpos($field['name'], 'dynamic_icon_'))
        return $field;

    $type = str_replace('dynamic_icon_', '', $field['name']);
    $icons = be_get_theme_icons($type);

    $field['choices'] = [0 => '(None)'];
    foreach ($icons as $icon) {
        $field['choices'][$icon] = $icon;
    }

    return $field;
}
add_filter('acf/load_field/type=select', 'be_acf_dynamic_icons');






/**
 * Get Theme Icons
 * Refresh cache by bumping CHILD_THEME_VERSION
 */
function be_get_theme_icons($directory = 'utility')
{

    $icons = get_option('be_theme_icons_' . $directory);
    $version = get_option('be_theme_icons_' . $directory . '_version');
    // if (empty($icons) || (defined('CHILD_THEME_VERSION') && version_compare(CHILD_THEME_VERSION, $version))) {
    $icons = scandir(get_stylesheet_directory() . '/library/icons/' . $directory);
    $icons = array_diff($icons, array('..', '.'));
    $icons = array_values($icons);
    if (empty($icons))
        return $icons;
    // remove the .svg
    foreach ($icons as $i => $icon) {
        $icons[$i] = substr($icon, 0, -4);
    }
    update_option('be_theme_icons_' . $directory, $icons);
    if (defined('CHILD_THEME_VERSION'))
        update_option('be_theme_icons_' . $directory . '_version', CHILD_THEME_VERSION);
    // }
    return $icons;
}
