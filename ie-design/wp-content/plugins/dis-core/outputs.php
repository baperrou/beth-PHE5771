<?php //OUTPUTS
// CUSTOM PAGE TITLE
function custom_page_title() {
	global $s, $paged, $wp_page, $_mobileopts, $post;
    ob_start();
	if(function_exists('is_tag') && is_tag()):
		single_tag_title();
		echo ' ' . get_the_title(NEWS_PAGE) . ' - ';
	elseif(is_archive()):
		wp_title('');
		echo ' - ';
	elseif(is_search()):
		echo 'Search for &quot;' . wp_specialchars($s) . '&quot; - ';
	elseif(!(is_404()) && ((is_single()) || (is_page())) && !is_front_page()):
		wp_title('');
		echo ' - ';
	elseif(is_404()):
		echo 'Not Found - ';
	endif;
	if(is_singular('post')):
		if(!isset($_mobileopts)):
			$tags = get_the_tags();
			if($tags):
				echo reset($tags->name);
				echo ' ';
			endif;
		endif;
		echo get_the_title(NEWS_PAGE);
		echo ' - ';
		bloginfo('name');
	elseif(isset($wp_page)):
		echo get_the_title($wp_page->post->ID);
		echo ' - ';
		bloginfo('name');
	elseif(is_home()):
		echo get_the_title(NEWS_PAGE);
		echo ' - ';
		bloginfo('name');
	else:
		bloginfo('name');
	endif;
	if($paged > 1):
		echo ' - page ' . $paged;
	endif;
    echo ucwords(strtolower(ob_get_clean()));
}
                                                                                                                                                                                                                     // CONTENT CREATION

// show YES/NO for further question forms based on Basic Form Answers
function yes_no_answers() {
	//get form based on app taxonomy
	
	//to do to reduce duplicate
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
	return $answers;
}


