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

    case "post":
      $uid = mysqli_real_escape_string($connection, $_GET['uid']);
      $body = mysqli_real_escape_string($connection, $_GET['body']);
      $query = "INSERT INTO twitts VALUES (null,'$uid', '$body', NOW())";
      $qry_result = mysqli_query($connection, $query);
      if($qry_result){
        $returnObj->retval = true;
        $returnObj->message = "Posted";
      }else{
        $returnObj->retval = false;
        $returnObj->message = "Could not post";
      }
      break;

    case "comment":
      $uid = mysqli_real_escape_string($connection, $_GET['uid']);
      $tid = mysqli_real_escape_string($connection, $_GET['tid']);
      $body = mysqli_real_escape_string($connection, $_GET['body']);
      $query = "INSERT INTO comment (uid, tid, body, comment_time) VALUES ('$uid', '$tid', '$body', NOW())";
      $qry_result = mysqli_query($connection, $query);
      if($qry_result){
        $returnObj->retval = true;
        $returnObj->message = "Posted comment";
      }else{
        $returnObj->retval = false;
        $returnObj->message = "Could not post comment";
      }
      break;

    case "feed":
      $uid = mysqli_real_escape_string($connection, $_GET['uid']);
      //watched
      $posts = array();
      $query = "SELECT username, uid, tid, body, post_time FROM twitts NATURAL JOIN user ORDER BY post_time DESC";
      $qry_result = mysqli_query($connection, $query);
      while($data = mysqli_fetch_object($qry_result)){
        $comments = array();
        $query = "SELECT username, cid, uid, tid, body, comment_time FROM comment NATURAL JOIN user WHERE tid = '$data->tid' ORDER BY comment_time ASC";
        $result2 = mysqli_query($connection, $query);
        while($data2 = mysqli_fetch_object($result2)){
              $comments[] = array(   'comment_time' => $data2->comment_time,
                                    'cid' => $data2->cid,
                                    'uid' => $data2->uid,
                                    'username' => $data2->username,
                                    'body' => $data2->body,
                                    'tid' => $data2->tid);
        }
        $posts[] = array(   'post_time' => $data->post_time,
                            'uid' => $data->uid,
                            'username' => $data->username,
                            'body' => $data->body,
                            'tid' => $data->tid,
                            'comments' => $comments);
      }
      //clean up
      $returnObj->data = $posts;
      $returnObj->retval = true;
      $returnObj->message = "Found " . $qry_result->num_rows . " results";
      break;

    default:

      break;
  }

  finish()

?>
