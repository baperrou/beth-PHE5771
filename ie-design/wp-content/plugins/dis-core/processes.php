<?php //COMMON PROCESSES
// add sessions to the site
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy ();
}

	
	
function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
	$arrData = array();
	if (is_object($arrObjData)):
		$arrObjData = get_object_vars($arrObjData);
	endif;
	if (is_array($arrObjData)):
		foreach ($arrObjData as $index => $value):
			if (is_object($value) || is_array($value)):
				$value = objectsIntoArray($value, $arrSkipIndices);
			endif;
			if (in_array($index, $arrSkipIndices)):
				continue;
			endif;
			$arrData[$index] = $value;
		endforeach;
	endif;
	return $arrData;
}



function do_truncate_string($string, $limit = 80, $pad = "...")
{
	if (strlen($string) <= $limit) return $string;
	$explode = explode(' ', $string);
	$count   = 0;
	$out     = '';
	foreach ($explode as $word):
		$count = $count + strlen($word);
		if ($count < $limit):
			$out .= $word . ' ';
		endif;
	endforeach;
	return str_replace(',' . $pad, $pad, trim($out) . $pad);
}

function beth_insert_term() {
	global $wpdb;
	$tax = $_REQUEST["app_name"];
	$update = $_REQUEST['update'];
	$id = $_SESSION['app_id'];
	
	if($update == 'yes') {
		// need to fix slug when updating
		$slug = sanitize_title($tax);
		wp_update_term($id, 'app_name', array('name' => $tax,'slug' => $slug));
		}
	else {
	 wp_insert_term($tax, 'app_name');
  }
  $term_id = $wpdb->get_var("SELECT MAX(term_id) FROM $wpdb->terms");
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	  
		 echo $term_id;
		 die();
   }
   else {
      header("Location: ".$_SERVER["HTTP_REFERER"]);
      die();
   }   

}

function create_user_cpt(){
	//request variables needed from ajax
	$app = $_REQUEST["app_id"];
	$name = $_REQUEST["name"];
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];
	$v_password = $_REQUEST['verify_password'];
		/*
	*  Create a new post and add field data
	*  - if the post does not already contain a "reference" to the field object, you must use the field_key instead of the field_name.
	*/
	// first check if email exists already then prompt to login if it does
	$ck_posts = get_posts(array(
		'numberposts'	=> -1,
		'post_type'		=> 'developer',
		'meta_query'	=> array(
			'relation'		=> 'AND',
			array(
				'key'	 	=> 'dev_email',
				'value'	  	=> $email,
				'compare' 	=> '=',
			),
		),
	));
	if($ck_posts[0]->ID){
		$result = 'yes';
	}
	else {
	// Create post object
	$my_post = array(
	    'post_status'	=> 'publish',
		'post_type'		=> 'developer',
		'post_content'  => 'This is my post.',
		'post_title'	=> 'Developer '.$name,
	);
	
	// Insert the post into the database
	$post_id = wp_insert_post( $my_post );
	$_SESSION['developer_id'] = $post_id;
	// Add field value
	update_field( "field_5571f92c8d53b", $email, $post_id );
	update_field( "field_5571f96f8d53c", $password, $post_id );
	update_field( "field_5571f9818d53d", $v_password, $post_id );
	$value = array($app);
	//update_field( "field_5571f9a18d53e", $value, $post_id );
	//select related app via taxonomy
	$app_ids = array_map( 'intval', $value );
	$app_ids = array_unique( $app_ids );
	wp_set_object_terms($post_id, $app_ids, 'app_name'); 
	
	//SEND EMAIL IF ITS A NEW REG FORM	
				// email data
		$to = $email;
		$headers = 'From: The App Test <apptest@app.com>' . "\r\n";
		$subject = 'New Registration for App Assessment';
		$body = 'Some arbitrary information to be added as and when.';
		// send email
		wp_mail($to, $subject, $body, $headers );

	// END SEND EMAIL IF ITS A NEW REG FORM	
	
		}

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		 echo $result;
		 die();
   }
   else {
      header("Location: ".$_SERVER["HTTP_REFERER"]);
      die();
   }  
   
				
}

