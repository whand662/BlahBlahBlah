<?php

//session_start();
//include("mysql_connection.php");
//include("functions.php");

$userid = $_SESSION['userid'];
$body = substr($_POST['body'],0,140);

add_post($userid,$body);
$_SESSION['message'] = "Your post has been added!";

//header("Location:test.php");
?>
