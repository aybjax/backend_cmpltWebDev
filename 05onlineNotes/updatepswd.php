<?php

session_start();
include("connection.php");

//define error msgs
$msgBe = "<div class='alert alert-danger'>";
$msgBeSucc = "<div class='alert alert-success'>";
$msgAf = "</div>";

//err msg
$noOldPd = "<p><strong> Please, enter current password </strong></p>";
$invOldPd = "<p><strong> Please, enter correct current password </strong></p>";
$noPd = "<p><strong> Please, enter password </strong></p>";
$invPd = "<p><strong> Password should contain at least 1 capital letter and
1 number, and should be at least 6 characters long </strong></p>";
$diffPd = "<p><strong> Passwords do not match </strong></p>";
$no2Pd = "<p><strong> Please, confirm password </strong></p>";

//prepare var
$errs=NULL;
$cur = NULL;
$oldPd = NULL;
$ps1 = NULL;
$ps2 = NULL;

$user_id = $_SESSION['user_id'];

//get user input

if( !$_POST['updatePswdOld'] )
{
    $errs .= $noOldPd;
}else
{
    $cur = filter_var($_POST['updatePswdOld'], FILTER_SANITIZE_STRING);
    $cur = mysqli_real_escape_string($link, $cur);
    $cur = hash("sha256", $cur);

    $query = "SELECT password FROM users WHERE user_id='$user_id'";

    $result = mysqli_query($link, $query);

    if(!$result)
    {
        echo $msgBe . "Error storing username in database" . $msgAf;
        echo $msgBe . "Error: " . mysqli_error($link) . $msgAf;
        exit;
    }

    $nbr = mysqli_num_rows($result);

    if($nbr == 1)
    {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        //cmpr pds
        if( $cur != $row['password'] )
        {
            $errs .= $invOldPd;
        }

    }else
    {
      echo $msgBe . "Error running query" . $msgAf;
      exit;
    }
}

//ps
if( empty($_POST["updatePswd1"]) )
    $errs .= $noPd;
elseif (!( strlen($_POST["updatePswd1"]) >= 6 and preg_match('/[A-Z]/', $_POST["updatePswd1"]) and preg_match('/[0-9]/', $_POST["updatePswd1"]) ))
        $errs .= $invPd;
else{
    $ps1 = filter_var( $_POST["updatePswd1"], FILTER_SANITIZE_STRING );
    if( empty($_POST["updatePswd2"]) )
        $errs .= $no2Pd;
    else{
        $ps2 = filter_var( $_POST["updatePswd2"], FILTER_SANITIZE_STRING );
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

//prepare vars => avoid sql injection
$ps = mysqli_real_escape_string($link, $ps1);
//$ps = md5($ps); //128 bit long => hex automatically => 32
$ps = hash("sha256", $ps);


//check for username in table
$query = "UPDATE users SET password='$ps' WHERE user_id = '$user_id'";

$result = mysqli_query($link, $query);
if(!$result){
    echo $msgBe."Error running query".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
}else{
    echo $msgBeSucc."Password updated successfully".$msgAf;
}
?>