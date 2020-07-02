<?php
//define error msgs
$msgBe = "<div class='alert alert-danger'>";
$msgBeSucc = "<div class='alert alert-success'>";
$msgAf = "</div>";



//logged out and remember me exits
if( !isset($_SESSION["user_id"]) 
        and !empty($_COOKIE["rememberMe"]) )
{   //extract from auth1/2 from cookie
    //f1: $a . "," . bin2hex($b);
    //f2: hash("sha256", $auth);
    list($auth1, $auth2) = explode(",", $_COOKIE['rememberMe']);
    $auth2 = hex2bin($auth2);
    $f2auth2 = hash("sha256", $auth2);

    //look auth1
    $query = "SELECT * FROM rememberme WHERE auth1='$auth1'";
    $result = mysqli_query($link, $query);

    $result = mysqli_query($link, $query);
    if(!$result){
        echo $msgBe."Error accessing database".$msgAf;
        echo $msgBe.mysqli_error($link).$msgAf;
        exit;
    }
    $count = mysqli_num_rows($result);
    if($count!==1){
        echo $msgBe."Remember me process failed".$msgAf;
        exit;
    }
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //compare f2auths
    if( hash_equals( $row["f2auth2"], $f2auth2) )
    {
        //new auths

        //log in user and redirct
        $_SESSION['user_id'] = $row['user_id'];
        header("location:loggedInPage.php");
    }
    else
    {
        echo $msgBe."Cookie content failed".$msgAf;
    }
}
//else{
//    echo $msgBe."<br/><br/><br/><br/>"."user id is "
//    .$_SESSION["user_id"]."<br/> and Cookie value is"
//    .$_COOKIE["rememberMe"]
//    .$msgAf;
//    unset($_SESSION['user_id']);
//    print_r($_COOKIE);
//}

?>