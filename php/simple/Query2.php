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

      //make connection
      $connect = mysqli_connect('localhost', 'root', '');

      //select db
      mysqli_select_db($connect, 'class_project');

      if(mysqli_connect_errno()){
        exit();
      }
      //fetch records
      $sql="SELECT f.follower_id, u.username FROM follow f, user u where u.uid=f.follower_id  GROUP BY following_id ORDER BY COUNT(*) DESC LIMIT 1";
      $result = mysqli_query($connect, $sql);

      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<h1 style=font-size:100%;>The user who has the most number of followers is:</h1>";
            echo "<tr><td>".$row["username"];
            //echo "<tr><td>".$row["follower_id"];
        }

      }else{
        echo "No data.";
      }

      $connect -> close();
      ?>
  </head>



</html>
