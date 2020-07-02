<?php

//db connection
$link = mysqli_connect("localhost", "onlineNotesApp", "Fez2vrqPGvHXNWKr", "onlineNotes");
if(mysqli_connect_error())
{
    die("Error: unable to connect:".mysqli_connect_error());
}

?>