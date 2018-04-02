<?php
  include('mysql_connection.php');
  $uid = $_POST["uid"];
  $tid = $_POST["tid"];
  $body = $_POST["comment"];
  $sql = "INSERT INTO comment (uid, tid, body, comment_time) VALUES ('$uid', '$tid', '$body', NOW())";
  //echo "$sql";
  $result = mysqli_query($connect, $sql);
  $connect -> close();
  header("Location: Query9.php?uid=$uid");
  exit;
?>
