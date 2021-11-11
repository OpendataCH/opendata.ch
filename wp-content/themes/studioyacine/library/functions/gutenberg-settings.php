<?php

/*	Editor styles
*   
*/
function studioyacine_gutenberg_css()
{

    add_theme_support('editor-styles'); // if you don't add this line, your stylesheet won't be added
    add_editor_style('library/css/style-editor.css'); // tries to include style-editor.css directly from your theme folder

}
add_action('after_setup_theme', 'studioyacine_gutenberg_css');



/*	Editor scripts
*   
*/
function studioyacine_gutenberg_scripts()
{
    wp_enqueue_script('studioyacine-editor', get_template_directory_uri() . '/library/js/editor.js', array('wp-blocks', 'wp-dom'), filemtime(get_template_directory() . '/library/js/editor.js'), true);
}
add_action('enqueue_block_editor_assets', 'studioyacine_gutenberg_scripts');




/*	Allowed block
*   
*/
function studioyacine_allowed_block_types($allowed_blocks)
{
    return array(
        'core/image',
        'core/paragraph',
		'core/buttons',
        'core/heading',
        'core/list',
        'core/quote',
        'core/gallery',
        'core/media-text',
        'core/separator',
		'core/table',
		'core/embed',
		'acf/team-member'
    );
}
add_filter('allowed_block_types', 'studioyacine_allowed_block_types');




/*	Disable gutenberg helper
*   
*/
function ea_disable_editor($id = false)
{

    $excluded_templates = array(
        'page-frontpage.php',
        'page-events.php',
        'page-news.php',
        'page-projects.php'
    );

    $excluded_ids = array(
        get_option('page_on_front')
    );

    if (empty($id))
        return false;

    $id = intval($id);
    $template = get_page_template_slug($id);

    return in_array($id, $excluded_ids) || in_array($template, $excluded_templates);
}




/**
 * Disable Gutenberg by template
 *
 */
function ea_disable_gutenberg($can_edit, $post_type)
{

    if (!(is_admin() && !empty($_GET['post'])))
        return $can_edit;

    if (ea_disable_editor($_GET['post']))
        $can_edit = false;

    return $can_edit;
}
// add_filter( 'gutenberg_can_edit_post_type', 'ea_disable_gutenberg', 10, 2 );
add_filter('use_block_editor_for_post_type', 'ea_disable_gutenberg', 10, 2);








// BLOCK - TEAM MEMBER
function acf_blocks() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		// register a portfolio item block
		acf_register_block(array(
			'name' => 'team-member',
			'title' => __('Team Member'),
			'description'	=> __('Embed a team member'),
			'render_template'	=> 'templates/blocks/team-member.php',
			'category' => 'formatting',
			'icon' => 'insert',
			'mode' => 'edit',
			'keywords' => array( 'team','member' ),
    	));
	}
}

add_action('acf/init', 'acf_blocks');