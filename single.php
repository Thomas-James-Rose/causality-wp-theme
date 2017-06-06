<!-- Single Post Page -->
<?php get_header(); // from header.php ?>

<main>
		<?php
		if ( have_posts() ):
			while ( have_posts() ) : the_post(); ?>
				<div class="blog-post-extract">
					<a class="post-title" href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
					<p class="post-date"><?php the_time('j F, Y'); ?></p>
					<?php the_category(); ?>
					<div class="post-thumbnail">
						<?php if(has_post_thumbnail()) : the_post_thumbnail(); endif; ?>
					</div>
					<p><?php the_content(); ?></p>
				</div>
			<?php endwhile;
		endif;
		?>
</main>

<?php get_footer(); // from footer.php ?>
