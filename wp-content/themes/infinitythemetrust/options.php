<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$theme = wp_get_theme();
	$themename = $theme->Name;
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
	
	$options['logo'] = array( "name" => __('Logo','themetrust'),
						"desc" => __('Upload a custom logo.','themetrust'),
						"id" => "logo",
						"type" => "upload");
						
	$options['ttrust_favicon'] = array( "name" => __('Favicon','themetrust'),
						"desc" => __('Upload a custom favicon.','themetrust'),
						"id" => "ttrust_favicon",
						"type" => "upload");					
		
	
	$options['ttrust_custom_css'] = array( "name" => __('Custom CSS','themetrust'),
						"desc" => __('Enter custom CSS here.','themetrust'),
						"id" => "ttrust_custom_css",
						"std" => "",
						"type" => "textarea");					
					
						
	$options[] = array( "name" => __('Appearance','themetrust'),
						"type" => "heading");
							
	$options['ttrust_color_scheme'] = array( "name" => __('Accent Color','themetrust'),
						"desc" => __('Select a color for the top bar.','themetrust'),
						"id" => "ttrust_color_scheme",
						"std" => "#93bcbe",
						"type" => "color");
						
	$options['ttrust_color_menu'] = array( "name" => __('Menu Color','themetrust'),
						"desc" => __('Select a color for your menu links.','themetrust'),
						"id" => "ttrust_color_menu",
						"std" => "#7b7b7b",
						"type" => "color");
						
	$options['ttrust_color_menu_hover'] = array( "name" => __('Menu Hover Color','themetrust'),
						"desc" => __('Select a hover color for your menu links.','themetrust'),
						"id" => " ttrust_color_menu_hover",
						"std" => "#93bcbe",
						"type" => "color");
						
	$options['ttrust_color_btn'] = array( "name" => __('Button Color','themetrust'),
						"desc" => __('Select a color for your buttons.','themetrust'),
						"id" => "ttrust_color_btn",
						"std" => "#515151",
						"type" => "color");
						
	$options['ttrust_color_btn_hover'] = array( "name" => __('Button Hover Color','themetrust'),
						"desc" => __('Select a hover color for your buttons.','themetrust'),
						"id" => "ttrust_color_btn_hover",
						"std" => "#717171",
						"type" => "color");
						
	$options['ttrust_color_link'] = array( "name" => __('Link Color','themetrust'),
						"desc" => __('Select a color for your links.','themetrust'),
						"id" => "ttrust_color_link",
						"std" => "#93bcbe",
						"type" => "color");

	$options['ttrust_color_link_hover'] = array( "name" => __('Link Hover Color','themetrust'),
						"desc" => __('Select a hover color for your links.','themetrust'),
						"id" => "ttrust_color_link_hover",
						"std" => "#4d787a",
						"type" => "color");
						
	$options['ttrust_heading_font'] = array( "name" => __('Font for Headings','themetrust'),
						"desc" => __('Enter the name of the <a href="http://www.google.com/webfonts" target="_blank">Google Web Font</a> you want to use for headings.','themetrust'),
						"id" => "ttrust_heading_font",
						"std" => "",
						"type" => "text");
						
	$options['ttrust_body_font'] = array( "name" => __('Font for Body Text','themetrust'),
						"desc" => __('Enter the name of the <a href="http://www.google.com/webfonts" target="_blank">Google Web Font</a> you want to use for the body text.','themetrust'),
						"id" => "ttrust_body_font",
						"std" => "",
						"type" => "text");
						
	$options['ttrust_home_message_font'] = array( "name" => __('Font for Home Message','themetrust'),
						"desc" => __('Enter the name of the <a href="http://www.google.com/webfonts" target="_blank">Google Web Font</a> you want to use for the home message text.','themetrust'),
						"id" => "ttrust_home_message_font",
						"std" => "",
						"type" => "text");
						
	$options['ttrust_background_texture'] = array( "name" => __('Background Texture','themetrust'),
						"desc" => __('Select a background texture. Select "None" if you are using the custom background option.','themetrust'),
						"id" => "ttrust_background_texture",
						"std" => "bg_waves",
						"type" => "select",
						"options" => $background_textures);
						
	
						
	$options[] = array( "name" => __('Home Page','themetrust'),
						"type" => "heading");
						
						
	$options['ttrust_home_message'] = array( "name" => __('Home Message','themetrust'),
						"desc" => __('Enter a short message to be displayed on the home page.','themetrust'),
						"id" => "ttrust_home_message",
						"std" => "",
						"type" => "textarea");
						
	$options['ttrust_home_content'] = array( "name" => __('Home Page Content','themetrust'),
						"desc" => __('Select the type of content to be displayed on the home page.','themetrust'),
						"id" => "ttrust_home_content",
						"std" => "projects",
						"type" => "select",
						"options" => $home_content);	
						
	$options['ttrust_home_project_type'] = array( "name" => __('Type of Projects to Show','themetrust'),
						"desc" => __('Select the type of projects to show on the home page.','themetrust'),
						"id" => "ttrust_home_project_type",
						"std" => "latest",
						"type" => "select",
						"options" => $home_project_type);						
						
	$options[] = array( "name" => __('Posts','themetrust'),
						"type" => "heading");
						
	$options['ttrust_post_show_author'] = array( "name" => __('Show Author','themetrust'),
						"desc" => __('Check this box to show the author.','themetrust'),
						"id" => "ttrust_post_show_author",
						"std" => "1",
						"type" => "checkbox");
						
	$options['ttrust_post_show_date'] = array( "name" => __('Show Date','themetrust'),
						"desc" => __('Check this box to show the publish date.','themetrust'),
						"id" => "ttrust_post_show_date",
						"std" => "1",
						"type" => "checkbox");
						
	$options['ttrust_post_show_category'] = array( "name" => __('Show Category','themetrust'),
						"desc" => __('Check this box to show the category.','themetrust'),
						"id" => "ttrust_post_show_category",
						"std" => "1",
						"type" => "checkbox");
						
	$options['ttrust_post_show_comments'] = array( "name" => __('Show Comment Count','themetrust'),
						"desc" => __('Check this box to show the comment count.','themetrust'),
						"id" => "ttrust_post_show_comments",
						"std" => "1",
						"type" => "checkbox");
						
	$options['ttrust_post_featured_img_size'] = array( "name" => __('Featured Image Size','themetrust'),
						"desc" => __('Select the size of the post featured image.','themetrust'),
						"id" => "ttrust_post_featured_img_size",
						"std" => "large",
						"type" => "select",
						"options" => $post_featured_image_size);
						
	$options['ttrust_post_show_featured_image'] = array( "name" => __('Show Featured Image on Single Posts','themetrust'),
						"desc" => __('Check this box to show the featured image on single post pages.','themetrust'),
						"id" => "ttrust_post_show_featured_image",
						"std" => "1",
						"type" => "checkbox");
						
	$options['ttrust_infinite_scrolling'] = array( "name" => __('Infinite Scrolling','themetrust'),
						"desc" => __('Change infinite scrolling settings.','themetrust'),
						"id" => "ttrust_infinite_scrolling",
						"std" => "enabled_with_button",
						"type" => "select",
						"options" => $infinite_scrolling);
						
	$options[] = array( "name" => __('Footer','themetrust'),
						"type" => "heading");
						
	$options['ttrust_footer_left'] = array( "name" => __('Left Footer Text','themetrust'),
						"desc" => __('This will appear on the left side of the footer.','themetrust'),
						"id" => "ttrust_footer_left",
						"std" => "",
						"type" => "textarea");

	$options['ttrust_footer_right'] = array( "name" => __('Right Footer Text','themetrust'),
						"desc" => __('This will appear on the right side of the footer.','themetrust'),
						"id" => "ttrust_footer_right",
						"std" => "",
						"type" => "textarea");
						
	$options[] = array( "name" => __('Integration','themetrust'),
						"type" => "heading");	
						
	$options['ttrust_analytics'] = array( "name" => __('Analytics','themetrust'),
						"desc" => __('Enter your custom analytics code. (e.g. Google Analytics).','themetrust'),
						"id" => "ttrust_analytics",
						"std" => "",
						"type" => "textarea",
						"validate" => "none");
						
	$options[] = array( "name" => __('Slideshow','themetrust'),
						"type" => "heading");	

	$options['ttrust_slideshow_delay'] = array( "name" => __('Slideshow Delay','themetrust'),
						"desc" => __('Enter the delay in seconds between slides. Enter 0 to disable auto-playing.','themetrust'),
						"id" => "ttrust_slideshow_delay",
						"std" => "6",
						"type" => "text");

	$options['ttrust_slideshow_effect'] = array( "name" => __('Slideshow Effect','themetrust'),
						"desc" => __('Select the type of transition effect for the slideshow.','themetrust'),
						"id" => "ttrust_slideshow_effect",
						"std" => "fade",
						"type" => "select",
						"options" => $slideshow_effect);				
	
	return $options;
}

