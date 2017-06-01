<?php get_header(); // from header.php ?>

<main>
	<?php
	// Main Post Loop
	/* Retrieves the posts of the WordPress site */
	if ( have_posts() ):
		while ( have_posts() ) : the_post(); ?>
			<div class="blog-post-extract">
				<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
				<small>Posted on: <?php the_time('F j, Y'); ?><?php the_category(); ?></small>
				<p><?php the_excerpt(); ?></p>
			</div>
		<?php endwhile;
	endif;
	?>
</main>

<?php get_footer(); // from footer.php ?>
