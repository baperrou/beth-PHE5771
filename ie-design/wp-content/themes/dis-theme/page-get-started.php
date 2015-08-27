<?php get_header(); ?>
    <div class="container">
      <div class="jumbotron">
        <div class="row">
          <div class="col-md-8">
            <h1>
              Get started
            </h1>
            <p>
              Find out if self assessed endorsement is right for your App, and what
              information you'll need to gather to complete the assessment.
            </p>
          </div>
          <div class="col-md-4">
            <h3>
              What you'll need:
            </h3>
            <ul>
              <li>
                5-10 minutes
              </li>
              <li>
                Basic knowledge of your App and how it works
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
                My App isn't in an App Store
              </h3>
            </div>
            <div class="panel-body">
              <p>
                If your App isn't in an App Store then you'll need to enter the App and
                publisher information by hand when you submit the assessment.&nbsp;
              </p>
              <p>
                <a href="/ie-design/the-basics" class="btn pull-right btn-success">Start</a>
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
                My App is already in an App Store
              </h3>
            </div>
            <div class="panel-body">
              You can save time by giving us a link to an App Store entry - it will
              save you retyping information later.
              <div>
                <br>
                <div class="form-group">
                  <label>
                    App store link
                  </label>
                  <input type="text" class="form-control">
                </div>
                <div>
                  <div>
                    <a href="screen-642b184ffc.html" class="btn pull-right btn-success">Get app info and start</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
                Resume a saved session
              </h3>
            </div>
            <div class="panel-body">
              Log in to continue a saved session
              <div>
                <br>
              </div>
              <form id="login-form">
                <div class="form-group">
                  <div class="form-group">
                    <label>
                      Email address
                    </label>
                    <input type="email" class="form-control" id="user-email">
                  </div>
                  <label>
                    Password
                  </label>
                  <input type="password" class="form-control" id="user-password">
                </div>
                <p id="feedback" class="bg-danger"></p>
              </form>
              <a href="#" class="btn btn-success pull-right" id="login-to-app">Login</a>
              
            </div>
          </div>
        </div>
      </div>
    </div>
   <?php get_footer(); ?>
