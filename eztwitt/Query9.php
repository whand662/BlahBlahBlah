
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
      $uid = $_GET['uid'];
      $posts = all_posts_with_comments();
      $connect -> close();
      //var_dump($posts);
      if (count($posts)){
      foreach ($posts as $key => $list){
          echo "<table border='1' cellspacing='0' cellpadding='5' width='500'>";
          echo "<tr valign='top'>\n";
          echo "<td>".$list['uid'] ."</td>\n";
          echo "<td>".$list['body'] ."<br/>\n";
          echo "<small>".$list['post_time'] ."</small></td>\n";
          echo "</tr>\n";
          echo "</table>";
          $comments = $list['comments'];
          echo "<p>Comments:</p>";
          echo "<table border='1' cellspacing='0' cellpadding='5' width='500'>";
          foreach ($comments as $key => $sublist){
            echo "<tr valign='top'>\n";
            echo "<td>".$sublist['uid'] ."</td>\n";
            echo "<td>".$sublist['body'] ."<br/>\n";
            echo "<small>".$sublist['comment_time'] ."</small></td>\n";
            echo "<td>";
            echo "  <form action=\"Query10helper.php\" method=\"POST\">";
            echo "    <input type=\"hidden\" name=\"uid\" value=\"$uid\" />";
            echo "    <input type=\"hidden\" name=\"cid\" value=\"".$sublist['cid']."\" />";
            echo "    <input type=\"submit\" value=\"delete\">";
            echo "  </form>";
            echo "</td>";
            echo "</tr>\n";
          }
          echo "</table>";
          echo "<form action=\"Query9helper.php\" method=\"POST\">";
          echo  "Enter a comment: <input type=\"text\" placeholder=\"Comment\" id=\"comment\" name=\"comment\"/>";
          echo  "<input type=\"hidden\" name=\"uid\" value=\"$uid\" />";
          echo  "<input type=\"hidden\" name=\"tid\" value=\"".$list['tid']."\" />";
          echo  "<br></br>";
          echo  "<input type=\"submit\" name=\"submit\">";
          echo "</form>";
      }
      }else{
      echo "<p><b>You havent posted anything yet!</b></p>";
      }
    ?>

  </head>

</html>
