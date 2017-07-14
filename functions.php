<?php

// php debugger for Google Chrome
//include 'chromephp/ChromePhp.php';

// enqueue custom scripts and styles
function causality_scripts_enqueue() {
	wp_enqueue_style('themestyles', get_template_directory_uri().'/css/causality.css', array(), '1.0.0', 'all'); // enqueue custom CSS
  wp_enqueue_script('themescripts', get_template_directory_uri().'/js/causality.js', array(), '1.0.0', true);  // enqueue custom JS
}

add_action('wp_enqueue_scripts', 'causality_scripts_enqueue'); // add the custom CSS and JS

// set up the theme
function causality_theme_setup() {

	// theme support
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	$header_args = array(
        'default-text-color' => '000',
        'width'              => 600,
        'height'             => 285,
        'flex-width'         => true,
        'flex-height'        => true,
    );
    add_theme_support( 'custom-header', $header_args );

	// theme nav menu locations
	register_nav_menu('primary_menu', 'Main Menu');
	register_nav_menu('footer_menu', 'Footer Menu');
}

add_action('init', 'causality_theme_setup'); // call the theme setup function when the theme is initialised

function causality_post_setup() {
	add_image_size('header', 500, 250, true);
}

add_action('after_setup_theme', 'causality_post_setup');

// set up the customize register
function causality_customize_register( $wp_customize ) {

	// function for adding an array of the settings to a section in the theme customizer
	function add_settings_to_sections($section, $settings, $wp_customize) {
		for ($i = 0; $i < count($settings); $i++) {
			$wp_customize->add_setting( $settings[$i]->id , array(
				'default'   => $settings[$i]->default_val,
				'transport' => 'refresh',
			) );

			if ($settings[$i]->type == 'color') {
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $settings[$i]->id.'_ctrl', array( // first arg is control_id
					'label'      => __( $settings[$i]->label, 'causality' ),
					'section'    => $section,
					'settings'   => $settings[$i]->id,
					'priority'	 => $i*1,
				) ) );
			} else {
				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $settings[$i]->id.'_ctrl', array( // first arg is control_id
					'label'      => __( $settings[$i]->label, 'causality' ),
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
		'title'      => __( 'Color Scheme', 'causality' ),
		'priority'   => 62,
	) );

	$color_options = array(
		(object)['id' => 'primary_color', 'label' => 'Primary Color', 'type' => 'color', 'default_val' => '#3f51b4'],
		(object)['id' => 'accent_color', 'label' => 'Accent Color', 'type' => 'color', 'default_val' => '#fe5252'],
		(object)['id' => 'primary_text_color', 'label' => 'Complementary Text Color', 'type' => 'color', 'default_val' => '#ffffff']
	);

	add_settings_to_sections('color_scheme', $color_options, $wp_customize);

	// social media options
	$wp_customize->add_section( 'social_media' , array(
		'title'      => __( 'Social Media Links', 'causality' ),
		'priority'   => 61,
	) );

	$social_options = array(
		(object)['id' => 'facebook_link', 'label' => 'Facebook', 'type' => 'text', 'default_val' => ''],
		(object)['id' => 'twitter_link', 'label' => 'Twitter', 'type' => 'text', 'default_val' => ''],
		(object)['id' => 'instagram_link', 'label' => 'Instagram', 'type' => 'text', 'default_val' => ''],
		(object)['id' => 'linkedin_link', 'label' => 'Linkedin', 'type' => 'text', 'default_val' => ''],
	);

	add_settings_to_sections('social_media', $social_options, $wp_customize);

	// footer options - TODO Scrap this and replace it with another area for widgets - apply unique styles
	$wp_customize->add_section( 'footer_options' , array( // first arg is section_id
		'title'      => __( 'Footer Options', 'causality' ),
		'priority'   => 63,
	) );

	$footer_options = array();
	$boxCount = 3;
	for ($i = 0; $i < $boxCount; $i++) {
		$footer_options[$i] = (object)['id' => 'footer_box_'.($i+1), 'label' => 'Footer Box '.($i+1), 'type' => 'textarea', 'default_val' => ''];
	}

	add_settings_to_sections('footer_options', $footer_options, $wp_customize);

	// Developer Options
	$wp_customize->add_section( 'dev_options' , array(
		'title'      => __( 'Developer Options', 'causality' ),
		'priority'   => 999,
	) );

	$dev_options = array(
		(object)['id' => 'scss_recompile', 'label' => 'Recompile SCSS on page load?', 'type' => 'checkbox', 'default_val' => ''],
	);

	add_settings_to_sections('dev_options', $dev_options, $wp_customize);

	// Remove unused sections
	$wp_customize->remove_section('colors');
}

add_action( 'customize_register', 'causality_customize_register' );

function set_excerpt_length() {
	return 30;
}

add_filter('excerpt_length', 'set_excerpt_length');

function causality_init_widgets() {
	register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id' => 'blog_sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3><div class="widget-body">'
	));
}

add_action('widgets_init', 'causality_init_widgets');