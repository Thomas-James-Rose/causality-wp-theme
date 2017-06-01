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

	// theme nav menu locations
	register_nav_menu('primary_menu', 'Main Menu');
	register_nav_menu('footer_menu', 'Footer Menu');
}

add_action('init', 'origin_theme_setup'); // call the theme setup function when the theme is initialised

// set up the customize register
function origin_customize_register( $wp_customize ) {

	// function for adding an array of the settings to a section in the theme customizer
	function add_settings_to_sections($section, $settings, $wp_customize) {
		for ($i = 0; $i < count($settings); $i++) {
			$wp_customize->add_setting( $settings[$i]->id , array(
				'default'   => $settings[$i]->default_val,
				'transport' => 'refresh',
			) );

			if ($settings[$i]->type == 'color') {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $settings[$i]->id.'_ctrl', array( // first arg is control_id
					'label'      => __( $settings[$i]->label, 'origin' ),
					'section'    => $section,
					'settings'   => $settings[$i]->id,
					'priority'	 => $i*1,
				) ) );
			} else {
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $settings[$i]->id.'_ctrl', array( // first arg is control_id
					'label'      => __( $settings[$i]->label, 'origin' ),
					'type'			 => $settings[$i]->type,
					'section'    => $section,
					'settings'   => $settings[$i]->id,
					'priority'	 => $i*1,
				) ) );
			}
		}
	}

	// color customization options
	$wp_customize->add_section( 'color_scheme' , array(
		'title'      => __( 'Color Scheme', 'origin' ),
		'priority'   => 30,
	) );

	$color_options = array(
		(object)['id' => 'primary_color', 'label' => 'Primary Color', 'type' => 'color', 'default_val' => '#dd3333'],
		(object)['id' => 'secondary_color', 'label' => 'Secondary Color', 'type' => 'color', 'default_val' => '#000000'],
		(object)['id' => 'tertiary_color', 'label' => 'Accent Color', 'type' => 'color', 'default_val' => '#dd9933'],
		(object)['id' => 'header_footer_text_color', 'label' => 'Header/Footer Text Color', 'type' => 'color', 'default_val' => '#000000'],
		(object)['id' => 'nav_text_color', 'label' => 'Main Navigation Text Color', 'type' => 'color', 'default_val' => '#ffffff'],
	);

	add_settings_to_sections('color_scheme', $color_options, $wp_customize);

	// social media options
	$wp_customize->add_section( 'social_media' , array(
		'title'      => __( 'Social Media Links', 'origin' ),
		'priority'   => 40,
	) );

	$social_options = array(
		(object)['id' => 'facebook_link', 'label' => 'Facebook', 'type' => 'text', 'default_val' => ''],
		(object)['id' => 'twitter_link', 'label' => 'Twitter', 'type' => 'text', 'default_val' => ''],
		(object)['id' => 'instagram_link', 'label' => 'Instagram', 'type' => 'text', 'default_val' => ''],
		(object)['id' => 'linkedin_link', 'label' => 'Linkedin', 'type' => 'text', 'default_val' => ''],
	);

	add_settings_to_sections('social_media', $social_options, $wp_customize);

	// footer options
	$wp_customize->add_section( 'footer_options' , array( // first arg is section_id
		'title'      => __( 'Footer Options', 'origin' ),
		'priority'   => 65,
	) );

	$footer_options = array();
	$boxCount = 3;
	for ($i = 0; $i < $boxCount; $i++) {
		$footer_options[$i] = (object)['id' => 'footer_box_'.($i+1), 'label' => 'Footer Box '.($i+1), 'type' => 'textarea', 'default_val' => ''];
	}

	add_settings_to_sections('footer_options', $footer_options, $wp_customize);

	// --- dynamic theme customizer code --- //
	/*$wp_customize->add_setting( 'footer_boxes_num' , array( // add code to refresh customize panel when this option is modified
		'default'   => 3,
		'transport' => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_boxes_num_ctrl', array(
		'label'      => __( 'Number of Footer Boxes', 'origin' ),
		'type'			 => 'number',
		'section'    => 'footer_options',
		'settings'   => 'footer_boxes_num',
		'priority'	 => 1,
	) ) );*/

	//ChromePhp::log('footer_boxes_num = '.get_theme_mod('footer_boxes_num'));
	// --- end --- //
}
add_action( 'customize_register', 'origin_customize_register' );

function origin_customizer_update()
{
	wp_enqueue_script(
		  'origin_themecustomizer', // give the script and ID
			get_template_directory_uri().'/js/theme-customizer.js', // point to file
		  array( 'jquery','customize-preview' ),	// define dependencies
		  '1.0.0',						// define a version (optional)
		  true					// put script in footer?
	);
}
//add_action( 'customize_preview_init', 'origin_customizer_update' );

function set_excerpt_length() {
	return 30;
}

add_filter('excerpt_length', 'set_excerpt_length');
