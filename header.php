<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php bloginfo('name'); ?></title>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <?php require('css/scss.php'); compileSCSS(); // compile the scss before origin.css is loaded ?>
	<?php wp_head(); ?> <!-- get the header generated by functions.php -->
</head>

<?php
/* this PHP adds a custom class to the body depending on whether
   or not the current page is the home page */
if (is_front_page()):
	$custom_class = 'home-page';
endif;
?>

<body <?php body_class($custom_class); // call the WP function to create a class for each body on each page ?>>
	<header class="origin-header">
		<div class="top-bar">
			<div class="icon-outer-wrapper secondary-color">
				<div class="icon-inner-wrapper">
					<?php
						if(get_theme_mod('facebook_link') != ''):
							echo '<a class="header-icon" href="' . get_theme_mod('facebook_link') . '"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>';
						endif;
						if(get_theme_mod('twitter_link') != ''):
							echo '<a class="header-icon" href="' . get_theme_mod('twitter_link') . '"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
						endif;
						if(get_theme_mod('instagram_link') != ''):
							echo '<a class="header-icon" href="' . get_theme_mod('instagram_link') . '"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
						endif;
						if(get_theme_mod('linkedin_link') != ''):
							echo '<a class="header-icon" href="' . get_theme_mod('linkedin_link') . '"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
						endif;
					?>
				</div>
			</div>
			<?php
			if (has_nav_menu('primary_menu')):
				wp_nav_menu(array('container' => 'nav', 'menu_class' => 'origin-nav top-nav', 'theme_location' => 'primary-menu'));
			endif;
			?>
		</div>
		<div class="logo-wrapper">
			<?php if(get_header_textcolor() != 'blank'): // <!-- check this stuff! Still doing anything?
				echo '<h1 class="custom-header">';
					bloginfo('name');
				echo '</h1>';
			endif; ?>
			<?php if(get_header_textcolor() != 'blank'):
				echo '<h3 class="custom-header">';
					bloginfo('description');
				echo '</h3>';
			endif; ?>
			<?php if(get_header_image() != ''):
				echo '<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />';
			endif;?>
		</div>
	</header>
