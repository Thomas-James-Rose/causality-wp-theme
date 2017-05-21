<?php
/* -- 
BEGINNER DEV NOTES: index.php is used to generate each page of the WP site and pulls in content using a variety of functions.    
-- */
?>

<?php get_header(); // from header.php ?>
	
	<?php 
	// Main Post Loop
	/* Retrieves the posts of the WordPress site */
	if ( have_posts() ):
		while ( have_posts() ):
			the_post(); ?>
			<h2><?php the_title(); ?></h2>
			<small>Posted on: <?php the_time('F j, Y'); ?><?php the_category(); ?></small>
			<p><?php the_content(); ?></p>
		<?php endwhile;
	endif;
	?>	

<?php get_footer(); // from footer.php ?>