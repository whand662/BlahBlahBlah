<?php

  include ("mysql_connection.php");

  function show_posts($userid){

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

  function show_posts_all(){
    $posts = array();

    $sql = "SELECT uid, tid, body, post_time FROM twitts ORDER BY post_time DESC";
    $result = mysqli_query($connect, $sql);

    while($data = mysqli_fetch_object($result)){
          $posts[] = array(   'post_time' => $data->post_time,
                              'uid' => $data->uid,
                              'body' => $data->body,
                              'tid' => $data->tid);
    }
    return $posts;
  }

  function all_posts_with_comments(){
    $posts = array();

    $sql = "SELECT uid, tid, body, post_time FROM twitts ORDER BY post_time DESC";
    $result = mysqli_query($connect, $sql);

    while($data = mysqli_fetch_object($result)){
      $comments = array();
      $sql = "SELECT cid, uid, tid, body, comment_time FROM comment ORDER BY comment_time DESC";
      $result = mysqli_query($connect, $sql);
      while($data2 = mysqli_fetch_object($result)){
            $comments[] = array(   'comment_time' => $data2->comment_time,
                                'cid' => $data2->cid,
                                'uid' => $data2->uid,
                                'body' => $data2->body,
                                'tid' => $data2->tid);
      }
      $posts[] = array(   'post_time' => $data->post_time,
                          'uid' => $data->uid,
                          'body' => $data->body,
                          'tid' => $data->tid,
                          'comments' => $comments);
    }
    return $posts;
  }

  function show_users(){
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
