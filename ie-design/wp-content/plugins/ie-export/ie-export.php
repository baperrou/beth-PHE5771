<?php
/**
 * Plugin Name: IE Export
 * Plugin URI: http://doitsimply.co.uk
 * Description: This plugin adds custom exports for PHE5771 * Version: 1.0.0
 * Author: DO IT SIMPLY
 * Author URI: http://doitsimply.co.uk
 * License: GPL2
 */



//INCLUDE NECESSARY FILES







// ADD ACTIONS AND ADMIN MENUS

//build the admin page for viewing
function ie_build_admin() {
    include('views/ie-export-admin.php');
}

//build menu item under tools to access plugin
function pedal_export_admin_actions() {
 	add_management_page("IE Form Exports", "IE Form Exports", 1, "ie-export-admin", "ie_build_admin");
}
 
add_action('admin_menu', 'pedal_export_admin_actions');

// function to query the database for class list
function ie_get_form($form, $id) {

	//get form based on app taxonomy
	//to do to reduce duplicate

	$answers = get_posts(array(
	  'post_type' => $form,
	  'numberposts' => -1,
	  'tax_query' => array(
	    array(
	      'taxonomy' => 'app_name',
	      'field' => 'slug',
	      'terms' => $id
	    )
	  )
	  )
	);
if($answers) {
	
	$fields = get_field_objects($answers[0]->ID);
	//echo '<pre>'; print_r($fields); echo '</pre>';
	$out = array();
	$out[] = '<table width="100%">';
		if($fields)
		
		{
		
		foreach( $fields as $field_name => $field )
		{
			$out[] = '<tr>';
				$out[] = '<td><b>' . $field['label'] . '</b></td>';
				$find_it = $field['choices'];
				if($find_it) {
					foreach($find_it as $find => $key) {
						//echo $key;
						//echo '</br>';
						if($find == $field['value']) {
							$out[] ='<td>'.$key.'</td>';
						}
					}
				}
				else {
				$out[] ='<td>'.$field['value'].'</td>';
				}
			$out[] ='</tr>';
		}
	}
	$out[] = '</table>';
}	

else {
	
	$out[] = 'No form filled in for this app';
}
//echo '<pre>';print_r($fields);echo '</pre>';
wp_reset_postdata();


echo implode($out);

		
}



//ENQUEUE JS SCRIPTS FOR FUNCTIONALITY

