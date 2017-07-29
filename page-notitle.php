<?php
/*
Template Name: No Title
*/
?>

<?php get_header(); // from header.php ?>

<main>
	<?php
	if ( have_posts() ):
		while ( have_posts() ):
			the_post(); ?>
			<p><?php the_content(); ?></p>
		<?php endwhile;
	endif;
	?>
</main>

<?php get_footer(); // from footer.php ?>
