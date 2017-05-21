<?php
/* --
BEGINNER DEV NOTES: This is an example of a custom page template that can be selected
in the WordPress back-end.
-- */
?>

<?php get_header(); // from header.php ?>

	<main>
		<?php
		// Main Post Loop
		/* Retrieves the posts of the WordPress site */
		if ( have_posts() ):
			while ( have_posts() ):
				the_post(); ?>
				<h2><?php the_title(); ?></h2>
				<p><?php the_content(); ?></p>
			<?php endwhile;
		endif;
		?>
	</main>

<?php get_footer(); // from footer.php ?>
