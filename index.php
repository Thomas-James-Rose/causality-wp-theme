<!-- Posts Feed Page -->
<?php get_header(); // from header.php ?>

<main class="home-posts">
	<section class="post-feed">
		<?php
		// Main Post Loop - retrieves the posts of the WordPress site */
		if ( have_posts() ):
			while ( have_posts() ) : the_post(); ?>
				<div class="blog-post-extract">
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
		<h2>Post Categories</h2>
		<ul class="post-category-menu">
		<?php
		$category = get_categories();
		foreach ($category as $c) { ?>
			<a href="<?php get_category_link($c->term_id); ?>"><li><?php echo $c->name; ?></li></a> <?php
		}
		?>
		</ul>
	</section>
</main>

<?php get_footer(); // from footer.php ?>
