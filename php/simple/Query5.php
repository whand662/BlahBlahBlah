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
    $year1 = $_POST["post_time"];
    $year2 = year1 + 1;
    $sql="SELECT uid, count(tid)
          from twitts
          where post_time >= '$year1-01-01' and post_time < '$year2-01-01'
          AND tid = (select MAX(tid) AS MostTwitts from twitts)";
    $result = mysqli_query($connect, $sql);
    if($result)
    $posts=mysqli_fetch_assoc($result)["post_time"];
    //$uid=mysqli_fetch_assoc($result)["uid"];
    //$_SESSION['uid'] = $uid;
    $_SESSION['post_time'] = $posts;
    echo $posts;
?>
<?php
    $posts = show_posts($_SESSION['uid']);
  if (count($posts)){
?>
    <table border='1' cellspacing='0' cellpadding='5' width='300'>
      <?php
          foreach ($posts as $key => $list){
              echo "<tr valign='top'>\n";
              echo "<td>".$list['uid'] ."</td>\n";
            //  echo "<td>".$list['body'] ."<br/>\n";
              echo "<small>".$list['post_time'] ."</small></td>\n";
              echo "</tr>\n";
            }
      ?>
    </table>
    <?php
  }else{
      ?>
      <p><b>There is no twits on that year!</b></p>
      <?php
  }
$connect -> close();
  ?>
  </head>



</html>
