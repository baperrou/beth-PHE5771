 <!-- signup modal start -->
       <div class="modal fade" id="signUp" tabindex="-1" role="dialog" aria-labelledby="signUp" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
		            <h4 class="modal-title">Have you registered?</h4>
		            <p id="feedback" class="alert-danger"></p>
	            </div>
	            <div class="modal-body">
		            <ul class="nav nav-tabs">						
						<li class="active"><a href="#create" data-toggle="tab">New Registration</a></li>
						<li><a href="#login" data-toggle="tab">Login</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane active in" id="create">
			                <form class="form-horizontal" id="new-user">
								<fieldset>
								
								<!-- Form Name -->
								<!-- Name input-->
								<div class="control-group">
								  <label class="control-label" for="name">Your Name</label>
								  <div class="controls">
								    <input  id="name" name="name" type="text" placeholder="Your Name" class="form-control" required="">
								    
								  </div>
								</div>
								<!-- Email input-->
								<div class="control-group">
								  <label class="control-label" for="email">Email Address</label>
								  <div class="controls">
								    <input type="email" id="email" name="email" type="text" placeholder="you@you.com" class="form-control" required="">
								    <p class="help-block">This will also be your username</p>
								  </div>
								</div>
								
								<!-- Password input-->
								<div class="control-group">
								  <label class="control-label" for="password">Password</label>
								  <div class="controls">
								    <input id="password" name="password" type="password" placeholder="password" class="form-control" required="">
								    
								  </div>
								</div>
								
								<!-- Password input-->
								<div class="control-group">
								  <label class="control-label" for="verify_password">Verify Password</label>
								  <div class="controls">
								    <input id="verify_password" name="verify_password" type="password" placeholder="password" class="form-control" required="">
								    <input type="hidden" name="current_app" value="<?php echo $_SESSION['app_id'];?>" id="current_app">
								    
								  </div>
								</div>
								
								</fieldset>
							</form>
							<div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				                <button type="submit" class="btn btn-primary" id="new_developer">Save changes</button>
				            </div>
	            		</div>
	            		<div class="tab-pane fade" id="login">
							<form class="form-horizontal" id="login">
								<fieldset>
									<div class="control-group">
										<!-- Username -->
										<label class="control-label" for="username">Username</label>
										<div class="controls">
											<input type="text" id="user-email" name="username" placeholder="" class="form-control">
										</div>
									</div>
									
									<div class="control-group">
										<!-- Password-->
										<label class="control-label" for="password">Password</label>
										<div class="controls">
											<input type="password" id="user-password" name="password" placeholder="" class="form-control">
											<input type="hidden" id="new-app" value="<?php echo $_SESSION['app_id'];?>">
										</div>
									</div>
									
									
									
								</fieldset>
							</form> 
							<div class="modal-footer">
				                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				                <button type="submit" class="btn btn-primary" id="login-to-app">Login</button>
				            </div>               
						</div>

					</div>
	            
	        </div>
	    </div>
       </div>
	<!-- signup modal stop -->