// check if developer exists
function check_user_cpt() {
	$user_email = $_REQUEST['user_email'];
	//$user_email = sanitize_email($user_email);
	$user_password = $_REQUEST['user_password'];
	$new_app = $_REQUEST['new_app'];
	
	//do the check
	$posts = get_posts(array(
		'numberposts'	=> -1,
		'post_type'		=> 'developer',
		'meta_query'	=> array(
			'relation'		=> 'AND',
			array(
				'key'	 	=> 'dev_email',
				'value'	  	=> $user_email,
				'compare' 	=> '=',
			),
			array(
				'key'	  	=> 'dev_pass',
				'value'	  	=> $user_password,
				'compare' 	=> '=',
			),
		),
	));
	//print_r($posts);
	//return result
	if($posts[0]->ID){
		$result = 'yes';
		$_SESSION['developer_id'] = $posts[0]->ID;
	}
	if($new_app != null) {
		$value = array($new_app);
		$app_ids = array_map( 'intval', $value );
		$app_ids = array_unique( $app_ids );
		wp_set_object_terms( $_SESSION['developer_id'], $app_ids, 'app_name', true);
		
	}
	
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		 echo $result;
		 die();
   }
   else {
      header("Location: ".$_SERVER["HTTP_REFERER"]);
      die();
   }   

	
	
}
//create pretty names for form post types

function form_name($form){
	switch($form){
		case 'safety_form':
        	return 'Safety';
            break;	
        case 'ps_form':
        	return 'Privacy & Security';
            break;
        case 'io_form':
        	return 'Interoperability';
            break;
        case 'od_form':
        	return 'Open Data';
            break;
        case 'equality_form':
        	return 'Equality';
            break;
        case 'eff_form':
        	return 'Effectiveness';
            break;
         // remove transparency 22 Aug    
        /**case 'trans_form':
        	return 'Transparency';
            break;*/
        case 'qu_form':
        	return 'Usability';
            break;
        case 'ts_form':
        	return 'Technical Stability';
        	break;
       // remove registration 15 Sept 
       // case 'reg_form':
        //	return 'Registration';
       // 	break;

    }
}
function form_id($form){
	switch($form){
		case 'safety_form':
        	return 64;
            break;	
        case 'ps_form':
        	return 86;
            break;
        case 'io_form':
        	return 188;
            break;
        case 'od_form':
        	return 189;
            break;
        case 'equality_form':
        	return 81;
            break;
        case 'eff_form':
        	return 175;
            break;
         // remove transparency 22 Aug    
        /**
        case 'trans_form':
        	return 85;
            break;*/
        case 'qu_form':
        	return 82;
            break;
        case 'ts_form':
        	return 83;
        	break;
        // remove registration 15 Sept
        //case 'reg_form':
        //	return 84;
        //	break;

    }
}
function form_description($form){
	switch($form){
		case 'safety_form':
        	return 'Some apps can cause harm, for instance by miscalculating a drug dose or giving incorrect medical advice to a consumer or patient. The health and care system cannot endorse an app that isn\'t safe. The following questions will help you to determine whether your app has the potential to cause harm. If it does it may need to be assessed and CE marked by the Medicines and Healthcare Regulatory Agency (MHRA).';
            break;	
        case 'ps_form':
        	return 'The health and care system can only endorse an app if it treats personal data legally and securely. In meeting the following standards app developers can assure themselves, and the health and care system, that data is being stored and processed appropriately and with the informed consent of the end user. ';
            break;
        case 'io_form':
        	return 'If your app needs to interface with clinical systems to share data, for instance if your app writes clinical information to the GP-held record, or enables users to access their own records through your app, you will need to ensure it complies with the relevant technical standards.';
            break;
        case 'od_form':
        	return 'Government, academia, private and third sectors and UK PLC all gain by sharing data more widely. Meeting these standards can help to improve your app by sharing data with local academic partners in order to determine the effectiveness of your app. In addition, sharing data openly and safely will result in your app being promoted more by the health and care system.';
            break;
        case 'equality_form':
        	return 'It is important that the apps promoted by the health and care system do not unnecessarily disdavantage some groups of users. All app developers are asked to ensure they meet basic accessibility standards and publish their apps on platforms that give the greatest coverage of their target population.';
            break;
        case 'eff_form':
        	return 'If the health service is going to promote an app, the app must work. The following questions help us to score your app to determine how likely it is to be effective. You can score significantly higher by undertaking or commissioning independent research to determine the effectiveness of your app or by taking advantage of our academic partnering service to share data collected by your app to determine it\'s effectiveness.';
            break;
         // remove transparency 22 Aug    
        /**case 'trans_form':
        	return 'Additional questions which help identify how the app is used and who benefits to enable us to understand how trustworthy the app is likely to be.';
            break;*/
        case 'qu_form':
        	return 'The following resources will help to determine if your app is high quality in terms of usability.';
            break;
        case 'ts_form':
        	return 'The following resources will help to determine if your app is high quality in terms of technical stability.';
        	break;
        // remove registration 15 Sept	
       // case 'reg_form':
        //	return 'The following questions help us better understand, categorise and promote your app to those who could use it or prescribe it. Questions about the apps publisher and developer are also captured here.';
       // 	break;

    }
}

