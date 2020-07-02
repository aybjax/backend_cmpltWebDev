<?php

$msgBe = "<div class='alert alert-danger'>";
$msgBeSucc = "<div class='alert alert-success'>";
$msgAf = "</div>";


session_start();
include("connection.php");

//user id
$user_id = $_SESSION['user_id'];

//get new username
if( empty($_POST['updateUsername']) )
{
    echo "Please enter username";
    exit;
}
$username = $_POST['updateUsername'];

//query
$query = "UPDATE users SET username='$username'
        WHERE user_id='$user_id'";

$result = mysqli_query($link, $query);

if(!$result)
{
    echo $msgBe . "Error storing username in database" . $msgAf;
    echo $msgBe . "Error: " . mysqli_error($link) . $msgAf;
    exit;
}

$_SESSION['username'] = $username;

?>