<?php 
	get_header(); 
	?>
<div class="container" >
	
      <div class="jumbotron" >
        <div class="row">
          <div class="col-md-8">
            <h1>
              Self assessment
            </h1>
            <p>
              This is where you'll answer the questions that we'll use to grade your
              App for the endorsement. You can save your progress. You'll get the opportunity
              to make changes to improve your scores before you choose to submit your
              assessment for endorsement.
            </p>
          </div>
          <div class="col-md-4">
            <h3>
              What's involved:
            </h3>
            <p>
            </p>
            <ul>
              <li>
                About 1hr of your time
              </li>
              <li>
                Answering approximately 50 questions to grade your app.
              </li>
            </ul>
          </div>
        </div>
        <p>
        </p>
      </div>
      <?php if($_GET['success']){ ?>
      <div class="alert alert-success">
        <h3>
          <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
          Your registration was successful
        </h3>
      </div>
      <?php } ?>
      <div class="page-header">
        <h3>
          Your Apps
        </h3>
      </div>
      <ul class="list-group">
        <?php get_user_apps();?>
        
      </ul>
    </div>    
    <?php get_footer(); ?>