function yes_no_forms($page) {
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
	
	$out= array();
	
	if(get_field('basics_q1',  $answers[0]->ID) == 'NO'):
	 	$out[]='<div class="alert alert-danger">
        <h3>
          <i class="fa fa-times-circle"></i>
          This assessment isn\'t suitable for your app so can not be submitted for endorsement
        </h3>
        <p>
         <a href="/ie-design/the-basics" class="btn btn-info">Go back and change answers</a> Something more here as they failed Effectiveness Question
        </p>
      </div>';
       echo implode($out);
      exit;
    elseif(get_field('basics_q2', $answers[0]->ID) =='YES' OR get_field('basics_q2', $answers[0]->ID) =='Unsure'):
      	$out[]='<div class="alert alert-warning">
        <h3>
          <i class="fa fa-check-circle"></i>
          Possibly
        </h3>
        <p>Self Assessed Endorsement is possibly suitable for your App. You declared that your App could cause harm to a user. Depending on the risk and severity of the possible harm you may need to register your App as a medical device which is a separate additional step. </p>

<p>Start your application with the ‘Safety’ section of the assessment to check the most appropriate next steps</p>

        <p>
        <a href="/ie-design/the-basics" class="btn btn-info">Go back and change answers</a>';
	      if(isset($_SESSION['developer_id'])) :
		  	$out[]=' <a href="/ie-design/your-apps"  class="btn btn-success">Save this and move to the next step</a>';
	      else:
	      $out[]=' <a href="#" data-toggle="modal" data-target="#signUp" class="btn btn-success">Save this and move to the next step</a>';
	      endif;
       $out[]=' </p></div>';
  	else:
		$eff = array('YES', 'label-success');
	 	$out[]='<div class="page-header">
	    <h3>
	      The results...
	    </h3>
	  </div>
	  <div class="alert alert-success">
	    <h3>
	      <i class="fa fa-check-circle"></i>
	      YES
	    </h3>
	    <p>
	      Self Assessed Endorsement is probably suitable for your App. We\'ve listed
	      the parts of the assessment that we think are relevant and that you will
	      need to answer in the next stage of the assessment process.
	      <br>
	      <br>
	      <a href="/ie-design/the-basics" class="btn btn-info">Go back and change answers</a>';
	      if(isset($_SESSION['developer_id'])) :
		  	$out[]=' <a href="/ie-design/your-apps"  class="btn btn-success">Save this and move to the next step</a>';
	      else:
	      $out[]=' <a href="#" data-toggle="modal" data-target="#signUp" class="btn btn-success">Save this and move to the next step</a>';
	      endif;
		 $out[]='</p></div>';    
	endif;
	if(get_field('basics_q2',  $answers[0]->ID) == 'NO'):
	 	$safety = array('NO', 'label-danger' , 'disabled');
	 	$safety_count ='';
	else:		
		$safety = array('YES', 'label-success');
		$safety_count = create_form_status_icon('safety_form', $tax_id);
	endif;
	if(get_field('basics_q3',  $answers[0]->ID) == 'NO'):
	 	$privacy = array('NO', 'label-danger', 'disabled');
	 	$privacy_count = '';
	else:
		$privacy = array('YES', 'label-success');	
		$privacy_count = create_form_status_icon('ps_form', $tax_id);	
	endif;
	if(get_field('basics_q4',  $answers[0]->ID) == 'NO'):
	 	$inter = array('NO', 'label-danger', 'disabled');
	 	$inter_count = '';
	else:		
		$inter = array('YES', 'label-success');
		$inter_count = create_form_status_icon('io_form', $tax_id);
	endif;
	if(get_field('basics_q5',  $answers[0]->ID) == 'NO'):
	 	$od =   array('NO', 'label-danger', 'disabled');
	 	$od_count = '';
	else:		
		$od = array('YES', 'label-success');
		$od_count = create_form_status_icon('od_form', $tax_id);
	endif;

	
	$out[] ='<div class="row">';
	$out[] = '<div class="col-md-3"><h3><span class="label '.$privacy[1].'">'.$privacy[0].'</span></h3>
            <h3>Privacy and Security</h3>
            <p>Are you looking after information in line with the Data Protection Act
              and protecting personal data in line with best practice?</p></div>';
    $out[] = '<div class="col-md-3"><h3><span class="label '.$safety[1].'">'.$safety[0].'</span></h3>
            <h3>Safety</h3>
            <p> What risk could your App pose and how is that risk communicated and managed?</p></div>';            
    $out[] = '<div class="col-md-3"><h3><span class="label '.$inter[1].'">'.$inter[0].'</span></h3>
            <h3>Interoperability</h3>
            <p>When your App integrates with other clinical systems what standards are being met and is best practice being followed?</p></div>';
            
    $out[] = '<div class="col-md-3"><h3><span class="label '.$od[1].'">'.$od[0].'</span></h3>            
		    <h3>Open Data</h3>
		    <p> Contributing to open data benefits the health community. Meeting best practice raises the profile and usefulness of your App.</p></div>';
	$out[] = '</div><div class="row">';	
    $out[] = '<div class="col-md-3"><h3><span class="label label-success">YES</span></h3>
			    <h3>Equality</h3>
			    <p> What efforts have been made to make your App available to and usable by the widest number of users?</p></div>';    
    $out[] = '<div class="col-md-3"><h3><span class="label  label-success">YES</span></h3>
    			<h3>Effectiveness</h3>
				<p>What efforts and evidence can you provide to support the effectiveness of your App?</p></div>';    				
	$out[] = '<div class="col-md-3"><h3><span class="label label-success">YES</span></h3>
    			<h3>Transparency</h3>
				<p>Being honest and open about who makes, publishes and benefits from the users usage of the App builds trust and encourages uptake.</p></div>';				    
	$out[] = '<div class="col-md-3"><h3><span class="label label-success">YES</span></h3>
    			<h3>Usability</h3>
				<p>What rigour has been applied to making the App free of technical and usability issues?</p></div>';  
	$out[]='</div>';   
	
	$out[] ='<div class="row">';	
    $out[] = '<div class="col-md-3"><h3><span class="label label-success">YES</span></h3>
			    <h3>Registration</h3>
			    <p> Information about registration form</p></div>'; 
			       
   	$out[] = '<div class="col-md-3"><h3><span class="label label-success">YES</span></h3>
    			<h3>Technical Stability</h3>
				<p>info about tech stability</p></div>';  
	$out[]='</div>'; 
	
	
	$out_app = array();
	$current = $_GET['form'];
	$out_app[] = '<div><b>Essentials:</b>
        <ul class="nav nav-pills">
          <li id="equality_form" class="'.$form.'"><a href="/ie-design/the-form?form=equality_form">Equality ' . create_form_status_icon('equality_form', $tax_id).' </a></li>';
          
     $out_app[] = '<li id="eff_form"><a href="/ie-design/the-form?form=eff_form" class="count '.$eff[2].'">Effectiveness' . create_form_status_icon('eff_form', $tax_id).'</a></li>';
     // remove transparency 22 Aug
     // <li id="trans_form"><a href="/ie-design/the-form?form=trans_form">Transparency ' . count_form_questions('trans_form', $tax_id).' </a></li>
      $out_app[] ='<li id="ts_form"><a href="/ie-design/the-form?form=ts_form">Technical Stability ' . create_form_status_icon('ts_form', $tax_id).' </a></li>';
      // remove registration 15 Sept
         // <li id="reg_form"><a href="/ie-design/the-form?form=reg_form">Registration ' . create_form_status_icon('reg_form', $tax_id).' </a></li>';
     $out_app[]='<li id="qu_form"><a href="/ie-design/the-form?form=qu_form">Usability ' . create_form_status_icon('qu_form', $tax_id).' </a></li>
        </ul>
      </div>
      <br>
      <div>
        <b>
    Extras:
    </b>
        <ul class="nav nav-pills">
          
          <li id="ps_form"><a href="/ie-design/the-form?form=ps_form&disabled='.$privacy[2].'" class="count '.$privacy[2].'">Privacy & Security' . $privacy_count.'</a></li>
          
          <li id="safety_form"><a href="/ie-design/the-form?form=safety_form&disabled='.$safety[2].'" class="count '.$safety[2].'">Safety' . $safety_count.'</a></li>
          <li id="io_form"><a href="/ie-design/the-form?form=io_form&disabled='.$inter[2].'" class="count '.$inter[2].'">Interoperability' . $inter_count.'</a></li>
          <li id="od_form"><a href="/ie-design/the-form?form=od_form&disabled='.$od[2].'" class="count '.$od[2].'">Open Data' . $od_count.'</a></li></ul></div>';
          
	if($page == 'started') {      
    	echo implode($out);
		}
	elseif ($page =='your_app') {
		echo implode($out_app);
	}
	else {
		
	}
    
	 	
}
// get Apps by user

