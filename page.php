<?php get_header(); ?>
<div id="content">
	<div class="row flex">
		<article>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>





