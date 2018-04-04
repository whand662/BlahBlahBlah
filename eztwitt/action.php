<?php
//the file action.php is used in the follow and unfollow links. This file accepts two
//GET parameters: one for the user ID and the other for follow or unfollow.
session_start();
include_once("mysql_connection.php");
include_once("functions.php");

$id = $_GET['id'];
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
echo $msg;
//redirect to users.php
header("Location:users.php");
?>
