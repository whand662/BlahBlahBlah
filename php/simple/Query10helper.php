<?php
  include('mysql_connection.php');
  $uid = $_POST["uid"];
  $cid = $_POST["cid"];
  $sql = "SELECT * FROM comment WHERE cid = '$cid'";
  //echo "$sql";
  $result = mysqli_query($connect, $sql);
  if($result->num_rows == 0){
    echo "That comment no longer exists!";
    echo "<script>";
    echo "  setTimeout(goHome, 3000);";
    echo "  function goHome() {";
    echo "    window.location.href = 'Query9.php?uid=$uid';";
    echo "  }";
    echo "</script>";
  }else{
    $temp = mysqli_fetch_assoc($result);
    if($temp['uid'] != $uid){
      echo "You cannot delete comments you did not write!";
      echo "<script>";
      echo "  setTimeout(goHome, 3000);";
      echo "  function goHome() {";
      echo "    window.location.href = 'Query9.php?uid=$uid';";
      echo "  }";
      echo "</script>";
    }else{
      $sql = "DELETE FROM comment WHERE cid = '$cid'";
      $result = mysqli_query($connect, $sql);
      echo "Comment deleted!";
      echo "<script>";
      echo "  setTimeout(goHome, 3000);";
      echo "  function goHome() {";
      echo "    window.location.href = 'Query9.php?uid=$uid';";
      echo "  }";
      echo "</script>";
    }
  }
  $connect -> close();
?>