function get_user_apps() {
	global $post;
	$id = $_SESSION['developer_id'];
	$apps = wp_get_post_terms($id, 'app_name', array("fields" => "all"));
	
	//	print_r($apps);
	// must use app id to count how many questions are left to answer
	foreach ($apps as $app){
		if(count_questions($app->term_id, 'all-apps') == null) {
			$count = 'Ready to start';
			$result = '';
		}
		else {
			$count = count_questions($app->term_id, 'all-apps');
			$result = count_questions($app->term_id, 'total-pass-fail');
		}
	
		// once clicked the session app id needs to change
	    echo '<li class="list-group-item app-progress"><a href="/ie-design/app_name/'.$app->slug.'">'.$app->name.'</a>
           <span class="label label-default"> '.$count .' </span> '.$result.'</li><div class="clearfix"></div>';
	}
}

// custom homepage content
function the_homepage(){
	global $post;
	$post = get_post('123');
	$out = array();
	$out[] = '<h1>' . get_field('home_headline') . '</h1>';
	$out[] ='<hr>';
	$out[] = '<p class="lead">' . get_field('home_text') . '</p>';
	wp_reset_postdata();
	echo implode($out);
	
}

//CUSTOM BODY CLASSES

function add_body_class( $classes )
{
    global $post;
    if ( isset( $post ) ) {
        $classes[] = $post->post_type . '-' . $post->post_name;
    }
    return $classes;
}


