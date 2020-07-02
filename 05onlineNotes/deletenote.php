<?php

session_start();
include("connection.php");

//get note id
$note_id = $_POST['id'];

//get user id
$user_id = $_SESSION['user_id'];

//delete notes
$query = "DELETE FROM notes WHERE id='$note_id' AND user_id='$user_id'";

$result = mysqli_query($link, $query);

if( !$result )
{
    echo "error";
}

?>