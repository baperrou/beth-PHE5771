<?php // CUSTOM FORM OUTPUTS FOR STYLE CONTROL

//updating content type with ACF form

add_filter('acf/pre_save_post' , 'acf_create_post' );

function acf_create_post( $post_id) {
		// bail early if not a new post
	if( $post_id !== 'new_post' ) {
				return $post_id;
		}
	
	
		
	//BEGIN CREATION NEW BASIC FORM	POST
	elseif ($_SESSION['form_type']=='basic_form') {
		

  	// vars
	$form_type = $_SESSION['form_type'];
	global $wpdb;
	$app_id = $wpdb->get_var("SELECT MAX(term_id) FROM $wpdb->terms");
	// create app id session variable
	$_SESSION['app_id'] = $app_id;
	
	
	// Create a new post
	$post = array(
		'post_status'	=> 'publish',
		'post_type'		=> $form_type,
		'post_content'  => 'This is my post.',
		'post_title'	=> 'Basic Form for App '.$app_id,
		
		
	);	
	
	
	// insert the post
	$post_id = wp_insert_post( $post ); 
	// clean up the app id
	$app_ids= array($app_id);
	$app_ids = array_map( 'intval', $app_ids );
	$app_ids = array_unique( $app_ids );
	// insert the newly created app taxonomy for this post
	wp_set_object_terms( $post_id, $app_ids, 'app_name'); 
	//add the app to the developer if they are logged in
		if(isset($_SESSION['developer_id'])){
			//
				wp_set_object_terms( $_SESSION['developer_id'], $app_ids, 'app_name', true); 
				}
			else {
				
			}
	// create basic form id session variable
	$_SESSION['basic_form_id'] = $post_id;
	
	// return the new ID
	return $post_id;
	// remove basic form session variable to prevent duplicates
	unset($_SESSION['form_type']);
	}
	//END CREATION OF BASIC FORM POST
		//*******************************//
	//BEGIN CREATION ANY OTHER FORM	POST
	else  {

	
	//get current app id
	$app_id = $_SESSION['app_id'];
	$form_type = $_SESSION['form_type'];
	$form_name = form_name($form_type);
	// Create a new post
	$post = array(
		'post_status'	=> 'publish',
		'post_type'		=> $form_type,
		'post_content'  => 'This is my post.',
		'post_title'	=> $form_name.' Form for App '.$app_id,
		);	
	
	
	// insert the post
	$post_id = wp_insert_post( $post ); 
	//clean up the app id
	$app_ids= array($app_id);
	$app_ids = array_map( 'intval', $app_ids );
	$app_ids = array_unique( $app_ids );
	
	//add the app to the equality form just created 
		wp_set_object_terms( $post_id, $app_ids, 'app_name'); 
	

	// return the new ID
	return $post_id;
	}
	
	//END CREATION OF ANY OTHER FORM POST

	
}

// creating html for forms pre-activation page

function activation_page($type) {
	if($type == 'safety_form'){
		$out = '<div class="alert alert-danger">
          <h3>
            Could this be classified as a Medical Device?
          </h3>
          <p>
            Apps that have potential to cause harm may be classified as Medical Devices
            depending on the functionality and level of risk. Medical Devices must
            be approved by the&nbsp; Medicines and Healthcare Products Regulatory Agency
            (MHRA) and become CE marked.
            <br>
            <br>
            If you use any of the following words in your app description your app may be classified as a medical device:&nbsp; amplify, analyse, interpret, alarm, calculate, control, convert, detect, diagnose, measure or monitor.
            <br>
          </p>
          <div>
            <br>
          </div>
          <div>
            CE marked Apps do not need extra self assessment declarations for safety
            and automatically receive the highest \Best practice\' for safety. &nbsp;
            &nbsp; &nbsp; &nbsp;&nbsp;
          </div>
          <p>
          </p>
          <div>
            <br>
          </div>
          <h4>
            Which of these descriptions best describes your App?
          </h4>
          <p>
          </p>
          <div>
            <br>
          </div>
          <p>
          </p>
          <div class="row">
            <div class="col-md-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">
                    Reference tool
                  </h3>
                </div>
                <div class="panel-body">
                  Your App doesn\'t collect data but provides access to reference materials
                  or background information.
                  <br>
                  <br>
                  <b>Probably not a Medical Device</b>
                  <br>
                  <br>
                  <a href="#" class="btn btn-default">Continue with self assessment</a>
                </div>
              </div>
              <p>
              </p>
            </div>
            <div class="col-md-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">
                    Health data collection
                  </h3>
                </div>
                <div class="panel-body">
                  Your App enables users to enter and retrieve health data but does not
                  perform any calculations or interpretations of that data.
                  <br>
                  <br>
                  <b>Probably not a Medical Device</b>
                  <br>
                  <br>
                  <a href="#" class="btn btn-default">Continue with self assessment</a>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">
                    Simple/low risk calculator
                  </h3>
                </div>
                <div class="panel-body">
                  Your App collects data and then performs simple calculations or interpolation
                  of that data. Those calculations are simple and are also a low risk of
                  causing harm.
                  <br>
                  <br>
                  <b>This may or may not be a Medical device. You should check the MHRA guidance before choosing an option below.</b>
                  <br>
                  <br>
                  <a href="#" class="btn btn-default">Start MHRA Approval</a>
                  <br>
                  <br>
                  <a href="#" class="btn btn-default">Continue with self assessment</a>
                  <div>
                    <br>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">
                    Complex/high risk tool
                  </h3>
                </div>
                <div class="panel-body">
                  Your App collects data and performs complex calculations and/or calculations
                  that have a higher risk of causing harm or a risk of significant harm.&nbsp;
                  <br>
                  <br>
                  <b>This is probably classed as a Medical Device and will require MHRA approval before this assessment can be submitted.</b>
                  <br>
                  <br>
                  <a href="#" class="btn btn-default">Start MHRA Approval</a>
                </div>
              </div>
            </div>
          </div>
        </div>';
	}
	
	
	
	
}
