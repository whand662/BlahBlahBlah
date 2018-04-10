<?php
  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = '';
  $dbname = 'class_project';
  $restkey = 'eatmoreveggies';

  $returnObj = new stdClass();
  $returnObj->retval = false;
  $returnObj->message = "default message";

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
  $query = "SET time_zone = -5:00";
  mysqli_query($connection, $query);

  function finish() {
    global $returnObj;
    global $connection;
    $returnJSON = json_encode($returnObj);
    echo $returnJSON;
    mysqli_close($connection);
    die(0);
  }

  switch($_GET['type']){

    case "login":
      $user = mysqli_real_escape_string($connection, $_GET['user']);
      $pass = mysqli_real_escape_string($connection, $_GET['pass']);
      $query = "SELECT * FROM user WHERE username = '$user' AND password = BINARY '$pass'";
      if(strlen($user) > 40){
        $returnObj->retval = false;
        $returnObj->message = "username too long";
        break;
      }
      $qry_result = mysqli_query($connection, $query);
      if($qry_result->num_rows == 1){
        $returnObj->retval = true;
        $returnObj->message = "Successful Login Attempt";
        $returnObj->data = mysqli_fetch_assoc($qry_result);
      }else if($qry_result->num_rows == 0){
        $returnObj->retval = false;
        $returnObj->message = "Login failed, no record found";
      }else{
        $returnObj->retval = false;
        $returnObj->message = "default case login failure";
      }
      break;

    case "follow":
      $sheep = mysqli_real_escape_string($connection, $_GET['sheep']);
      $shepherd = mysqli_real_escape_string($connection, $_GET['shepherd']);
      //check user exists
      $query = "SELECT * FROM user WHERE username = '$shepherd'";
      $qry_result = mysqli_query($connection, $query);
      if($qry_result->num_rows == 0){
        $returnObj->retval = false;
        $returnObj->message = "User does not exist";
        break;
      }
      //check for duplicate entry
      $query = "SELECT * FROM follow WHERE follower_id = '$sheep' AND following_id = '$shepherd'";
      $qry_result = mysqli_query($connection, $query);
      if($qry_result->num_rows == 1){
        $returnObj->retval = false;
        $returnObj->message = "Entry already exists";
        break;
      }
      //add tuple
      $query = "INSERT INTO follow (follower_id, following_id) VALUES ('$sheep', '$shepherd')";
      $qry_result = mysqli_query($connection, $query);
      $returnObj->retval = true;
      $returnObj->message = "Follow successful";
      break;

    case "unfollow":
      $sheep = mysqli_real_escape_string($connection, $_GET['sheep']);
      $shepherd = mysqli_real_escape_string($connection, $_GET['shepherd']);
      //check for entry existence
      $query = "SELECT * FROM follow WHERE follower_id = '$sheep' AND following_id = '$shepherd'";
      $qry_result = mysqli_query($connection, $query);
      if($qry_result->num_rows == 0){
        $returnObj->retval = false;
        $returnObj->message = "Entry does not exist";
        break;
      }
      $query = "DELETE FROM follow WHERE follower_id = '$sheep' AND following_id = '$shepherd'";
      $qry_result = mysqli_query($connection, $query);
      $returnObj->retval = true;
      $returnObj->message = "Unfollow successful";
      break;

    case "newuser":
      $user = mysqli_real_escape_string($connection, $_GET['user']);
      $pass = mysqli_real_escape_string($connection, $_GET['pass']);
      $email = mysqli_real_escape_string($connection, $_GET['email']);

      $query = "SELECT * FROM user WHERE username = '$user'";
      $qry_result = mysqli_query($connection, $query);
      if($qry_result->num_rows == 1){
        $returnObj->retval = false;
        $returnObj->message = "Username taken";
      }else if($qry_result->num_rows == 0){
        $query = "INSERT INTO user (username, password, email) ";
        $query = $query . "VALUES ('$user', '$pass', '$email')";
        $qry_result = mysqli_query($connection, $query);
        $query = "SELECT * FROM user WHERE username = '$user' AND password = BINARY '$pass'";
        $qry_result = mysqli_query($connection, $query);
        $returnObj->data = mysqli_fetch_assoc($qry_result);
        $returnObj->retval = true;
      }else{
        $returnObj->retval = false;
        $returnObj->message = "default case";
      }
      break;

    case "search":
      $criteria = mysqli_real_escape_string($connection, $_GET['criteria']);
      $query = "SELECT * FROM Films WHERE title LIKE '%$criteria%' ORDER BY year DESC LIMIT 50";
      $qry_result = mysqli_query($connection, $query);

      if($qry_result == false){
        $returnObj->retval = false;
        $returnObj->message = "Failed to perform search";
      }else{
        $returnObj->rowCount = $qry_result->num_rows;
        $returnObj->retval = true;
        $returnObj->message = "Found $qry_result->num_rows results";
        while($r = mysqli_fetch_assoc($qry_result)){
          foreach($r as $key=>$value){
            if(is_null($value) || $value == '')
              unset($r[$key]);
          }
          $returnObj->data[] = $r;
        }

      }
      break;

    case "feed":
      $user = mysqli_real_escape_string($connection, $_GET['user']);
      //watched
      $query = "SELECT * FROM Watch, Films WHERE Watch.imdbID = Films.imdbID AND Watch.user = '$user'";
      $qry_result = mysqli_query($connection, $query);
      if($qry_result == false){
        $returnObj->retval = false;
        $returnObj->message = "Failed to perform query1";
        break;
      }else{
        $returnObj->rowCount = $qry_result->num_rows;
        while($r = mysqli_fetch_assoc($qry_result)){
          foreach($r as $key=>$value){
            if(is_null($value) || $value == '')
              unset($r[$key]);
          }
          $returnObj->data[] = $r;
        }
      }
      //Ratings
      $query = "SELECT * FROM Ratings, Films WHERE Ratings.imdbID = Films.imdbID AND Ratings.user = '$user'";
      $qry_result = mysqli_query($connection, $query);
      if($qry_result == false){
        $returnObj->retval = false;
        $returnObj->message = "Failed to perform query2";
        break;
      }else{
        $returnObj->rowCount = $returnObj->rowCount + $qry_result->num_rows;
        while($r = mysqli_fetch_assoc($qry_result)){
          foreach($r as $key=>$value){
            if(is_null($value) || $value == '')
              unset($r[$key]);
          }
          $returnObj->data2[] = $r;
        }
      }
      //Achieved
      $query = "SELECT * FROM Achieved, Achievements WHERE Achieved.aid = Achievements.aid AND Achieved.user = '$user'";
      $qry_result = mysqli_query($connection, $query);
      if($qry_result == false){
        $returnObj->retval = false;
        $returnObj->message = "Failed to perform query3";
        break;
      }else{
        $returnObj->rowCount = $returnObj->rowCount + $qry_result->num_rows;
        while($r = mysqli_fetch_assoc($qry_result)){
          foreach($r as $key=>$value){
            if(is_null($value) || $value == '')
              unset($r[$key]);
          }
          $returnObj->data3[] = $r;
        }
      }
      //clean up
      $returnObj->retval = true;
      $returnObj->message = "Found " . $qry_result->num_rows . " results";
      break;

    default:

      break;
  }

  finish()

?>
