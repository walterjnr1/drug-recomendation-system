<?php
include('../inc/config.php'); 
if(empty($_SESSION['user_id']))
    {
        header("Location: ../Auth/user_login");
    } 

//Automatic logout
$t=time();
if (isset($_SESSION['logged']) && ($t - $_SESSION['logged'] > 3600)) {

	session_destroy();
    session_unset();
	echo ("<script LANGUAGE='JavaScript'>
    window.alert('Sorry , You have been Logout because of inactivity. Try Again');
    window.location.href='../Auth/user_login';
    </script>");
	}else {
    $_SESSION['logged'] = time();
}

session_destroy(); //destroy the session

header("Location: ../Auth/user_login");

?>
