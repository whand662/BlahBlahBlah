<?php
  function show_posts($userid){
    include("mysql_connection.php");
  // //make connection
  // $connect = mysqli_connect('localhost', 'root', '');
  // //select db
  // mysqli_select_db($connect, 'class_project');
  //
  // if(mysqli_connect_errno()){
  //   exit();
  // }
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
?>
