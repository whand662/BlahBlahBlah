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
      $sql="SELECT follower_id FROM follow GROUP BY following_id ORDER BY COUNT(*) DESC LIMIT 1";
      $result = mysqli_query($connect, $sql);

      if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<p>Result: </p>";
            // echo "<h></h>";
            echo "<tr><td>".$row["follower_id"];

        }

      }else{
        echo "No data.";
      }

      $connect -> close();
      ?>
  </head>



</html>
