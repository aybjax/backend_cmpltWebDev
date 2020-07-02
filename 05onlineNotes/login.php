<?php

session_start();
include("connection.php");

function f1($a, $b){
    $c = $a . "," . bin2hex($b);
    return $c;
}

function f2($a){
    $b = hash("sha256", $a);
    return $b;
}


$errs=NULL;
$result=NULL;

//define error msgs
$msgBe = "<div class='alert alert-danger'>";
$msgBeSucc = "<div class='alert alert-success'>";
$msgAf = "</div>";


//msg
$noMail = "<p><strong> Please, enter your email </strong></p>";
$noPs = "<p><strong> Please, enter password </strong></p>";

//get input
if( empty($_POST["loginEmail"]) )
    $errs .= $noMail;
else
{
    $email = filter_var($_POST["loginEmail"], FILTER_SANITIZE_EMAIL);
}

if( empty($_POST["loginPswd"]) )
    $errs .= $noMail;
else
{
    $ps = filter_var($_POST["loginPswd"], FILTER_SANITIZE_STRING);
}

//check for errors
if($errs){
    $result = $msgBe . $errs . $msgAf;
    echo $result;
    exit;
}

//no errors
//prepare vars -> avoid SQL injection
$email = mysqli_real_escape_string($link, $email);
$ps = mysqli_real_escape_string($link, $ps);
//$ps = md5($ps); //128 bit long => hex automatically => 32
$ps = hash("sha256", $ps);



$query = "SELECT * FROM users  WHERE (email='$email' AND password='$ps'
            AND activation='activated')";

$result = mysqli_query($link, $query);
if(!$result){
    echo $msgBe."Error running query".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}

//need to be 1 match

$count = mysqli_num_rows($result);


if( $count == 1 )
{
    //if 1 match, store in session
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['email'] = $row['email'];

    //if rememberMe is not checked, go right away
    if( empty( $_POST["rememberMe"] ) )
    {
        echo "success";
    }
    //if remember me is checked
    else
    {
        $auth1 = bin2hex(openssl_random_pseudo_bytes(10));
        $auth2 = openssl_random_pseudo_bytes(20);
        //store vars in cookies
        $cVal = f1($auth1, $auth2);
        setcookie("rememberMe", $cVal, time() + 15*24*60*60);

        $f2auth2 = f2($auth2);
        $user_id = $_SESSION['user_id'];
        $expiration = date("Y-m-d H:i:s", time() + 15*24*60*60 );
        //store vals in rememberMe table
        $query = "INSERT INTO rememberme (`auth1`, `f2auth2`, `user_id`, `expiration`) VALUES ('$auth1', '$f2auth2', '$user_id', '$expiration')";
        

        $result = mysqli_query($link, $query);
        if(!$result){
            echo $msgBe."Error to remember you for next time".$msgAf;
            echo $msgBe.mysqli_error($link).$msgAf;
        }else{
            echo "success";
        }
    }
}
else
{
    echo $msgBe."Wrong username or password!".$msgAf;
    exit;
}

?>