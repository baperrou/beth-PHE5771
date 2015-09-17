<?php   
	acf_form_head();
	get_header(); 
	$form = $_GET['form'];
	$tax_id = $_SESSION['app_id'];
	$is_there_a_form = get_posts(array(
	  'post_type' => $form,
	  'numberposts' => -1,
	  'tax_query' => array(
	    array(
	      'taxonomy' => 'app_name',
	      'field' => 'id',
	      'terms' => $tax_id
	    )
	  )
	 )
	);
	$term = get_term_by( 'id', $tax_id, 'app_name' );
	$out= array();
	if($is_there_a_form != null) {
			$get_form = $is_there_a_form[0]->ID;
			$id = $_SESSION['app_id'];
			global $wpdb;
			$group = false;
		}
		else {
			$get_form = 'new_post';
			$update ='no';
			$group = array(form_id($form));
		}
		
	?>

    <div class="container">
      <div class="jumbotron">
	      
	       <div class="row">
		   		<div class="col-md-8">
			        <h1>
			          <?php echo form_name($form); ?>
			        </h1>
			        <p>
			          Helpful info for this form.
			        </p>
		   		</div>
		   		<?php count_questions($tax_id, 'single-app');?>
	       </div>
      </div>
    </div>
   
	        
    <div class="container">
	    <div id="find-active" class="<?php echo $form;?>">
	     <?php yes_no_forms('your_app'); ?>
	     
	    </div>
	    <div class="page-header">
        <h3>
          <?php echo form_name($form); ?>
          <h4></h4>
        </h3>
        <hr>
        
 <?php 
	 //if safety form check for answered questions then give warning
	 if($_GET['begin_safety']) {
		 $begin_safety = 1;
		 } else {
	 		$begin_safety = count_single_form_answered($form, $tax_id);
	 		}
	 if($_GET['disabled'] == 'disabled') {
		echo '<div class="alert alert-info">
          <h3>
            This section has been marked as not relevant for your App
          </h3>
          <p>
            This is because you declared that the App can cause no harm to a user,
            even in the case of a fault with the App. If this is not the case then
            you must enable this section and answer the questions.
          </p>
          <div>
            <br>
            <a href="#" onClick="alert(\'TO DO\')" class="btn btn-default">Enable this section</a>
          </div>
          <p>
          </p>
        </div>';
	}
	
	elseif($begin_safety == 0 && $form == 'safety_form') {
		activation_page($form);
	}
	else { ?>
		
		<?php form_pass_fail($form, $id, 'single_form');?>
	
	
        <p>
          <?php echo form_description($form); ?>
        </p>
      </div>

	    <?php
		acf_form(array(
		//'id'		=> $form,
		'post_id'		=> $get_form,
		'form_attributes' => array(
			'id' => $form,
			'action' => '',
			'method' => 'post',
		),
		
		'field_groups'	=> $group,		
		'submit_value' => __("Save and continue", 'acf'),
		'return'		=> home_url('/app_name/'.$term->slug),	
		));
	
	?>
	
    </div> 
    <?php }?>
    <script type="text/javascript">
	   (function ($) {
		    $(document).live('acf/setup_fields', function(e, div){
				
				$('.page-the-form .acf_postbox .field_type-select option:selected').each(function(){
			   
				   var selected_option = $(this).val();
				//   alert(selected_option);
				   if (selected_option <= -998) {
				   $(this).closest('.field_type-select').addClass('bg-danger');
					}
  			
   });

				});
				  
})(jQuery);
	</script>

    

       <?php get_footer(); ?>
        