<?php

$errs = NULL;
//define error msgs
$msgBe = "<div class='alert alert-danger'>";
$msgBeSucc = "<div class='alert alert-success'>";
$msgAf = "</div>";


//start session
session_start();

//connect to database
include("connection.php");

//error msg
$noMail = "<p><strong> Please, enter email address </strong></p>";
$invMail = "<p><strong> Please, enter valid email address </strong></p>";

//get email
if( empty($_POST["forgotEmail"]) )
    $errs .= $noMail;
else
{
    $email = filter_var($_POST["forgotEmail"], FILTER_SANITIZE_EMAIL);
    if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
        $errs .= $invMail;
}

//check for errors
if($errs){
    $result = $msgBe.$errs.$msgAf;
    echo $result;
    exit;
}

//no errors
//prepare vars -> avoid SQL injection
$email = mysqli_real_escape_string($link, $email);


//check for username in table
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $query);
if(!$result){
    echo $msgBe."Error running query".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}
$resultS = mysqli_num_rows($result);//nbr of usernames

//if email foes not exits in db
if( $resultS !== 1 )
{
    echo $msgBe."The email does not exist in our databse".$msgAf;
    exit;
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$user_id = $row['user_id'];

//table detailns
//unique activation code
$actKey = bin2hex(openssl_random_pseudo_bytes(16));

$time = time();
$status = 'pending';

$query = "INSERT INTO forgotpswd (`user_id`, `validation`, `time`, `status`)
        VALUES ('$user_id', '$actKey', '$time', '$status')";


$result = mysqli_query($link, $query);

if(!$result){
    echo $msgBe."Error adding to database".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}


//send email to resetpswd.php w/ user_id and act'code
$msg = "Click on this link to reset:\n\n";
$msg .= "http://localhost/phps/05onlineNotes/resetpswd.php?user_id=";
$msg .= $user_id."&key=$actKey";

$msgSent = mail($email, "Reset password", $msg, 'From:'."aybat93@gmail.com");

//check for email
if($msgSent)
{
    echo $msgBeSucc."Email was sent to
         $email. Please, click on activation link to reset password".$msgAf;
    
}else{
    echo $msgBe.$msg.$msgAf;
    echo $msgBe."Cannot send activation code to $email".$msgAf;
    exit;
}

?>