// create threasholds for each form best/basic/enhanced

function create_threasholds($form) {
	$posts = get_posts(array(
		'numberposts'	=> -1,
		'post_type'		=> 's_score',
		'meta_key'		=> 'scored_form',
		'meta_value'	=> $form
	));
	
	
	$bs = get_field('basic_score', $posts[0]->ID);
	$eh =  get_field('enhanced', $posts[0]->ID);
	$bp =  get_field('best_practice', $posts[0]->ID);
	return array($bs, $eh, $bp);
}
//begin per form checks for pass/fail etc

function form_pass_fail($type, $app_id, $page){
	// first check if form exists for app id
	$posts = get_posts(array(
    'post_type' => $type,
    'tax_query' => array(
        array(
        'taxonomy' => 'app_name',
        'field' => 'term_id',
        'terms' => $app_id,
	    )))
	);
	//set initial score to ZERO
	$score = 0;
	// now get the potential questions with answers
	$fields = get_field_objects($posts[0]->ID);
	
	//echo '<pre>'; print_r($posts); echo '</pre>';
	
	
	//this check should apply for all forms	
	if(empty($posts)) {
		// 19991 represents incomplete for now
		$score = '199912';
	}
	
	//privacy and security logic
	elseif ($type == 'ps_form') {	
		//check first question, decide what to do if NO
		if($fields['ps_q1']['value'] =='NO') {
			$score= 'not relevant';
		}
		foreach($fields as $field ){						
			switch($field['value']){
				case -999:
					//all nos represent absolute fail
					// -999 represents fail for now
		        	$score = -999;	
					break;	
				case 'SELECT ANSWER':
					$score = 19991;
					break;
				default :									
					// pass logic for Privacy and Security Only
					$score = 1;
					break;
				}
			}
												
		}
	//safety form logic
	elseif ($type == 'safety_form') {
		//check first question, decide what to do if NO
		if($fields['safety_q1']['value'] =='NO'){ 
			$score= 'not relevant';
			
		}
		elseif($fields['safety_q6']['value'] == -999){
		//this no represents absolute fail 
			$score = -999;	
		}
		
		else{
		
			foreach($fields as $field ){						
				if($field['value'] =='SELECT ANSWER'):
				// 19991 represents incomplete for now
				$score = 19990;
				endif;
			}
			if($fields['safety_q2']['value'] !='SELECT ANSWER'): 
				$score = $score + $fields['safety_q2']['value'];
			endif;
			if($fields['safety_q3']['value'] !='SELECT ANSWER'): 
				$score = $score + 1;
			endif;
			if($fields['safety_q4']['value'] !='SELECT ANSWER'): 
				$score = $score + 1;
			endif;
			if($fields['safety_q5']['value'] !='SELECT ANSWER'): 
				$score = $score + 1;
			endif;
			if($fields['safety_q6']['value'] !='SELECT ANSWER'): 
				$score = $score + 1;
			endif;
		}

	}
	//interoperatbility logic
	elseif ($type == 'io_form') {	
		//check first question, decide what to do if NO
		if($fields['io_q0']['value'] =='NO'): 
			echo 'not relevant';
			break;
		endif;	
		foreach($fields as $field ){						
			switch($field['value']){				
				case 'SELECT ANSWER':
					$score = 19991;
					break;
				default :									
					// pass logic for interoperability all transparent
					// may need to change to add all questions
					$score = 1;
					break;
				}
			}
												
		}	

	//open data logic
	elseif ($type == 'od_form') {
		//check first question, decide what to do if NO
		if($fields['od_q0']['value'] =='NO'): 
			echo 'not relevant';
			break;
		endif;
		if($fields['od_q3']['value'] ==-999):
		//this no represents absolute fail 
			$score = -999;	
			break;
		endif;
		
		
		foreach($fields as $field ){						
			if($field['value'] =='SELECT ANSWER'):
			// 19991 represents incomplete for now
			$score = '19990';
			endif;
		}
		if($fields['od_q2']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['od_q7']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['od_q1']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['od_q5']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['od_q6']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['od_q4']['value'] !='SELECT ANSWER'): 
			$score = $score + $fields['od_q2']['value'];
		endif;


	}
	//equality logic
	elseif ($type == 'equality_form') {	
		//check first question, decide what to do if NO		
		foreach($fields as $field ){						
			switch($field['value']){
				case -999:
					//all nos represent absolute fail
					// -999 represents fail for now
		        	$score = -999;	
					break 2;	
				case 'SELECT ANSWER':
					$score = 19991;
					break 2;
				default :									
					// pass logic for Privacy and Security Only
					$score = 1;
					break 2;
				}
			}
												
		}
	//usability logic
	elseif ($type == 'qu_form') {	
		//check first question, decide what to do if NO	
		$score = 0;	
		foreach($fields as $field ){						
			switch($field['value']){
				case -999:
					//all nos represent absolute fail
					// -999 represents fail for now
		        	$score = -999;	
					break 1;	
				case 'SELECT ANSWER':
					$score = 19991;
					break 1;
				default :									
					// pass logic for Privacy and Security Only
					$score = $score + $field['value'];
					break 1;
				}
			}
												
		}
	//tech stability logic
	elseif ($type == 'ts_form') {	
		//check first question, decide what to do if NO	
		$score = 0;		
		foreach($fields as $field ){						
			switch($field['value']){
				case -999:
					//all nos represent absolute fail
					// -999 represents fail for now
		        	$score = -999;	
					break 1;	
				case 'SELECT ANSWER':
					$score = 19991;
					break 1;
				default :									
					// pass logic for tech stability Only
					// do we need to add up the 1s
					$score = $score + $field['value'];
					break 1;
				}
			}
												
		}	
	//effectiveness data logic
	elseif ($type == 'eff_form') {
		
		foreach($fields as $field ){
			if($field['value'] ==-999):
			//  represents automative fail
			$score = -999;
			break;
			endif;						
			if($field['value'] =='SELECT ANSWER'):
			// 19991 represents incomplete for now
			$score = 19990;
			endif;
		}
		if($fields['eff_q1']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q3']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q5']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q7']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q9']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q12']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q14']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q16']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q18']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q20']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q23']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q25']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q27']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q28']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q30']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;
		if($fields['eff_q32']['value'] !='SELECT ANSWER'): 
			$score = $score + 1;
		endif;

		if($fields['eff_q2']['value'] !='SELECT ANSWER'): 
			$score = $score + $fields['eff_q2']['value'];
		endif;
		if($fields['eff_q8']['value'] !='SELECT ANSWER'): 
			$score = $score + $fields['eff_q8']['value'];
		endif;
		if($fields['eff_q22']['value'] !='SELECT ANSWER'): 
			$score = $score + $fields['eff_q24']['value'];
		endif;
		if($fields['eff_q24']['value'] !='SELECT ANSWER'): 
			$score = $score + $fields['eff_q24']['value'];
		endif;
		if($fields['eff_q26']['value'] !='SELECT ANSWER'): 
			$score = $score + $fields['eff_q26']['value'];
		endif;
		if($fields['eff_q29']['value'] !='SELECT ANSWER'): 
			$score = $score + $fields['eff_q29']['value'];
		endif;
		if($fields['eff_q31']['value'] !='SELECT ANSWER'): 
			$score = $score + $fields['eff_q31']['value'];
		endif;


	}
		
		
		
		
	//AFTER LAST FORM LOGIC	
	else {
		//nothing for now until decide on final outcome
	}
	
	// last chance to check of form is relevant from Basic Form Answers
	// get form basic answer results	
	
	$answers = get_posts(array(
	  'post_type' => 'basic_form',
	  'numberposts' => -1,
	  'tax_query' => array(
		    array(
		      'taxonomy' => 'app_name',
		      'field' => 'id',
		      'terms' => $app_id
		    )
		  )
	  )
	);
	

	// go through questions to turn forms on and off
		//The Safety Form
		if(get_field('basics_q2',  $answers[0]->ID) == 'NO' && $type == 'safety_form'):					
			$score = 'NOTNEEDED';
		endif;
		//The Interoperability Form
		if(get_field('basics_q4',  $answers[0]->ID) == 'NO' && $type == 'io_form'):
			$score = 'NOTNEEDED';
		endif;
		//The Open Data Form
		if(get_field('basics_q5',  $answers[0]->ID) == 'NO' && $type == 'od_form'):
			$score = 'NOTNEEDED';
		endif;
		//The Privacy & Security Form
		if(get_field('basics_q3',  $answers[0]->ID) == 'NO' && $type == 'ps_form'):
			$score = 'NOTNEEDED';
		endif;	
		
	// get thresholds to test with
	list($bs, $eh, $bp) = create_threasholds($type);	
		
	switch($score){
		case $score == "NOTNEEDED" :
			$level = 'Not relevant';	
			$alert = 'alert-info';
			break;
		case $score < 1 :
			// any negative number at this point is a fail
			$alert = 'alert-danger';
			$text = 'Your app has failed evaluation for 1 or more reasons.  Please see red below to correct';	
			$level = 'Failed';
			$test = 0;
			break;
		case $score >= $bs && $score < $eh:
			$alert = 'alert-success';
			$text = 'Your app has passed this section.';
			$level = 'Basic';
			$test = 2;
			break;	
		case $score >= $eh && $score < $bp:
			$alert = 'alert-success';
			$text = 'Your app has passed this section.';
			$level = 'Enhanced';
			$test = 3;
			break;	
		case $score >= $bp && $score < 2000:
			$alert = 'alert-success';
			$text = 'Your app has passed this section.';
			$level = 'Best Practice';
			$test = 4;
			break;	
		case $score >5000:
			$alert = 'alert-warning';
			$text = 'You have not yet completed this section.';
			$level = 'Incomplete';
			$test = 1;
			break;
		
	}
	if($page == 'single_form')	{	
		$out = '<div class="alert ' .$alert. '  "><h3> ' . $text . '</h3></div>';
		//echo '<h2>SCORE ';
		//echo $score;
		//echo '</h2>';
		echo $out;
	}
	elseif($page == 'app_name') {
		$out = '<li class="list-group-item">';
        $out .='<span class="badge '.$alert.'">'. $level.'</span><b>';
        $out .= form_name($type);
        $out .= '</b></li>';
        echo $out;
	}
	elseif($page =='just_score') {
		return $test;
	}
	
}


