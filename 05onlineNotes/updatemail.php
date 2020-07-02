<?php

session_start();
include("connection.php");

//define vars
$email = NULL;

//define error msgs
$msgBe = "<div class='alert alert-danger'>";
$msgBeSucc = "<div class='alert alert-success'>";
$msgAf = "</div>";

$noMail = "<p><strong> Please, enter email address </strong></p>";
$invMail = "<p><strong> Please, enter valid email address </strong></p>";

//get user info

$user_id = $_SESSION['user_id'];

//email input
if( empty($_POST["updateEmail"]) )
    $errs .= $noMail;
else
{
    $email = filter_var($_POST["updateEmail"], FILTER_SANITIZE_EMAIL);
    if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
        $errs .= $invMail;
}

//check for email in table: if already used?
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $query);
if(!$result)
{
    echo $msgBe."Error running query".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}
$nbr = mysqli_num_rows($result);
if( $nbr > 0 )
{//email already exit
    echo $msgBe . "Email already registered <br/>
        Please, choose another one" . $msgAf;
    exit;
}


//old email retrieval
$query = "SELECT * FROM users WHERE user_id = '$user_id'";

$result = mysqli_query($link, $query);
if(!$result){
    echo $msgBe."Error running query".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}
$nbr = mysqli_num_rows($result);
if( $nbr != 1 )
{//error
    echo $msgBe . "Error retrieving data" . $msgAf;
    exit;
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$oldEmail = $row['email'];

//create unique activation code
$actKey = bin2hex(openssl_random_pseudo_bytes(16));

//insert act key into table
//insert data to table
$query = "UPDATE users SET activation2='$actKey'
            WHERE user_id='$user_id'";

$result = mysqli_query($link, $query);

if(!$result){
    echo $msgBe."Error adding to database".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}


//send email
$msg = "Click on this link to change email:\n\n";
$msg .= "http://localhost/phps/05onlineNotes/newemail.php?email=";
$msg .= urlencode($oldEmail)."&newemail=".urlencode($email).'&key=';
$msg .= $actKey;

$msgSent = mail($email, "Confirm registration", $msg, 'From:'."aybat93@gmail.com");

//check for email
if($msgSent)
{
    echo $msgBeSucc."Thanks for registering. Confirmation email was sent to
         $oldEmail. Please, click on activation link to activate your code".$msgAf;
    
}else{
    echo $msgBe.$msg.$msgAf;
    echo $msgBe."Cannot send activation code to $oldEmail".$msgAf;
    exit;
}



?>