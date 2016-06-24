<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Home Content
	$home_content = array("projects" => "Projects ", "posts" => "Posts");	
	
	// Home Project Type
	$home_project_type = array("all" => "All projects", "featured" => "Featured");
	
	// Project Thumb Layout
	$project_thumb_layout = array("masonry" => "Masonry", "grid" => "Grid");
	
	// Background Textures
	$background_textures = array("bg_none" => "None", "bg_waves" => "Waves", "bg_diagonal" => "Diagonal", "bg_grid" => "Grid");
	
	// Post Featured Image Size
	$post_featured_image_size = array("large" => "Large", "small" => "Small");
	
	// Infinite Scrolling
	$infinite_scrolling = array("disabled" => "Disabled", "enabled" => "Enabled", "enabled_with_button" => "Enabled With Button");

	// Slideshow Transition Effect
	$slideshow_effect = array("slide" => "Slide", "fade" => "Fade");

		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();
		
	$options[] = array( "name" => __('General','themetrust'),
						"type" => "heading");	
	
	$options[] = array( "name" => __('Logo','themetrust'),
						"desc" => __('Upload a custom logo.','themetrust'),
						"id" => "logo",
						"type" => "upload");
						
	$options[] = array( "name" => __('Favicon','themetrust'),
						"desc" => __('Upload a custom favicon.','themetrust'),
						"id" => "ttrust_favicon",
						"type" => "upload");					
		
	
	$options[] = array( "name" => __('Custom CSS','themetrust'),
						"desc" => __('Enter custom CSS here.','themetrust'),
						"id" => "ttrust_custom_css",
						"std" => "",
						"type" => "textarea");					
					
						
	$options[] = array( "name" => __('Appearance','themetrust'),
						"type" => "heading");
							
	$options[] = array( "name" => __('Accent Color','themetrust'),
						"desc" => __('Select a color for the top bar.','themetrust'),
						"id" => "ttrust_color_scheme",
						"std" => "#93bcbe",
						"type" => "color");
						
	$options[] = array( "name" => __('Menu Color','themetrust'),
						"desc" => __('Select a color for your menu links.','themetrust'),
						"id" => "ttrust_color_menu",
						"std" => "#7b7b7b",
						"type" => "color");
						
	$options[] = array( "name" => __('Menu Hover Color','themetrust'),
						"desc" => __('Select a hover color for your menu links.','themetrust'),
						"id" => "ttrust_color_menu_hover",
						"std" => "#93bcbe",
						"type" => "color");
						
	$options[] = array( "name" => __('Button Color','themetrust'),
						"desc" => __('Select a color for your buttons.','themetrust'),
						"id" => "ttrust_color_btn",
						"std" => "#515151",
						"type" => "color");
						
	$options[] = array( "name" => __('Button Hover Color','themetrust'),
						"desc" => __('Select a hover color for your buttons.','themetrust'),
						"id" => "ttrust_color_btn_hover",
						"std" => "#717171",
						"type" => "color");
						
	$options[] = array( "name" => __('Link Color','themetrust'),
						"desc" => __('Select a color for your links.','themetrust'),
						"id" => "ttrust_color_link",
						"std" => "#93bcbe",
						"type" => "color");

	$options[] = array( "name" => __('Link Hover Color','themetrust'),
						"desc" => __('Select a hover color for your links.','themetrust'),
						"id" => "ttrust_color_link_hover",
						"std" => "#4d787a",
						"type" => "color");
						
	$options[] = array( "name" => __('Font for Headings','themetrust'),
						"desc" => __('Enter the name of the <a href="http://www.google.com/webfonts" target="_blank">Google Web Font</a> you want to use for headings.','themetrust'),
						"id" => "ttrust_heading_font",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Font for Body Text','themetrust'),
						"desc" => __('Enter the name of the <a href="http://www.google.com/webfonts" target="_blank">Google Web Font</a> you want to use for the body text.','themetrust'),
						"id" => "ttrust_body_font",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Font for Home Message','themetrust'),
						"desc" => __('Enter the name of the <a href="http://www.google.com/webfonts" target="_blank">Google Web Font</a> you want to use for the home message text.','themetrust'),
						"id" => "ttrust_home_message_font",
						"std" => "",
						"type" => "text");
						
	$options[] = array( "name" => __('Background Texture','themetrust'),
						"desc" => __('Select a background texture. Select "None" if you are using the custom background option.','themetrust'),
						"id" => "ttrust_background_texture",
						"std" => "bg_waves",
						"type" => "select",
						"options" => $background_textures);
						
	
						
	$options[] = array( "name" => __('Home Page','themetrust'),
						"type" => "heading");
						
						
	$options[] = array( "name" => __('Home Message','themetrust'),
						"desc" => __('Enter a short message to be displayed on the home page.','themetrust'),
						"id" => "ttrust_home_message",
						"std" => "",
						"type" => "textarea");
						
	$options[] = array( "name" => __('Home Page Content','themetrust'),
						"desc" => __('Select the type of content to be displayed on the home page.','themetrust'),
						"id" => "ttrust_home_content",
						"std" => "projects",
						"type" => "select",
						"options" => $home_content);	
						
	$options[] = array( "name" => __('Type of Projects to Show','themetrust'),
						"desc" => __('Select the type of projects to show on the home page.','themetrust'),
						"id" => "ttrust_home_project_type",
						"std" => "latest",
						"type" => "select",
						"options" => $home_project_type);						
						
	$options[] = array( "name" => __('Posts','themetrust'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Show Author','themetrust'),
						"desc" => __('Check this box to show the author.','themetrust'),
						"id" => "ttrust_post_show_author",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __('Show Date','themetrust'),
						"desc" => __('Check this box to show the publish date.','themetrust'),
						"id" => "ttrust_post_show_date",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __('Show Category','themetrust'),
						"desc" => __('Check this box to show the category.','themetrust'),
						"id" => "ttrust_post_show_category",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __('Show Comment Count','themetrust'),
						"desc" => __('Check this box to show the comment count.','themetrust'),
						"id" => "ttrust_post_show_comments",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __('Featured Image Size','themetrust'),
						"desc" => __('Select the size of the post featured image.','themetrust'),
						"id" => "ttrust_post_featured_img_size",
						"std" => "large",
						"type" => "select",
						"options" => $post_featured_image_size);
						
	$options[] = array( "name" => __('Show Featured Image on Single Posts','themetrust'),
						"desc" => __('Check this box to show the featured image on single post pages.','themetrust'),
						"id" => "ttrust_post_show_featured_image",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => __('Infinite Scrolling','themetrust'),
						"desc" => __('Change infinite scrolling settings.','themetrust'),
						"id" => "ttrust_infinite_scrolling",
						"std" => "enabled_with_button",
						"type" => "select",
						"options" => $infinite_scrolling);
						
	$options[] = array( "name" => __('Footer','themetrust'),
						"type" => "heading");
						
	$options[] = array( "name" => __('Left Footer Text','themetrust'),
						"desc" => __('This will appear on the left side of the footer.','themetrust'),
						"id" => "ttrust_footer_left",
						"std" => "",
						"type" => "textarea");

	$options[] = array( "name" => __('Right Footer Text','themetrust'),
						"desc" => __('This will appear on the right side of the footer.','themetrust'),
						"id" => "ttrust_footer_right",
						"std" => "",
						"type" => "textarea");
						
	$options[] = array( "name" => __('Integration','themetrust'),
						"type" => "heading");	
						
	$options[] = array( "name" => __('Analytics','themetrust'),
						"desc" => __('Enter your custom analytics code. (e.g. Google Analytics).','themetrust'),
						"id" => "ttrust_analytics",
						"std" => "",
						"type" => "textarea",
						"validate" => "none");
						
	$options[] = array( "name" => __('Slideshow','themetrust'),
						"type" => "heading");	

	$options[] = array( "name" => __('Slideshow Delay','themetrust'),
						"desc" => __('Enter the delay in seconds between slides. Enter 0 to disable auto-playing.','themetrust'),
						"id" => "ttrust_slideshow_delay",
						"std" => "6",
						"type" => "text");

	$options[] = array( "name" => __('Slideshow Effect','themetrust'),
						"desc" => __('Select the type of transition effect for the slideshow.','themetrust'),
						"id" => "ttrust_slideshow_effect",
						"std" => "fade",
						"type" => "select",
						"options" => $slideshow_effect);				
	
	return $options;
}