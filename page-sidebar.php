<?php
/*
Template Name: Sidebar
*/
?>

<?php get_header(); // from header.php ?>

<main class="sidebar-page">
	<section class="page-content">
		<?php
		if ( have_posts() ):
			while ( have_posts() ):
				the_post(); ?>
				<h1 class="page-title"><?php the_title(); ?></h1>
				<p><?php the_content(); ?></p>
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
