<!-- Posts Feed Page -->
<?php get_header(); // from header.php ?>

<main class="cy-main cy-main--sidebar">
	<section class="cy-main__post-feed">
		<?php
		// Main Post Loop - retrieves the posts of the WordPress site */
		if ( have_posts() ):
			while ( have_posts() ) : the_post(); ?>
				<div class="blog-post">
					<a class="post-title" href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
					<p class="post-date"><?php the_time('j F, Y'); ?></p>
					<?php the_category(); ?>
					<div class="post-thumbnail">
						<?php if(has_post_thumbnail()) : the_post_thumbnail(); endif; ?>
					</div>
					<p><?php the_excerpt(); ?></p>
				</div>
			<?php endwhile;
		endif;
		?>
	</section>
	<section class="sidebar">
		<?php
		if(is_active_sidebar('blog_sidebar')) :
			dynamic_sidebar('blog_sidebar');
		endif;
		?>
	</section>
</main>

<?php get_footer(); // from footer.php ?>
