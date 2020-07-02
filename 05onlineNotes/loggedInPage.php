<?php

session_start();
if( !isset($_SESSION['user_id']) )
{
  header("location:index.php");
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
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li class="active"><a href="#">My Notes</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li><a>Logged in as <b>
                      <?php echo $_SESSION['username'] ?>
                    </b></a></li>
                    <li><a href="index.php?logout=1">Logout</a></li>
                  </ul>

                </div>
            </div>
        </nav>


        <!-- Container -->
        <div class="container-fluid addContainer">

          <!-- alert messages -->
          <div id="alert" class="alert alert-danger collapse col-md-offset-3 col-md-6">
            <a class="close" data-dismiss="alert">
              &times;
            </a>
            <p id="alertMsg"></p>
          </div>
          
          <div class="row">
            <div class="col-md-offset-3 col-md-6">

            <div class="noteButtons">
                <!-- Some buttons are seen , some not -->
                <button id="addNote" class="btn btn-info btn-lg">Add Note</button>
                <button id="edit" class="btn btn-info btn-lg pull-right">Edit</button>
                <button id="done" class="btn green btn-lg pull-right">Done</button>
                <button id="allNotes" class="btn btn-info btn-lg">All Notes</button>
            </div>

                <!-- visible with all notes on pressing add note -->
            <div id="notePad">
                <textarea rows="10">       </textarea>
            </div>

            <!-- All written notes -->
            <div id="notes" class="notes">
                <!-- Ajax call to retrieve -->
            </div>

            </div>
          </div>
        </div>





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
        <script src="mynotes.js"></script>
    </body>
</html>