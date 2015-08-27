<?php
	
// count all questions to be answered
// needs to be filtered by qualifying questions first
// then modify to be used by specific developer
function OLD__count_questions($app_id, $page) {
	// get form basic answer results
	
	$tax_id = $_SESSION['app_id'];
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

	
	// count all form questions (not Basic)
	
	//The Privacy & Security Form
	if(get_field('basics_q3',  $answers[0]->ID) == 'YES'):
	$groups1 = apply_filters('acf/field_group/get_fields', $groups, 86);
	else:
	$groups1 = array();
	endif;
	
	
	//The Safety Form
	if(get_field('basics_q2',  $answers[0]->ID) == 'YES'):
	$groups4 = apply_filters('acf/field_group/get_fields', $groups, 64);
	else:
	$groups4 =array();
	endif;	
	
	
	
	//The Interoperability Form
	if(get_field('basics_q4',  $answers[0]->ID) == 'YES'):
	$groups9 = apply_filters('acf/field_group/get_fields', $groups, 188);
	else:
	$groups9 = array();
	endif;
	//The Open Data Form
	if(get_field('basics_q5',  $answers[0]->ID) == 'YES'):
	$groups10 = apply_filters('acf/field_group/get_fields', $groups, 189);
	else:
	$groups10 = array();
	endif;
	
	
	//The Equality Form
	$groups2 = apply_filters('acf/field_group/get_fields', $groups, 81);
		//The Registration Form
	$groups3 = apply_filters('acf/field_group/get_fields', $groups, 84);
	//The Technical Stability Form
	$groups5 = apply_filters('acf/field_group/get_fields', $groups, 83);
	//The Transparency Form
	 // remove transparency 22 Aug    
	//$groups6 = apply_filters('acf/field_group/get_fields', $groups, 85);
	//The Usability Form
	$groups7 = apply_filters('acf/field_group/get_fields', $groups, 82);
	//The Effectiveness Form
	$groups8 = apply_filters('acf/field_group/get_fields', $groups, 175);

	$groups = array();
	$groups = array_merge( $groups1, $groups2, $groups3, $groups4, $groups5, $groups7, $groups8, $groups9, $groups10);
	
	$k = 0;
	if( $groups )
		{
			foreach( $groups as $group )
			{
				if($group['conditional_logic']['status'] != "1") {
					$k++;
				}
			}
		}
	
	//echo '<pre>'; print_r($groups); echo '</pre>';
	
	// now count answered questions
	$posts = get_posts(array(
    'post_type' => array( 'equality_form', 'ps_form', 'safety_form', 'od_form',  'qu_form', 'eff_form', 'reg_form', 'ts_form', 'io_form' ),
    'tax_query' => array(
        array(
        'taxonomy' => 'app_name',
        'field' => 'term_id',
        'terms' => $app_id,
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
	// get term slug for overview link
	$term = get_term_by('id', $tax_id, 'app_name');
	
	// $k is total questions answered or unanswered	
	//$i is the total questions answered
	if($page == 'single-app'){
	echo '<div class="col-md-4"><h3>Your progress:</h3>';
    echo'<h3> '. $i.' / '.$k.'</h3>';
    echo '<div class="progress"><div class="progress-bar" style="width: '.number_format( ($i/$k) * 100, 0 ) .'%"></div></div>';
    echo '<a href="/ie-design/app_name/'.$term->slug.'" class="btn btn-primary">See overview</a></div>';
    }
    elseif ($page == 'all-apps'){
	    return $i.' / '.$k;
    }
}
    

function count_form_questions($type, $app_id) {
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
		// $q represents total questions
		$q = 0;
		$groups = array();
		$groups = apply_filters('acf/field_group/get_fields', $groups, form_id($type));
//echo '<pre>'; print_r($groups); echo '</pre>';
		if( $groups )
		{
			foreach( $groups as $group )
			{
					$q++;												
			}
		}
// testing for conditional logic on specific forms
			
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
				if($fields['us_q2']['value'] != 'YES'):
					$q--;
				endif;
				if($fields['us_q9']['value'] != 'YES'):
				$q--;
				endif;
			endif;
			
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
				if(strstr($fields['od_q0']['value'], 'YES')):
					$q= $q - 6;
				endif;	
				if(strstr($fields['od_q2']['value'], 'YES')):
					$q--;
				endif;				
			endif;
			//Equality form
			//no question count logic
			//Effectiveness form
			if($type == 'eff_form'):
				if($fields['eff_q2']['value'] != 'YES'):
					$q--;
				endif;
				if($fields['eff_q4']['value'] != 'YES'):
					$q--;
				endif;
				if($fields['eff_q6']['value'] != 'YES'):
					$q--;
				endif;
				if($fields['eff_q8']['value'] == -999):
					$q--;$q--;
				endif;
				if($fields['eff_q11']['value'] != 'YES'):
					$q--; 
				endif;
				if($fields['eff_q13']['value'] != 'YES'):
					$q--;
				endif;
				if($fields['eff_q15']['value'] != 'YES'):
					$q--;
				endif;
				if($fields['eff_q17']['value'] != 'YES'):
					$q--;
				endif;
				if($fields['eff_q19']['value'] != 'YES'):
					$q--;
				endif;	
				if($fields['eff_q21']['value'] != 'YES'):
					$q--;$q--; 
				endif;
				if($fields['eff_q26']['value'] != 'YES'):
					$q--;$q--;
				endif;
				if($fields['eff_q29']['value'] != 'YES'):
					$q--;$q--;$q--;
				endif;				
			endif;
// end testing for conditional logic on specific forms
	if($posts != null) {
			// $i represents filled in value
		$i = 0;
	
		if( $fields ):	
			foreach( $fields as $field ):
				
				if( $field['value'] !="SELECT ANSWER" ):
				// do counting here
				$i++;
				endif;
			endforeach;
			//with conditional
			
			if($i == $q && $i > 0):
			return '<span class="badge"><i class="fa fa-check-circle"></i></span>';
			elseif($i > 0):
			return '<span class="badge"> '.$i . '/'. $q . '</span>';
			endif;
		endif;
		
		
		
	}
	
	else {
		
		return '<span class="badge"> 0/'. $q . '</span>';
	}
}