//TESTING SECTION FOR LOGIC AND COUNTING PURPOSES
function test_count_form_questions($type, $app_id) {
	// first check if form exists for app id
	$posts = get_posts(array(
    'post_type' => $type,
    'tax_query' => array(
        array(
        'taxonomy' => 'app_name',
        'field' => 'term_id',
        'terms' => $app_id,
	    )))
	);

	// now count number of questions that can currently be completed
	$fields = get_field_objects($posts[0]->ID);
		// $q represents total questions
	$q = 0;
	$groups = array();
	$groups = apply_filters('acf/field_group/get_fields', $groups, form_id($type));
	echo '<pre>'; print_r($groups); echo '</pre>';
	
		foreach($groups as $group ){
			if(empty($posts)) {
				if($group['conditional_logic']['status'] != "1") {
					$q++;
				}
			}
			else {
				$q++;
			}											
		}
		//check to see if the form exists yet for APP id
		if(!empty($posts)) {
		// testing for conditional logic on specific forms removing questions from count with conditional logic			
			//privacy and security form
			if($type == 'ps_form'):
				if($fields['ps_q1']['value'] != 'YES'):
					$q= $q - 11;
				endif;				
			endif;
			//safety form
			if($type == 'safety_form'):
				if($fields['safety_q1']['value'] != 'YES'):
					$q= $q - 5;
				endif;				
			endif;
			// Usability form
			if($type == 'qu_form'):
				//no logic needed
			endif;			
			//interoperability form
			if($type == 'io_form'):
				if($fields['io_q0']['value'] != 'YES'):
						$q=$q-7;
					endif;
				if($fields['io_q1']['value'] != 'YES'):
					$q--; $q--;
				endif;
				if($fields['io_q4']['value'] != 'YES'):
					$q--; $q--;
				endif;
				if($fields['io_q7']['value'] != 'YES'):
					$q--; 
				endif;
				if($fields['io_q10']['value'] != 'YES'):
					$q--;
				endif;
				if($fields['io_q12']['value'] != 'YES'):
					$q--; $q--;
				endif;
				if($fields['io_q15']['value'] != 'YES'):
					$q--; $q--;
				endif;
			endif;
			//Open Data form
			if($type == 'od_form'):
				if($fields['od_q0']['value']!= 'YES'):
					$q= $q - 7;
				endif;	
				if($fields['od_q2']['value']!= 'YES'):
					$q--;
				endif;				
			endif;
			//Equality form
			//no question count logic
			//Effectiveness form
			if($type == 'eff_form'):
				if($fields['eff_q2']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q4']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q6']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q8']['value'] <= -998 OR $fields['eff_q8']['value'] == 'SELECT ANSWER' ):
					$q--;$q--;
				endif;
				if($fields['eff_q11']['value'] != 1):
					$q--; 
				endif;
				if($fields['eff_q13']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q15']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q17']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q19']['value'] != 1):
					$q--;
				endif;	
				if($fields['eff_q21']['value'] != 1):
					$q--;$q--; 
				endif;
				if($fields['eff_q26']['value'] != 'YES'):
					$q--;$q--;
				endif;
				if($fields['eff_q29']['value'] != 'YES'):
					$q--;$q--;$q--;
				endif;				
			endif;
		}
// end testing for conditional logic on specific forms
	//return the total possible questions to answer
	
	return $q;
}


