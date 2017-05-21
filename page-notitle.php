<?php
/* --
BEGINNER DEV NOTES: page.php is a specific page template designed to generate pages only (not posts!).
-- */

/*
Template Name: No Title
*/
?>

<?php get_header(); // from header.php ?>

<main class="main-content">
	<?php
	// Main Post Loop
	/* Retrieves the posts of the WordPress site - without the title! */
	if ( have_posts() ):
		while ( have_posts() ):
			the_post(); ?>
			<p><?php the_content(); ?></p>
		<?php endwhile;
	endif;
	?>
</main>

<?php get_footer(); // from footer.php ?>
