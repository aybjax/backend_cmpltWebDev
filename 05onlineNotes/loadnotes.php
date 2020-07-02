<?php
//define error msgs
$msgBe = "<div class='alert alert-danger'>";
$msgBeSucc = "<div class='alert alert-success'>";
$msgAf = "</div>";


$text1 = "<div class='noteDiv'>
            <div class='col-xs-5 col-sm-3 delete'>
                <button style='width:100%' class='btn-lg btn-danger'>delete</button>
            </div>
            <div class='note' id='";
$text2 = "                          '><div class='text'>";
$timetext = "<div class='timetext'>";
$div = "                                                </div>";

session_start();
include("connection.php");

//get user id
$user_id = $_SESSION['user_id'];

//delete empty notes => bc when open new note it is deleted
//so when switchin go load file it shd be deleted
$query = "DELETE FROM notes WHERE note=''";

$result = mysqli_query($link, $query);

if(!$result)
{
    echo $msgBe."Error running query".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}


//look for notes
$query = "SELECT * FROM notes WHERE user_id='$user_id'
            ORDER BY time DESC";
$result = mysqli_query($link, $query);

if(!$result)
{
    echo $msgBe."Error running query".$msgAf;
    echo $msgBe.mysqli_error($link).$msgAf;
    exit;
}


if( ($count = mysqli_num_rows($result)) == 0 ) 
{
    //echo "
    //    <div class='alert alert-warning collapse col-md-offset-3 col-md-6'>
    //        <a class='close' data-dismiss='alert'>
    //            &times;
    //        </a>
    //        You have not created any notes yet
    //    </div>";
    exit;
}

//create notes
while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) )
{
    $note_id = $row["id"];
    $note = $row["note"];
    $time = $row["time"];
    $time = date("F d, Y h:i:s A", $time);

    echo $text1 . $note_id . $text2 . $note . $div 
        . $timetext . $time . $div . $div . $div;

}
?>