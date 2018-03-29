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

      function add_comment(){
        $connect = mysqli_connect('localhost', 'root', '');
        $uid = $_POST["uid"];
        $tid = $_POST["tid"];
        $body = $_POST["body"];
        $sql = "INSERT INTO comment (uid, tid, body) VALUES ('$uid', '$tid', '$body')";
        $result = mysqli_query($connect, $sql);
        $connect -> close();
      }

      include('mysql_connection.php');
      include('functions.php');
      //make connection
      $connect = mysqli_connect('localhost', 'root', '');

      //select db
      mysqli_select_db($connect, 'class_project');

      if(mysqli_connect_errno()){
        exit();
      }

      $connect -> close();

      $posts = all_posts_with_comments();

      if (count($posts)){
      foreach ($posts as $key => $list){
          echo <table border='1' cellspacing='0' cellpadding='5' width='500'>;
          echo "<tr valign='top'>\n";
          echo "<td>".$list['uid'] ."</td>\n";
          echo "<td>".$list['body'] ."<br/>\n";
          echo "<small>".$list['post_time'] ."</small></td>\n";
          echo "</tr>\n";
          foreach ($posts['comments'] as $key => $sublist){
            echo "<tr valign='top'>\n";
            echo "<td>".$sublist['uid'] ."</td>\n";
            echo "<td>".$sublist['body'] ."<br/>\n";
            echo "<small>".$sublist['comment_time'] ."</small></td>\n";
            echo "</tr>\n";
          }
          echo <form action="Query5helper.php" method="POST">
          echo  Enter a year: <input type="text" placeholder="Comment" id="comment" name="comment"/>
          echo  Enter your userID: <input type="text" placeholder="ID" id="uid" name="uid"/>
          echo  <input type="hidden" name="tid" value="$list['tid']" />
          echo  <br></br>
          echo  <input type="submit" name="submit">
          echo </form>
          echo </table>;
      }
      }else{
      echo <p><b>You havent posted anything yet!</b></p>;
      }

    ?>

  </head>

</html>
