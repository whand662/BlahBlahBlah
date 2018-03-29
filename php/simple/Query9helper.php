<?php
  function add_comment(){
  }
  include('mysql_connection.php');
  include('functions.php');
  //make connection
  $connect = mysqli_connect('localhost', 'root', '');
  mysqli_select_db($connect, 'class_project');
  if(mysqli_connect_errno()){
    header("Location: Query9.php");
    exit;
  }
  $uid = $_POST["uid"];
  $tid = $_POST["tid"];
  $body = $_POST["body"];
  $sql = "INSERT INTO comment (uid, tid, body) VALUES ('$uid', '$tid', '$body')";
  $result = mysqli_query($connect, $sql);
  $connect -> close();
  header("Location: Query9.php");
  exit;
?>
