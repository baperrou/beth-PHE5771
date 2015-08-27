<?php get_header(); ?>

<div class="container main">
	
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1><?php the_title(); ?></h1>
			<?php //form_pass_fail('equality_form', 26); ?>
			
		<?php endwhile; endif; ?>
		
		<?php test_count_form_questions('eff_form', 26);?>
</div>
</div>
<?php get_footer(); ?>