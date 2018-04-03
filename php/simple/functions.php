<?php
//The file functions.php has a list of functions used for the queries
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
// This function gives a list of all the users in the system.

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
    //this fc is used for Q8 gives a list of all the users in the system and
    //it's ordered by uid
  function showUsersUidOrder(){
      include("mysql_connection.php");
      $users = array();
      $sql1 = "select uid, username from user order by uid";
      $result1 = mysqli_query($connect, $sql1);

      while ($data = mysqli_fetch_object($result1)){
          // $users[] = $data->username;
          //   $users[] = $data->uid;


          $users[$data->uid] = $data->username;
      }
      return $users;
  }


//function show_messages() to show messages
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
  //function that tells you who the current user is already following
  function following($userid){
    include("mysql_connection.php");
    $users = array();

    $sql = "select distinct following_id from follow
            where follower_id = '$userid'";

    $result = mysqli_query($connect, $sql);

    while($data = mysqli_fetch_object($result)){
        array_push($users, $data->following_id);

    }

    return $users;

  }


  function check_count($first, $second){
    include("mysql_connection.php");
    $sql = "select count(*) from follow
            where following_id='$second' and follower_id='$first'";
    $result = mysqli_query($connect, $sql);

    $row = mysqli_fetch_row($result);
    return $row[0];

}

function follow_user($me,$them){
  include("mysql_connection.php");
    //$count = check_count($me,$them);
        $sql = "insert into follow
                values ($me,$them,NOW())";

        $result = mysqli_query($connect, $sql);
}


function unfollow_user($me,$them){
  include("mysql_connection.php");
    //$count = check_count($me,$them)
        $sql = "delete from follow
                where follower_id='$me' and following_id='$them'
                limit 1";

        $result = mysqli_query($connect, $sql);
}
//Display a list of other users the user is following on the home page
function showUsers($user_id=0){
 include("mysql_connection.php");
    if ($user_id > 0){
        $follow = array();
        $fsql = "select follower_id from follow
                where following_id='$user_id'";
        $fresult = mysqli_query($connect, $fsql);

        while($f = mysqli_fetch_object($fresult)){
            array_push($follow, $f->follower_id);
        }

        if (count($follow)){
            $id_string = implode(',', $follow);
            $extra =  " and id in ($id_string)";

        }else{
            return array();
        }

    }

    $users = array();
    $sql = "select uid, username from user";
             //$extra order by username";
    // $sql = "select u.uid, u.username, f.follower_id from user u, follow f
    //             where u.uid=f.follower_id";
    $result = mysqli_query($connect, $sql);

    while ($data = mysqli_fetch_object($result)){
        $users[$data->uid] = $data->username;
    }
    return $users;

}


// Willis's fc fro q9
function all_posts_with_comments(){
    include("mysql_connection.php");
    $posts = array();
    $sql = "SELECT uid, tid, body, post_time FROM twitts ORDER BY post_time DESC";
    $result = mysqli_query($connect, $sql);
    while($data = mysqli_fetch_object($result)){
      $comments = array();
      $sql = "SELECT cid, uid, tid, body, comment_time FROM comment WHERE tid = '$data->tid' ORDER BY comment_time ASC";
      $result2 = mysqli_query($connect, $sql);
      while($data2 = mysqli_fetch_object($result2)){
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

?>
