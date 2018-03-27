<?php

  function show_posts($userid){
      include("mysql_connection.php");

      $posts = array();

      $sql = "select body, post_time from twitts
                  where uid = '$userid' order by post_time desc";
      $result = mysqli_query($connect, $sql);

      while($data = mysqli_fetch_object($result)){
            $posts[] = array(   'post_time' => $data->post_time,
                                'uid' => $userid,
                                'body' => $data->body);
      }
      return $posts;

  }

  function show_users(){
      include("mysql_connection.php");
      $users = array();
      $sql1 = "select uid, username from user order by username";
      $result1 = mysqli_query($connect, $sql1);

      while ($data = mysqli_fetch_object($result1)){
          $users[$data->uid] = $data->username;
      }
      return $users;
  }

//show messages
  function show_messages($userid){
      include("mysql_connection.php");
      $messages = array();

      $sql = "SELECT sender_id, receiver_id, body, send_time FROM message
                  WHERE receiver_id = '$userid' order by send_time desc";
      $result = mysqli_query($connect, $sql);

      while($data = mysqli_fetch_object($result)){
            $messages[] = array(   'send_time' => $data->send_time,
                                   'sender_id' => $data-> sender_id,
                                   'uid' => $userid,
                                   'body' => $data->body);
      }
    return $messages;

  }
?>
