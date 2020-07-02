<?php

//session is present and logout is given
if( isset($_SESSION['user_id']) and $_GET['logout']==1 )
{
    session_destroy();
    setcookie("rememberMe", "", time()-1);
}

?>