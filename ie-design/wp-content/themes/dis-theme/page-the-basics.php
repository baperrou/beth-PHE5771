<?php 
  
	acf_form_head();
	get_header(); 
	if(isset($_SESSION['basic_form_id'])) {
			$basic_post = $_SESSION['basic_form_id'];
			$id = $_SESSION['app_id'];
			global $wpdb;
			$app_name = $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE term_id = $id");
			$update ='yes';
			$group = false;
		}
		else {
			$basic_post = 'new_post';
			$update ='no';
			$group = array(15);
		}
		
	?>

    <div class="container 099">
      <div class="jumbotron 099">
        <h1>
          The basics
        </h1>
        <p>
          Answer these simple questions and we'll let you know if self assessment
          is appropriate for your App and give you some pointers for preparing for
          your assessment.
        </p>
        <p>
        </p>
      </div>
    </div>
    <div class="container">
	    <div class="form-group">
	        <div class="well">
	          <label>
	            What is the name of your App?
	          </label>
	          
	          <form id="insert_term" name="insert_term" method="post" action=""> 
	
			    <input type="text" value="<?php echo $app_name; ?>" name="term" id="term" class="form-control" /> 
			    
			    <input type="hidden" name="update" id="update" value="<?php echo $update; ?>" />
			
				</form> 
	        </div>
        </div>
        <hr>

	    <?php
		acf_form(array(
		//'id'		=> 'basic_form',
		'post_id'		=> $basic_post,	
		'form_attributes' => array(
			'id' => 'basic_form',
			'action' => '',
			'method' => 'post',
		),
	
		'field_groups'	=> $group,		
		'submit_value' => __("Submit your answers", 'acf'),
		'return'		=> home_url('the-results'),	
		));
	
	?>
    </div> 
    <?php get_footer(); ?>