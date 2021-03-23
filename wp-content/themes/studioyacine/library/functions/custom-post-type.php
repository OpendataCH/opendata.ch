<?php
/* Custom Post Types GOES HERE*/

// Flush rewrite rules for custom post types
add_action('after_switch_theme', 'bones_flush_rewrite_rules');

// Flush your rewrite rules
function bones_flush_rewrite_rules()
{
	flush_rewrite_rules();
}

// let's create the function for the custom type
function post_project()
{
	// creating (registering) the custom type
	register_post_type(
		'project', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array(
			'labels' => array(
				'name' => __('Projects', 'bonestheme'), /* This is the Title of the Group */
				'singular_name' => __('Project', 'bonestheme'), /* This is the individual type */
				'all_items' => __('All Projects', 'bonestheme'), /* the all items menu item */
				'add_new' => __('Add New Project', 'bonestheme'), /* The add new menu item */
				'add_new_item' => __('Add New Project', 'bonestheme'), /* Add New Display Title */
				'edit' => __('Edit', 'bonestheme'), /* Edit Dialog */
				'edit_item' => __('Edit Project', 'bonestheme'), /* Edit Display Title */
				'new_item' => __('New Project', 'bonestheme'), /* New Display Title */
				'view_item' => __('View Project', 'bonestheme'), /* View Display Title */
				'search_items' => __('Search Projects', 'bonestheme'), /* Search Custom Type Title */
				'not_found' =>  __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */
				'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __('Project post', 'bonestheme'), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 6, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array('slug' => 'projects', 'with_front' => false), /* you can specify its url slug */
			'has_archive' => 'projects', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_rest' => true,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions')
		) /* end of options */
	); /* end of register post type */
}

