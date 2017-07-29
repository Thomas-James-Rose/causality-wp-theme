<!-- Single Post Page -->
<?php get_header(); // from header.php ?>

<main class="sidebar-page">
	<section class="post-feed">
		<?php
		if ( have_posts() ):
			while ( have_posts() ) : the_post(); ?>
				<div class="blog-post">
					<h2 class="post-title"><?php the_title(); ?></h2>
					<p class="post-date"><?php the_time('j F, Y'); ?></p>
					<?php the_category(); ?>
					<div class="post-thumbnail">
						<?php if(has_post_thumbnail()) : the_post_thumbnail(); endif; ?>
					</div>
					<p><?php the_content(); ?></p>
					<?php comments_template(); ?>
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
