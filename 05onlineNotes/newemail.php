<!--new email -->

<?php
session_start();

include("connection.php");
//msgs
$msgBe = "<div class='alert activation-alert alert-danger'>";
$msgBeSucc = "<div class='alert activation-alert alert-success'>";
$msgAf = "</div>";

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Change email</title>

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
        <div id="activationHeader">
            <h1>Change email</h1>






<!-- PHP COPIED HERE FOR GOOD LOOK-->
<?php


//see if email or actKey is missing
//cn use isset for link

if( !isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key']) )
{
    echo $msgBe."There was an error. Please, click on the activation link
        you received in your email".$msgAf;
    exit;
}

$email = $_GET['email'];
$newemail = $_GET['newemail'];
$actKey = $_GET['key'];

//prepare for quesry
$email = mysqli_real_escape_string($link, $email);
$newemail = mysqli_real_escape_string($link, $newemail);
$actKey = mysqli_real_escape_string($link, $actKey);

//update email
$query = "UPDATE users SET email='$newemail', activation2='changed' WHERE
            (email='$email' AND activation2='$actKey') LIMIT 1";

$result = mysqli_query($link, $query);
if(!$result)
{
    echo $msgBe."Database query error".$msgAf;
    echo $msgBe."".mysqli_connect_error()."".$msgAf;
    exit;
}

//changed or not
if(mysqli_affected_rows($link) == 1)
{
    //destroy session
    session_destroy();
    setcookie("rememberMe", "", time()-3600);
    echo $msgBeSucc."Your email has been updated".$msgAf;
    echo '<a href="index.php" class="btn btn-lg btn-success"> Log in </a>';
}
else
{
    echo $msgBe."Your account could not be activated".$msgAf;
}




?>


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
        <script src="index.js"></script>
    </body>
</html>