/**
 * Front End Customizer
 *
 * WordPress 3.4 Required
 */

add_action( 'customize_register', 'ttrust_customizer_register' );

function ttrust_customizer_register($wp_customize) {
	
	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$theme = wp_get_theme();
	$themename = $theme->Name;
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	/**
	 * This is optional, but if you want to reuse some of the defaults
	 * or values you already have built in the options panel, you
	 * can load them into $options for easy reference
	 */
	 
	$options = optionsframework_options();

	$wp_customize->add_section( 'ttrust_general', array(
		'title' => __( 'General', 'themetrust' ),
		'priority' => 25
	) );

	$wp_customize->add_setting( $themename.'[logo]', array(
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		'label' => $options['logo']['name'],
		'section' => 'ttrust_general',
		'settings' => $themename.'[logo]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[ttrust_favicon]', array(
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ttrust_favicon', array(
		'label' => $options['ttrust_favicon']['name'],
		'section' => 'ttrust_general',
		'settings' => $themename.'[ttrust_favicon]'
	) ) );

	$wp_customize->add_setting( $themename.'[ttrust_custom_css]', array(
		'default' => $options['ttrust_custom_css']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Textarea_Control( $wp_customize, 'ttrust_customizer_custom_css', array(
		'label' => $options['ttrust_custom_css']['name'],
		'section' => 'ttrust_general',
		'settings' => $themename.'[ttrust_custom_css]',
		'type' => $options['ttrust_custom_css']['type']
	) ) );
	
	/* Appearance */
	$wp_customize->add_section( 'ttrust_appearance', array(
		'title' => __( 'Appearance', 'themetrust' ),
		'priority' => 26
	) );

	$wp_customize->add_setting( $themename.'[ttrust_color_scheme]', array(
		'default' => $options['ttrust_color_scheme']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ttrust_color_scheme', array(
		'label'   => $options['ttrust_color_scheme']['name'],
		'section' => 'ttrust_appearance',
		'settings'   => $themename.'[ttrust_color_scheme]'
	) ) );

	$wp_customize->add_setting( $themename.'[ttrust_color_menu]', array(
		'default' => $options['ttrust_color_menu']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ttrust_color_menu', array(
		'label'   => $options['ttrust_color_menu']['name'],
		'section' => 'ttrust_appearance',
		'settings'   => $themename.'[ttrust_color_menu]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[ttrust_color_menu_hover]', array(
		'default' => $options['ttrust_color_menu_hover']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ttrust_color_menu_hover', array(
		'label'   => $options['ttrust_color_menu_hover']['name'],
		'section' => 'ttrust_appearance',
		'settings'   => $themename.'[ttrust_color_menu_hover]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[ttrust_color_btn]', array(
		'default' => $options['ttrust_color_btn']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ttrust_color_btn', array(
		'label'   => $options['ttrust_color_btn']['name'],
		'section' => 'ttrust_appearance',
		'settings'   => $themename.'[ttrust_color_btn]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[ttrust_color_btn_hover]', array(
		'default' => $options['ttrust_color_btn_hover']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ttrust_color_btn_hover', array(
		'label'   => $options['ttrust_color_btn_hover']['name'],
		'section' => 'ttrust_appearance',
		'settings'   => $themename.'[ttrust_color_btn_hover]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[ttrust_color_link]', array(
		'default' => $options['ttrust_color_link']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ttrust_color_link', array(
		'label'   => $options['ttrust_color_link']['name'],
		'section' => 'ttrust_appearance',
		'settings'   => $themename.'[ttrust_color_link]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[ttrust_color_link_hover]', array(
		'default' => $options['ttrust_color_link_hover']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ttrust_color_link_hover', array(
		'label'   => $options['ttrust_color_link_hover']['name'],
		'section' => 'ttrust_appearance',
		'settings'   => $themename.'[ttrust_color_link_hover]'
	) ) );
	
	$wp_customize->add_setting( $themename.'[ttrust_background_texture]', array(
		'default' => $options['ttrust_background_texture']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_background_texture', array(
		'label' => $options['ttrust_background_texture']['name'],
		'section' => 'ttrust_appearance',
		'settings' => $themename.'[ttrust_background_texture]',
		'type' => $options['ttrust_background_texture']['type'],
		'choices' => $options['ttrust_background_texture']['options']
	) );
	
	
	/* Typography */
	$wp_customize->add_section( 'ttrust_typography', array(
		'title' => __( 'Typography', 'themetrust' ),
		'priority' => 27
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_heading_font]', array(
		'default' => $options['ttrust_heading_font']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'ttrust_customizer_heading_font', array(
		'label' => $options['ttrust_heading_font']['name'],
		'section' => 'ttrust_typography',
		'settings' => $themename.'[ttrust_heading_font]',
		'type' => $options['ttrust_heading_font']['type']
	) );

	$wp_customize->add_setting( $themename.'[ttrust_body_font]', array(
		'default' => $options['ttrust_body_font']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'ttrust_customizer_body_font', array(
		'label' => $options['ttrust_body_font']['name'],
		'section' => 'ttrust_typography',
		'settings' => $themename.'[ttrust_body_font]',
		'type' => $options['ttrust_body_font']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_home_message_font]', array(
		'default' => $options['ttrust_home_message_font']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'ttrust_customizer_home_message_font', array(
		'label' => $options['ttrust_home_message_font']['name'],
		'section' => 'ttrust_typography',
		'settings' => $themename.'[ttrust_home_message_font]',
		'type' => $options['ttrust_home_message_font']['type']
	) );
	
	/* Home Page */
	$wp_customize->add_section( 'ttrust_home_page', array(
		'title' => __( 'Home Page', 'themetrust' ),
		'priority' => 27
	) );

	$wp_customize->add_setting( $themename.'[ttrust_home_message]', array(
		'default' => $options['ttrust_home_message']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'ttrust_customizer_home_message', array(
		'label' => $options['ttrust_home_message']['name'],
		'section' => 'ttrust_home_page',
		'settings' => $themename.'[ttrust_home_message]',
		'type' => 'text'
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_home_content]', array(
		'default' => $options['ttrust_home_content']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_home_content', array(
		'label' => $options['ttrust_home_content']['name'],
		'section' => 'ttrust_home_page',
		'settings' => $themename.'[ttrust_home_content]',
		'type' => $options['ttrust_home_content']['type'],
		'choices' => $options['ttrust_home_content']['options']
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_home_project_type]', array(
		'default' => $options['ttrust_home_project_type']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_home_project_type', array(
		'label' => $options['ttrust_home_project_type']['name'],
		'section' => 'ttrust_home_page',
		'settings' => $themename.'[ttrust_home_project_type]',
		'type' => $options['ttrust_home_project_type']['type'],
		'choices' => $options['ttrust_home_project_type']['options']
	) );
	
	/* Posts */
	$wp_customize->add_section( 'ttrust_posts', array(
		'title' => __( 'Posts', 'themetrust' ),
		'priority' => 28
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_post_show_author]', array(
		'default' => $options['ttrust_post_show_author']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_show_author', array(
		'label' => $options['ttrust_post_show_author']['name'],
		'section' => 'ttrust_posts',
		'settings' => $themename.'[ttrust_post_show_author]',
		'type' => $options['ttrust_post_show_author']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_post_show_date]', array(
		'default' => $options['ttrust_post_show_date']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_show_date', array(
		'label' => $options['ttrust_post_show_date']['name'],
		'section' => 'ttrust_posts',
		'settings' => $themename.'[ttrust_post_show_date]',
		'type' => $options['ttrust_post_show_date']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_post_show_category]', array(
		'default' => $options['ttrust_post_show_category']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_show_category', array(
		'label' => $options['ttrust_post_show_category']['name'],
		'section' => 'ttrust_posts',
		'settings' => $themename.'[ttrust_post_show_category]',
		'type' => $options['ttrust_post_show_category']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_post_show_comments]', array(
		'default' => $options['ttrust_post_show_comments']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_show_comments', array(
		'label' => $options['ttrust_post_show_comments']['name'],
		'section' => 'ttrust_posts',
		'settings' => $themename.'[ttrust_post_show_comments]',
		'type' => $options['ttrust_post_show_comments']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_post_featured_img_size]', array(
		'default' => $options['ttrust_post_featured_img_size']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_featured_img_size', array(
		'label' => $options['ttrust_post_featured_img_size']['name'],
		'section' => 'ttrust_posts',
		'settings' => $themename.'[ttrust_post_featured_img_size]',
		'type' => $options['ttrust_post_featured_img_size']['type'],
		'choices' => $options['ttrust_post_featured_img_size']['options']
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_post_show_featured_image]', array(
		'default' => $options['ttrust_post_show_featured_image']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_show_featured_image', array(
		'label' => $options['ttrust_post_show_featured_image']['name'],
		'section' => 'ttrust_posts',
		'settings' => $themename.'[ttrust_post_show_featured_image]',
		'type' => $options['ttrust_post_show_featured_image']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_infinite_scrolling]', array(
		'default' => $options['ttrust_infinite_scrolling']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_featured_infinite_scrolling', array(
		'label' => $options['ttrust_infinite_scrolling']['name'],
		'section' => 'ttrust_posts',
		'settings' => $themename.'[ttrust_infinite_scrolling]',
		'type' => $options['ttrust_infinite_scrolling']['type'],
		'choices' => $options['ttrust_infinite_scrolling']['options']
	) );
	
	/* Footer */
	$wp_customize->add_section( 'ttrust_footer', array(
		'title' => __( 'Footer', 'themetrust' ),
		'priority' => 29
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_footer_left]', array(
		'default' => $options['ttrust_footer_left']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Textarea_Control( $wp_customize, 'ttrust_customizer_footer_left', array(
		'label' => $options['ttrust_footer_left']['name'],
		'section' => 'ttrust_footer',
		'settings' => $themename.'[ttrust_footer_left]',
		'type' => $options['ttrust_footer_left']['type']
	) ) );
	
	$wp_customize->add_setting( $themename.'[ttrust_footer_right]', array(
		'default' => $options['ttrust_footer_right']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Textarea_Control( $wp_customize, 'ttrust_customizer_footer_right', array(
		'label' => $options['ttrust_footer_right']['name'],
		'section' => 'ttrust_footer',
		'settings' => $themename.'[ttrust_footer_right]',
		'type' => $options['ttrust_footer_right']['type']
	) ) );
	
	/* Slideshow */
	$wp_customize->add_section( 'ttrust_slideshow', array(
		'title' => __( 'Slideshow', 'themetrust' ),
		'priority' => 30
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_slideshow_delay]', array(
		'default' => $options['ttrust_slideshow_delay']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( 'ttrust_customizer_slideshow_delay', array(
		'label' => $options['ttrust_slideshow_delay']['name'],
		'section' => 'ttrust_slideshow',
		'settings' => $themename.'[ttrust_slideshow_delay]',
		'type' => $options['ttrust_slideshow_delay']['type']
	) );
	
	$wp_customize->add_setting( $themename.'[ttrust_slideshow_effect]', array(
		'default' => $options['ttrust_slideshow_effect']['std'],
		'type' => 'option'
	) );

	$wp_customize->add_control( 'ttrust_customizer_slideshow_effect', array(
		'label' => $options['ttrust_slideshow_effect']['name'],
		'section' => 'ttrust_slideshow',
		'settings' => $themename.'[ttrust_slideshow_effect]',
		'type' => $options['ttrust_slideshow_effect']['type'],
		'choices' => $options['ttrust_slideshow_effect']['options']
	) );
	
}