///	NEW FUNCTIONS TO IMPROVE COUNTING LOGIC GOING FORWARD ///

function count_answered_questions_all() {
	
	$tax_id = $_SESSION['app_id'];

	$posts = get_posts(array(
		//remove registration form 16-9-15 'reg_form',
    'post_type' => array( 'equality_form', 'ps_form', 'safety_form', 'od_form',  'qu_form', 'eff_form',  'ts_form', 'io_form' ),
    'tax_query' => array(
        array(
        'taxonomy' => 'app_name',
        'field' => 'term_id',
        'terms' => $tax_id,
	    )))
	);
	
	if($posts != null) {
		foreach($posts as $post){
			
			$fields[] = get_field_objects($post->ID);
		}
	}
	// $i represents filled in value
	$i = 0;
	
	if( $fields ){
		
		foreach( $fields as $key => $field ):
		
			foreach( $field as $key => $question ):
				if( $question['value'] && $question['value'] != 'SELECT ANSWER' ):
				// do counting here
				$i++;
				endif;
			endforeach;
			
		endforeach;
	}
	return $i;

	
}

function single_form_question_count($type, $app_id) {
	// first check if form exists for app id
	$posts = get_posts(array(
    'post_type' => $type,
    'tax_query' => array(
        array(
        'taxonomy' => 'app_name',
        'field' => 'term_id',
        'terms' => $app_id,
	    )))
	);

	// now count number of questions that can currently be completed
	$fields = get_field_objects($posts[0]->ID);
		// $q represents total questions
	$q = 0;
	$groups = array();
	$groups = apply_filters('acf/field_group/get_fields', $groups, form_id($type));
	//echo '<pre>'; print_r($groups); echo '</pre>';
	
		foreach($groups as $group ){
			if(empty($posts)) {
				if($group['conditional_logic']['status'] != "1") {
					$q++;
				}
			}
			else {
				$q++;
			}											
		}
		//check to see if the form exists yet for APP id
		if(!empty($posts)) {
		// testing for conditional logic on specific forms removing questions from count with conditional logic			
			//privacy and security form
			if($type == 'ps_form'):
				if($fields['ps_q1']['value'] != 'YES'):
					$q= $q - 11;
				endif;				
			endif;
			//safety form
			if($type == 'safety_form'):
				if($fields['safety_q1']['value'] != 'YES'):
					$q= $q - 5;
				endif;				
			endif;
			//* Usability form - no dependent logic
			/*if($type == 'qu_form'):
				if($fields['us_q2']['value'] != 1):
					$q--;
				endif;
				if($fields['us_q9']['value'] != 'YES'):
				$q--;
				endif;
			endif;**/		
			//inoperability form
			if($type == 'io_form'):
				if($fields['io_q0']['value'] != 'YES'):
						$q=$q-7;
					endif;
				if($fields['io_q1']['value'] != 'YES'):
					$q--; $q--;
				endif;
				if($fields['io_q4']['value'] != 'YES'):
					$q--; $q--;
				endif;
				if($fields['io_q7']['value'] != 'YES'):
					$q--; 
				endif;
				if($fields['io_q10']['value'] != 'YES'):
					$q--;
				endif;
				if($fields['io_q12']['value'] != 'YES'):
					$q--; $q--;
				endif;
				if($fields['io_q15']['value'] != 'YES'):
					$q--; $q--;
				endif;
			endif;
			//Open Data form
			if($type == 'od_form'):
				if($fields['od_q0']['value'] != 'YES'):
					$q= $q - 6;
				endif;	
				if($fields['od_q2']['value']!= 'YES'):
					$q--;
				endif;				
			endif;
			//Equality form
			//no question count logic
			//Effectiveness form
			if($type == 'eff_form'):
				if($fields['eff_q2']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q4']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q6']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q8']['value'] <= -998 OR $fields['eff_q8']['value'] == 'SELECT ANSWER' ):
					$q--;$q--;
				endif;
				if($fields['eff_q11']['value'] != 1):
					$q--; 
				endif;
				if($fields['eff_q13']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q15']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q17']['value'] != 1):
					$q--;
				endif;
				if($fields['eff_q19']['value'] != 1):
					$q--;
				endif;	
				if($fields['eff_q21']['value'] != 1):
					$q--;$q--; 
				endif;
				if($fields['eff_q26']['value'] != 10):
					$q--;$q--;
				endif;
				if($fields['eff_q29']['value'] != 10):
					$q--;$q--;$q--;
				endif;				
			endif;
		}
