<?php

session_start();

include("connection.php");
//msgs
$msgBe = "<div class='alert activation-alert alert-danger'>";
$msgBeSucc = "<div class='alert activation-alert alert-success'>";
$msgAf = "</div>";



//see if email or actKey is missing
//cn use isset for link

if( !isset($_POST['user_id']) || !isset($_POST['actKey']) )
{
    echo $msgBe."There was an error. Please, click on the reset password link
        you received in your email".$msgAf;
    echo $_POST['user_id'];
    $_POST['actKey'];

    exit;
}

$user_id = $_POST['user_id'];
$actKey = $_POST['actKey'];
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

//define err msg
$invMail = "<p><strong> Please, enter valid email address </strong></p>";
$noPd = "<p><strong> Please, enter password </strong></p>";
$invPd = "<p><strong> Password should contain at least 1 capital letter and
1 number, and should be at least 6 characters long </strong></p>";
$diffPd = "<p><strong> Passwords do not match </strong></p>";
$no2Pd = "<p><strong> Please, confirm password </strong></p>";

$errs = NULL;

//ps
if( empty($_POST["pd1"]) )
    $errs .= $noPd;
elseif (!( strlen($_POST["pd1"]) >= 6 and preg_match('/[A-Z]/', $_POST["pd1"]) and preg_match('/[0-9]/', $_POST["pd1"]) ))
        $errs .= $invPd;
else{
    $ps1 = filter_var( $_POST["pd1"], FILTER_SANITIZE_STRING );
    if( empty($_POST["pd2"]) )
        $errs .= $no2Pd;
    else{
        $ps2 = filter_var( $_POST["pd2"], FILTER_SANITIZE_STRING );
        if ( $ps1 !== $ps2 )
            $errs .= $diffPd;
    }
}

//check for errors
if($errs){
    $result = $msgBe.$errs.$msgAf;
    echo $result;
    exit;
}

//prepare vals
$ps = mysqli_real_escape_string($link, $ps1);
//$ps = md5($ps); //128 bit long => hex automatically => 32
$ps = hash("sha256", $ps);

$user_id = mysqli_real_escape_string($link, $user_id);

//run query to update pswd
$query = "UPDATE users SET password='$ps' WHERE user_id='$user_id'";

$result = mysqli_query($link, $query);
if(!$result)
{
    echo $msgBe."Problem storing password".$msgAf;
    echo $msgBe."".mysqli_connect_error()."".$msgAf;
    exit;
}

//change status pending to used
$query = "UPDATE forgotpswd SET status='used' WHERE user_id='$user_id'
                AND validation='$actKey'";

$result = mysqli_query($link, $query);
if(!$result)
{
    echo $msgBe."Error".$msgAf;
    echo $msgBe."".mysqli_connect_error()."".$msgAf;
    exit;
}
else
{
    echo $msgBeSucc."Your password is updated successfully.
    <a href='index.php'>Login</a>".$msgAf;
}


?>