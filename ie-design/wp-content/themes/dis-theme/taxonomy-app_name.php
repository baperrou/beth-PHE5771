<?php

get_header(); 
 $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
// if(!isset($_SESSION['app_id'])) {
	 $_SESSION['app_id']= $term->term_id;
//	 }

?>

<div class="container">
      <div class="jumbotron">
        <div class="row">
          <div class="col-md-8">
            <h1><?php echo $term->name; ?></h1>
            <p>
              Answer the questions to build your self assessment score. You can see
              your summary as you go in the overview
            </p>
          </div>
          <?php count_questions($term->term_id, 'single-app');?>
        </div>
       
      </div>
      <?php count_questions($term->term_id, 'total-alert');?>
      
      <?php yes_no_forms('your_app'); ?>
      <div class="page-header">
        <h3>
          Summary of your assessment
        </h3>
        <div class="row">
          <div class="col-md-3 alert-info">
            <h3>
              Unacceptable
            </h3>
            <p>
              There are essential requirements that have not been met
            </p>
          </div>
          <div class="col-md-3 not-needed">
            <h3>
              Basic
            </h3>
            <p>
              All essential requirements have been met.
            </p>
          </div>
          <div class="col-md-3 not-needed">
            <h3>
              Enhanced
            </h3>
            <p>
              Some enhanced best practice has been declared with supporting documentation.
            </p>
          </div>
          <div class="col-md-3 not-needed">
            <h3>
              Best practice
            </h3>
            <p>
              A high degree of best practice has been declared with supporting documentation.
            </p>
          </div>
        </div>
      </div>
      <ul class="list-group">
       	<?php form_pass_fail('ps_form', $term->term_id, 'app_name');?> 
       	<?php form_pass_fail('equality_form', $term->term_id, 'app_name');?> 
       	<?php form_pass_fail('eff_form', $term->term_id, 'app_name');?>  
       	<?php form_pass_fail('ts_form', $term->term_id, 'app_name');?> 
        <?php form_pass_fail('qu_form', $term->term_id, 'app_name');?> 
        <?php form_pass_fail('safety_form', $term->term_id, 'app_name');?> 
        <?php form_pass_fail('io_form', $term->term_id, 'app_name');?> 
        <?php form_pass_fail('od_form', $term->term_id, 'app_name');?> 
        <?php //form_pass_fail('reg_form', $term->term_id, 'app_name');?>         
      </ul>
      
    </div>
	
	
	
	
	
	
	
	
	
	
			
<?php

get_footer();
?>
