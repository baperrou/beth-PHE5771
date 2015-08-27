<?php 
	get_header(); 
	 
	?>
<div class="container">
            
<?php get_sidebar('signin-modals' ); ?>

      </div>
      <hr>
     
      <div class="container">
        <!--<h1><?php echo $_SESSION['app_id']; ?></h1>
        <h2>Form type <?php echo $_SESSION['form_type']; ?></h2>-->
          <?php yes_no_forms('started');?>
          
      
      </div>
      <hr>
    </div>
    
    <?php get_footer(); ?>