<?php 
	
	    if($_POST['ie_hidden'] == 'Y') {
        $app = $_POST['ie-app'];
        update_option('ie-app', $app);
        
                      
           } else {
        $app = get_option('ie-app');
    
    }
    ?>
<?php get_header(); ?>



<div class="container">
<div class="wrap">
    <?php    echo "<h2>" . __( 'App Question Answer List', 'ie_trdom' ) . "</h2>"; ?>
     
    <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="ie_hidden" value="Y">
       
        
       
        <p><?php _e("Choose App to view: " ); ?> 
        	<select name="ie-app">
	        	<?php 
		        	$terms = get_terms('app_name');
		        	//print_r($terms);
		        	
						foreach($terms as $term) {
							if($term->slug == $app){
								$selected = 'selected ="selected"';
							}
							else {
								$selected = '';
							}
							$out = '<option value="' . $term->slug.'" ' .$selected.'>'. $term->name.'</option>';
							echo $out;
						 ?>
	        	
				<? }?>
				
			</select>
		</p>
                
     
        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Submit', 'ie_trdom' ) ?>" />
        </p>
    </form>
    <?php
	   
        echo '<h3>Privacy and Security Form</h3>';
      ie_get_form('ps_form', $app);
    
	
       echo '<br/>';
              echo '<br/>';
         echo '<h3>Safety Form</h3>';
        ie_get_form('safety_form', $app);
       echo '<br/>';
         echo '<h3>Interoperability Form</h3>';
       ie_get_form('io_form', $app);
	 echo '<br/>';
	   echo '<h3>Open Data Form</h3>';
       ie_get_form('od_form', $app);
       echo '<br/>';
         echo '<h3>Equality Form</h3>';
       ie_get_form('equality_form', $app);
       echo '<br/>';
         echo '<h3>Usability Form</h3>';
       ie_get_form('qu_form', $app);
        echo '<h3>Effectiveness Form</h3>';
       ie_get_form('eff_form', $app);
       echo '<br/>';
?>
</div>
</div>
<?php get_footer(); ?>