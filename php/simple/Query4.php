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

          $sql = "SELECT uid, username from user where username=\"".$_POST["username"]."\"";
          $result = mysqli_query($connect, $sql);
          if($result)
          $uid=mysqli_fetch_assoc($result)["uid"];
          $_SESSION['uid'] = $uid;
          //echo $uid;
    ?>
    <?php
          $posts = show_posts($_SESSION['uid']);
        if (count($posts)){
    ?>
          <table border='1' cellspacing='0' cellpadding='5' width='300'>
            <?php
                echo "<p>User ".$_POST["username"], " posted: ";
                foreach ($posts as $key => $list){
                    echo "<tr valign='top'>\n";
                  //  echo "<td>".$list['uid'] ."</td>\n";
                    echo "<td>".$_POST["username"] ."</td>\n";
                    echo "<td>".$list['body'] ."<br/>\n";
                    echo "<small>".$list['post_time'] ."</small></td>\n";
                    echo "</tr>\n";
                  }
            ?>
          </table>
          <?php
        }else{
            ?>
            <p><b>Enter user name to show user's posts!</b></p>
            <?php
        }
      $connect -> close();
        ?>
  </head>
</html>
