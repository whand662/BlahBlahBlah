<?php
session_start();
include_once("mysql_connection.php");
include_once("functions.php");

$id = $_GET['uid'];
$do = $_GET['do'];

switch ($do){
    case "follow":
        follow_user($_SESSION['uid'],$id);
        $msg = "You have followed a user!";
    break;

    case "unfollow":
        unfollow_user($_SESSION['uid'],$id);
        $msg = "You have unfollowed a user!";
    break;

}
$_SESSION['message'] = $msg;

header("Location:indexQ8.php");
?>