// end testing for conditional logic on specific forms
	//return the total possible questions to answer
	
	return $q;

}

function count_single_form_answered($type, $app_id) {
	// first check if form exists for app id
	$posts = get_posts(array(
    'post_type' => $type,
    'tax_query' => array(
        array(
        'taxonomy' => 'app_name',
        'field' => 'term_id',
        'terms' => $app_id,
	    )))
	);

	//now count questions completed per form
	$fields = get_field_objects($posts[0]->ID);
	if($posts != null) {
			// $i represents filled in value
		$i = 0;
		if( $fields ):	
			foreach( $fields as $field ):				
				if( $field['value'] !=null && $field['value'] !="SELECT ANSWER" ):
				// do counting here
				$i++;
				endif;
			endforeach;
		endif;
	}
	//return total answered for form
	return $i;

}

function create_form_status_icon($type, $app_id) {
	$i = count_single_form_answered($type, $app_id);
	  if($i == false) {$i = 0;}
	$q = single_form_question_count($type, $app_id);
		 //if($q = null) {$q = 0;}
	if($i == $q && $i > 0):
		return '<span class="badge"><i class="fa fa-check-circle"></i></span>';
		elseif($i >= 0):
		return '<span class="badge"> '.$i . '/'. $q . '</span>';
		
	endif;

}
// count all questions that could be answered across all forms
function count_questions($app_id, $page) {
	// first test for what forms need filling out from basic answers
	// get form basic answer results
	if(!$_SESSION['app_id']) {
		$tax_id = $app_id;
	}
	else {	
	$tax_id = $_SESSION['app_id'];
	}
	$answers = get_posts(array(
	  'post_type' => 'basic_form',
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
	
	$tax_id = $_SESSION['app_id'];
	// get term slug for overview link
	$term = get_term_by('id', $tax_id, 'app_name');
	//$i is the total questions answered
	// $k is total questions answered or unanswered	
		$i = 	count_single_form_answered('ps_form', $app_id) + 
				count_single_form_answered('qu_form', $app_id) + 
				count_single_form_answered('safety_form', $app_id) + 
				count_single_form_answered('io_form', $app_id) + 
				count_single_form_answered('od_form', $app_id) + 
				//count_single_form_answered('reg_form', $app_id) + 
				count_single_form_answered('eff_form', $app_id) + 
				count_single_form_answered('ts_form', $app_id) + 
				count_single_form_answered('equality_form', $app_id);
	
		$k = 	single_form_question_count('ts_form', $app_id) +
				single_form_question_count('equality_form', $app_id)+
				//single_form_question_count('reg_form', $app_id) + 				 
				single_form_question_count('qu_form', $app_id) + 
				single_form_question_count('eff_form', $app_id);
				
				//The Safety Form
				if(get_field('basics_q2',  $answers[0]->ID) == 'YES'):					
					$k =$k + single_form_question_count('safety_form', $app_id);
				endif;
				//The Interoperability Form
				if(get_field('basics_q4',  $answers[0]->ID) == 'YES'):
					$k =$k+ single_form_question_count('io_form', $app_id); 
				endif;
				//The Open Data Form
				if(get_field('basics_q5',  $answers[0]->ID) == 'YES'):
					$k =$k +single_form_question_count('od_form', $app_id);
				endif;
				//The Privacy & Security Form
				if(get_field('basics_q3',  $answers[0]->ID) == 'YES'):
					$k =$k + single_form_question_count('ps_form', $app_id);
				endif;	
				
				 
				
	//echo get_field('basics_q2',  $answers[0]->ID);
	if($page == 'single-app'){
	echo '<div class="col-md-4"><h3>Your progress:</h3>';
    echo'<h3> '. $i.' / '.$k.'</h3>';
    echo '<div class="progress"><div class="progress-bar" style="width: '.number_format( ($i/$k) * 100, 0 ) .'%"></div></div>';
    echo '<a href="/ie-design/app_name/'.$term->slug.'" class="btn btn-primary">See overview</a></div>';
    }
    elseif ($page == 'all-apps'){
	    return $i.' / '.$k;
    }
    elseif ($page == 'total-alert') {
	    $level = create_level();
	    if($level == 'f') {
		    echo '<div class="alert alert-danger">
        <h3>
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          This assessment is complete and but has failed for one or more reasons.
        </h3>
        <p>
          Please review and correct sections before attempting to submit.
        </p>
        <div>
          
        </div>
        <p>
        </p>
      </div>';

		    
	    }
	    elseif($i == $k ) {
		    echo '<div class="alert alert-success">
        <h3>
          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
          This assessment is complete and ready to be submitted
        </h3>
        <p>
          You should ensure that the declarations you have made in answering the
          questions are true and complete before submitting this assessment. You
          can revisit the assessment in the future to enhance your scores or to reflect
          changes in your application.
        </p>
        <div>
          <br>
          <div>
            <a href="#" class="btn btn-default">Submit this assessment to be endorsed</a>
            <br>
          </div>
        </div>
        <p>
        </p>
      </div>';
	    }
	    elseif ($i<$k) {
		    echo ' <div class="alert alert-danger">
        <h3>
          <i class="fa fa-exclamation-circle"></i>
          This assessment is incomplete so can not be submitted for endorsement
        </h3>
        <p>
          Check the essential items to resolve list below - everything here must
          be completed before you can submit you application for endorsement.
        </p>
      </div>
';
	    }
	}
    elseif ($page == 'total-pass-fail') {
	    if($i == $k) {
		    return '<span class="label label-success">Completed</span>';
	    }
	    elseif ($i<$k) {
		    return '<span class="label label-info">In progress</span>';
	    }
	}
    else {
	    echo 'there was a counting error';
    }
    
}
// create level array for all forms filled out per app
function create_level() {
	//current session app id
	$id =$_SESSION['app_id'];
	$level = array();
	      $level[]= form_pass_fail('ps_form', $id, 'just_score');
	      $level[]= form_pass_fail('equality_form', $id, 'just_score');      
	      $level[]= form_pass_fail('eff_form', $id, 'just_score');
	      $level[]= form_pass_fail('ts_form', $id, 'just_score');
	      $level[]= form_pass_fail('qu_form', $id, 'just_score');
	      $level[]= form_pass_fail('safety_form', $id, 'just_score');
	      $level[]= form_pass_fail('io_form', $id, 'just_score');
		  $level[]= form_pass_fail('od_form', $id, 'just_score');
	 arsort($level);
	  foreach ($level as $test) {
	  	switch($test) {
	      	case 0:
	      		$type = 'f';
		  		$failed = 'alert-danger';
		  		break;
		  	case 1:
		  		$type = 'i';
		  		$incomplete = 'alert-warning';
		  		break;
		  	case 2:
		  		$type = 'b';
		  		$basic = 'alert-info';
		  		break;
		  	case 3:
		  		$type = 'e';
		  		$enhanced = 'alert-info';
		  		break;
		  	case 4:
		  		$type = 'bp';
		  		$best = 'alert-info';
		  		break;
		  	}
		}	
		  	return $type;			
}
