<?php
  $dbhost = 'localhost';
  $dbuser = 'weblog_interface';
  $dbpass = '1qaz2wsx3edc';
  $dbname = 'class_project';
  $restkey = 'eatmoreveggies';

  $returnObj = new stdClass();
  $returnObj->returnVal = false;
  $returnObj->message = "default message";

  function finish() {
    $returnJSON = json_encode($returnObj);
    echo $returnJSON;
    mysqli_close($connection);
    die(0);
  }

  if($_GET['auth'] != $restkey){
    $returnObj->message = "Invalid REST key";
    finish();
  }

  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if(!$connection){
    $returnObj->message = "Could not connect to DB";
    finish();
  }

  mysqli_set_charset( $connection, 'utf8');

  if(isset($_GET['tz'])){
    $tz = mysqli_real_escape_string($connection, $_GET['tz']);
    $query = "SET time_zone = $tz";
    mysqli_query($connection, $query);
  }else{
    $query = "SET time_zone = -5:00";
    mysqli_query($connection, $query);
  }

  //need to:
  //make chat
  //send message
  //retrieve both
  //follow and unfollow
  //login
  //like a post
  //block?

  switch($_GET['type']){


    case "login":

      break;

    //find the post with the most likes
    //find the person with the most followers
    //count the number of posts containing keyword flu and display by location
    //get all twits by a person
    //input a year find person who twits most in that year
    //find all senders of messages
    //post a twits
    //follow/unfollow
    //adds comment to post
    //user deletes a comment to a post

    default:

      break;
  }

  finish()

?>
