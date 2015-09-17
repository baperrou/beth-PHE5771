(function ($) {
	// check what form page you are on then add active link
	 var check_form = $('.page-the-form #find-active').attr('class');
	 
		$('.page-the-form .nav-pills li').each(function() {
			var id = $(this).attr('id');
			if(id == check_form) {
				$(this).addClass('active');
			}
			
		});
	// create the new taxonomy for the App Name
	    $('.page-the-basics .field input[type="submit"]').click(function(e){
		    e.preventDefault();
		    var app_name = $('#term').val();
			var update = $('#update').val();
			
		    $.ajax({
	         type : "post",
	         dataType : "html",
	         url : myAjax.ajaxurl,
	         data : {action: "beth_insert_term", app_name : app_name, update: update},
	         success: function(data) { 
		       //  alert(data);  
				 $('#basic_form').submit();

	            },
	         error:  function(request,error){
				alert("Request: "+JSON.stringify(request));
				}
		 	});
		 
		 });    
		// create a new developer
		   $('.page-the-results #new_developer').click(function(e){			
		    e.preventDefault();		  
		    var the_app = $('#current_app').val();		     
		    var name = $('#name').val();
		    var email = $('#email').val();
		    var password = $('#password').val();
		    var verify_password = $('#verify_password').val();
		    $.ajax({
	         type : "post",
	         dataType : "html",
	         url : myAjax.ajaxurl,
	         data : {action: "create_user_cpt", app_id : the_app, name : name, email : email, password : password, verify_password : verify_password},
	         success: function(data) {  
		         if(data =='yes') {	
			        
				 $('#feedback').html('That email has already been used, please login with previous details.');
				 }
				 else {
					$('.close').trigger('click');		        
				window.location = "http://dev.doitsimply.co.uk/ie-design/your-apps?success=true";				 } 
		        

	            },
	         error:  function(request,error){
				alert("Request: "+JSON.stringify(request));
				}
		 });    
		   
    });
    
    // login current Developer
		   $('#login-to-app').click(function(e){
			
		    e.preventDefault();
		    var user_email = $('#user-email').val();		   
		    var user_password = $('#user-password').val();
		    var new_app = $('#new-app').val();

			    $.ajax({
		         type : "post",
		         dataType : "html",
		         url : myAjax.ajaxurl,
		         data : {action: "check_user_cpt",  user_email : user_email, user_password : user_password, new_app : new_app},
		         success: function(data) {    
			        if(data =='yes') {	
				    //      alert(data);  
					window.location = "http://dev.doitsimply.co.uk/ie-design/your-apps";
					}
					else {
				//		 alert(data);  
						$('#feedback').html('Those details are incorrect, please try again.');
					}
	
		         },
		         error: function(xhr, textStatus, error){
				      console.log(xhr.statusText);
				      console.log(textStatus);
				      console.log(error);
				  }			
			 });     
			   
	    });
		// trigger the login with enter
		$('#user-password').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#login-to-app').click();//Trigger search button click event
        }
    });
    
   
})(jQuery);