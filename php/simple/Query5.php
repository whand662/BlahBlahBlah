<?php
  include("mysql_connection.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
      <img src="logoUser.png"  class="center">
      <h1 align="center">Welcome to EzTwitt</h1>

    <style>
      body{
          background: url(background2.jpg);
          background-size: cover;
          margin: 0;
      }
      .center {
          display: block;
          margin-left: auto;
          margin-right: auto;
          width: 10%;
       }

      </style>


    <?php
    session_start();
    include('mysql_connection.php');
    include('functions.php');
    //hardcoded user id so that will display need to change this
    //  $sql="SELECT uid, COUNT(tid) from twitts where post_time=\"".$_POST["post_time"]."\"";
    $year = $_POST["post_time"];
    $sql = "SELECT username AS User, MAX(counted) AS Posts FROM (SELECT *, COUNT(*) AS counted FROM twitts NATURAL JOIN user WHERE YEAR(post_time) = '$year' GROUP BY uid) AS counts";
    $result = mysqli_query($connect, $sql);
    $connect -> close();
    if($result)
    $posts = mysqli_fetch_assoc($result);
    $_SESSION['post_time'] = $posts;
    ?>

    <table border='1' cellspacing='0' cellpadding='5' width='300'>
      <?php
          foreach ($posts as $key => $list){
              echo "<tr valign='top'>\n";
              echo "<td>".$list['User'] ."</td>\n";
            //  echo "<td>".$list['body'] ."<br/>\n";
              echo "<small>".$list['Posts'] ."</small></td>\n";
              echo "</tr>\n";
            }
      ?>
    </table>

  </head>

</html>
