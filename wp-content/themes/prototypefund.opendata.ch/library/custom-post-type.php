<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// let's create the function for the custom type
function ct_team()
{
// creating (registering) the custom type
    register_post_type('team', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
        // let's now add all the options for this post type
        array('labels' => array(
            'name' => __('Team', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Team Member', 'bonestheme'), /* This is the individual type */
            'all_items' => __('All Team Members', 'bonestheme'), /* the all items menu item */
            'add_new' => __('New Team Member', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('New Team Member', 'bonestheme'), /* Add New Display Title */
            'edit' => __('Edit', 'bonestheme'), /* Edit Dialog */
            'edit_item' => __('Edit Team Member', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('New Team Member', 'bonestheme'), /* New Display Title */
            'view_item' => __('View Team Member', 'bonestheme'), /* View Display Title */
            'search_items' => __('Search Team Member', 'bonestheme'), /* Search Custom Type Title */
            'not_found' => __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => __('PTF Team Members', 'bonestheme'), /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
            'rewrite' => array('slug' => 'team', 'with_front' => false), /* you can specify its url slug */
            'has_archive' => 'team', /* you can rename the slug here */
            'capability_type' => 'post',
            'hierarchical' => false,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
        ) /* end of options */
    ); /* end of register post type */
}

register_taxonomy_for_object_type( 'teamtype', 'team' );



function ct_jury()
{
// creating (registering) the custom type
    register_post_type('jury', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
        // let's now add all the options for this post type
        array('labels' => array(
            'name' => __('Jury', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('Jury Member', 'bonestheme'), /* This is the individual type */
            'all_items' => __('All Jury Members', 'bonestheme'), /* the all items menu item */
            'add_new' => __('New Jury Member', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('New Jury Member', 'bonestheme'), /* Add New Display Title */
            'edit' => __('Edit', 'bonestheme'), /* Edit Dialog */
            'edit_item' => __('Edit Jury Member', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('New Jury Member', 'bonestheme'), /* New Display Title */
            'view_item' => __('View Jury Member', 'bonestheme'), /* View Display Title */
            'search_items' => __('Search Jury Member', 'bonestheme'), /* Search Custom Type Title */
            'not_found' => __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => __('PTF Jury Members', 'bonestheme'), /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
            'rewrite' => array('slug' => 'jury', 'with_front' => false), /* you can specify its url slug */
            'has_archive' => 'jury', /* you can rename the slug here */
            'capability_type' => 'post',
            'hierarchical' => false,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
        ) /* end of options */
    ); /* end of register post type */
}

register_taxonomy_for_object_type( 'teamtype', 'jury' );


// let's create the function for the custom type
function ct_submission()
{
// creating (registering) the custom type
    register_post_type('user_submission', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
        // let's now add all the options for this post type
        array('labels' => array(
            'name' => __('User Submission', 'bonestheme'), /* This is the Title of the Group */
            'singular_name' => __('User Submission', 'bonestheme'), /* This is the individual type */
            'all_items' => __('All User Submissions', 'bonestheme'), /* the all items menu item */
            'add_new' => __('New User Submission', 'bonestheme'), /* The add new menu item */
            'add_new_item' => __('New User Submission', 'bonestheme'), /* Add New Display Title */
            'edit' => __('Edit', 'bonestheme'), /* Edit Dialog */
            'edit_item' => __('Edit User Submission', 'bonestheme'), /* Edit Display Title */
            'new_item' => __('New User Submission', 'bonestheme'), /* New Display Title */
            'view_item' => __('View User Submission', 'bonestheme'), /* View Display Title */
            'search_items' => __('Search User Submission', 'bonestheme'), /* Search Custom Type Title */
            'not_found' => __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */
            'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => __('PTF User Submissions', 'bonestheme'), /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
            'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
            'rewrite' => array('slug' => 'usersubmission', 'with_front' => false), /* you can specify its url slug */
            'has_archive' => 'user_submission', /* you can rename the slug here */
            'capability_type' => 'post',
            'hierarchical' => false,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
        ) /* end of options */
    ); /* end of register post type */
}

// let's create the function for the custom type
function ct_project() {
	// creating (registering) the custom type 
	register_post_type( 'project', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Projects', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Project', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Projects', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'New Project', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'New Project', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Project', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'Neues Projekt', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'Projekt ansehen', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Projekt suchen', 'bonestheme' ), /* Search Custom Type Title */
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Ein PTF Projekt', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'project', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'project', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	register_taxonomy_for_object_type( 'projectcategory', 'project' );
	/* this adds your post tags to your custom post type */
    //register_taxonomy_for_object_type( 'post_tag', 'custom_type' );
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'ct_project');
	add_action( 'init', 'ct_submission');
	add_action( 'init', 'ct_jury');
	add_action( 'init', 'ct_team');

	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
	register_taxonomy( 'projectcategory',
		array('project'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => true,     /* if this is true, it acts like categories */
			'labels' => array(
				'name' => __( 'Project Categories', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Project Category', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Project Categories', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Project Categories', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Project Category', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Project Category:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Project Category', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Project Category', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Project Category', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Project Category Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true, 
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'projectcategory' ),
		)
	);

// now let's add custom categories (these act like categories)
register_taxonomy( 'teamtype',
    array('jury', 'team'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    array('hierarchical' => true,     /* if this is true, it acts like categories */
        'labels' => array(
            'name' => __( 'Mitgliedstyp', 'bonestheme' ), /* name of the custom taxonomy */
            'singular_name' => __( 'Mitgliedstyp', 'bonestheme' ), /* single taxonomy name */
            'search_items' =>  __( 'Mitgliedstyp suchen', 'bonestheme' ), /* search title for taxomony */
            'all_items' => __( 'Alle Mitgliedstyp', 'bonestheme' ), /* all title for taxonomies */
            'parent_item' => __( 'Parent Mitgliedstyp', 'bonestheme' ), /* parent title for taxonomy */
            'parent_item_colon' => __( 'Parent Type:', 'bonestheme' ), /* parent taxonomy title */
            'edit_item' => __( 'Mitgliedstyp bearbeiten', 'bonestheme' ), /* edit custom taxonomy title */
            'update_item' => __( 'Update Type', 'bonestheme' ), /* update title for taxonomy */
            'add_new_item' => __( 'Neuer Mitgliedstyp', 'bonestheme' ), /* add new title for taxonomy */
            'new_item_name' => __( 'Neuer Mitgliedstyp', 'bonestheme' ) /* name title for taxonomy */
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'teamtype' ),
    )
);
	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'custom_tag', 
		array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => false,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'Custom Tags', 'bonestheme' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Custom Tag', 'bonestheme' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Custom Tags', 'bonestheme' ), /* search title for taxomony */
				'all_items' => __( 'All Custom Tags', 'bonestheme' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Custom Tag', 'bonestheme' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Custom Tag:', 'bonestheme' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Custom Tag', 'bonestheme' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Custom Tag', 'bonestheme' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Custom Tag', 'bonestheme' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Custom Tag Name', 'bonestheme' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
		)
	);
	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
	

?>
