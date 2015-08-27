<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div class="container main">
		
			
			<?php if(!is_mobile()):?>
		<div class="row">
			<div class="col-lg-3"><?php the_news_subnav($post->ID);  ?></div>
			<div class="col-lg-9">
					
					<?php echo get_the_post_thumbnail($post->ID, 'news-small', array( 'class' => 'img-responsive' )); ?>
					<h1><?php the_title(); ?></h1>
					<p class="date"><?php the_date('j, F Y'); ?> </p>
					<div class="news-content"><?php the_content(); ?></div>
			</div>
		</div>
				
				
				<?php else:
					mobile_news_single($post->ID); ?>
				
				
				
			
			<?php endif; endwhile; endif; ?>
		
</div>
<?php get_footer(); ?>
