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
        <title>Reset password</title>

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
            <h1>Account activation</h1>



<div id="msg"></div>


<!-- PHP COPIED HERE FOR GOOD LOOK-->
<?php


//see if email or actKey is missing
//cn use isset for link

if( !isset($_GET['user_id']) || !isset($_GET['key']) )
{
    echo $msgBe."There was an error. Please, click on the reset password link
        you received in your email".$msgAf;
    exit;
}

$user_id = $_GET['user_id'];
$actKey = $_GET['key'];
//time 24 hours before
$time = time()-24*60*60;

//prepare for quesry
$user_id = mysqli_real_escape_string($link, $user_id);
$actKey = mysqli_real_escape_string($link, $actKey);

//make a query for email and key
$query = "SELECT user_id FROM forgotpswd WHERE user_id='$user_id'
            AND validation='$actKey'
            AND time>'$time' AND status='pending'";

$result = mysqli_query($link, $query);
if(!$result)
{
    echo $msgBe."Database query error".$msgAf;
    echo $msgBe."".mysqli_connect_error()."".$msgAf;
    exit;
}

//if combination does not exits
$resultS = mysqli_num_rows($result);
if($resultS !== 1)
{
    echo $msgBe."Try again".$msgAf;
    exit;
}

//if exist
//print form for password
echo "
<div class='container-fluid' id='pdResetDiv'>
    <form method=post id='pdReset'>
        <input type=hidden name=user_id value=$user_id>
        <input type=hidden name=actKey value=$actKey>
        <div class='form-group'>
            <label for='pd1'>
                Enter your new Password:
            </label>
            <input type='password' name='pd1' id='pd1' placeholder='Enter Password' class='form-control'>
        </div>
        <div class='form-group'>
            <label for='pd2'>
                Re-enter Password:
            </label>
            <input type='password' name='pd2' id='pd2' placeholder='Enter Password' class='form-control'>
        </div>
        <input type='submit' name='resetpswd' class='btn btn-success btn-lg' value='Reset Password'>
    </form>
</div>
";


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
        <script>
            $("#pdReset").submit(function(event){
                //prevent default php processing
                event.preventDefault();

                //collect user input
                var dataToPost = $(this).serializeArray();

                //send to php using AJAX call
                $.ajax({
                    url: "storeresetpswd.php",
                    type: "POST",
                    data: dataToPost,
                    success: function(data){
                        $("#msg").html(data);
                    },
                    error: function(){
                        $("#msg").html("<div class='alert alert-danger'>Error with AJAX Call. Please, try again later</div>");
                    }
                });
            })
        </script>
    </body>
</html>