<?php
/*
 * Template Name: Other Template
 * Description: A Page Template for Other */
 ?>

<?php get_header(); ?>

<div class="container main">
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php $the_people =$post->post_name; ?>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
				<?php the_people($the_people); ?>
		<?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>