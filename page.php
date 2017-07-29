<?php get_header(); // from header.php ?>

	<main>
		<?php
		// Main Post Loop
		/* Retrieves the posts of the WordPress site */
		if ( have_posts() ):
			while ( have_posts() ):
				the_post(); ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
				<p><?php the_content(); ?></p>
			<?php endwhile;
		endif;
		?>
	</main>

<?php get_footer(); // from footer.php ?>
