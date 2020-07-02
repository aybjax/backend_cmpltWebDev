<?php

session_start();
include("connection.php");

//get note id
$id = $_POST["id"];

//get content
$note = $_POST["note"];

//get current time forupdating note
$time = time();

//run query to update note
$query = "UPDATE notes SET note='$note', time='$time'
    WHERE id='$id'";

$result = mysqli_query($link, $query);

if(!$result)
{
    echo "error";
    exit;
}

?>