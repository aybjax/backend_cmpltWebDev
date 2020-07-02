<?php
session_start();
include("connection.php");

//logout
include("logout.php");

//rememberMe
include("rememberme.php");

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Online Notes App</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom -->
        <link href="custom/style.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Arvo&display=swap" rel="stylesheet"> 


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-custom navbar-fixed-top">
            
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand">Online Notes App</a>
                    <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                </div>
                
                <div class="navbar-collapse collapse" id="navbarCollapse">
                  
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Contact Us</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li><a href="#loginModal" data-toggle="modal">Login</a></li>
                  </ul>

                </div>
            </div>
        </nav>


        <!-- Jumbotron-->
        <div class="jumbotron" id="mainJumbotron">
          
        
          <h1>Online Notes App</h1>
          <p>Your notes with you wherever you go</p>
          <p>Easy to use, protect your notes</p>

          <button class="btn btn-lg green signup" data-target="#signupModal" data-toggle="modal">
            Sign Up - It is free
          </button>

        </div>






        
        
        <!--modals -->

        <!-- SIGNUP MODAL -->
        <form method="post" id="signupForm">
          <div class="modal" id="signupModal">
            <div class="modal-dialog">

              <div class="modal-content">
                
                
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>


                  <h4 id="signupHeader">Signup today and start using our Online Notes App</h4>
                </div>


                <div class="modal-body">

                  <!-- Signup message message from PHP -->
                  <div id="signupMsg"></div>

                  <div class="form-group">
                    <input class="form-control" type="text" name="signupUsername" placeholder="Username" maxlength="30">
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="email" name="signupEmail" placeholder="Email Address" maxlength="50">
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="password" name="signupPswd1" placeholder="Choose a password" maxlength="30">
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="password" name="signupPswd2" placeholder="Confirm password" maxlength="30">
                  </div>

                </div>


                <div class="modal-footer">
                  <input type="submit" class="btn green" value="Sign up" name="signupSubmit">
                  
                  <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                  </button>

                </div>
              
              </div>

            </div>
          </div>
        </form>



        <!-- LOGIN MODAL -->
        <form method="post" id="loginForm">
          <div class="modal" id="loginModal">
            <div class="modal-dialog">

              <div class="modal-content">
                
                
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>


                  <h4 id="loginHeader">Login:</h4>
                </div>


                <div class="modal-body">

                  <!-- Login message message from PHP -->
                  <div id="loginMsg"></div>

                  <div class="form-group">
                    <input class="form-control" type="email" name="loginEmail" placeholder="Email Address" maxlength="50">
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="password" name="loginPswd" placeholder="Choose a password" maxlength="30">
                  </div>


                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="rememberMe" id="rememberMe">
                      Remember me
                    </label>
                    <a class="pull-right" style="cursor: pointer" href="#forgotModal" data-toggle="modal" data-dismiss="modal">
                      Forgot Password?
                    </a>
                  </div>

                </div>


                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal" data-target="#signupModal">
                    Register
                  </button>

                  <input type="submit" class="btn green" value="Login" name="loginSubmit">
                  
                  <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                  </button>

                </div>
              
              </div>

            </div>
          </div>
        </form>




        <!-- FORGOT PASSWORD MODAL -->
        <form method="post" id="forgotForm">
          <div class="modal" id="forgotModal">
            <div class="modal-dialog">

              <div class="modal-content">
                
                
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>


                  <h4 id="forgotHeader">Forgot Password? Enter your email:</h4>
                </div>


                <div class="modal-body">

                  <!-- Login message message from PHP -->
                  <div id="forgotMsg"></div>

                  <div class="form-group">
                    <input class="form-control" type="email" name="forgotEmail" placeholder="Email" maxlength="50">
                  </div>

                </div>


                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal" data-target="#signupModal">
                    Register
                  </button>

                  <input type="submit" class="btn green" value="Submit" name="forgotSubmit">
                  
                  <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                  </button>

                </div>
              
              </div>

            </div>
          </div>
        </form>






        <!--Footer-->
        <div class="footer">
          <div class="container-fluid">
            <p>Develop with aybjax &copy; 2015-<?php $today = date("Y"); echo $today ?>. </p>
          </div>
        </div>
    
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="index.js"></script>
    </body>
</html>