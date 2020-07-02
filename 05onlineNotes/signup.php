<?php
$ps1 = NULL;
//start session
session_start();

//connect to database
include("connection.php");

//define error msgs
$msgBe = "<div class='alert alert-danger'>";
$msgBeSucc = "<div class='alert alert-success'>";
$msgAf = "</div>";


$noUsername = "<p><strong> Please, enter username </strong></p>";
$noMail = "<p><strong> Please, enter email address </strong></p>";
$invMail = "<p><strong> Please, enter valid email address </strong></p>";
$noPd = "<p><strong> Please, enter password </strong></p>";
$invPd = "<p><strong> Password should contain at least 1 capital letter and
1 number, and should be at least 6 characters long </strong></p>";
$diffPd = "<p><strong> Passwords do not match </strong></p>";
$no2Pd = "<p><strong> Please, confirm password </strong></p>";

//get user input
$errs=NULL;
//username
if( empty($_POST["signupUsername"]) )
    $errs .= $noUsername;
else
    $userName = filter_var($_POST["signupUsername"], FILTER_SANITIZE_STRING);
//email
if( empty($_POST["signupEmail"]) )
    $errs .= $noMail;
else
{
    $email = filter_var($_POST["signupEmail"], FILTER_SANITIZE_EMAIL);
    if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
        $errs .= $invMail;
}

//ps
if( empty($_POST["signupPswd1"]) )
    $errs .= $noPd;
elseif (!( strlen($_POST["signupPswd1"]) >= 6 and preg_match('/[A-Z]/', $_POST["signupPswd1"]) and preg_match('/[0-9]/', $_POST["signupPswd1"]) ))
        $errs .= $invPd;
else{
    $ps1 = filter_var( $_POST["signupPswd1"], FILTER_SANITIZE_STRING );
    if( empty($_POST["signupPswd2"]) )
        $errs .= $no2Pd;
    else{
        $ps2 = filter_var( $_POST["signupPswd2"], FILTER_SANITIZE_STRING );
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

//no errors
//prepare vars -> avoid SQL injection
$userName = mysqli_real_escape_string($link, $userName);
$email = mysqli_real_escape_string($link, $email);
$ps = mysqli_real_escape_string($link, $ps1);
//$ps = md5($ps); //128 bit long => hex automatically => 32
$ps = hash("sha256", $ps);

//if info in table = error


//check for username in table
$query = "SELECT * FROM users WHERE username = '$userName'";
$result = mysqli_query($link, $query);
if(!$result){
    echo $msgBe."Error running query".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}
$resultS = mysqli_num_rows($result);//nbr of usernames
if($resultS)
{
    echo $msgBe."That username already taken. Do you want to log in?".$msgAf;
    exit;
}

//same for email
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $query);
if(!$result){
    echo $msgBe."Error running query".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}
$resultS = mysqli_num_rows($result);//nbr of emails
if($resultS)
{
    echo $msgBe."That email already taken. Do you want to log in?".$msgAf;
    exit;
}


//if not taken create unique activation code
$actKey = bin2hex(openssl_random_pseudo_bytes(16));


//insert data to table
$query = "INSERT INTO users (`username`, `email`, `password`, `activation`)
    VALUES ('$userName', '$email', '$ps', '$actKey')";

$result = mysqli_query($link, $query);

if(!$result){
    echo $msgBe."Error adding to database".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}

//send email
$msg = "Click on this link to activate account:\n\n";
$msg .= "http://localhost/phps/05onlineNotes/activate.php?email=";
$msg .= urlencode($email)."&key=$actKey";

$msgSent = mail($email, "Confirm registration", $msg, 'From:'."aybat93@gmail.com");

//check for email
if($msgSent)
{
    echo $msgBeSucc."Thanks for registering. Confirmation email was sent to
         $email. Please, click on activation link to activate your code".$msgAf;
    
}else{
    echo $msgBe."".$msg."".$msgAf;
    echo $msgBe."Cannot send activation code to $email".$msgAf;
    exit;
}

?>