// let's create the function for the custom type
function post_event()
{
	// creating (registering) the custom type
	register_post_type(
		'event', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array(
			'labels' => array(
				'name' => __('Events', 'bonestheme'), /* This is the Title of the Group */
				'singular_name' => __('Event', 'bonestheme'), /* This is the individual type */
				'all_items' => __('All Events', 'bonestheme'), /* the all items menu item */
				'add_new' => __('Add New Event', 'bonestheme'), /* The add new menu item */
				'add_new_item' => __('Add New Event', 'bonestheme'), /* Add New Display Title */
				'edit' => __('Edit', 'bonestheme'), /* Edit Dialog */
				'edit_item' => __('Edit Event', 'bonestheme'), /* Edit Display Title */
				'new_item' => __('New Event', 'bonestheme'), /* New Display Title */
				'view_item' => __('View Event', 'bonestheme'), /* View Display Title */
				'search_items' => __('Search Event', 'bonestheme'), /* Search Custom Type Title */
				'not_found' =>  __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */
				'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __('Event post', 'bonestheme'), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array('slug' => 'events', 'with_front' => false), /* you can specify its url slug */
			'has_archive' => 'events', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_rest' => true,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'custom-fields', 'revisions')
		) /* end of options */
	); /* end of register post type */
}

function post_team()
{
	// creating (registering) the custom type
	register_post_type(
		'team_member', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array(
			'labels' => array(
				'name' => __('Team member', 'bonestheme'), /* This is the Title of the Group */
				'singular_name' => __('Team Member', 'bonestheme'), /* This is the individual type */
				'all_items' => __('All Team Members', 'bonestheme'), /* the all items menu item */
				'add_new' => __('Add New Team Member', 'bonestheme'), /* The add new menu item */
				'add_new_item' => __('Add New Team Member', 'bonestheme'), /* Add New Display Title */
				'edit' => __('Edit', 'bonestheme'), /* Edit Dialog */
				'edit_item' => __('Edit Team Member', 'bonestheme'), /* Edit Display Title */
				'new_item' => __('New Team Member', 'bonestheme'), /* New Display Title */
				'view_item' => __('View Team Member', 'bonestheme'), /* View Display Title */
				'search_items' => __('Search Team Member', 'bonestheme'), /* Search Custom Type Title */
				'not_found' =>  __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */
				'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __('Team member', 'bonestheme'), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 6, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> false,
			'has_archive' => false, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_rest' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'revisions')
		) /* end of options */
	); /* end of register post type */
}


function post_news()
{
	// creating (registering) the custom type
	register_post_type(
		'news', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array(
			'labels' => array(
				'name' => __('News', 'bonestheme'), /* This is the Title of the Group */
				'singular_name' => __('News', 'bonestheme'), /* This is the individual type */
				'all_items' => __('All News', 'bonestheme'), /* the all items menu item */
				'add_new' => __('Add News', 'bonestheme'), /* The add new menu item */
				'add_new_item' => __('Add News', 'bonestheme'), /* Add New Display Title */
				'edit' => __('Edit', 'bonestheme'), /* Edit Dialog */
				'edit_item' => __('Edit News', 'bonestheme'), /* Edit Display Title */
				'new_item' => __('New News post', 'bonestheme'), /* New Display Title */
				'view_item' => __('View News', 'bonestheme'), /* View Display Title */
				'search_items' => __('Search News', 'bonestheme'), /* Search Custom Type Title */
				'not_found' =>  __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */
				'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __('News post', 'bonestheme'), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 4, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array('slug' => 'news', 'with_front' => false), /* you can specify its url slug */
			'has_archive' => 'news', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_rest' => true,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions')
		) /* end of options */
	); /* end of register post type */
}

// now let's add custom categories (these act like categories)
register_taxonomy(
	'news_category',
	array('news'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
	array(
		'hierarchical' => false,     /* if this is true, it acts like categories */
		'labels' => array(
			'name' => __('Category', 'bonestheme'), /* name of the custom taxonomy */
			'singular_name' => __('Category', 'bonestheme'), /* single taxonomy name */
			'search_items' =>  __('Search Categories', 'bonestheme'), /* search title for taxomony */
			'all_items' => __('All Categories', 'bonestheme'), /* all title for taxonomies */
			'parent_item' => __('Parent Category', 'bonestheme'), /* parent title for taxonomy */
			'parent_item_colon' => __('Parent Category:', 'bonestheme'), /* parent taxonomy title */
			'edit_item' => __('Edit Category', 'bonestheme'), /* edit custom taxonomy title */
			'update_item' => __('Update Category', 'bonestheme'), /* update title for taxonomy */
			'add_new_item' => __('Add New Category', 'bonestheme'), /* add new title for taxonomy */
			'new_item_name' => __('New Category Name', 'bonestheme') /* name title for taxonomy */
		),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true
	)
);

// now let's add custom categories (these act like categories)
register_taxonomy(
	'team_category',
	array('team_member'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
	array(
		'hierarchical' => false,     /* if this is true, it acts like categories */
		'labels' => array(
			'name' => __('Category', 'bonestheme'), /* name of the custom taxonomy */
			'singular_name' => __('Category', 'bonestheme'), /* single taxonomy name */
			'search_items' =>  __('Search Categories', 'bonestheme'), /* search title for taxomony */
			'all_items' => __('All Categories', 'bonestheme'), /* all title for taxonomies */
			'parent_item' => __('Parent Category', 'bonestheme'), /* parent title for taxonomy */
			'parent_item_colon' => __('Parent Category:', 'bonestheme'), /* parent taxonomy title */
			'edit_item' => __('Edit Category', 'bonestheme'), /* edit custom taxonomy title */
			'update_item' => __('Update Category', 'bonestheme'), /* update title for taxonomy */
			'add_new_item' => __('Add New Category', 'bonestheme'), /* add new title for taxonomy */
			'new_item_name' => __('New Category Name', 'bonestheme') /* name title for taxonomy */
		),
		'show_admin_column' => true,
		'show_ui' => true,
		'query_var' => true
	)
);

// adding the function to the Wordpress init
add_action('init', 'post_project');
add_action('init', 'post_news');
add_action('init', 'post_event');
add_action('init', 'post_team');
