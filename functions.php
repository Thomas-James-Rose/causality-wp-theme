<?php

// php debugger for Google Chrome
include 'chromephp/ChromePhp.php';

/* --
BEGINNER DEV NOTES: functions.php manages the backend of the theme and is commonly used to hook into the WordPress core.
It can be used to add custom CSS and JS to the theme as well as to enable theme support and register nav menus etc.
-- */

// enqueue custom scripts and styles
function origin_scripts_enqueue() {
	wp_enqueue_style('themestyles', get_template_directory_uri().'/css/origin.css', array(), '1.0.0', 'all'); // enqueue custom CSS
  wp_enqueue_script('themescripts', get_template_directory_uri().'/js/origin.js', array(), '1.0.0', true);  // enqueue custom JS
}

add_action('wp_enqueue_scripts', 'origin_scripts_enqueue'); // add the custom CSS and JS

// set up the theme
function origin_theme_setup() {

	// theme support
	add_theme_support('menus');
	add_theme_support('custom_background'); // <-- can probably be deleted
	add_theme_support('custom-header');

	// theme nav menu locations
	register_nav_menu('primary_menu', 'Main Menu');
	register_nav_menu('footer_menu', 'Footer Menu');
}

add_action('init', 'origin_theme_setup'); // call the theme setup function when the theme is initialised

// set up the customize register
function origin_customize_register( $wp_customize ) {
	$wp_customize->remove_section('colors'); // remove the pre-existing color customization section

	// color customization options
	$wp_customize->add_section( 'color_scheme' , array( // first arg is section_id
		'title'      => __( 'Color Scheme', 'origin' ),
		'priority'   => 30,
	) );

	$color_options = array(
		(object)['id' => 'primary_color', 'label' => 'Primary Color', 'default_val' => '#dd3333'],
		(object)['id' => 'secondary_color', 'label' => 'Secondary Color', 'default_val' => '#000000'],
		(object)['id' => 'tertiary_color', 'label' => 'Accent Color', 'default_val' => '#dd9933'],
		(object)['id' => 'header_footer_text_color', 'label' => 'Header/Footer Text Color', 'default_val' => '#000000'],
		(object)['id' => 'nav_text_color', 'label' => 'Main Navigation Text Color', 'default_val' => '#ffffff'],
	);

	for ($i = 0; $i < count($color_options); $i++) {
		$wp_customize->add_setting( $color_options[$i]->id , array(
			'default'   => $color_options[$i]->default_val,
			'transport' => 'refresh',
		));

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color_options[$i]->id.'_ctrl', array( // first arg is control_id
			'label'      => __( $color_options[$i]->label, 'origin' ),
			'section'    => 'color_scheme',
			'settings'   => $color_options[$i]->id,
			'priority'	 => $i*1,
		) ) );
	}

	// social media options
	$wp_customize->add_section( 'social_media' , array( // first arg is section_id
		'title'      => __( 'Social Media Links', 'origin' ),
		'priority'   => 40,
	) );

	$social_options = array(
		(object)['id' => 'facebook_link', 'label' => 'Facebook', 'default_val' => ''],
		(object)['id' => 'twitter_link', 'label' => 'Twitter', 'default_val' => ''],
		(object)['id' => 'instagram_link', 'label' => 'Instagram', 'default_val' => ''],
		(object)['id' => 'linkedin_link', 'label' => 'Linkedin', 'default_val' => ''],
	);

	for ($i = 0; $i < count($social_options); $i++) {
		$wp_customize->add_setting( $social_options[$i]->id , array(
			'default'   => $social_options[$i]->default_val,
			'transport' => 'refresh',
		));

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $social_options[$i]->id.'_ctrl', array( // first arg is control_id
			'label'      => __( $social_options[$i]->label, 'origin' ),
			'type'			 => 'text',
			'section'    => 'social_media',
			'settings'   => $social_options[$i]->id,
			'priority'	 => $i*1,
		) ) );
	}
	//ChromePhp::log(get_theme_mod('facebook_link'));
}
add_action( 'customize_register', 'origin_customize_register' );

// add customizable css to page header
function origin_customize_css() // add the classes in the style tag to html elements to apply the custom colors
{
    ?>
         <style type="text/css">
				 		 /* Color Classes */
             .primary-color { background-color: <?php echo get_theme_mod('primary_color'); ?>; }
						 .secondary-color { background-color: <?php echo get_theme_mod('secondary_color'); ?>; }
						 .accent-color { background-color: <?php echo get_theme_mod('tertiary_color'); ?>; }
						 .nav-text { color: <?php echo get_theme_mod('nav_text_color'); ?>; }

						 /* Header and Footer */
						 header, footer { color: <?php echo get_theme_mod('header_footer_text_color'); ?>; }

						 /* Top Nav */
						 /*.top-nav { border-left: solid 0.1em <?php echo get_theme_mod('tertiary_color'); ?>; }*/
						 .top-nav > li > a {
						 	 color: <?php echo get_theme_mod('nav_text_color'); ?>;
							 background: <?php echo get_theme_mod('secondary_color'); ?>;
							 border-bottom: solid 0.3em <?php echo get_theme_mod('secondary_color'); ?>;
						 }
						 .top-nav > li > a:hover { border-bottom: solid 0.3em <?php echo get_theme_mod('tertiary_color'); ?>;}
						 .top-nav > .current_page_item > a { border-bottom: solid 0.3em <?php echo get_theme_mod('tertiary_color'); ?>;}
						 .top-nav > li > .sub-menu > li > a {
							 color: <?php echo get_theme_mod('nav_text_color'); ?>;
							 background: <?php echo get_theme_mod('secondary_color'); ?>;
							 border-left: solid 0.2em <?php echo get_theme_mod('secondary_color'); ?>;
						 }
						 .top-nav > li > .sub-menu > li > a:hover { border-left: solid 0.2em <?php echo get_theme_mod('tertiary_color'); ?>; }
						 .top-nav > li > .sub-menu > .current_page_item > a { border-left: solid 0.2em <?php echo get_theme_mod('tertiary_color'); ?>; }

						 /* Footer Nav */
						 .footer-nav > li > a {
							 color: <?php echo get_theme_mod('header_footer_text_color'); ?>;
							 border-left: solid 0.1em <?php echo get_theme_mod('secondary_color'); ?>;
						 }
						 .footer-nav > li > a:hover { border-left: solid 0.1em <?php echo get_theme_mod('tertiary_color'); ?>;}
						 .footer-nav > li > a:hover { color: <?php echo get_theme_mod('tertiary_color'); ?>;}
         </style>
    <?php
}
add_action( 'wp_head', 'origin_customize_css');
