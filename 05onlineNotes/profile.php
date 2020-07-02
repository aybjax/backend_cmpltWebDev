<?php

session_start();
if( !isset($_SESSION['user_id']) )
{
  header("location:index.php");
}
include("connection.php");

$user_id = $_SESSION["user_id"];

//get username
$query = "SELECT * FROM users WHERE user_id='$user_id'";

$result = mysqli_query($link, $query);

$nbr = mysqli_num_rows($result);

if($nbr == 1)
{
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $username = $row['username'];
  $email = $row['email'];
}else
{
  echo "Error retrieving from database";
  $username = 'Error name';
  $email = 'Error name';
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>My notes</title>

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
                    <li class="active"><a href="#">Profile</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="loggedInPage.php">My Notes</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li><a>Logged in as <b>
                    <?php echo $username ?>
                    </b></a></li>
                    <li><a href="index.php?logout=1">Logout</a></li>
                  </ul>

                </div>
            </div>
        </nav>


        <!-- Container -->
        <div class="container-fluid addContainer">
          <div class="row">
            <div class="col-md-offset-3 col-md-6">

                <h2>General Account Settings:</h2>

                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-bordered">
                        <tr data-target="#updateUsername" data-toggle="modal">
                            <td>Username</td>
                            <td><?php echo $username ?></td>
                        </tr>
                        <tr data-target="#updateEmail" data-toggle="modal">
                            <td>Email</td>
                            <td><?php echo $email ?></td>
                        </tr>
                        <tr data-target="#updatePswd" data-toggle="modal">
                            <td>Password</td>
                            <td>Hidden</td>
                        </tr>
                    </table>
                </div>

            </div>
          </div>
        </div>















        
        <!--modals -->

        <!-- UPDATE USERNAME MODAL -->
        <form method="post" id="updateUsernameForm">
          <div class="modal" id="updateUsername">
            <div class="modal-dialog">

              <div class="modal-content">
                
                
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>


                  <h4 id="updateUsernameHeader">Edit Username:</h4>
                </div>


                <div class="modal-body">

                  <!-- Signup message message from PHP -->
                  <div id="updateUsernameMsg"></div>

                  <div class="form-group">
                    <label for="updateName">Username:</label>
                    <input class="form-control" id="updateName" type="text" name="updateUsername" maxlength="30" value="<?php echo $username ?>">
                  </div>
                </div>


                <div class="modal-footer">
                  <input type="submit" class="btn green" value="Submit" name="updateUsernameSubmit">
                  
                  <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                  </button>

                </div>
              
              </div>

            </div>
          </div>
        </form>




        <!-- UPDATE EMAIl MODAL -->
        <form method="post" id="updateEmailForm">
          <div class="modal" id="updateEmail">
            <div class="modal-dialog">

              <div class="modal-content">
                
                
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>


                  <h4 id="updateEmailHeader">Enter new email:</h4>
                </div>


                <div class="modal-body">

                  <!-- Signup message message from PHP -->
                  <div id="updateEmailMsg"></div>

                  <div class="form-group">
                    <label for="updateEmail">Email:</label>
                    <input class="form-control" id="updateEmail" type="email" name="updateEmail" maxlength="50" value="<?php echo $email ?>">
                  </div>
                </div>


                <div class="modal-footer">
                  <input type="submit" class="btn green" value="Submit" name="updateEmailSubmit">
                  
                  <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                  </button>

                </div>
              
              </div>

            </div>
          </div>
        </form>





        <!-- UPDATE PSWD MODAL -->
        <form method="post" id="updatePswdForm">
          <div class="modal" id="updatePswd">
            <div class="modal-dialog">

              <div class="modal-content">
                
                
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>


                  <h4 id="updatePswdHeader">Edit Username:</h4>
                </div>


                <div class="modal-body">

                  <!-- Signup message message from PHP -->
                  <div id="updatePswdMsg"></div>

                  <div class="form-group">
                    <label class="sr-only" for="updatePswdOld">Password</label>
                    <input class="form-control" id="updatePswdOld" type="password" name="updatePswdOld" maxlength="30" placeholder="Your Current Password">
                  </div>

                  <div class="form-group">
                    <label class="sr-only" for="updatePswd1">Password</label>
                    <input class="form-control" id="updatePswd1" type="password" name="updatePswd1" maxlength="30" placeholder="Choose Password">
                  </div>

                  <div class="form-group">
                    <label class="sr-only" for="updatePswd2">Password</label>
                    <input class="form-control" id="updatePswd2" type="password" name="updatePswd2" maxlength="30" placeholder="Confirm Password">
                  </div>



                </div>


                <div class="modal-footer">
                  <input type="submit" class="btn green" value="Submit" name="updatePswdSubmit">
                  
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
        <script src="profile.js"></script>
    </body>
</html>