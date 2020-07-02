<?php
session_start();
include("connection.php");

//get user id
$user_id = $_SESSION['user_id'];

//get current time
$time = time();

//query for not
$query = "INSERT INTO notes (`user_id`, `note`, `time`)
        VALUES ('$user_id', '', '$time')";

$result = mysqli_query($link, $query);

if(!$result)
{
    echo "error";
}else
{
    //return auto generated id
    echo mysqli_insert_id($link);
}


?>